<?php
class Sitemap_Controllers_AdminSitemapController extends Core_Controller_Action_Admin {
    public function indexAction() {
        $request = $this->getRequest();
        $array = array('name', 'pos');
        $form = new Sitemap_Form_Sitemap();
        $form->setTitle($array);
        $this->view->titles = $form->getTitle();        
        if ($request->isPost()) {
            $request = $request->getPost();
            if ($request['type']) {
                $model = new Sitemap_Models_Sitemap();
                $model->listAction($request['type'], $request['submit_mult']);
            }
        }    
        $ttt = new Sitemap_Models_Sitemap();
        $this->view->module = $this->_getParam('module');
        $this->view->add = $this->_getParam('module');        
        $this->view->paginator = $ttt->getAllSitemaps(); //getAll();
    }
    
    public function addAction() {
        $pageId = $this->_getParam('pageId');        
        $request = $this->getRequest();
        $form = new Sitemap_Form_Sitemap();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $model = new Sitemap_Models_Sitemap();
                $model->savePage($form->getElements(), $pageId);
                $this->_redirector->gotoActionUrl('/admin/', $model->getInsertId());
            }
        }        
        //$error = $form->getMessages();        
        $this->view->module = $this->_getParam('module');
        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }
    
    public function editAction() {
        $request = $this->getRequest();
        $pageId = $this->_getParam('pageId');
        $model = new Sitemap_Models_Sitemap();
        $rrr = $model->getRecord($pageId);
        $form = new Sitemap_Form_Sitemap();
        foreach ($form->getElements() as $value) {
            $nnn = $value->getName();
            $value->setValue($rrr->$nnn);
        }        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $model = new Sitemap_Models_Sitemap();
                $model->savePage($form->getElements(), $pageId);                
                $this->_redirector->gotoActionUrl('/admin/', $pageId);
            }
        }        
        //$error = $form->getMessages();
        $this->view->module = $this->_getParam('module');
        $this->view->id = $pageId;
        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }
    
    public function deleteAction() {
        $pageId = $this->_getParam('pageId');        
        $model = new Sitemap_Models_Sitemap();
        $model->listAction($pageId, 'delete');        
        $filename = APPLICATION_PATH . '/temporary/cache/sitemap-' . $pageId;
        if (file_exists($filename)) {
            unlink($filename);
        }        
        $this->_redirector->gotoActionUrl('/admin/sitemap/');
    }
}