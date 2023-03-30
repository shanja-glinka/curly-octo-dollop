<?

namespace Models;

use \Exception;

final class OrderClients extends \System\Model
{
    public function __construct(&$connection = null)
    {
        parent::__construct('OrderClients', $connection);
    }


    
    public function findClient($clientId)
    {
        return $this->find1By('clientId=?d OR clientHash=?', array($clientId, $this->extractHash($clientId)));
    }

    public function getClientId($clientAtt)
    {
        $clinet = $this->findClient($clientAtt);

        if (!$clinet)
            return null;
        return $clinet['clientId'];
    }

    public function newClient($clientName)
    {
        $clientHash = $this->extractHash($clientName);
        if ($this->count('clientHash=?', array($clientHash)))
            return null;

        return $this->insert(array('clientFillName' => $clientName, 'clientHash' => $clientHash));
    }



    private function extractHash($str)
    {
        return md5(strtolower($str));
    }
}
