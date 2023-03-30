<?

namespace Models;

use \Exception;

final class Products extends \System\Model
{
    public function __construct(&$connection = null)
    {
        parent::__construct('Orders', $connection);
    }


    public function getProducts()
    {
        return $this->connection->fetchRows($this->connection->select('Products'));
    }

    public function getProduct($id)
    {
        return $this->connection->fetch1Row($this->connection->select('Products', '*', 'pID=?d', array($id)));
    }
}
