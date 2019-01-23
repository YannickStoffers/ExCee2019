<?php
require_once 'include/models/Model.class.php';

class Companies extends Model
{
    public function __construct($db) {
        parent::__construct($db, 'companies');
    }
}
