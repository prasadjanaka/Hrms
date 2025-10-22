<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {
    protected $table = 'salary_payments';

    public function __construct() {
        parent::__construct();
    }

    public function calculate_salary($employee, $month, $year) {
        // Get attendance summary
        $attendance = $this->Attendance_model->get_monthly_summary($employee->id, $month, $year);
        $present_days = $attendance->present_days ?: 0;
        $absent_days = $attendance->absent_days ?: 0;
        $late_days = $attendance->late_days ?: 0;
        $total_days = $attendance->total_days ?: 0;
        $total_hours = $attendance->total_hours ?: 0;

        // Get leave summary
        $leave = $this->Leave_model->get_monthly_summary($employee->id, $month, $year);
        $approved_leaves = $leave->approved_leaves ?: 0;

        // Salary calculation
        $basic = 0;
        $deductions = 0;
        $net_salary = 0;
        $salary_type = $employee->salary_type;
        if ($salary_type == 'monthly') {
            $basic = $employee->monthly_basic_rate;
            // Deduct for absent days (excluding approved paid leaves)
            $deduct_days = max(0, $absent_days - $approved_leaves);
            $per_day = $basic / ($total_days ?: 30);
            $deductions = round($per_day * $deduct_days, 2);
            $net_salary = round($basic - $deductions, 2);
        } else { // daily
            $basic = $employee->daily_basic_rate * $present_days;
            $deductions = 0; // No deductions for daily mode
            $net_salary = $basic;
        }
        return [
            'basic' => round($basic, 2),
            'deductions' => round($deductions, 2),
            'net_salary' => round($net_salary, 2),
            'present_days' => $present_days,
            'absent_days' => $absent_days,
            'late_days' => $late_days,
            'total_days' => $total_days,
            'total_hours' => $total_hours,
            'approved_leaves' => $approved_leaves
        ];
    }

    public function save_salary_payment($employee_id, $month, $year, $salary) {
        // Check if already exists
        $exists = $this->db->where('employee_id', $employee_id)
                           ->where('month', $month)
                           ->where('year', $year)
                           ->get($this->table)
                           ->row();
        $data = [
            'employee_id' => $employee_id,
            'month' => $month,
            'year' => $year,
            'basic' => $salary['basic'],
            'deductions' => $salary['deductions'],
            'net_salary' => $salary['net_salary'],
            'generated_at' => date('Y-m-d H:i:s')
        ];
        if ($exists) {
            $this->db->where('id', $exists->id)->update($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
        }
    }

    public function get_salary_history($employee_id) {
        return $this->db->where('employee_id', $employee_id)
                        ->order_by('year', 'DESC')
                        ->order_by('month', 'DESC')
                        ->get($this->table)
                        ->result();
    }

    public function get_salary_payment($employee_id, $month, $year) {
        return $this->db->where('employee_id', $employee_id)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->get($this->table)
                        ->row();
    }
}