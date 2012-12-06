<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options
 * @category Controller
 * @author Michael Krasnow <mike@c5rockstars.com>
 * @copyright  Copyright (c) 2010-2011 C5Rockstars. (http://www.c5rockstars.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
Loader::model('social', 'theme_options_lite');

class DashboardThemeOptionsLiteSocialController extends Controller { 	

	public function on_start() {
		$this->token = Loader::helper('validation/token');
		$this->set('networks', Social::getNetworkList());
	}	
	
	public function delete($sID = false, $token = false) {
		if (!$this->token->validate("delete_network", $token)) {
			$this->set('error', array($this->token->getErrorMessage()));
			return;
		}
		$obj = Social::getByID($sID);
		if(is_object($obj)) {
			$obj->delete();
			$this->redirect("/dashboard/theme_options_lite/social", "social_network_deleted");
		} else {
			throw new exception(t('Invalid Social ID!'));
		}
	
	}
	
	public function edit($sID = false) {
		$obj = Social::getByID($sID);
		if(is_object($obj)) {
			$this->set('network', $obj);
		} else {
			throw new exception(t('Invalid Social ID!'));
		}
	
	}
	
	public function save_networks() {
		if (!$this->token->validate("save_networks")) {
			$this->set('error', array($this->token->getErrorMessage()));
			return;
		}
		$txt = Loader::helper('text');
		//var_dump($this->post());
		foreach($this->post() as $handle => $value) {
			$obj = Social::getByHandle($handle);
			if(is_object($obj)) {
				$obj->setValue($txt->entities($value));
			}
		}

		$this->redirect("/dashboard/theme_options_lite/social", "social_networks_saved");
	}
	
	public function save_network_edit() {
		if (!$this->token->validate("save_network_edit")) {
			$this->set('error', array($this->token->getErrorMessage()));
			return;
		}
		//var_dump($this->post());
		$txt = Loader::helper('text');
		if(!$this->post('handle') && !$txt->entities($this->post('name'))) {
			$this->set('error', array(t('Please enter values for the Name and Handle!')));
			return;
		}
		$obj = Social::getByID($this->post('sID'));
		if(is_object($obj)) {
			$obj->setHandle($this->post('handle'));
			$obj->setName($txt->entities($this->post('name')));
		}

		$this->redirect("/dashboard/theme_options_lite/social", "social_network_updated");
	}
	
	public function add_new_network() {
		if (!$this->token->validate("add_new_network")) {
			$this->set('error', array($this->token->getErrorMessage()));
			return;
		}
		$txt = Loader::helper('text');
		if(!$this->post('handle') && !$txt->entities($this->post('name'))) {
			$this->set('error', array(t('Please enter values for the Name and Handle!')));
			return;
		}
		Social::add($this->post('handle'), $txt->entities($this->post('name')));

		$this->redirect("/dashboard/theme_options_lite/social", "social_network_added");
	}
	
	public function social_network_deleted() {
		$this->set('message', t('Social Network deleted.'));
	}
		
	public function social_networks_saved() {
		$this->set('message', t('Social Networks saved.'));
	}
	
	public function social_network_updated() {
		$this->set('message', t('Social Network updated.'));
	}
	
	public function social_network_added() {
		$this->set('message', t('Social Network added.'));
	}
	
}