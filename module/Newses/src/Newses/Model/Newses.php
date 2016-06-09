<?php

namespace Newses\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Newses
{
    public $news_id;
    public $date;
    public $theme_id;
	public $text;
	public $title;
	public $themesCount;
	protected $inputFilter; 
	

    public function exchangeArray($data)
    {
        $this->news_id     = (!empty($data['news_id'])) ? $data['news_id'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
        $this->theme_id  = (!empty($data['theme_id'])) ? $data['theme_id'] : null;
		$this->text  = (!empty($data['text'])) ? $data['text'] : null;
		$this->title  = (!empty($data['title'])) ? $data['title'] : null;
		$this->themesCount  = (!empty($data['themesCount'])) ? $data['themesCount'] : null;		
		$this->month  = (!empty($data['month'])) ? $data['month'] : null;
		$this->year  = (!empty($data['year'])) ? $data['year'] : null;
    }
}