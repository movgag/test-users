<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("users_model");
    }

    public function index()
    {
        $data['title'] = "Users";
        // getting all users from the database
        $data['users'] = $this->users_model->get_users();
        $this->load->view('users/index', $data);
    }

}
