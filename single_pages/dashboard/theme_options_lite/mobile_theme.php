<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options
 * @category Single Page
 * @author Michael Krasnow <mike@c5rockstars.com>
 * @copyright  Copyright (c) 2010-2011 C5Rockstars. (http://www.c5rockstars.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
$bt = Loader::helper('concrete/interface');
$valt = Loader::helper('validation/token');
$form = Loader::helper('form');

$alreadyActiveMessage = t('This theme is currently active on your mobile site.');
?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Enable Mobile Theme'), false, false, false);?>
	<form method="post" id="mobile_enabled" action="<?php   echo View::url('dashboard/theme_options_lite/mobile_theme', mobile_enabled)?>">
		<div class="ccm-pane-body">
			<div class="clearfix inputs-list">
				<?php   echo $valt->output('mobile_enabled')?>
				<label for="MOBILE_ENABLED"><?php   echo $form->checkbox('MOBILE_ENABLED', 1, $mobile_enabled)?><span><?php   echo t('Mobile Theme Enabled')?></span></label>
			</div>
		</div>
		<div class="ccm-pane-footer">
			<?php   echo $bt->submit(t('Save'), 'mobile_enabled', 'right', 'primary');?>
		</div>
	</form>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Mobile Themes'), false, false, false);?>
	
	<div class="ccm-pane-body">	
		<h2><?php   echo t('Choose a theme that will be shown to mobile devices:')?></h2>
		<br />
		<table border="0" cellspacing="0" cellpadding="0" id="ccm-template-list">
			<?php  
			if (count($tArray) == 0) { ?>
				<tr>
					<td colspan="5"><?php   echo t('No themes are available.')?></td>
				</tr>
			<?php   } else {
				foreach ($tArray as $t) { ?>
					<tr <?php   if ($siteThemeID == $t->getThemeID()) { ?> class="ccm-theme-active" <?php   } ?>>
						<td><?php   echo $t->getThemeThumbnail()?></td>
						<td class="ccm-template-content">
							<h2><?php   echo $t->getThemeName()?></h2>
							<?php   echo $t->getThemeDescription()?>
							<br/><br/>
							<?php   if ($siteThemeID == $t->getThemeID()) { ?>
								<?php   echo $bt->button_js(t("Activate"), "alert('" . $alreadyActiveMessage . "')", "right", "primary ccm-button-inactive");?>&nbsp;
							<?php   } else { ?>
								<?php   echo $bt->button(t("Activate"), $this->url('/dashboard/theme_options_lite/mobile_theme','activate_confirm', $t->getThemeID(), $valt->generate('activate_mobile')), "right", 'primary');?>&nbsp;
							<?php   } ?>
							<?php   echo $bt->button_js(t("Preview"), "ccm_previewInternalTheme(1, " . intval($t->getThemeID()) . ",'" . addslashes(str_replace(array("\r","\n",'\n'),'',$t->getThemeName())) . "')", "right");?>&nbsp;
						</td>
					</tr>
				<?php   }
			} ?>

		</table>
	</div>
	<div class="ccm-pane-footer"></div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>