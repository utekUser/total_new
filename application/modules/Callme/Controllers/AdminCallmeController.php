<?php

class Callme_Controllers_AdminCallmeController extends Core_Controller_Action_Admin {

    public function indexAction() {
        $request = $this->getRequest();
        $array = array('name', 'phone', 'date');
        $form = new Callme_Form_Callme();
        $form->setTitle($array);
        $this->view->titles = $form->getTitle();
        if ($request->isPost()) { // если был POST запрос
            $request = $request->getPost();
            $model = new Callme_Models_Callme();
            $model->listAction($request['type'], $request['submit_mult']);
        }
        $ttt = new Callme_Models_Callme();
        $this->view->module = $this->_getParam('module');
        $this->view->add = $this->_getParam('module');
        $this->view->paginator = $ttt->getAllCallmes(); //getAll();
    }

    /**
     * Добавление
     *
     */
    public function addAction() {
        $pageId = $this->_getParam('pageId');
        $request = $this->getRequest();
        $form = new Callme_Form_Callme();
        if ($request->isPost()) { // если был POST запрос
            if ($form->isValid($request->getPost())) {
                $model = new Callme_Models_Callme();
                $model->save($form->getElements(), $pageId);
                $this->_redirector->gotoActionUrl('/admin/', $model->getInsertId());
            }
        }
        $this->view->module = $this->_getParam('module');
        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }

    /**
     * Редактирование
     *
     */
    public function editAction() {
        $request = $this->getRequest();
        $pageId = $this->_getParam('pageId');
        $model = new Callme_Models_Callme();
        $rrr = $model->getRecord($pageId);

        $form = new Callme_Form_Callme();
        foreach ($form->getElements() as $value) {
            $nnn = $value->getName();
            $value->setValue($rrr->$nnn);
        }
        if ($request->isPost()) { // если был POST запрос
            if ($form->isValid($request->getPost())) {
                $model = new Callme_Models_Callme();
                $model->save($form->getElements(), $pageId);

                $this->_redirector->gotoActionUrl('/admin/', $pageId);
            }
        }
        $this->view->module = $this->_getParam('module');
        $this->view->id = $pageId;
        $this->view->elements = $form->getElements();
        $this->view->form = $form;
    }

    /**
     * Удаление
     *
     */
    public function deleteAction() {
        $pageId = $this->_getParam('pageId');
        $model = new Callme_Models_Callme();
        $model->listAction($pageId, 'delete');
        $this->_redirector->gotoActionUrl('/admin/callme/');
    }

}
