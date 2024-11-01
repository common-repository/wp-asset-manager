<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');

$all_styles = isset($_POST['order']) && !empty($_POST['order']) ? $_POST['order'] : '';

if ($all_styles != ''):

	$_clean_array = serialize($all_styles);

	update_option('_wp_custom_style',$_clean_array);

	echo 1;

else:

	echo 0;

endif;
?>