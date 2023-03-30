<?

namespace Controllers;

use Exception;

class Index extends \System\Controllers
{

    public function __construct()
    {
        parent::__construct();
    }



    public function Home()
    {
        $products = $this->getProducts();

        $this->responce->setContentType('text');
        return $this->responce->withHtml(new \System\TemplateData('index.html', array('products' => $products)));
    }



    private function getProducts()
    {
        $productModel = new \Models\Products();
        $products = $productModel->getProducts();

        $this->setView('Products');
        return $this->renderView('getProducts', $products);
    }

    
}
