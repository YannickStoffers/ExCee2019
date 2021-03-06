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
		if ($this->_view === 'list' && 			// LIST pages are accessible
			(PRE_ANNOUNCEMENT === false) ||		// IF announcement event has been
				session_is_admin ())			// OR you're a member of the ExCee or the board
			return parent::run_page ();

		// Other pages only accessible for the ExCee
		if (!cover_session_logged_in() && !DEBUG)
			throw new HttpException(401, 'Unauthorized', sprintf('<a href="%s" class="btn btn-excee">Login and get started!</a>', cover_login_url()));
		else if (!session_is_admin ())
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
		$data['show_time'] = empty($data['show_time']) ? 0 : 1;
		
		parent::process_form_data($data);   
	}
}

// Create and run home view
$view = new ProgrammeView('programme', 'Programme', get_model('Programme'));

$view->run();
