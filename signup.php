<?php
require_once 'include/init.php';
require_once 'include/SignupForm.class.php';

/** Renders and processes Signup form */
class SignupView extends FormView
{
    protected $model;
    protected $template_base_name = 'templates/signup/signup';

    public function run_page() {
        if (cover_session_logged_in() || DEBUG) {
            $member = get_cover_session ();
            $result = $this->model->get_by_id ($member->email, 'email');
            if (!empty($result)) {
                $context = [
                    'status' => 'success',
                    'data' => $result
                ];
                return $this->render_template($this->get_template('processed'), $context);
            }
            return parent::run_page();
        }
        else
            return parent::run_page();
    }

    public function __construct(){
        parent::__construct('signup', 'Sign up');
        $this->model = get_model('Registration');
    }

    /** Creates and returns the request form */
    protected function get_form() {
        $form = new SignupForm('signup');

        // Prefill form with data from the website if user is logged in.
        if (cover_session_logged_in()){
            $member = get_cover_session();
            $form->populate_fields([
                'first_name' => $member->voornaam,
                'surname' => empty($member->tussenvoegsel) ? $member->achternaam : $member->tussenvoegsel . ' ' . $member->achternaam,
                'birthday' => $member->geboortedatum,
                'address' => $member->adres,
                'postal_code' => $member->postcode,
                'city' => $member->woonplaats,
                'email' => $member->email,
                'phone' => $member->telefoonnummer,
            ]);
        }

        return $form;
    }

    /** Renders response indicating whether the valid form was successfully processed (or not) */
    protected function form_valid($form){
        try {
            $this->process_form_data($form->get_values());
            $context = [
                'status' => 'success',
                'data' => $form->get_values ()
            ];
        } catch (Exception $e) {
            $context = [
                'status' => 'error', 
                'message' => $e->getMessage()
            ];
        }
        return $this->render_template($this->get_template('processed'), $context);
    }
    
    /** Processes the data of a valid form */
    protected function process_form_data($data) {        
        // Convert booleans to tinyints
        $data['accept_terms'] = empty($data['accept_terms']) ? 0 : 1;
        $data['accept_costs'] = empty($data['accept_costs']) ? 0 : 1;
        $data['installments'] = empty($data['installments']) ? 0 : 1;
        $data['registration_date'] = date ("Y-m-d H:i:s");

        // Set the registration as pending, or waiting list if max capacity has been reached.
        $data['status'] = count( array_filter($this->model->get (), function ($p) {
                    return $p['status'] === 'registered' || $p['status'] === 'pending' || $p['status'] === 'waiting_list';
                })) >= MAX_SIGNUPS ? 'waiting_list' : 'pending';
        
        $this->model->create($data);

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
            throw new HttpException(500, 'Your registration has been stored in our database, but we failed to send you a confirmation email!');
    }
}

// Create and run home view
$view = new SignupView();    
$view->run();
