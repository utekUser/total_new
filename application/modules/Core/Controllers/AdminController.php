<?php
/* ВЫВЕСТ�? В Engine_Controller url и Layout как у Zend_Controller_action */
//class Texts_Controllers_AdminController extends Engine_Controller_Action_Admin {
class Core_Controllers_AdminController extends Core_Controller_Action_Admin {
    protected $_form = array(
        'Cms_Form_CmsUser'
    ); // Классы дял создания и/или обновления таблиц в БД
    /**
     * �?нициализация
     *
     */
    public function init() {
        if(isset($_GET['mode']) && $_GET['mode'] == 'logout') {
            $auth = Zend_Auth::getInstance();
            $auth->setStorage(new Engine_Auth_Storage());
            $auth->clearIdentity();
            
            $this->_redirect('/admin/'); 
//            $this->_redirect('/admin/'); 
        }
        
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Engine_Auth_Storage());
        
        if ($auth->hasIdentity()) {			
            Core_Controller_Action_User::setViewMain('welcome');
        }
//        Core_Controller_Action_User::setViewMain('welcome');
//        exit;    
    }
   
    /**
     * Главная, листинг
     *
     */
    public function indexAction() {
        $request = $this->getRequest(); // получение объекта запроса Engine_Controller_Request_Http
        
        if ($request->isPost()) { // если был POST запрос
            
            $username = $_POST['login'];
            $password = $_POST['password'];
            
            // Получение синглтон экземпляра Zend_Auth
            $auth = Zend_Auth::getInstance();
            $auth->setStorage(new Engine_Auth_Storage());
            
            // Установка адаптера
            $authAdapter = new Engine_AuthUserAdmin($username, $password);
            
            // Попытка аутентификации, сохранение результата
            $result = $auth->authenticate($authAdapter);

            if (!$result->isValid()) {
                $this->view->error = $result->getMessages();
            } else {
				//echo "lol"; die;
                $this->_redirect('/admin/');
            }
        }
    }
    
    public function restoreAction() {
//        if (Engine_Auth::getAuth()) {
//            $this->_redirect('/admin/');
//        }
    }
    
    /**
     * Добавление
     *
     */
    public function addAction() {
        $request = $this->getRequest(); // получение объекта запроса...
        $form = new Texts_Form_Texts();
        
        if ($request->isPost()) {
            echo "!!!!!!!!!!!!!!!!!";    
        }
        
        $this->view->elements = $form->getElements();
        
        $form = new Texts_Form_Texts();
        $this->view->elements = $form->getElements();
        
        ////////
        $request = $this->getRequest();
        $form    = new Application_Form_Guestbook();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $comment = new Application_Model_Guestbook($form->getValues());
                $mapper  = new Application_Model_GuestbookMapper();
                $mapper->save($comment);
                return $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
    }
    
    /**
     * Изменение
     *
     */
    public function editAction() {
        $pageId = $this->_getParam('pageId');
        $model = new Texts_Models_Texts();
        $rrr = $model->getRecord($pageId);
        $form = new Texts_Form_Texts();
        foreach ($form->getElements() as $value) {
            $nnn = $value->getName();
            $value->setValue($rrr->$nnn);
        }
        $this->view->elements = $form->getElements();
    }
    
    /**
     * Удаление
     *
     */
    public function deleteAction() {

    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Engine_Auth_Storage());
        echo "!!!"; exit;
        $auth->clearIdentity();        
        $this->_redirect('/');
    }
}