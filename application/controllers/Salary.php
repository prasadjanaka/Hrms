<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Salary_model');
        $this->load->model('Employee_model');
        $this->load->model('Attendance_model');
        $this->load->model('Leave_model');
        $this->load->model('Department_model');
    }

    public function index() {
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
        $this->render('salary/index', $data);
    }

    public function payslip($employee_id, $month = null, $year = null) {
        $month = $month ?: date('m');
        $year = $year ?: date('Y');
        $employee = $this->Employee_model->get_by_id($employee_id);
        if (!$employee) show_404();
        $salary = $this->Salary_model->calculate_salary($employee, $month, $year);
        $data['employee'] = $employee;
        $data['salary'] = $salary;
        $data['month'] = $month;
        $data['year'] = $year;
        $this->render('salary/payslip', $data);
    }

    public function generate() {
        if ($this->input->post()) {
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            $employees = $this->Employee_model->get_all(['is_active' => 1]);
            foreach ($employees as $employee) {
                $salary = $this->Salary_model->calculate_salary($employee, $month, $year);
                $this->Salary_model->save_salary_payment($employee->id, $month, $year, $salary);
            }
            $this->session->set_flashdata('success', 'Salaries generated for ' . date('F Y', mktime(0,0,0,$month,1,$year)));
            redirect('salary?month=' . $month . '&year=' . $year);
        }
        $this->render('salary/generate');
    }

    public function export() {
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
        $filename = 'salary_report_' . $month . '_' . $year . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Employee Code', 'Name', 'Department', 'Salary Type', 'Basic', 'Deductions', 'Net Salary']);
        foreach ($salary_data as $row) {
            fputcsv($output, [
                $row['employee']->employee_code,
                $row['employee']->full_name,
                $row['employee']->department_name,
                ucfirst($row['employee']->salary_type),
                $row['salary']['basic'],
                $row['salary']['deductions'],
                $row['salary']['net_salary']
            ]);
        }
        fclose($output);
        exit;
    }
}