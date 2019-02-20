<?php
set_include_path('../');
require_once 'include/init.php';
require_once 'include/form.php';
require_once 'include/PackListForm.class.php';

/** Renders and processes CRUD operations for the Signup Model */
class PackListView extends ModelView
{
	protected $views = ['create', 'list', 'delete'];
	protected $template_base_name = 'templates/packlist/packlist';
	private $admin_view_enabled;

	public function __construct($page_id, $title='', $model=null) {
		parent::__construct($page_id, $title, $model, $this->get_form ());
		$this->success_url = '/packlist?admin=true';

		if (!isset($_GET['admin']))
			$this->admin_view_enabled = false;
		else
			$this->admin_view_enabled = $_GET['admin'] == 'true';

	}

	public function run_page() {
		// Delete and create page requires admin rights.
		if ($this->_view !== 'delete' && $this->_view !== 'create') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->form->validate() && session_is_admin ())
				$this->process_form_data ($this->form->get_values());
			return parent::run_page ();
		}

		if (!cover_session_logged_in() && !DEBUG)
			throw new HttpException(401, 'Unauthorized', sprintf('<a href="%s" class="btn btn-excee">Login and get started!</a>', cover_login_url()));
		else if (!session_is_admin ())
			throw new HttpException(403, 'You need to be a member of the ExCee to see this page!');
		else
			return parent::run_page();
	}

	/** Runs the list view */
	protected function run_list() {
		return $this->render_template($this->get_template(), ['objects' => $this->get_model()->get(), 'form' => $this->form, 'admin_view_enabled' => $this->admin_view_enabled]);
	}

	/** Create and returns the form to use for create and update */
	protected function get_form() {
		$form = new PackListForm('packlist', false);
		// Signup form is slightly optimized for non-admin use
		return $form;
	}

	/** Maps a valid form to its database representation */
	protected function process_form_data($data) {
		$this->get_model()->create($data);
	}

	/** Returns the url to redirect to after (successful) create, update or delete */
	protected function get_success_url() {
		return $this->success_url;
	}

	/** Renders an invalid form */
	protected function form_invalid($form) {
		return $this->render_template($this->get_template('list'), ['form' => $form, 'objects' => $this->get_model ()->get (), 'admin_view_enabled' => true]);
	}
}

// Create and run home view

$view = new PackListView('packlist', 'PackList', get_model('PackList'));

$view->run();
