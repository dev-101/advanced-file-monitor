<?php
$path = dirname(dirname(dirname(dirname(__FILE__)))) . '/' . 'oc-load.php';
require_once($path);
require_once('index.php');
afm_cron_function();
?>