<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class NewsTable
{
	protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {			
		$resultSet = $this->tableGateway->select(function (Select $select) {
			$select->order('date DESC');
		});
        return $resultSet;
    }

    public function getNews($news_id)
    {
        $news_id  = (int) $news_id;
        $rowset = $this->tableGateway->select(array('news_id' => $news_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $news_id");
        }
        return $row;
    }

    public function saveNews(News $news)
    {
        $data = array(
            'text' => $news->text,
            'title'  => $news->title,
			'theme_id' => $news->theme_id,
			'date'=> $news->date,
        );

        $news_id = (int) $news->news_id;
        if ($news_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getNews($news_id)) {
                $this->tableGateway->update($data, array('news_id' => $news_id));
            } else {
                throw new \Exception('news_id does not exist');
            }
        }
    }
}