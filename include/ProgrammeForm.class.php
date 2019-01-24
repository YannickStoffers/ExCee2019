<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class ProgrammeForm extends Bootstrap3Form
{
	public function __construct($name, $strict=true){
		$model = get_model('Programme');
		$companies = get_model('Companies')->get ();
		$company_ids = [['Select a company', ['selected', 'disabled']]];
		foreach ($companies as $company) {
			$company_ids[] = $company['id'];
		}
		$company_ids = array_merge($company_ids, $model::$company_ids);

		$sections = [['Select a location', ['selected', 'disabled']]];
		$sections = array_merge($sections, $model::$sections);

		$fields = [
			'section'		=> new SelectField		('Location of the activity', $sections,							false),
			'date'        	=> new DateField		('Date of activity (yyyy-mm-dd)', 'Y-m-d',						!$strict),
			'show_time' 	=> new CheckBoxField	('Show time in programme',    									true),
			'time'          => new StringField		('Time of activity (hh:mm)',									!$strict, ['maxlength' => 10]),
			'title'         => new StringField		('Title',														!$strict, ['maxlength' => 255]),
			'description'   => new TextAreaField	('Description',													!$strict, ['maxlength' => 4096]),
			'image_name'	=> new StringField		('Image name (make sure the image is uploaded to the server)',	!$strict, ['maxlength' => 30]),
			'company_visit' => new CheckBoxField	('This is a company visit',    									!$strict),
			'company_id'    => new SelectField		('Company ID', $company_ids,									true),
		];

		return parent::__construct($name, $fields);
	}

	/** Implement custom validation */
	public function validate() {
		$result = parent::validate();

		$time = $this->get_value ('time');

		if (isset($time) && !empty(trim($time))){
			// Time is set.
			$time_object = date_create($time);
			if (!$time_object){
				// Can't create proper DateTime object.
				$this->get_field ('time')->errors[] = 'Please enter a valid time';
				$result = false && $result;
			}
		}

		$company_id = $this->get_value('company_id');

		// Validate if BIC is set for non-Dutch IBANs.
		if (!empty($this->get_value ('company_visit'))) {
			if (!isset($company_id)){
				$this->get_field('company_id')->errors[] = 'Company ID is required for company visits.';
				$result = false && $result;
			}
		}

		return $result;
	}
}

