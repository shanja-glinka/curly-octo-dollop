<?

namespace System\Traits;

trait PaymentSystem
{

    public function getPaySys($psysID)
    {
        $psysList = @require(AssetsDirectory . '/data/payments.php');

        if (!$psysList[$psysID])
            return null;

        return $this->loadPsysList()[$psysID];
    }

    public function getDefaultPsys()
    {
        return $this->loadPsysList()[1];
    }


    private function loadPsysList()
    {
        $psysList = @require(AssetsDirectory . '/data/payments.php');

        if (!is_array($psysList))
            return array();

        return $psysList;
    }
}
