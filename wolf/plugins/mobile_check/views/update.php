<!-- <h1>MobileCheck <?php echo __('Update'); ?></h1> -->

<?php
//if (MOBILE_VERSION > Plugin::getSetting('version', 'mobile_check')) {
   Flash::set('success', __('MobileCheck - plugin settings updated.'));
//}
?>
<?php include "_settings_form.php"; ?>