<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("users_model");
        $this->config->load('custom');
    }

    public function index()
    {
        // checking if the form is submitted
        if (isset($_POST["submit"])) {
            // adding validation rules&implementing custom rules
            $this->form_validation->set_rules('username', 'username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_validate_real_email');
            $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha', 'required|callback_validate_captcha');

            // setting custom messages for custom rules
            $this->form_validation->set_message('validate_real_email','The email field does not contain a real email address');
            $this->form_validation->set_message('validate_captcha','The captcha form should be checked');

            // collecting input data
            $arr = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
            );

            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('result', validation_errors());
                $this->session->set_flashdata('old', $arr);
                redirect("/");
            } else {
                // inserting new user to database
                $this->users_model->add_user($arr);

                $this->session->set_flashdata('result', 'You are successfully registered!');
                redirect("/users");
            }
        }
        // displaying register page in case of submit button is not pressed
        $data['title'] = "Register";
        $data['recaptcha_api_url'] = $this->config->item('recaptcha_api_url');
        $data['recaptcha_site_key'] = $this->config->item('recaptcha_site_key');
        $this->load->view('register/index', $data);
    }

    /* custom method for captcha validating, google recaptcha api */
    public function validate_captcha() {
        $res = FALSE;

        $data = array(
            'secret' => $this->config->item('recaptcha_private_key'),
            'response' => $this->input->post('g-recaptcha-response'),
        );

        // making api call
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->config->item('recaptcha_vrf_url'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);

        $resp= json_decode($resp, true);

        curl_close($curl);

        // checking response status.
        if (isset($resp['success']) && $resp['success']) {
            $res = TRUE;
        }

        return $res;
    }

    /* custom method for real email address validating, debounce api */
    public function validate_real_email () {
        $res = FALSE;

        // making api call
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->config->item('debounce_api_url').'?api='.$this->config->item('debounce_api_key').'&email='.$this->input->post('email'),
        ));

        $resp = curl_exec($curl);

        $resp = json_decode($resp, true);

        // checking response status.
        // Note: allowing only "Safe to Send" case
        if (isset($resp['debounce']) && isset($resp['debounce']['result']) && $resp['debounce']['result'] == 'Safe to Send') {
            $res = TRUE;
        }

        curl_close($curl);

        return $res;
    }

}
