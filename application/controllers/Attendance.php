<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Attendance_model');
        $this->load->model('Employee_model');
        $this->load->model('Shift_model');
    }
    
    public function index() {
        $data = array();
        
        // Get filter parameters
        $date = $this->input->get('date') ?: date('Y-m-d');
        $department_id = $this->input->get('department_id');
        $status = $this->input->get('status');
        
        // Get attendance data
        $where = array('a.date' => $date);
        if ($department_id) {
            $where['e.department_id'] = $department_id;
        }
        if ($status) {
            $where['a.status'] = $status;
        }
        
        $data['attendances'] = $this->Attendance_model->get_all($where);
        $data['date'] = $date;
        $data['departments'] = $this->Employee_model->get_departments();
        
        // Get summary statistics
        $data['total_employees'] = $this->Employee_model->count_all(array('is_active' => 1));
        $data['present_today'] = $this->Attendance_model->count_present_today();
        $data['late_today'] = $this->db->where('date', $date)->where('is_late', 1)->count_all_results('attendances');
        $data['absent_today'] = $data['total_employees'] - $data['present_today'];
        
        $this->render('attendance/index', $data);
    }
    
    public function check_in() {
        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id');
            
            if ($this->Attendance_model->check_in($employee_id)) {
                $this->session->set_flashdata('success', 'Check-in successful');
            } else {
                $this->session->set_flashdata('error', 'Check-in failed or already checked in');
            }
        }
        
        redirect('attendance');
    }
    
    public function check_out() {
        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id');
            
            if ($this->Attendance_model->check_out($employee_id)) {
                $this->session->set_flashdata('success', 'Check-out successful');
            } else {
                $this->session->set_flashdata('error', 'Check-out failed');
            }
        }
        
        redirect('attendance');
    }
    
    public function manual_mark() {
        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id');
            $date = $this->input->post('date');
            $in_time = $this->input->post('in_time');
            $out_time = $this->input->post('out_time');
            $status = $this->input->post('status');
            
            // Check if attendance already exists
            $existing = $this->Attendance_model->get_employee_attendance($employee_id, $date);
            
            $data = array(
                'employee_id' => $employee_id,
                'date' => $date,
                'status' => $status
            );
            
            if ($in_time) {
                $data['in_time'] = $in_time;
            }
            if ($out_time) {
                $data['out_time'] = $out_time;
                // Calculate worked hours if both times are provided
                if ($in_time) {
                    $worked_hours = round((strtotime($out_time) - strtotime($in_time)) / 3600, 2);
                    $data['worked_hours'] = $worked_hours;
                }
            }
            
            if ($existing) {
                $this->Attendance_model->update($existing->id, $data);
            } else {
                $this->Attendance_model->create($data);
            }
            
            $this->session->set_flashdata('success', 'Attendance marked successfully');
            redirect('attendance');
        }
        
        $data['employees'] = $this->Employee_model->get_all(array('is_active' => 1));
        $this->render('attendance/manual_mark', $data);
    }
    
    public function employee($employee_id) {
        $employee = $this->Employee_model->get_by_id($employee_id);
        if (!$employee) {
            show_404();
        }
        
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        
        $data['employee'] = $employee;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['attendance_summary'] = $this->Attendance_model->get_monthly_summary($employee_id, $month, $year);
        $data['attendance_details'] = $this->Attendance_model->get_all(array('a.employee_id' => $employee_id, 'MONTH(a.date)' => $month, 'YEAR(a.date)' => $year));
        
        $this->render('attendance/employee', $data);
    }
    
    public function report() {
        $data = array();
        
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        
        // Get attendance report data
        $data['month'] = $month;
        $data['year'] = $year;
        $data['departments'] = $this->Employee_model->get_departments();
        
        // Get employee attendance summary
        $employees = $this->Employee_model->get_all(array('is_active' => 1));
        $attendance_data = array();
        
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) {
                continue;
            }
            
            $summary = $this->Attendance_model->get_monthly_summary($employee->id, $month, $year);
            $attendance_data[] = array(
                'employee' => $employee,
                'summary' => $summary
            );
        }
        
        $data['attendance_data'] = $attendance_data;
        
        $this->render('attendance/report', $data);
    }
    
    public function export() {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        
        // Get attendance data
        $employees = $this->Employee_model->get_all(array('is_active' => 1));
        $attendance_data = array();
        
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) {
                continue;
            }
            
            $summary = $this->Attendance_model->get_monthly_summary($employee->id, $month, $year);
            $attendance_data[] = array(
                'employee' => $employee,
                'summary' => $summary
            );
        }
        
        // Generate CSV
        $filename = 'attendance_report_' . $month . '_' . $year . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Employee Code', 'Name', 'Department', 'Present Days', 'Absent Days', 'Late Days', 'Total Hours'));
        
        // CSV data
        foreach ($attendance_data as $row) {
            fputcsv($output, array(
                $row['employee']->employee_code,
                $row['employee']->full_name,
                $row['employee']->department_name,
                $row['summary']->present_days ?: 0,
                $row['summary']->absent_days ?: 0,
                $row['summary']->late_days ?: 0,
                $row['summary']->total_hours ?: 0
            ));
        }
        
        fclose($output);
        exit;
    }
}