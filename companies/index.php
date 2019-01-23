<?php
set_include_path('../');
require_once 'include/init.php';
require_once 'include/form.php';
require_once 'include/CompaniesForm.class.php';

/** Renders and processes CRUD operations for the Signup Model */
class CompaniesView extends ModelView
{
    protected $views = ['create', 'read', 'update', 'list'];
    protected $template_base_name = 'templates/companies/company';

    /** Create and returns the form to use for create and update */
    protected function get_form() {
        $form = new CompaniesForm('companies', false);
        // Signup form is slightly optimized for non-admin use
        return $form;
    }

    /** Maps a valid form to its database representation */
    protected function process_form_data($data) {
        // Convert booleans to tinyints
        // $data['company_visit'] = empty($data['company_visit']) ? 0 : 1;
        // $data['accept_costs'] = empty($data['accept_costs']) ? 0 : 1;
        // $data['installments'] = empty($data['installments']) ? 0 : 1;

        $url = explode('//', $data['home_page'], 2);
        $data['home_page'] = '//' . (count($url) > 1 ? $url[1] : $url[0]);
        
        parent::process_form_data($data);   
    }
}

// Create and run home view

$view = new CompaniesView('companies', 'Companies', get_model('Companies'));

$view->run();
