<?php
namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ProductTable
{
	
	protected $tableGateway;
	protected $select;
	
	public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
        $this->select 		= new Select();
    }
	
	public function _predump($a){
		echo "<pre>";
		var_dump($a);
		echo "</pre>";
		die;
	}
	
	public function fetchAll(){
		//TODO: get categories' name
		//$resultSet = $this->tableGateway->select();
		
		$select = $this->tableGateway->getSql()->select();
	    $select->join('categories', 'categories.id = products.category', array('category' => 'name'), 'left');


	    $resultSet = $this->tableGateway->selectWith($select);

		return $resultSet;
	}
	
	public function getProduct($id){
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if(!$row){
			throw new \Exception('Could not find row $id');
		}
		return $row;
	}
	
	public function saveProduct(Product $product){
		$data = array(
			'code'		=> $product->code,
			'name' 		=> $product->name,
			'category' 	=> $product->category,
		);
		
		$id = (int) $product->id;

		if($id == 0){
			$this->tableGateway->insert($data);
			$id = $this->tableGateway->getLastInsertValue();
		}else{
			if($this->getProduct($id)){
				$this->tableGateway->update($data, array('id' => $id));
				$id = $this->tableGateway->getLastInsertValue();
			}else{
				throw new \Exception('Product id does not exist');
			}
		}

		return $id;
	}
	
	public function deleteProduct($id){
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}
