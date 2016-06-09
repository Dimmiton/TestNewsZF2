<?php

namespace Newses\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

use Zend\Db\Sql\Predicate\Expression;

use Zend\View\Model\ViewModel;

class NewsesTable
{
	protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false)
    {			
		if ($paginated){
			$select = new Select ('test_news');
			$resultSetPrototype = new ResultSet();
			$resultSetPrototype->setArrayObjectPrototype(new Newses());
			$paginatorAdapter = new DbSelect(
				$select,
				$this->tableGateway->getAdapter(),
				$resultSetPrototype
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		}
		$resultSet = $this->tableGateway->select();
        return $resultSet;
    }
	
	public function getPaginatorRows ($pageNumber = 1)
		{
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($this->select()));
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage(1);
		$paginator->setPageRange(1);
		return $paginator;
	}

    public function getNewsesByTheme($theme_id)
    {
        $theme_id  = (int) $theme_id;
        $resultSet = $this->tableGateway->select(array('theme_id' => $theme_id));
        return $resultSet;
    }
	
	public function getNewsesByID($news_id)
    {
        $news_id  = (int) $news_id;
        $resultSet = $this->tableGateway->select(array('news_id' => $news_id));
        return $resultSet;
    }
	
	public function getNewsesByYear($year)
    {
        $year  = (int) $year;
        $resultSet = $this->tableGateway->select(function (Select $select) use ($year){
			$select->columns(array(	
				'title' => new Expression('title'),
				'text' => new Expression('text'),
				'theme_id' => new Expression('theme_id'),
				'year' => new Expression('year(date)')));
			$select->having(array('year' => $year));
		});
		
        return $resultSet;
    }
	
	public function getNewsesByMonth($year, $month)
    {
        $year  = (int) $year;
		$month = (int) $month;
        $resultSet = $this->tableGateway->select/*array('date' => '2016-06-28'));*/(function (Select $select) use ($year, $month){
			$select->columns(array(	
				'title' => new Expression('title'),
				'text' => new Expression('text'),
				'theme_id' => new Expression('theme_id'),
				'year' => new Expression('year(date)'),
				'month' => new Expression('month(date)')));
			$select->having(array('year' => $year));
			$select->having(array('month' => $month));
		});
        return $resultSet;
    }
	
	public function fetchTheme()
    {			
		$resultSet = $this->tableGateway->select(function (Select $select) {
			$select->columns(array(
				'theme_id' => new Expression('DISTINCT(theme_id)'),
				'themesCount' => new Expression('COUNT(theme_id)')));
			$select->quantifier('DISTINCT');
            $select->group('theme_id');
            $select->order('theme_id');
		});
        return $resultSet;
    }
	
	public function fetchYear()
    {			
		$resultSet = $this->tableGateway->select(function (Select $select) {
			$select->columns(array(
				'date' => new Expression('year(date)')));
			$select->quantifier('DISTINCT');
            $select->group('date');
            $select->order('date DESC');
		});
        return $resultSet;
    }
	
	public function fetchDate(){
		$resultSet = $this->tableGateway->select(function (Select $select) {
			$select->columns(array(
				'month' => new Expression('monthname(date)'),
				'date'	=> new Expression('month(date)'),
				'year' => new Expression('year(date)'),
				'themesCount' => new Expression('COUNT(date)')));
			$select->quantifier('DISTINCT');
			$select->group('month');
            $select->group('year');
            $select->order('year DESC');
			$select->order('date');
		});
        return $resultSet;
	}		

}