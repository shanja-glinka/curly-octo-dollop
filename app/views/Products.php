<?

namespace Views;

class Products extends \System\Views
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts($args)
    {
        $products = array();

        foreach ($args as $values) {
            $products[$values['pID']] = [
                'name' => $values['pName'],
                'sum' => number_format($values['pSum'], 2, '.', ' ')
            ];
        }

        return $products;
    }
}
