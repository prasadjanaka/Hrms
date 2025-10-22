<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Employee_model');
        $this->load->model('Attendance_model');
        $this->load->model('Leave_model');
        $this->load->model('Salary_model');
        $this->load->model('Department_model');
    }

    public function attendance() {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        $employees = $this->Employee_model->get_all(['is_active' => 1]);
        $attendance_data = [];
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) continue;
            $summary = $this->Attendance_model->get_monthly_summary($employee->id, $month, $year);
            $attendance_data[] = [
                'employee' => $employee,
                'summary' => $summary
            ];
        }
        $data['attendance_data'] = $attendance_data;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['departments'] = $this->Department_model->get_all();
        $this->render('reports/attendance', $data);
    }

    public function salary() {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        $employees = $this->Employee_model->get_all(['is_active' => 1]);
        $salary_data = [];
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) continue;
            $salary = $this->Salary_model->calculate_salary($employee, $month, $year);
            $salary_data[] = [
                'employee' => $employee,
                'salary' => $salary
            ];
        }
        $data['salary_data'] = $salary_data;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['departments'] = $this->Department_model->get_all();
        $this->render('reports/salary', $data);
    }

    public function employees() {
        $department_id = $this->input->get('department_id');
        $cadre_id = $this->input->get('cadre_id');
        $shift_id = $this->input->get('shift_id');
        $filters = [];
        if ($department_id) $filters['department_id'] = $department_id;
        if ($cadre_id) $filters['cadre_id'] = $cadre_id;
        if ($shift_id) $filters['shift_id'] = $shift_id;
        $employees = $this->Employee_model->get_all($filters);
        $data['employees'] = $employees;
        $data['departments'] = $this->Department_model->get_all();
        $data['cadres'] = $this->load->model('Cadre_model', '', true)->get_all();
        $data['shifts'] = $this->load->model('Shift_model', '', true)->get_all();
        $this->render('reports/employees', $data);
    }

    public function leaves() {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');
        $department_id = $this->input->get('department_id');
        $employees = $this->Employee_model->get_all(['is_active' => 1]);
        $leave_data = [];
        foreach ($employees as $employee) {
            if ($department_id && $employee->department_id != $department_id) continue;
            $summary = $this->Leave_model->get_monthly_summary($employee->id, $month, $year);
            $leave_data[] = [
                'employee' => $employee,
                'summary' => $summary
            ];
        }
        $data['leave_data'] = $leave_data;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['departments'] = $this->Department_model->get_all();
        $this->render('reports/leaves', $data);
    }

    // Export methods can be added for each report type as needed
}