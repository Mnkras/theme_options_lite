<?php       
defined('C5_EXECUTE') or die("Access Denied.");

class ThemeOptionsLitePackage extends Package {

	protected $pkgHandle = 'theme_options_lite';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '1.2';
	
	public function getPackageName() {
		return t("Theme Options Lite");
	}
	
	public function getPackageDescription() {
		return t("Configure Theme Options.");
	}
	
	public function install() {
		$pkg = parent::install();
		
		Loader::model('single_page');

		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle.'/', $pkg);
		$sp->update(array('cName'=>t("Theme Options"), 'cDescription'=>t("Configure Theme Options.")));
		
		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle.'/social/', $pkg);
		$sp->update(array('cName'=>t("Social Networks"), 'cDescription'=>t("Configure Social Network Usernames.")));
		
		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle.'/mobile_theme/', $pkg);
		$sp->update(array('cName'=>t("Mobile Theme"), 'cDescription'=>t("Set a theme for mobile devices.")));
			
		//add some social stuff
		Loader::model('social', $this->pkgHandle);
		Social::add('rss', 'RSS');
		Social::add('twitter', 'Twitter');
		Social::add('facebook', 'Facebook');
		Social::add('youtube', 'YouTube');
		Social::add('tumblr', 'Tumblr');
		Social::add('digg', 'Digg');
		Social::add('aim', 'AIM');
		Social::add('skype', 'Skype');
		Social::add('formspring', 'Formspring');
		
		//add mobile theme stuff
		$co = new Config();
		$pkg = Package::getByHandle($this->pkgHandle);
		$co->setPackageObject($pkg);
		$co->save('MOBILE_SITE_THEME_ENABLED', 1);
		$co->save('MOBILE_SITE_THEME_ID', 0);

	}
	
	public function uninstall() {
		parent::uninstall();
		$db = Loader::db();
		$db->Execute('DROP TABLE IF EXISTS `ThemeOptionsSocialIDs`');//remove everthing!
	}
	
	public function on_start() {
	
		/* Mobile Device Stuff */
		$co = new Config();
		$pkg = Package::getByHandle($this->pkgHandle);
		$co->setPackageObject($pkg);
		$en = $co->get('MOBILE_SITE_THEME_ENABLED');
		$at = $co->get('MOBILE_SITE_THEME_ID');
		if($en == 1 && $at > 0) {
			Events::extend('on_start', 'MobileSwitcher', 'checkForMobile', './'.DIRNAME_PACKAGES.'/'.$this->pkgHandle.'/'.DIRNAME_MODELS.'/mobile_switcher.php');
		}
	}

}