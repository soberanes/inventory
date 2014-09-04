<?php
namespace ProductRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Product\Model\Product;
use Product\Model\ProductTable;
use Product\Form\ProductForm;
use Zend\View\Model\JsonModel;

class ProductRestController extends AbstractRestfulController{

	protected $productTable;
	 
	public function getProductTable(){
        if (!$this->productTable){
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Product\Model\ProductTable');
        }
        return $this->productTable;
    }

	public function getList(){
		$results = $this->getProductTable()->fetchAll();
		$data = array();
		foreach($results as $result) {
			$data[] = $result;
		}
		 
		return new JsonModel(array(
			'data' => $data,
		));
	}

	public function get($id){
		$product = $this->getProductTable()->getProduct($id);
		return new JsonModel(array(
			'data' => $product,
		));
	}
    
}