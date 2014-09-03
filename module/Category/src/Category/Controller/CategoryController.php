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

	}

	public function editAction(){

	}

	public function deleteAction(){

	}
}