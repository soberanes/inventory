<?php
namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Category\Model\Category;
use Category\Form\CategoryForm;

class CategoryController extends AbstractActionController
{
	protected $categoryTable;

	public function _predump($a){
		echo "<pre>";
		var_dump($a);
		echo "</pre>";
		die;
	}
	 
	public function getCategoryTable()
    {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Category\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
	
	public function indexAction(){
		$categories = $this->getCategoryTable()->fetchAll();
		return new ViewModel(array(
            'categories' => $categories,
        ));
	}

	public function addAction(){
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new CategoryForm($dbAdapter);
		
		$form->get('submit')->setValue('Guardar');
		
		$request = $this->getRequest();
		if($request->isPost()){
			$category = new Category();
			$form->setInputFilter($category->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				$category->exchangeArray($form->getData());
				$this->getCategoryTable()->saveCategory($category);
				
				//redirect
				return $this->redirect()->toRoute('category');
			}
		}
		return array('form' => $form);
	}

	public function editAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		if(!$id){
			return $this->redirect()->toRoute('category', array('action' => 'add'));
		}
		
		try{
			$category = $this->getCategoryTable()->getCategory($id);
		}catch(\Exception $ex){
			return $this->redirect()->toRoute('category', array('action' => 'index'));	
		}
		
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$form = new CategoryForm($dbAdapter);

		$form->bind($category);
		$form->get('submit')->setAttribute('value', 'Guardar');
		
		$request = $this->getRequest();
		if($request->isPost()){
			$form->setInputFilter($category->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				$this->getCategoryTable()->saveCategory($category);
				return $this->redirect()->toRoute('category');
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
			return $this->redirect()->toRoute('category');
		}
		
		$request = $this->getRequest();
		if($request->isPost()){
			$del = $request->getPost('del', 0);
			
			
			
			if($del == 1){
				$id = (int) $request->getPost('id');
				$this->getCategoryTable()->deleteCategory($id);
				
			}
			return $this->redirect()->toRoute('category');
		}
		return array(
			'id' => $id,
			'category' => $this->getCategoryTable()->getCategory($id),
		);
	}
}