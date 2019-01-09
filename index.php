<?php
require_once 'include/init.php';

// Create and run home view

$view = new TemplateView('index');
if (PRE_ANNOUNCEMENT) {
	$view = new TemplateView('pre-announcement');
}

$view->run();
