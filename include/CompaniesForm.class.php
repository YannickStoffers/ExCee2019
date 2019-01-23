<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class CompaniesForm extends Bootstrap3Form
{
    public function __construct($name, $strict=true){
        $model = get_model('Programme');

        $fields = [
            'name'			=> new StringField   		('Name',                                !$strict, ['maxlength' => 50]),
            'description'	=> new TextAreaField		('Description',							!$strict, ['maxlength' => 4096]),
            'home_page'		=> new StringField			('Home page url',						!$strict, ['maxlength' => 255]),
            'logo_url'		=> new StringField			('Logo url',							!$strict, ['maxlength' => 255]),
            'activity_date' => new DateField			('Date of activity (yyyy-mm-dd)', 'Y-m-d',			!$strict),
            'activity_time' => new StringField			('Time of activity (hh:mm)',					!$strict, ['maxlength' => 5]),
            'activity_description' => new TextAreaField ('Activity description',				!$strict, ['maxlength' => 4096]),
        ];

        return parent::__construct($name, $fields);
    }
}
