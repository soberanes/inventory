<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\Product;
use Product\Form\ProductForm;

class ProductController extends AbstractActionController
{
	protected $productTable;
	 
	public function getProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Product\Model\ProductTable');
        }
        return $this->productTable;
    }
	
	public function indexAction(){
		$products = $this->getProductTable()->fetchAll();
		return new ViewModel(array(
            'products' => $products,
        ));
	}
	
	public function addAction(){
		
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new ProductForm($dbAdapter);
		
		$form->get('submit')->setValue('Guardar');
		
		$request = $this->getRequest();
		if($request->isPost()){
			$product = new Product();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				$product->exchangeArray($form->getData());
				$this->getProductTable()->saveProduct($product);
				
				//redirect
				return $this->redirect()->toRoute('product');
			}
		}
		return array('form' => $form);
	}
	
	public function editAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		if(!$id){
			return $this->redirect()->toRoute('product', array('action' => 'add'));
		}
		
		try{
			$product = $this->getProductTable()->getProduct($id);
		}catch(\Exception $ex){
			return $this->redirect()->toRoute('product', array('action' => 'index'));	
		}
		
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new ProductForm($dbAdapter);

		$form->bind($product);
		$form->get('submit')->setAttribute('value', 'Guardar');
		
		$request = $this->getRequest();
		if($request->isPost()){
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				$this->getProductTable()->saveProduct($product);
				return $this->redirect()->toRoute('product');
			}
		}
		
		return array(
			'id' 	=> $id,
			'form'	=> $form,
		);
	}
	
	public function deleteAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		if(!$id){
			return $this->redirect()->toRoute('product');
		}
		
		$request = $this->getRequest();
		if($request->isPost()){
			$del = $request->getPost('del', 0);
			
			
			
			if($del == 1){
				$id = (int) $request->getPost('id');
				$this->getProductTable()->deleteProduct($id);
				
			}
			return $this->redirect()->toRoute('product');
		}
		return array(
			'id' => $id,
			'product' => $this->getProductTable()->getProduct($id),
		);
	}
	
	public function _predump($a){
		echo "<pre>";
		var_dump($a);
		echo "</pre>";
		die;
	}
}




