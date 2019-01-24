<?php
require_once 'include/models/Model.class.php';

class Programme extends Model
{
	public static $company_ids = [];
	public static $sections = ['pre-excursion','city-01','city-02','city-03','post-excursion'];

	public function __construct($db) {
		parent::__construct($db, 'programme');
	}
}
