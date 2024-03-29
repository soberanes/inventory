<?php
namespace Category\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoryTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
    }

    public function _predump($a){
		echo "<pre>";
		var_dump($a);
		echo "</pre>";
		die;
	}

    public function fetchAll(){
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getCategory($id){
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if(!$row){
			throw new \Exception('Could not find row $id');
		}
		return $row;
	}
	
	public function saveCategory(Category $category){
		$data = array(
			'name' => $category->name,
		);
		
		$id = (int) $category->id;
		if($id == 0){
			$this->tableGateway->insert($data);
		}else{
			if($this->getCategory($id)){
				$this->tableGateway->update($data, array('id' => $id));
			}else{
				throw new \Exception('Category id does not exist');
			}
		}
	}
	
	public function deleteCategory($id){
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}