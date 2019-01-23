<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class ProgrammeForm extends Bootstrap3Form
{
    public function __construct($name, $strict=true){
        $model = get_model('Programme');

        $fields = [
        	'date'        	=> new DateField     ('Date of activity (yyyy-mm-dd)', 'Y-m-d', !$strict),
        	'time'          => new StringField   ('Time of activity (hh:mm)',               !$strict, ['maxlength' => 5]),
            'title'         => new StringField   ('Title',                                  !$strict, ['maxlength' => 255]),
            'description'   => new TextAreaField ('Description',                            !$strict,     ['maxlength' => 4096]),
            'image_name'	=> new StringField	 ('Image name (make sure the image is uploaded to the server)', !$strict, ['maxlength' => 30]),
            'company_visit' => new CheckBoxField ('This is a company visit',    			!$strict),
            'company_id'    => new NumberField   ('Company database ID',                    false),
        ];

        return parent::__construct($name, $fields);
    }
}

