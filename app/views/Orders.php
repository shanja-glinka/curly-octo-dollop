<?

namespace Views;

class Orders extends \System\Views
{

    use \System\Traits\PaymentSystem;
    

    public function __construct()
    {
        parent::__construct();
    }

    public function operStateToView($stateIndex) {
        $stateIndex = $stateIndex + 0;
        $operStates = array(
            0 => 'ожидется оплата',
            1 => 'оплачено',
            2 => 'отменено',
            3 => 'отклонено',
            9 => 'ошибка'
        );

        return $operStates[$stateIndex];
    }

    public function formatView($args)
    {
        if (!$args or !count($args))
            return null;

            
        $order = array();

        $totalOrderSum = 0.0;
        $payment = null;

        foreach ($args as $index => $values) {
            if ($index === 'roID') {
                if (is_array($payment) or !count($values))
                    continue;

                $payment = array();
                $payment['payID'] = $values['oID'];
                $payment['paySysID'] = $this->getPaySys($values['ocID'])['cName'];
                $payment['paySum'] = number_format($values['oSum'],  2, '.', ' ');
                $payment['payCreated'] = \System\Utils\TimeWorker::stampToViewFormat($values['oCTS']);
                $payment['payUpdated'] = \System\Utils\TimeWorker::stampToViewFormat($values['oUTS']);
                $payment['payStateId'] = $values['oState'];
                $payment['payState'] = $this->operStateToView($values['oState']);

                continue;
            }

            $order[$index] = [
                'orderID' => $values['rID'],
                'clientFillName' => $values['clientFillName'],
                'productName' => $values['pName'],
                'productCount' => $values['rCount'],
                'productSum' => number_format($values['rSum'],  2, '.', ' ')
            ];

            $totalOrderSum += (floatval($values['rSum']) * ($values['rCount'] + 0));
        }

        $order['payment'] = $payment;
        $order['totalSum'] = number_format($totalOrderSum,  2, '.', ' ');


        // \System\Utils\Debug::varDump($order);
        return $order;
    }

    
}
