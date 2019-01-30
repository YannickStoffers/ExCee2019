<?php
require_once 'include/init.php';
require_once 'include/form.php';

/** Renders and processes CRUD operations for the  Model */
class SignupForm extends Bootstrap3Form
{
    public function __construct($name, $strict=true){
        $model = get_model('Registration');
        $ov_options = [['Select your student transit product.', ['selected', 'disabled']]];
        $ov_options = array_merge($ov_options, $model::$ov_options);

        $fields = [
            'first_name'      => new StringField   ('First name (according to passport)',     !$strict, ['maxlength' => 255]),
            'surname'         => new StringField   ('Surname (according to passport)',        !$strict, ['maxlength' => 255]),
            'birthday'        => new DateField     ('Date of birth', 'Y-m-d',                 !$strict),
            'address'         => new StringField   ('Street name + number',                   !$strict, ['maxlength' => 255]),
            'postal_code'     => new StringField   ('Postal code',                            !$strict, ['maxlength' => 255]),
            'city'            => new StringField   ('Place of residence',                     !$strict, ['maxlength' => 255]),
            'email'           => new EmailField    ('Email',                                  !$strict),
            'phone'           => new StringField   ('Phone number',                           !$strict, ['maxlength' => 100]),
            'emergency_phone' => new StringField   ('Emergency contact',                      !$strict, ['maxlength' => 100]),
            'iban'            => new StringField   ('IBAN',                                   !$strict, ['maxlength' => 34]),
            'bic'             => new StringField   ('BIC (only for non-Dutch bank accounts)', true,     ['maxlength' => 11]),
            'installments'    => new CheckBoxField ('I would like to pay in installments',    true),
            'accept_costs'    => new CheckBoxField ('I accept the costs',                     !$strict),
            'student_ov'      => new SelectField   ('I travel by train for free during the...', $ov_options),
            'remarks'         => new TextAreaField ('Comments',                               true,     ['maxlength' => 1024]),
            'accept_terms'    => new CheckBoxField ('I have read and accepted the terms and conditions', !$strict),
        ];

        return parent::__construct($name, $fields);
    }

    /** Implement custom validation */
    public function validate() {
        $result = parent::validate();

        if (defined('NO_IBAN_STRING') && $this->get_value('iban') == NO_IBAN_STRING)
            return $result;


        if (!\IsoCodes\Iban::validate($this->get_value('iban'))) {
            $this->get_field('iban')->errors[] = 'Please provide a valid IBAN';      
            $result = false && $result;
        }

        $bic = $this->get_value('bic');

        // Validate if BIC is set for non-Dutch IBANs.
        if (substr(strtoupper($this->get_value('iban')), 0, 2) !== 'NL') {
            if (!isset($bic) || empty(trim($bic))){
                $this->get_field('bic')->errors[] = 'BIC is required for non-Dutch bank accounts';
                $result = false && $result;
            }
        }

        if (isset($bic) && !empty(trim($bic)) && !\IsoCodes\SwiftBic::validate($bic)) {
            $this->get_field('bic')->errors[] = 'Please provide a valid BIC';      
            $result = false && $result;
        }

        return $result;
    }
}

