<?php
set_include_path('../');
require_once '../include/init.php';

// Create and run home view

$view = new TemplateView('companies/index');

$view->run();
