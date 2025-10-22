<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->model('Attendance_model');
        $this->load->model('Leave_model');
        $this->load->model('Department_model');
    }
    
    public function index() {
        $data = array();
        
        // Get dashboard statistics
        $data['total_employees'] = $this->Employee_model->count_all(array('is_active' => 1));
        $data['total_departments'] = $this->Department_model->count_all(array('is_active' => 1));
        $data['present_today'] = $this->Attendance_model->count_present_today();
        $data['on_leave_today'] = $this->Leave_model->count_on_leave_today();
        
        // Get attendance trend (last 7 days)
        $data['attendance_trend'] = $this->Attendance_model->get_attendance_trend(7);
        
        // Get shift-wise employee count
        $data['shift_stats'] = $this->Employee_model->get_shift_statistics();
        
        // Get recent activities
        $data['recent_attendances'] = $this->Attendance_model->get_recent_attendances(5);
        $data['recent_leaves'] = $this->Leave_model->get_recent_leaves(5);
        
        // Get employee statistics by department
        $data['department_stats'] = $this->Employee_model->get_department_statistics();
        
        $this->render('dashboard/index', $data);
    }
    
    public function get_chart_data() {
        $type = $this->input->get('type');
        
        switch ($type) {
            case 'attendance_trend':
                $data = $this->Attendance_model->get_attendance_trend(7);
                break;
            case 'department_stats':
                $data = $this->Employee_model->get_department_statistics();
                break;
            case 'shift_stats':
                $data = $this->Employee_model->get_shift_statistics();
                break;
            default:
                $data = array();
        }
        
        $this->json_response($data);
    }
}