<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Leave_model');
        $this->load->model('Employee_model');
        $this->load->model('Leave_type_model');
    }
    
    public function index() {
        $data = array();
        
        // Get filter parameters
        $status = $this->input->get('status');
        $leave_type_id = $this->input->get('leave_type_id');
        $department_id = $this->input->get('department_id');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        
        // Build where conditions
        $where = array();
        if ($status) {
            $where['l.status'] = $status;
        }
        if ($leave_type_id) {
            $where['l.leave_type_id'] = $leave_type_id;
        }
        if ($department_id) {
            $where['e.department_id'] = $department_id;
        }
        if ($date_from) {
            $where['l.start_date >='] = $date_from;
        }
        if ($date_to) {
            $where['l.end_date <='] = $date_to;
        }
        
        $data['leaves'] = $this->Leave_model->get_all($where);
        $data['leave_types'] = $this->Leave_type_model->get_all();
        $data['departments'] = $this->Employee_model->get_departments();
        
        // Get summary statistics
        $data['total_leaves'] = count($data['leaves']);
        $data['pending_leaves'] = $this->Leave_model->count_pending_leaves();
        $data['approved_leaves'] = $this->db->where('status', 'approved')->count_all_results('leaves');
        $data['rejected_leaves'] = $this->db->where('status', 'rejected')->count_all_results('leaves');
        
        $this->render('leaves/index', $data);
    }
    
    public function add() {
        $data = array();
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('employee_id', 'Employee', 'required');
            $this->form_validation->set_rules('leave_type_id', 'Leave Type', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('reason', 'Reason', 'required');
            
            if ($this->form_validation->run()) {
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                
                // Calculate number of days (excluding weekends)
                $days = $this->calculate_working_days($start_date, $end_date);
                
                $leave_data = array(
                    'employee_id' => $this->input->post('employee_id'),
                    'leave_type_id' => $this->input->post('leave_type_id'),
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_days' => $days,
                    'reason' => $this->input->post('reason'),
                    'status' => 'pending',
                    'applied_by' => $this->user->id
                );
                
                if ($this->Leave_model->create($leave_data)) {
                    $this->session->set_flashdata('success', 'Leave request submitted successfully');
                    redirect('leaves');
                } else {
                    $this->session->set_flashdata('error', 'Failed to submit leave request');
                }
            }
        }
        
        $data['employees'] = $this->Employee_model->get_all(array('is_active' => 1));
        $data['leave_types'] = $this->Leave_type_model->get_all();
        
        $this->render('leaves/add', $data);
    }
    
    public function edit($id) {
        $data = array();
        
        $leave = $this->Leave_model->get_by_id($id);
        if (!$leave) {
            show_404();
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('reason', 'Reason', 'required');
            
            if ($this->form_validation->run()) {
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                
                // Calculate number of days
                $days = $this->calculate_working_days($start_date, $end_date);
                
                $leave_data = array(
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_days' => $days,
                    'reason' => $this->input->post('reason')
                );
                
                if ($this->Leave_model->update($id, $leave_data)) {
                    $this->session->set_flashdata('success', 'Leave request updated successfully');
                    redirect('leaves');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update leave request');
                }
            }
        }
        
        $data['leave'] = $leave;
        $data['leave_types'] = $this->Leave_type_model->get_all();
        
        $this->render('leaves/edit', $data);
    }
    
    public function view($id) {
        $leave = $this->Leave_model->get_by_id($id);
        if (!$leave) {
            show_404();
        }
        
        $data['leave'] = $leave;
        $data['employee'] = $this->Employee_model->get_by_id($leave->employee_id);
        
        // Get leave balance
        $data['leave_balance'] = $this->Leave_model->get_leave_balance($leave->employee_id, $leave->leave_type_id);
        
        $this->render('leaves/view', $data);
    }
    
    public function approve($id) {
        $leave = $this->Leave_model->get_by_id($id);
        if (!$leave) {
            show_404();
        }
        
        if ($this->input->post()) {
            $remarks = $this->input->post('remarks');
            
            if ($this->Leave_model->approve_leave($id, $this->user->id, $remarks)) {
                $this->session->set_flashdata('success', 'Leave request approved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to approve leave request');
            }
        }
        
        redirect('leaves');
    }
    
    public function reject($id) {
        $leave = $this->Leave_model->get_by_id($id);
        if (!$leave) {
            show_404();
        }
        
        if ($this->input->post()) {
            $remarks = $this->input->post('remarks');
            
            if ($this->Leave_model->reject_leave($id, $this->user->id, $remarks)) {
                $this->session->set_flashdata('success', 'Leave request rejected successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to reject leave request');
            }
        }
        
        redirect('leaves');
    }
    
    public function delete($id) {
        $leave = $this->Leave_model->get_by_id($id);
        if (!$leave) {
            show_404();
        }
        
        if ($this->Leave_model->delete($id)) {
            $this->session->set_flashdata('success', 'Leave request deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete leave request');
        }
        
        redirect('leaves');
    }
    
    public function pending() {
        $data['leaves'] = $this->Leave_model->get_pending_leaves();
        $data['title'] = 'Pending Leave Requests';
        
        $this->render('leaves/pending', $data);
    }
    
    public function calendar() {
        $data = array();
        
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        
        // Get all approved leaves for the month
        $leaves = $this->db->select('l.*, e.full_name, e.employee_code, lt.name as leave_type_name, lt.color')
                          ->from('leaves l')
                          ->join('employees e', 'e.id = l.employee_id')
                          ->join('leave_types lt', 'lt.id = l.leave_type_id')
                          ->where('l.status', 'approved')
                          ->where('MONTH(l.start_date)', $month)
                          ->where('YEAR(l.start_date)', $year)
                          ->get()
                          ->result();
        
        $data['leaves'] = $leaves;
        $data['month'] = $month;
        $data['year'] = $year;
        
        $this->render('leaves/calendar', $data);
    }
    
    public function report() {
        $data = array();
        
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        
        // Get leave report data
        $data['month'] = $month;
        $data['year'] = $year;
        $data['departments'] = $this->Employee_model->get_departments();
        
        // Get employee leave summary
        $employees = $this->Employee_model->get_all(array('is_active' => 1));
        $leave_data = array();
        
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) {
                continue;
            }
            
            $summary = $this->Leave_model->get_monthly_summary($employee->id, $month, $year);
            $leave_data[] = array(
                'employee' => $employee,
                'summary' => $summary
            );
        }
        
        $data['leave_data'] = $leave_data;
        
        $this->render('leaves/report', $data);
    }
    
    public function export() {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        
        // Get leave data
        $employees = $this->Employee_model->get_all(array('is_active' => 1));
        $leave_data = array();
        
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) {
                continue;
            }
            
            $summary = $this->Leave_model->get_monthly_summary($employee->id, $month, $year);
            $leave_data[] = array(
                'employee' => $employee,
                'summary' => $summary
            );
        }
        
        // Generate CSV
        $filename = 'leave_report_' . $month . '_' . $year . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Employee Code', 'Name', 'Department', 'Total Leaves', 'Approved', 'Rejected', 'Pending', 'Total Days'));
        
        // CSV data
        foreach ($leave_data as $row) {
            fputcsv($output, array(
                $row['employee']->employee_code,
                $row['employee']->full_name,
                $row['employee']->department_name,
                $row['summary']->total_leaves ?: 0,
                $row['summary']->approved_leaves ?: 0,
                $row['summary']->rejected_leaves ?: 0,
                $row['summary']->pending_leaves ?: 0,
                $row['summary']->total_days ?: 0
            ));
        }
        
        fclose($output);
        exit;
    }
    
    private function calculate_working_days($start_date, $end_date) {
        $begin = strtotime($start_date);
        $end = strtotime($end_date);
        
        if ($begin > $end) {
            return 0;
        }
        
        $working_days = 0;
        $days_in_seconds = 86400;
        
        for($i = $begin; $i <= $end; $i += $days_in_seconds) {
            $day_of_week = date('N', $i); // 1 (Monday) to 7 (Sunday)
            if ($day_of_week <= 5) { // Monday to Friday
                $working_days++;
            }
        }
        
        return $working_days;
    }
}