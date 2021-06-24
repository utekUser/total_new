<?php
class News_controllers_IndexController extends Core_Controller_Action_User {
    public function init() {
        $this->pageId = $this->_getParam('urlToInt');
        if ($this->pageId) {
            Core_Controller_Action_User::setViewMain('view');
            Core_Controller_Action_User::setDefaultParseUrlAction('view');
        }
    }
    
    public function indexAction() {
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/news/" => "Новости"
		);
		$this->view->pageTitle = "Новости";
        $model = new News_Models_News();
        $this->view->paginator = $model->getNews();
    }
    
    public function viewAction() {
        $id = $this->_getParam('urlToInt');
        $action = $this->_getParam('action');
        
        $ttt = new News_Models_News();
        $ttt->addView($id);
        
		$newsCur = $ttt->getCurrentNew($id);
		$newLink = ($newsCur['url'] ? $newsCur['url'] . "-" : "");
		$_SESSION['UrlAfterAutorize'] = $_SERVER['REQUEST_URI'];
		$this->view->breadCrumbs = array(
			"/" => "Главная",
			"/news/" => "Новости",
			"/news/" . $newLink . $newsCur['id'] . ".html"  => $newsCur['name'],
		);
		$this->view->pageTitle = $newsCur['name'];
        $this->view->currentNew = $ttt->getCurrentNew($id);
    }
}