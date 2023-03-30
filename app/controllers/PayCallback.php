<?

namespace Controllers;

use Exception;

class PayCallback extends \System\Controllers
{


    public function __construct()
    {
        parent::__construct();

        $this->responce->setContentType('json');
    }


    //?orderId=51858812-8013-0b1f-5129-61246a7184c7
    public function CallSuccess($cid)
    {
        if ($cid == 1) {
            $this->updateState(1, 1);
        } else {
            throw new Exception('Payment not found', 404);
        }

        return $this->responce->send(array('ok' => 200));
    }


    public function CallFail($cid)
    {
        if ($cid == 1) {
            $this->updateState(1, 3);
        } else {
            throw new Exception('Payment not found', 404);
        }

        return $this->responce->send(array('ok' => 200));
    }


    private function updateState($cid, $state, $stateActive = 0)
    {
        $orderId = null;

        $sberPay = new \System\Utils\Payments\SberPayment($cid);
        $orderId = $sberPay->getOrderId();

        if (!$orderId)
            throw new Exception('Payment not found', 404);

        $opersModel = new \Models\Operations();
        $oper = $opersModel->getOperByPayId($orderId);

        if (!$oper || $oper['oState'] != $stateActive)
            throw new Exception('Operation not found', 404);

        $opersModel->updateParams($oper['oID'], array('oOrder' => time()));
        return $opersModel->updateState($oper['oID'], $state);
    }
}
