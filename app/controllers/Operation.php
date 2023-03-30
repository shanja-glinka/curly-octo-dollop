<?

namespace Controllers;

use Exception;

class Operation extends \System\Controllers
{

    public function __construct()
    {
        parent::__construct();
    }



    public function Index($operId)
    {
        $opersModel = new \Models\Operations();
        $orderId = $opersModel->getOperation($operId);

        if (!$orderId)
            throw new Exception("Order $operId not found", 404);

        $orderId = $orderId['orID'];

        $orderController = new \Controllers\Order();

        return $orderController->Index($orderId);
    }
}
