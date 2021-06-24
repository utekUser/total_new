<?php

class Texts_Controllers_AdminTextsController extends Core_Controller_Action_Admin {

	public function indexAction() {
		$request = $this->getRequest();
		$array = array('name', 'pos');
		$form = new Texts_Form_Texts();
		$form->setTitle($array);
		$this->view->titles = $form->getTitle();
		if ($request->isPost()) {
			$request = $request->getPost();
			$model = new Texts_Models_Texts();
			$model->listAction($request['type'], $request['submit_mult']);
		}
		$ttt = new Texts_Models_Texts();
		$this->view->module = $this->_getParam('module');
		$this->view->add = $this->_getParam('module');
		$this->view->paginator = $ttt->getAllTexts(); //getAll();
	}

	/**
	 * Добавление
	 *
	 */
	public function addAction() {
		$pageId = $this->_getParam('pageId');
		$request = $this->getRequest();
		$form = new Texts_Form_Texts();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Texts_Models_Texts();
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
		$model = new Texts_Models_Texts();
		$rrr = $model->getRecord($pageId);
		$form = new Texts_Form_Texts();
		foreach ($form->getElements() as $value) {
			$nnn = $value->getName();
			$value->setValue($rrr->$nnn);
		}
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Texts_Models_Texts();
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
		$model = new Texts_Models_Texts();
		$model->listAction($pageId, 'delete');
		$this->_redirector->gotoActionUrl('/admin/texts/');
	}

}
