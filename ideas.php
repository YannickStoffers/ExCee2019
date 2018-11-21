<?php
require_once 'include/init.php';
require_once 'include/IdeasForm.class.php';

/** Renders and processes Signup form */
class IdeaView extends FormView
{
	protected $template_base_name = 'templates/ideas/idea';

    public function __construct(){
        parent::__construct('ideas', 'Ideas');
    }

    /** Creates and returns the request form */
    protected function get_form() {
        $form = new IdeasForm('ideas');

        // Prefill form with data from the website if user is logged in.
        if (cover_session_logged_in()){
            $member = get_cover_session();
            $form->populate_fields([
                'name' => $member->voornaam,
                'email' => $member->email,
            ]);
        }

        return $form;
    }

    /** Renders response indicating whether the valid form was successfully processed (or not) */
    protected function form_valid($form){
        try {
            $this->process_form_data($form->get_values());
            $context = ['status' =>  'success'];
        } catch (Exception $e) {
            $context = [
                'status' => 'error', 
                'message' => $e->getMessage()
            ];
        }
        return $this->render_template($this->get_template('submitted'), $context);
    }
    
    /** Processes the data of a valid form */
    protected function process_form_data($data) {        
        // Send confirmation email
        $success = send_mail(
            ADMIN_EMAIL,
            filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            $this->render_template($this->get_template('email'), $data),
            null,
            [sprintf('Bcc: %s', ADMIN_EMAIL)]
        );

        // Determine wether email has ben send succesfully
        if (!$success)
            throw new HttpException(500, "We failed to sent the idea. Please, try again. We're terribly sorry!");
    }
}

// Create and run home view
$view = new IdeaView ();

$view->run();
