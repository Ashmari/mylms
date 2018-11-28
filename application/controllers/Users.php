<?php

class Users extends CI_Controller
{
  private $current_user;

  public function __construct()
  {
    parent::__construct();
    $this->current_user = array();

    $this->load->model('users_model');
    $this->load->library('session');
    // $this->load->helper('url');
  }

  public function login()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'USERNAME', 'required');
    $this->form_validation->set_rules('password', 'PASSWORD', 'required');

    if ($this->form_validation->run() == TRUE) {
      if ($this->_run_login() == TRUE) {
        // successful login
        $next = 'templates/message';
        $data['type'] = 'positive';
        $data['message_title'] = 'You have successfully logged in';
        $data['redirect'] = 'home';

        $userdata = array(
          'logged_in' => TRUE,
          'username' => $this->current_user['username'],
          'first_name' => $this->current_user['first_name'],
          'last_name' => $this->current_user['last_name'],
          'login_time' => time()
        );
        $this->session->set_userdata($userdata);
      } else {
        // access denied
        $next = 'users/login';
        $data['result'] = json_encode(array(
          'data' => null,
          'error' => array(
            'type' => 'auth',
            'message' => 'Invalid username or password'
          )
        ));
      }
    } else {
      // check current_user alternatively
      if ($this->session->userdata('logged_in') == TRUE) {
        $next = 'templates/message';
        $data['type'] = 'negative';
        $data['message_title'] = 'You have already logged in';
        $data['redirect'] = 'home';
      } else {
        $next = 'users/login';
      }
      // $data['jqueries'] = array(
      //   '.ui.error.message' => array(
      //     'addClass' => "'visible'",
      //     'text' => "'Internal validation error occurred.'"
      //   ),
      // );
    }

    $data['title'] = 'Sahana :: Login';

    $this->load->view('templates/header', $data);
    $this->load->view($next, $data);
    $this->load->view('templates/footer', $data);
  }

  private function _run_login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->users_model->get_user($username);

    if ($username == $user['username'] && $password == $user['userpass']) {
      $this->current_user = $user;
      return TRUE;
    }
    return FALSE;
  }
}
