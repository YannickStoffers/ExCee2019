<?php
require_once 'include/models/Model.class.php';

class Registration extends Model
{
    public static $status_options = ['registered','cancelled','waiting_list'];

    public function __construct($db) {
        parent::__construct($db, 'registrations');
    }
}
