<?

namespace Controllers;

use Exception;

class Order extends \System\Controllers
{

    public function __construct()
    {
        parent::__construct();
    }



    public function Index($orderId)
    {
        $orderModel = new \Models\Orders();
        $order = $orderModel->extractOrder($orderModel->getOrder($orderId));

        $oper = $order['roID'];

        if (!$order)
            throw new Exception("Order $orderId not found", 404);


        $this->setView('Orders');
        $order = $this->renderView('formatView', $order);


        $this->responce->setContentType('text');
        return $this->responce->withHtml(
            new \System\TemplateData(
                'order.html',
                array(
                    'order' => $order,
                    'payment' => &$order['payment'],
                    'paylink' => $this->getOrderPayLink($oper)
                )
            )
        );
    }

    public function CreateOrder()
    {
        $this->request->throwIfValuesNotExist(array('userFullName', 'productId', 'count'), 'POST');

        $orderIndex = $this->newOrder();

        if ($orderIndex > 0)
            $this->responce->redirectTo('/order/' . $orderIndex);

        $this->responce->redirectTo('/');
    }


    public function Payment($orderId)
    {
        $operationIndex = $this->newOperation($orderId);

        if ($operationIndex > 0)
            return $this->responce->redirectTo('/operation/' . $operationIndex);


        return $this->responce->redirectTo('/order/' . $orderId);
    }






    private function newOrder()
    {
        $productId = $this->request->val('productId');

        if (is_array($productId))
            throw new Exception('Array of ProductId cannot be proccessed', 500);


        $productModel = new \Models\Products();
        $product = $productModel->getProduct($productId);


        if (!$product)
            throw new Exception('ProductId: ' . $this->request->val('productId') . ' not found', 404);

        if (!is_numeric($this->request->val('count')) or $this->request->val('count') < 1)
            throw new Exception('Variable \'count\' numeric required', 400);


        $orderModel = new \Models\Orders();

        return $orderModel->newOrder(array(
            'ruID' => $this->request->val('userFullName'),
            'rpID' => $product['pID'],
            'rSum' => $product['pSum'],
            'rCount' => $this->request->val('count'),
            'rGroup' => 0
        ));
    }

    private function newOperation($orderId)
    {
        $orderModel = new \Models\Orders();
        $order = $orderModel->getOrders($orderId);

        if (!$order or !count($order))
            throw new Exception("Order $orderId not found", 404);

        $opersModel = new \Models\Operations();

        if ($opersModel->isOperExists($orderId))
            throw new Exception('Operation cannot be created. The Operation is already linked to an order', 500);


        $totalSum = 0.0;
        foreach ($order as $values)
            $totalSum += (floatval($values['rSum']) * ($values['rCount'] + 0));


        $operIndex = $opersModel->createOper(array(
            'ouID' => $order[0]['ruID'],
            'orID' => ($order[0]['rGroup'] == 0 ? $orderId : $order[0]['rGroup']),
            'ocID' => null,
            'oSum' => $totalSum
        ));


        // $opersModel = new \Models\Operations();
        // $operIndex = 2;

        $this->makePay($opersModel->getOperation($operIndex));

        return $operIndex;
    }

    private function makePay($oper)
    {

        $sberPaymnt = new \System\Utils\Payments\SberPayment($oper['ocID']);
        $res = $sberPaymnt->newOrder(array(
            'id' => ($oper['oID'] + 0),
            'sum' => floatval($oper['oSum'])
        ));

        $opersModel = new \Models\Operations();

        if ($res === null or $res['errorCode'] != 0) {
            $opersModel->updateState($oper['oID'], 9);
            return false;
        }

        $opersModel->updateParams($oper['oID'], array('oParams' => serialize($res), 'oOrder' => $res['id']));
    }

    private function getOrderPayLink($oper)
    {
        if ($oper['oState'] != 0)
            return null;

        $params = unserialize($oper['oParams']);
        return $params['url'];
    }
}
