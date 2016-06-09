<?php

namespace Admin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class News
{
    public $news_id;
    public $date;
    public $theme_id;
	public $text;
	public $title;
	protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->news_id     = (!empty($data['news_id'])) ? $data['news_id'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
        $this->theme_id  = (!empty($data['theme_id'])) ? $data['theme_id'] : null;
		$this->text  = (!empty($data['text'])) ? $data['text'] : null;
		$this->title  = (!empty($data['title'])) ? $data['title'] : null;
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }

	public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'news_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
			
			$inputFilter->add(array(
                'name'     => 'theme_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'int'),
                ),
				'validators' => array(
                    array(
                        'name'    => 'Between',
                        'options' => array(
                            'min'      => 1,
                            'max'      => 6,
                        ),
                    ),
                ),
            ));
			
			$inputFilter->add(array(
                'name'     => 'date',
                'required' => true,
            ));

            $inputFilter->add(array(
                'name'     => 'text',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1800,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}