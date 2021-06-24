<?php
class Shop_Controllers_AdminShopCatalogStructController extends Core_Controller_Action_Admin {
    /**
     * Редиректор - определен для полноты кода
     *
     * @var Zend_Controller_Action_Helper_Redirector
     */
    protected $_redirector = null;    
    protected $_form = array(
        'Shop_Form_ShopStock'
    ); 
    
    /**
     * �?нициализация
     *
     */
    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');        
        /*if (isset($_GET['manager']) && intval($_GET['manager'])) {
            Engine_Controller_Action::setViewMain('edit');
            Engine_Controller_Action::setDefaultParseUrlAction('edit');
        }*/
    }
   
    /**
     * Главная, листинг
     *
     */
    public function indexAction() {
        $ttt = new Shop_Models_OrderStock();
        
        if (isset($_GET['deactive']) && intval($_GET['deactive'])) {
            $ttt->deactivateOrder(intval($_GET['deactive']));
            $this->_redirect('/admin/shop/stock/');
        }
        
        $ttt = new Shop_Models_OrderStock();
        $this->view->paginator = $ttt->getStock();
    }
    
	/**
     * Добавление
     */
    public function addAction() {
        $pageId = $this->_getParam('pageId');        
        $request = $this->getRequest();
        
        $form = new Shop_Form_OrderStock();
        if ($request->isPost()) { // если был POST запрос
            if ($form->isValid($request->getPost())) {
                $model = new Shop_Models_OrderStock();
                $model->save($form->getElements(), $pageId);
                $this->_redirector->gotoActionUrl('/admin/', $model->getInsertId());
            }
        }

        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }
        	
	/**
     * Удаление
     */
    public function deleteAction() {
        $pageId = $this->_getParam('pageId');        
        $model = new Shop_Models_OrderStock();
        $model->listAction($pageId, 'delete');
        echo "!!!"; exit;
        $this->_redirector->gotoActionUrl('/admin/', $pageId);
    }	
	
     /**
     * Редактирование
     */
    public function editAction() {
        $request = $this->getRequest();        
        $pageId = $this->_getParam('pageId');
        $model = new Shop_Models_OrderStock();
        $rrr = $model->getRecord($pageId);
        $form = new Shop_Form_OrderStock();
        foreach ($form->getElements() as $value) {
            $nnn = $value->getName();
            $value->setValue($rrr->$nnn);
        }        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $model = new Shop_Models_OrderStock();
                $model->save($form->getElements(), $pageId);                
                $this->_redirector->gotoActionUrl('/admin/', $pageId);
            }
        }
        $this->view->id = $pageId;
        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }
}