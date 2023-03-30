<?

namespace Models;

use \Exception;

final class Operations extends \System\Model
{

    use \System\Traits\PaymentSystem;


    public function __construct(&$connection = null)
    {
        parent::__construct('Opers', $connection);
    }


    public function getOperation($operationId)
    {
        return $this->find1By('oID=?d', array($operationId));
    }

    public function getOperByOrder($orderId)
    {
        return $this->find1By('orID=?d', array($orderId));
    }

    public function getOperByPayId($payId)
    {
        return $this->find1By('oOrder=?', array($payId));
    }


    public function isOperExists($orderId)
    {
        return $this->count('orID=?d', array($orderId));
    }

    public function createOper($params)
    {
        if ($params['orID'] == 0 or $this->isOperExists($params['orID']))
            return 0;

        if (!$params['ocID'] or $params['ocID'] === null)
            $params['ocID'] = $this->getDefaultPsys()['cID'];


        $params['oState'] = 0;
        $params['oCTS'] = \System\Utils\TimeWorker::timeToStamp();

        return $this->insert($params);
    }

    public function updateParams($operId, $values)
    {
        return $this->connection->update($this->tableName, $values, '', 'oID=?d', array($operId));
    }
    public function updateState($operId, $newState)
    {
        return $this->connection->update($this->tableName, array('oState' => $newState), '', 'oID=?d', array($operId));
    }

}
