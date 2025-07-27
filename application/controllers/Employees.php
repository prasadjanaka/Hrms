<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Employee_model');
        $this->load->model('Department_model');
        $this->load->model('Designation_model');
        $this->load->model('Cadre_model');
        $this->load->model('Shift_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }
    
    public function index() {
        $data = array();
        
        // Get filter parameters
        $keyword = $this->input->get('keyword');
        $department_id = $this->input->get('department_id');
        $shift_id = $this->input->get('shift_id');
        $cadre_id = $this->input->get('cadre_id');
        
        $filters = array();
        if ($department_id) $filters['department_id'] = $department_id;
        if ($shift_id) $filters['shift_id'] = $shift_id;
        if ($cadre_id) $filters['cadre_id'] = $cadre_id;
        
        // Get employees with filters
        $data['employees'] = $this->Employee_model->search($keyword, $filters);
        
        // Get filter options
        $data['departments'] = $this->Department_model->get_all(array('is_active' => 1));
        $data['shifts'] = $this->Shift_model->get_all(array('is_active' => 1));
        $data['cadres'] = $this->Cadre_model->get_all(array('is_active' => 1));
        
        // Pass filter values back to view
        $data['filters'] = array(
            'keyword' => $keyword,
            'department_id' => $department_id,
            'shift_id' => $shift_id,
            'cadre_id' => $cadre_id
        );
        
        $this->render('employees/index', $data);
    }
    
    public function add() {
        $data = array();
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('employee_code', 'Employee Code', 'required|is_unique[employees.employee_code]');
            $this->form_validation->set_rules('nic', 'NIC', 'required|is_unique[employees.nic]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employees.email]');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('designation_id', 'Designation', 'required');
            $this->form_validation->set_rules('cadre_id', 'Cadre', 'required');
            $this->form_validation->set_rules('shift_id', 'Shift', 'required');
            $this->form_validation->set_rules('salary_type', 'Salary Type', 'required');
            $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
            
            if ($this->form_validation->run()) {
                $employee_data = array(
                    'full_name' => $this->input->post('full_name'),
                    'employee_code' => $this->input->post('employee_code'),
                    'nic' => $this->input->post('nic'),
                    'gender' => $this->input->post('gender'),
                    'date_of_birth' => $this->input->post('date_of_birth'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'department_id' => $this->input->post('department_id'),
                    'designation_id' => $this->input->post('designation_id'),
                    'cadre_id' => $this->input->post('cadre_id'),
                    'shift_id' => $this->input->post('shift_id'),
                    'salary_type' => $this->input->post('salary_type'),
                    'daily_basic_rate' => $this->input->post('daily_basic_rate') ?: 0,
                    'monthly_basic_rate' => $this->input->post('monthly_basic_rate') ?: 0,
                    'joining_date' => $this->input->post('joining_date')
                );
                
                // Handle profile photo upload
                if ($_FILES['profile_photo']['name']) {
                    $config['upload_path'] = './assets/uploads/employees/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = 'emp_' . time() . '_' . $_FILES['profile_photo']['name'];
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('profile_photo')) {
                        $upload_data = $this->upload->data();
                        $employee_data['profile_photo'] = $upload_data['file_name'];
                    }
                }
                
                $employee_id = $this->Employee_model->create($employee_data);
                
                if ($employee_id) {
                    // Create user account for employee
                    $user_data = array(
                        'username' => $this->input->post('employee_code'),
                        'email' => $this->input->post('email'),
                        'password' => 'admin123', // Default password
                        'role' => 'employee'
                    );
                    
                    $user_id = $this->User_model->create($user_data);
                    
                    // Link user to employee
                    $this->Employee_model->update($employee_id, array('user_id' => $user_id));
                    
                    $this->session->set_flashdata('success', 'Employee added successfully');
                    redirect('employees');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add employee');
                }
            }
        }
        
        // Get form options
        $data['departments'] = $this->Department_model->get_all(array('is_active' => 1));
        $data['designations'] = $this->Designation_model->get_all(array('is_active' => 1));
        $data['cadres'] = $this->Cadre_model->get_all(array('is_active' => 1));
        $data['shifts'] = $this->Shift_model->get_all(array('is_active' => 1));
        
        $this->render('employees/add', $data);
    }
    
    public function edit($id) {
        $data = array();
        
        $employee = $this->Employee_model->get_by_id($id);
        if (!$employee) {
            show_404();
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('designation_id', 'Designation', 'required');
            $this->form_validation->set_rules('cadre_id', 'Cadre', 'required');
            $this->form_validation->set_rules('shift_id', 'Shift', 'required');
            $this->form_validation->set_rules('salary_type', 'Salary Type', 'required');
            
            if ($this->form_validation->run()) {
                $employee_data = array(
                    'full_name' => $this->input->post('full_name'),
                    'nic' => $this->input->post('nic'),
                    'gender' => $this->input->post('gender'),
                    'date_of_birth' => $this->input->post('date_of_birth'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'department_id' => $this->input->post('department_id'),
                    'designation_id' => $this->input->post('designation_id'),
                    'cadre_id' => $this->input->post('cadre_id'),
                    'shift_id' => $this->input->post('shift_id'),
                    'salary_type' => $this->input->post('salary_type'),
                    'daily_basic_rate' => $this->input->post('daily_basic_rate') ?: 0,
                    'monthly_basic_rate' => $this->input->post('monthly_basic_rate') ?: 0
                );
                
                // Handle profile photo upload
                if ($_FILES['profile_photo']['name']) {
                    $config['upload_path'] = './assets/uploads/employees/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = 'emp_' . time() . '_' . $_FILES['profile_photo']['name'];
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('profile_photo')) {
                        $upload_data = $this->upload->data();
                        $employee_data['profile_photo'] = $upload_data['file_name'];
                        
                        // Delete old photo if exists
                        if ($employee->profile_photo && file_exists('./assets/uploads/employees/' . $employee->profile_photo)) {
                            unlink('./assets/uploads/employees/' . $employee->profile_photo);
                        }
                    }
                }
                
                if ($this->Employee_model->update($id, $employee_data)) {
                    $this->session->set_flashdata('success', 'Employee updated successfully');
                    redirect('employees');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update employee');
                }
            }
        }
        
        $data['employee'] = $employee;
        $data['departments'] = $this->Department_model->get_all(array('is_active' => 1));
        $data['designations'] = $this->Designation_model->get_all(array('is_active' => 1));
        $data['cadres'] = $this->Cadre_model->get_all(array('is_active' => 1));
        $data['shifts'] = $this->Shift_model->get_all(array('is_active' => 1));
        
        $this->render('employees/edit', $data);
    }
    
    public function view($id) {
        $employee = $this->Employee_model->get_by_id($id);
        if (!$employee) {
            show_404();
        }
        
        $data['employee'] = $employee;
        
        // Get attendance statistics
        $data['attendance_stats'] = $this->Attendance_model->get_employee_stats($id);
        $data['today_attendance'] = $this->Attendance_model->get_employee_attendance($id, date('Y-m-d'));
        $data['recent_attendance'] = $this->Attendance_model->get_employee_attendance_history($id, 10);
        
        // Get leave statistics
        $data['leave_stats'] = $this->Leave_model->get_employee_stats($id);
        $data['recent_leaves'] = $this->Leave_model->get_employee_leaves($id, 10);
        
        $this->render('employees/view', $data);
    }
    
    public function delete($id) {
        $employee = $this->Employee_model->get_by_id($id);
        if (!$employee) {
            show_404();
        }
        
        if ($this->Employee_model->delete($id)) {
            // Delete associated user account
            if ($employee->user_id) {
                $this->User_model->delete($employee->user_id);
            }
            
            // Delete profile photo
            if ($employee->profile_photo && file_exists('./assets/uploads/employees/' . $employee->profile_photo)) {
                unlink('./assets/uploads/employees/' . $employee->profile_photo);
            }
            
            $this->session->set_flashdata('success', 'Employee deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete employee');
        }
        
        redirect('employees');
    }
}