<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');

$all_scripts = isset($_POST['order']) && !empty($_POST['order']) ? $_POST['order'] : '';

if ($all_scripts != ''):

	$_clean_array = serialize($all_scripts);

	update_option('_wp_custom_script',$_clean_array);

	echo 1;

else:

	echo 0;

endif;
?>