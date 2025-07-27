<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }
    
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run()) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                
                $user = $this->User_model->authenticate($username, $password);
                
                if ($user) {
                    // Set session data
                    $this->session->set_userdata(array(
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'role' => $user->role
                    ));
                    
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid username or password');
                }
            }
        }
        
        $this->load->view('auth/login');
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
    
    public function change_password() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
            
            if ($this->form_validation->run()) {
                $user = $this->User_model->get_by_id($this->session->userdata('user_id'));
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                
                if (password_verify($current_password, $user->password)) {
                    $this->User_model->change_password($user->id, $new_password);
                    $this->session->set_flashdata('success', 'Password changed successfully');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Current password is incorrect');
                }
            }
        }
        
        $this->load->view('auth/change_password');
    }
    
    public function forgot_password() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            
            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $user = $this->User_model->get_by_email($email);
                
                if ($user) {
                    // Generate reset token (simplified - in production, use proper token system)
                    $reset_token = bin2hex(random_bytes(32));
                    $this->User_model->update($user->id, array('reset_token' => $reset_token));
                    
                    // Send email (simplified - in production, implement proper email sending)
                    $this->session->set_flashdata('success', 'Password reset instructions sent to your email');
                } else {
                    $this->session->set_flashdata('error', 'Email not found');
                }
            }
        }
        
        $this->load->view('auth/forgot_password');
    }
}