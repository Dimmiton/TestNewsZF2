<?php

namespace Newses\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class NewsesController extends AbstractActionController
{
	protected $newsesTable;
	
    public function indexAction()
    {
		$paginator = $this->getNewsesTable()->fetchAll(true);
		$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(5);		
		
		$view = new viewModel(array(
			'paginator' => $paginator,
		));

		$theme = $this->getNewsesTable()->fetchTheme();
		$year = $this->getNewsesTable()->fetchYear();
		$date = $this->getNewsesTable()->fetchDate();

		$SidebarView = new ViewModel(array(
			'theme' => $theme,
			'year' => $year,
			'date' => $date
		));
		
        $SidebarView->setTemplate('newses/sidebar');
		$view ->addChild($SidebarView, 'sidebar');
		
		return $view;
    }

	public function getNewsesTable()
    {
        if (!$this->newsesTable) {
            $sm = $this->getServiceLocator();
            $this->newsesTable = $sm->get('Newses\Model\NewsesTable');
        }
        return $this->newsesTable;
    }
	
	public function NewsesByYearAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
             
        try {
            $newses = $this->getNewsesTable()->getNewsesByYear($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('newses', array(
                'action' => 'index'
            ));
        }
		
		$view = new viewModel(array(
			'newses' => $newses,
		));

        return $view;
	}
	
	public function NewsesByMonthAction()
	{
		$year = (int) $this->params()->fromRoute('id', 0);
		$month = (int) $this->params()->fromRoute('id1', 0);
		
             
        try {
            $newses = $this->getNewsesTable()->getNewsesByMonth($year, $month);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('newses', array(
                'action' => 'index'
            ));
        }
		
		$view = new viewModel(array(
			'newses' => $newses,
		));

        return $view;
	}
	
	public function NewsesByThemeAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        
        try {
            $newses = $this->getNewsesTable()->getNewsesByTheme($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('newses', array(
                'action' => 'index'
            ));
        }
		
		$view = new viewModel(array(
			'newses' => $newses,
		));
		
        return $view;
	}
	
	public function NewsByIDAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        
        try {
            $newses = $this->getNewsesTable()->getNewsesByID($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('newses', array(
                'action' => 'index'
            ));
        }
		
		$view = new viewModel(array(
			'newses' => $newses,
		));
		
        return $view;
	}
}