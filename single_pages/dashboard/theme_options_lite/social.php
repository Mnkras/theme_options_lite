<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options
 * @category Single Page
 * @author Michael Krasnow <mike@c5rockstars.com>
 * @copyright  Copyright (c) 2010-2011 C5Rockstars. (http://www.c5rockstars.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
$ih = Loader::helper('concrete/interface');
$form = Loader::helper('form');
Loader::model('social', 'theme_options_lite');
$valt = Loader::helper('validation/form');
$val = Loader::helper('validation/token');
?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Social Network Options'), false, false, false);?>
	
	<?php  
	if ($this->controller->getTask() == 'edit') { ?>
		<form method="post" action="<?php  echo $this->action('save_network_edit')?>" id="theme-options-social-form">
			<div class="ccm-pane-body">
				<h4><?php   echo t('Edit %s Network', $network->getName())?></h4>
				<?php  echo $this->controller->token->output('save_network_edit');
				echo $form->hidden('sID', $network->getID());
				echo '<label for="name"><strong>'.t('Network Name').':&nbsp;</strong></label>';
				echo $form->text('name', $network->getName());
				echo '<span class="help-block">'.t('(eg. Some Network)').'<span>';
				echo '<div class="ccm-spacer">&nbsp;</div>';
				echo '<label for="handle"><strong>'.t('Network Handle').':&nbsp;</strong></label>';
				echo $form->text('handle', $network->getHandle());
				echo '<span class="help-block">'.t('(eg. some_network)').'</span>';
				echo '<div class="ccm-spacer">&nbsp;</div>
			</div>';
			echo '<div class="ccm-pane-footer">';
				echo $ih->submit(t('Save Network'), 'theme-options-social-form', 'right', 'primary');
				echo $ih->button(t('Cancel'), View::url('dashboard/theme_options_lite'), 'left');
				?>
			</div>
		</form>
	<?php  
	} else {
	?>
		<form method="post" action="<?php  echo $this->action('save_networks')?>" id="theme-options-social-form">
			<?php   echo $this->controller->token->output('save_networks');?>
			<div class="ccm-pane-body">
				<div class="ccm-dashboard-text">
					<table class="zebra-striped" width="100%" cellspacing="1" cellpadding="0" border="0">	
						<tbody>
							<tr>
								<td class="subheader"><strong><?php   echo t('Network Name')?></strong></td>
								<td class="subheader"><strong><?php   echo t('Profile URL')?></strong></td>
								<td class="subheader" style="width:25%;"></td>
							</tr>			
							<?php  
							if(count($networks) > 0) {
								foreach($networks as $network) {
									$edit = $ih->button(t('Edit'), View::url('dashboard/theme_options_lite/social/', 'edit', $network->getID()), 'left');
									$delete = $ih->button_js(t('Delete'), 'delete_confirm(\''.$network->getName().'\', \''.$network->getID().'\')', 'left', 'danger');
									echo '<tr>'."\n";
										echo '<td><label for="'.$network->getHandle().'"><strong>'.$network->getName().':</strong></label></td>'."\n";
										echo '<td>'.$form->text($network->getHandle(), $network->getValue(), array('style'=>'width:98%;')).'</td>'."\n";
										echo '<td>'.$edit . '&nbsp;' . $delete.'</td>'."\n";
									echo '</tr>'."\n";			
								}
							} else {
								echo '<tr><td colspan="3">'.t('There are no social networks to display.').'</td></tr>';
							} ?>
						</tbody>
					</table>
					<br />
					<div class="ccm-spacer">&nbsp;</div>
				</div>
			</div>
			<div class="ccm-pane-footer">	
				<?php   echo $ih->submit(t('Save Networks'), 'theme-options-social-form', 'right', 'primary')?>
			</div>
		
			<script type="text/javascript">
				delete_confirm = function(Name, sID) {
					if (confirm('<?php   echo t("Are you sure you want to delete %s?", "' + Name + '")?>')) {
						window.location = "<?php   echo View::url('dashboard/theme_options_lite/social/', 'delete');?>" + sID + "/<?php   echo $val->generate('delete_network')?>";
					}
				};
			</script>
		</form>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add New Network'), false, false, false);?>
		<form method="post" action="<?php  echo $this->action('add_new_network')?>" id="theme-options-social-add-form">
			<?php   echo $this->controller->token->output('add_new_network');?>
			<div class="ccm-pane-body">
				<?php  
				echo '<label for="name"><strong>'.t('Network Name').':&nbsp;</strong></label>';
				echo $form->text('name');
				echo '<span class="help-block">'.t('(eg. Some Network)').'<span>';
				echo '<div class="ccm-spacer">&nbsp;</div>';
				echo '<label for="handle"><strong>'.t('Network Handle').':&nbsp;</strong></label>';
				echo $form->text('handle');
				echo '<span class="help-block">'.t('(eg. some_network)').'</span>';
				echo '<div class="ccm-spacer">&nbsp;</div>';
			echo '</div>';
			echo '<div class="ccm-pane-footer">';
					echo $ih->submit(t('Save New Network'), 'theme-options-social-add-form', 'right', 'primary');
				?>
			</div>
		</form>

		<?php   } ?>
		
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Theme Developers'), false, false, false);?>
		<div class="ccm-pane-body">
			<p><?php   echo t('For documentation on how to use this with your theme please see the <a href="http://www.concrete5.org/marketplace/addons/theme_options_lite/documentation/">Theme Options Lite Documentation.</a>')?></p>
		</div>
		<div class="ccm-pane-footer"></div>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
