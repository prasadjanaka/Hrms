<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    protected $data = array();
    protected $user = null;
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        $this->check_auth();
        
        // Load common data
        $this->load_common_data();
    }
    
    private function check_auth() {
        $this->load->library('session');
        
        // Skip auth check for login page
        if ($this->router->class == 'auth' && $this->router->method == 'login') {
            return;
        }
        
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        // Load user data
        $this->load->model('User_model');
        $this->user = $this->User_model->get_by_id($this->session->userdata('user_id'));
        
        if (!$this->user) {
            $this->session->sess_destroy();
            redirect('auth/login');
        }
    }
    
    private function load_common_data() {
        $this->data['user'] = $this->user;
        $this->data['base_url'] = base_url();
        $this->data['site_title'] = 'HRMS - Human Resource Management System';
    }
    
    protected function require_role($roles) {
        if (!is_array($roles)) {
            $roles = array($roles);
        }
        
        if (!in_array($this->user->role, $roles)) {
            show_error('Access Denied', 403, 'Unauthorized Access');
        }
    }
    
    protected function is_admin() {
        return $this->user->role == 'admin';
    }
    
    protected function is_hr() {
        return in_array($this->user->role, array('admin', 'hr'));
    }
    
    protected function is_employee() {
        return $this->user->role == 'employee';
    }
    
    protected function render($view, $data = array()) {
        $this->data = array_merge($this->data, $data);
        
        // Load layout
        $this->load->view('layouts/header', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('layouts/footer', $this->data);
    }
    
    protected function render_ajax($view, $data = array()) {
        $this->data = array_merge($this->data, $data);
        $this->load->view($view, $this->data);
    }
    
    protected function json_response($data, $status = 200) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }
    
    protected function success_response($message = 'Success', $data = array()) {
        $this->json_response(array(
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ));
    }
    
    protected function error_response($message = 'Error', $data = array()) {
        $this->json_response(array(
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ), 400);
    }
}