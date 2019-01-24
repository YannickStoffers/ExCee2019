<?php
set_include_path('../');
require_once 'include/init.php';
require_once 'include/form.php';
require_once 'include/ProgrammeForm.class.php';

/** Renders and processes CRUD operations for the Signup Model */
class ProgrammeView extends ModelView
{
	protected $views = ['create', 'update', 'delete', 'list'];
	protected $template_base_name = 'templates/programme/programme';

	public function run_page() {
		if ($this->_view === 'list')
			return parent::run_page ();

        if (!cover_session_logged_in() && !DEBUG)
            throw new HttpException(401, 'Unauthorized', sprintf('<a href="%s" class="btn btn-primary">Login and get started!</a>', cover_login_url()));
        else if (!cover_session_in_committee(ADMIN_COMMITTEE) && !DEBUG)
            throw new HttpException(403, 'You need to be a member of the ExCee to see this page!');
        else
            return parent::run_page ();
    }

	/** Create and returns the form to use for create and update */
	protected function get_form() {
		$form = new ProgrammeForm('programme', false);
		// Signup form is slightly optimized for non-admin use
		return $form;
	}

	/** Maps a valid form to its database representation */
	protected function process_form_data($data) {
		// Convert booleans to tinyints
		$data['company_visit'] = empty($data['company_visit']) ? 0 : 1;
		// $data['accept_costs'] = empty($data['accept_costs']) ? 0 : 1;
		// $data['installments'] = empty($data['installments']) ? 0 : 1;
		
		parent::process_form_data($data);   
	}
}

// Create and run home view
$view = new ProgrammeView('programme', 'Programme', get_model('Programme'));

$view->run();
