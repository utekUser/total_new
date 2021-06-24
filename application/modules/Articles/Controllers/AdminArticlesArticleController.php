<?php

class Articles_Controllers_AdminArticlesArticleController extends Core_Controller_Action_Admin {

	/**
	 * Редиректор - определен для полноты кода
	 *
	 * @var Zend_Controller_Action_Helper_Redirector
	 */
	protected $_redirector = null;
	protected $_form = array(
		'Articles_Form_ArticlesArticle'
	); // Классы для создания и/или обновления таблиц в БД

	/**
	 * Инициализация
	 *
	 */

	public function init() {
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}

	/**
	 * Главная, листинг
	 *
	 */
	public function indexAction() {
		$request = $this->getRequest();
		$array = array('name', 'posted');
		$form = new Articles_Form_ArticlesArticle();
		$form->setTitle($array);
		$this->view->titles = $form->getTitle();
		if ($request->isPost()) {
			$request = $request->getPost();
			$model = new Articles_Models_ArticlesArticle();
			$model->listAction($request['type'], $request['submit_mult']);
			$this->_redirector->gotoActionUrl('/admin/');
		}
		$ttt = new Articles_Models_ArticlesArticle();
		$this->view->add = $pageId = $this->_getParam('module');
		$this->view->paginator = $ttt->getAllArticles(); //getAll();
	}

	/**
	 * Добавление
	 *
	 */
	public function addAction() {
		$pageId = $this->_getParam('pageId');
		$request = $this->getRequest();
		$form = new Articles_Form_ArticlesArticle();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Articles_Models_ArticlesArticle();
				$model->save($form->getElements(), $pageId);
				$this->_redirector->gotoActionUrl('/admin/', $model->getInsertId());
			}
		}
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
		$model = new Articles_Models_ArticlesArticle();
		$rrr = $model->getRecord($pageId);
		$form = new Articles_Form_ArticlesArticle();
		foreach ($form->getElements() as $value) {
			$nnn = $value->getName();
			$value->setValue($rrr->$nnn);
		}
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Articles_Models_ArticlesArticle();
				$model->save($form->getElements(), $pageId);
				$this->_redirector->gotoActionUrl('/admin/', $pageId);
			}
		}
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
		$model = new Articles_Models_ArticlesArticle();
		$model->listAction($pageId, 'delete');		
		$this->_redirector->gotoActionUrl('/admin/articles/article/');
	}

}
