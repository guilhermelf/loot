<?php
class System extends Route {
	private $_url;
	private $_explode;
	private $_controller;
	private $_action;
	
	function __construct() {
		$this->setUrl();
		$this->setExplode();
		$this->setController();
		$this->setAction();
	}
	
	private function setUrl() {
		$this->_url = (empty($_GET['url']) ? 'index' : $_GET['url']);
	}

	private function setExplode() {
		$this->_explode = explode("/", $this->_url);
	}

	private function setController() {
		$this->_controller = $this->_explode[0];
	}

	private function setAction() {
		$this->_action = (empty($this->_explode[1]) ? 'index_action' : $this->_explode[1]);
	}
	
	function run() {
		if(file_exists(CONTROLLERS.$this->_controller.'Controller.php')) {
			require_once(CONTROLLERS.$this->_controller.'Controller.php');
			
			if(class_exists($this->_controller)) {
				$controller = new $this->_controller();
				$action = $this->_action;
				
				if(method_exists($controller, $action)) {
					$controller->$action();
				} else {
					parent::route($this->_url, $this->_explode);
				}
			} else {
				parent::route($this->_url, $this->_explode);
			}
		} else {
			parent::route($this->_url, $this->_explode);
		}
	}
}
?>