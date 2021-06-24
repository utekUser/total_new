<?php
define("MEDIA_ROOT_CATALOG", APPLICATION_PATH ."/public/slides");

class Slides_Controllers_AdminSlidesController extends Core_Controller_Action_Admin {

	protected $_controllerModel = 'Slides_Models_Slides';
	protected $_formTable = 'Slides_Form_Slides';
	protected $_dbTable = 'slides';
	
	public function indexAction() {
		$request = $this->getRequest(); // получение объекта запроса Engine_Controller_Request_Http

		$array = array('name', 'begindate', 'enddate');
		$form = new Slides_Form_Slides();
		$form->setTitle($array);
		$this->view->titles = $form->getTitle();
		if ($request->isPost()) { // если был POST запрос
			$request = $request->getPost();
			$model = new Slides_Models_Slides();
			$model->listAction($request['type'], $request['submit_mult']);
		}

		$ttt = new Slides_Models_Slides();
		$this->view->module = $this->_getParam('module');
		$this->view->add = $this->_getParam('module');

		$this->view->paginator = $ttt->getAllSlides();//getAll();
	}

	/**
	 * Добавление
	 *
	 */
	public function addAction() {
		$pageId = $this->_getParam('pageId');
		$request = $this->getRequest();
		$form = new Slides_Form_Slides();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Slides_Models_Slides();
				//$model->save($form->getElements(), $pageId);
				$data = array(
					'name' => $request->getPost('name'),
					'text' => $request->getPost('text'),
					'url' => $request->getPost('url'),
					'display' => $request->getPost('display'),
					'begindate' => $request->getPost('begindate'),
					'enddate' => $request->getPost('enddate'),
				);				
				$lastId = $model->saveSlide($data);			
				$updArr = array(
					'id' => $lastId,
					'file' => $this->uplSlideFile('file', $lastId),
					'filemobile' => $this->uplSlideFile('filemobile', $lastId)
				);			
				$model->changeFilesInSlide($updArr);
				$this->_redirector->gotoActionUrl('/admin/', $lastId);
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
		$pageId = $this->_getParam('pageId');
		$request = $this->getRequest();		
		$model = new Slides_Models_Slides();
		$rec = $model->getRecord($pageId);
		$form = new Slides_Form_Slides();
		foreach ($form->getElements() as $value) {
			$name = $value->getName();
			$value->setValue($rec->$name);
		}
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Slides_Models_Slides();
				//$model->save($form->getElements(), $pageId);
				$data = array(
					'id' => $pageId,
					'pos' => $request->getPost('pos'),
					'name' => $request->getPost('name'),
					'text' => $request->getPost('text'),
					'url' => $request->getPost('url'),
					'display' => $request->getPost('display'),
					'begindate' => $request->getPost('begindate'),
					'enddate' => $request->getPost('enddate'),
				);
				$model->updateSlide($data);	
				$updArr = array(
					'id' => $pageId,
					'file' => $this->uplSlideFile('file', $pageId),
					'filemobile' => $this->uplSlideFile('filemobile', $pageId)
				);	
				//print_r($updArr); die;
				if ($updArr['file'] == "") {
					$updArr['file'] = $request->getPost('file');
				}
				if ($updArr['filemobile'] == "") {
					$updArr['filemobile'] = $request->getPost('filemobile');
				}
				if (strlen($updArr['file']) > 0) {
					$model->changeFileInSlide($updArr);
				}
				if (strlen($updArr['filemobile']) > 0) {
					$model->changeModFileInSlide($updArr);
				}
				$this->_redirector->gotoActionUrl('/admin/', $model->getInsertId());
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
		$model = new Slides_Models_Slides();
		$model->listAction($pageId, 'delete');
		$this->removeDir(MEDIA_ROOT_CATALOG . '/' . $pageId);
		$this->_redirector->gotoActionUrl('/admin/slides/');
	}
	
	public function uplSlideFile($param, $lastId) {
		$pathPic = "";
		if ($_FILES[$param]['name']) {
			$md5File = md5_file($_FILES[$param]['tmp_name']);
			if (!is_dir(MEDIA_ROOT_CATALOG)) {
				mkdir(MEDIA_ROOT_CATALOG, 0777, true);
			}
			if (!is_dir(MEDIA_ROOT_CATALOG . '/' . $lastId)) {
				mkdir(MEDIA_ROOT_CATALOG . '/' . $lastId, 0777, true);
			}
			$fileName = substr($md5File, -(strlen($md5File) - 4)) . '.' . pathinfo($_FILES[$param]['name'], PATHINFO_EXTENSION);
			if (move_uploaded_file($_FILES[$param]['tmp_name'], MEDIA_ROOT_CATALOG . '/' . $lastId . '/' . $fileName)) {
				$pathPic = 'public/slides/' . $lastId . '/' . $fileName;
			}
		}
		return $pathPic;
	}

	public function removeDir($path) {		
		if (file_exists($path) AND is_dir($path)) {			
			$dir = opendir($path);
			while (false !== ( $element = readdir($dir) )) {				
				if ($element != '.' AND $element != '..') {
					$tmp = $path . '/' . $element;
					chmod($tmp, 0777);					
					if (is_dir($tmp)) {
						removeDir($tmp);						
					} else {
						unlink($tmp);
					}
				}
			}
			closedir($dir);
			if (file_exists($path)) {
				rmdir($path);
			}
		}
	}

}
