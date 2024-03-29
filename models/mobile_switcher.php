<?php    
defined('C5_EXECUTE') or die('Access Denied');

Loader::library('Browser', 'theme_options_lite');
class MobileSwitcher {

	public function checkForMobile($view) {	
		$page = Page::getCurrentPage();
		$browser = new Browser();
		if (!$page->isAdminArea()) {		
			if($browser->isMobile() && !isset($_COOKIE[SESSION.'_MOBILE'])) {
				define('IS_MOBILE_DEVICE', true);
				setcookie(SESSION.'_MOBILE', 2, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
				$theme = PageTheme::getByID(MobileSwitcher::getMobileThemeID());
				$view->setTheme($theme);
			}
		}
		MobileSwitcher::SetMobile($view);
	}

	public function SetMobile($view) {
		$page = Page::getCurrentPage();
		if (!$page->isAdminArea()) {
			if($_GET['site'] == 'full') {
				define('IS_MOBILE_DEVICE', false);
				setcookie(SESSION.'_MOBILE', 1, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
			} else
			if($_GET['site'] == 'mobile') {
				define('IS_MOBILE_DEVICE', true);
				setcookie(SESSION.'_MOBILE', 2, strtotime('+10 year'), DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
				$theme = PageTheme::getByID(MobileSwitcher::getMobileThemeID());
				$view->setTheme($theme);
			} else
			if($_GET['site'] == 'unset') {
				setcookie(SESSION.'_MOBILE', null, -1, DIR_REL.'/', '.'.$_SERVER['HTTP_HOST']);
			} else
			if (isset($_COOKIE[SESSION.'_MOBILE']) && $_COOKIE[SESSION.'_MOBILE'] == 2) {
				define('IS_MOBILE_DEVICE', true);
				$theme = PageTheme::getByID(MobileSwitcher::getMobileThemeID());
				$view->setTheme($theme);	
			}
		}
		if(!defined('IS_MOBILE_DEVICE')) {
			define('IS_MOBILE_DEVICE', false);
		}
	}
	
	public function getMobileThemeID() {
		$co = new Config();
		$pkg = Package::getByHandle("theme_options");
		$co->setPackageObject($pkg);
		return $co->get('MOBILE_SITE_THEME_ID');
	}
}