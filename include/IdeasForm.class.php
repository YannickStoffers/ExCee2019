<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class IdeasForm extends Bootstrap3Form
{
    public function __construct($name, $strict=true){
        $fields = [
            'name'  => new StringField   ('Name',               true, ['maxlength' => 8]),
            'email' => new StringField   ('Email',              true, ['maxlength' => 255]),
            'idea'  => new TextAreaField ('Idea for the trip!', false,  ['maxlength' => 4096]),
        ];

        return parent::__construct($name, $fields);
    }
}
