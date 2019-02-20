<?php
require_once 'include/models/Model.class.php';

class PackList extends Model
{
	public static $sections = ['Personal Care','Clothing','Sleeping','Travel','Other'];

    public function __construct($db) {
        parent::__construct($db, 'packlist');
    }
}
