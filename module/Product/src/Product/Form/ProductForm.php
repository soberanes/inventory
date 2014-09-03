<?php
namespace Product\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class ProductForm extends Form
{
	protected $adapter;
	
	public function __construct(AdapterInterface $dbAdapter){
		
		$this->adapter = $dbAdapter;
		
		parent::__construct('product');
	
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'code',
			'attributes' => array(
                'type'  => 'text',
                'id' => 'txt-code',
                'class' => 'form-control',
            ),
			'options' => array(
				'label' => 'Código',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'name',
			'attributes' => array(
                'type'  => 'text',
                'id' => 'txt-name',
                'class' => 'form-control',
            ),
			'options' => array(
				'label' => 'Nombre',
			),
		));
		
		/*
		$this->add(array(
			'name' => 'category',
			'attributes' => array(
                'type'  => 'text',
                'id' => 'txt-category',
                'class' => 'form-control',
            ),
			'options' => array(
				'label' => 'Categoría',
				'class' => 'form-control',
			),
		));
		*/
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category',
            'attributes' => array(
				'id' => 'slc-category',
				'class' => 'form-control select'
			),
            'options' => array(
                    'label' => 'Author',
                    'empty_option' => 'Selecciona una categoría',
                    'value_options' => $this->getOptionsForSelect(),
            )
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
	
	public function getOptionsForSelect()
    {
        $dbAdapter = $this->adapter;
        $sql       = 'SELECT id,name  FROM categories ORDER BY name ASC';
        $statement = $dbAdapter->query($sql);
        $result    = $statement->execute();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['name'];
        }
        return $selectData;
    }
	
}