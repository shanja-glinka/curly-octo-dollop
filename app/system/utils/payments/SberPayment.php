<?

namespace System\Utils\Payments;

// class SberPayment implements \System\Interfaces\IPayment
class SberPayment
{
    use \System\Traits\PaymentSystem;

    private $apiURL;
    private $paymentData = array();

    public function __construct($cID)
    {
        $this->apiURL = 'https://3dsec.sberbank.ru/payment/rest';
        $this->paymentData = $this->getPaySys($cID);
    }


    public function newOrder($params)
    {
        $requestData = $this->extractParams($params);
        $requestParam = [
            'host' => $this->apiURL . '/register.do',
            'method' => 'POST',
            'requestValue' => $requestData
        ];

        // EXAMPLE RETURN
        return $this->requestExtract($this->makeRequest($requestParam));
    }

    public function getOrderId()
    {
        $request = new \System\Request();
        return $request->val('orderId');
    }



    private function requestExtract($requestData)
    {
        if (!is_array($requestData) or !isset($requestData['errorCode']))
            return null;

        return [
            'id' => $requestData['orderId'],
            'errorCode' => $requestData['errorCode'],
            'url' => $requestData['formUrl']
        ];
    }

    private function makeRequest($erquestParam)
    {
        return json_decode(
            '{
                "errorCode":"0",
                "orderId":"51858812-8013-0b1f-5129-61246a7184c7",
                "formUrl":"https://3dsec.sberbank.ru/payment/merchants/test/payment_ru.html?mdOrder=51858812-8013-0b1f-5129-61246a7184c7"
            }',
            true
        );

        // НЕ НАШЕЛ userName для теста sberApi
        $request = new \System\Request();
        $res = @json_decode($request->sendRequest($erquestParam, true), true);

        return $res;
    }

    private function extractParams($params)
    {
        return [
            // 'token' => $this->paymentData['cAPIKey'],
            'userName' => $this->paymentData['cSCI']['userName'],
            'password' => $this->paymentData['cSCI']['password'],
            'orderNumber' => $params['id'],
            'amount' => $params['sum'] * 100,
            'description' => (!$params['id'] ? '' : $params['id']),
            'returnUrl' => ($params['success'] ? $params['success'] : ('https://' . $_SERVER['HTTP_HOST'] . '/payment/' . $this->paymentData['cID'] . '/callback/success')),
            'failUrl' => ($params['fail'] ? $params['fail'] : ('https://' . $_SERVER['HTTP_HOST'] . '/payment/' . $this->paymentData['cID'] . '/callback/fail'))
        ];
    }
    
}
