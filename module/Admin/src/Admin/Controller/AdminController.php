<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\News;         
use Admin\Form\NewsForm;

class AdminController extends AbstractActionController
{
	protected $NewsTable;
	
    public function indexAction()
    {
		return new ViewModel(array(
            'newses' => $this->getNewsTable()->fetchAll(),
        ));
    }
		
    public function editAction()
    {
		$news_id = (int) $this->params()->fromRoute('news_id', 0);
        if (!$news_id) {
            return $this->redirect()->toRoute('admin', array(
                'action' => 'add'
            ));
        }

        try {
            $news = $this->getNewsTable()->getNews($news_id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('admin', array(
                'action' => 'index'
            ));
        }

        $form  = new NewsForm();
        $form->bind($news);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getNewsTable()->saveNews($news);

                return $this->redirect()->toRoute('admin');
            }
        }

        return array(
            'news_id' => $news_id,
            'form' => $form,
        );
    }
	
	public function getNewsTable()
    {
        if (!$this->NewsTable) {
            $sm = $this->getServiceLocator();
            $this->NewsTable = $sm->get('Admin\Model\NewsTable');
        }
        return $this->NewsTable;
    }
	
	public function addAction()
    {
        $form = new NewsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $news = new News();
            $form->setInputFilter($news->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $news->exchangeArray($form->getData());
                $this->getNewsTable()->saveNews($news);
                
                return $this->redirect()->toRoute('admin');
            }
        }
        return array('form' => $form);
    }

}