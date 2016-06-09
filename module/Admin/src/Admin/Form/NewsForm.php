<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class NewsForm extends Form
{
    public function __construct($name = null)
    {
        
        parent::__construct('admin');

        $this->add(array(
            'name' => 'news_id',
            'type' => 'Hidden',
        ));
		
		$this->add(array(
			'name' => 'date',
			'type' => 'Zend\Form\Element\date',
			'attributes' => array(
				'id' => 'datepicker',
				'type' => 'text'
			),
			'options' => array(
				'label' => 'Date'
			)
		));
		
		$this->add(array(
            'name' => 'theme_id',
            'type' => 'select',
			'attributes' => array(
				'min' => 1,
				'max' => 6,
			),
            'options' => array(
                'label' => 'Theme',
				'empty_option' => 'choose theme_id',
				'value_options' => array(
                             '1' => '1_id',
                             '2' => '2_id',
                             '3' => '3_id',
                             '4' => '4_id',
							 '5' => '5_id',
							 '6' => '6_id',
				),
            ),
        ));
		
		
		
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'text',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Text',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}