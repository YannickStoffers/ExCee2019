<?php
set_include_path('../');
require_once 'include/init.php';
require_once 'include/form.php';
require_once 'include/CompaniesForm.class.php';

/** Renders and processes CRUD operations for the Signup Model */
class CompaniesView extends ModelView
{
    protected $views = ['create', 'read', 'update', 'delete', 'list'];
    protected $template_base_name = 'templates/companies/company';

    public function run_page() {
        if (($this->_view === 'list' || $this->_view === 'read') &&                             // List and read pages are accessible
                (PRE_ANNOUNCEMENT === false ||                                                  // IF announcement event has been
                session_is_admin ()))    // OR you're a member of the ExCee
            return parent::run_page ();

        // Other pages are accessible for the ExCee.
        if (!cover_session_logged_in() && !DEBUG)
            throw new HttpException(401, 'Unauthorized', sprintf('<a href="%s" class="btn btn-excee">Login and get started!</a>', cover_login_url()));
        else if (!session_is_admin ())
            throw new HttpException(403, 'You need to be a member of the ExCee to see this page!');
        else
            return parent::run_page ();
    }

    /** Create and returns the form to use for create and update */
    protected function get_form() {
        $form = new CompaniesForm('companies', false);
        // Signup form is slightly optimized for non-admin use
        return $form;
    }

    /** Maps a valid form to its database representation */
    protected function process_form_data($data) {
        // Convert booleans to tinyints
        $data['show_time'] = empty($data['show_time']) ? 0 : 1;

        $url = explode('//', $data['home_page'], 2);
        $data['home_page'] = '//' . (count($url) > 1 ? $url[1] : $url[0]);
        
        parent::process_form_data($data);   
    }
}

// Create and run home view

$view = new CompaniesView('companies', 'Companies', get_model('Companies'));

$view->run();
