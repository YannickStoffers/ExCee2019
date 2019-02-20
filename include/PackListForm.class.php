<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class PackListForm extends Bootstrap3Form
{
	public function __construct($name, $strict=true){
		$model = get_model('PackList');
		$sections = [['Select a section', ['selected', 'disabled']]];
		$sections = array_merge($sections, $model::$sections);

		$fields = [
			'section'	=> new SelectField ('Section of pack list', $sections, false),
			'item' 		=> new StringField ('Item', !$strict, ['maxlength' => 50]),
		];

		return parent::__construct($name, $fields);
	}
}
