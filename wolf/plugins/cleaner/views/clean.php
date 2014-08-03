<?php

if (!defined('IN_CMS')) { exit(); }


?>
<!-- <h1><?php echo __('Clean'); ?></h1> -->

<?php if (!AuthUser::hasPermission('client')) { ?>

<?php //set_time_limit(900); ?>
<?php cleanCMS(); ?>

<?php } ?>