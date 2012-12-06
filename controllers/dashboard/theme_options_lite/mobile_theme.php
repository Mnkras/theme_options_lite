<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options
 * @category Controller
 * @author Michael Krasnow <mike@c5rockstars.com>
 * @copyright  Copyright (c) 2010-2011 C5Rockstars. (http://www.c5rockstars.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class DashboardThemeOptionsLiteMobileThemeController extends Controller { 	

	protected $helpers = array('html');

	public function view() {
		
		$tArray = array();
		
		$tArray = PageTheme::getList();
		
		$this->set('tArray', $tArray);
		$siteThemeID = 0;
		$co = new Config();
		$pkg = Package::getByHandle("theme_options_lite");
		$co->setPackageObject($pkg);
		$obj = $co->get('MOBILE_SITE_THEME_ID');
		if($obj) {
			$siteThemeID = $obj;
		}
		
		$this->set('siteThemeID', $siteThemeID);
	}

	public function on_start() {
		$co = new Config();
		$pkg = Package::getByHandle("theme_options_lite");
		$co->setPackageObject($pkg);
		$enabled = $co->get('MOBILE_SITE_THEME_ENABLED');
		$this->set('disableThirdLevelNav', true);
		$this->set('mobile_enabled', $enabled);
	}
		
	public function activate_confirm($ptID, $token) {
		$l = PageTheme::getByID($ptID);
		$val = Loader::helper('validation/error');
		$valt = Loader::helper('validation/token');
		if (!$valt->validate('activate_mobile', $token)) {
			$val->add($valt->getErrorMessage());
			$this->set('error', $val);
		} else if (!is_object($l)) {
			$val->add('Invalid Theme');
			$this->set('error', $val);
		} else {
			$co = new Config();
			$pkg = Package::getByHandle("theme_options_lite");
			$co->setPackageObject($pkg);
			$obj = $co->save('MOBILE_SITE_THEME_ID', $ptID);
			$this->set('message', t('Mobile Theme activated'));
		}
		$this->view();
	}
	
	public function mobile_enabled() {
		$val = Loader::helper('validation/error');
		$valt = Loader::helper('validation/token');
		if (!$valt->validate('mobile_enabled')) {
			$val->add($valt->getErrorMessage());
			$this->set('error', $val);
		} else {
			$co = new Config();
			$pkg = Package::getByHandle("theme_options_lite");
			$co->setPackageObject($pkg);
			$obj = $co->save('MOBILE_SITE_THEME_ENABLED', $this->post('MOBILE_ENABLED'));
			$this->set('message', t('Mobile Setting Saved'));
		}
		$this->view();
	}
	

}