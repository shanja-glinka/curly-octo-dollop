<?

namespace Models;

use \Exception;

final class Orders extends \System\Model
{
    public function __construct(&$connection = null)
    {
        parent::__construct('Orders', $connection);
    }

    public function getOrder($id)
    {
        return $this->find1By('rID=?d', array($id));
    }

    public function getOrders($id)
    {
        return $this->findBy('rID=?d OR rGroup=?d', array($id, $id));
    }

    public function extractOrder($order1)
    {
        if (!is_array($order1) or !$order1['rID'])
            return array();


        $operation = new Operations($this->connection);

        if (!$order1['rGroup']) {
            $user = new OrderClients($this->connection);

            return array(
                array_merge(
                    $order1,
                    $this->getProduct($order1['rpID']),
                    $user->findClient($order1['ruID'])
                ),
                'roID' => $operation->getOperByOrder($order1['rID'])
            );
        }


        $orders = $this->connection->fetchRows(
            $this->connection->select(
                $this->tableName . ' LEFT JOIN OrderClients ON ruID=clientId LEFT JOIN Products ON rpID=pID',
                '*',
                'rGroup=?d',
                array($order1['rGroup'])
            )
        );


        return array_merge(
            $orders,
            array('roID' => $operation->getOperByOrder($order1['rGroup']))
        );
    }

    public function newOrder($params)
    {
        $clientModel = new OrderClients($this->connection);


        $clinetId = $clientModel->getClientId($params['ruID']);

        $params['ruID'] = ((!$clinetId) ? $clientModel->newClient($params['ruID']) : $clinetId);
        $params['rCTS'] = \System\Utils\TimeWorker::timeToStamp();

        return $this->insert($params, 'ruID, rpID, rGroup, rCount, rSum, rCTS');
    }


    private function getProduct($productId)
    {
        $productModel = new Products($this->connection);

        return $productModel->getProduct($productId);
    }
}
