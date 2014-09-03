<?php
namespace Category\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class CategoryForm extends Form
{
	public function __construct(){
		parent::__construct('product');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'name',
			'attributes' => array(
                'type'  => 'text',
                'id' => 'txt-name',
                'class' => 'form-control',
            ),
			'options' => array(
				'label' => 'Código',
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Guardar',
				'id' => 'submitbutton',
				'class' => 'btn btn-success',
			),
		));
	}

}