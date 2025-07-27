<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {
    
    protected $table = 'attendances';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_by_id($id) {
        return $this->db->select('a.*, e.full_name, e.employee_code')
                        ->from($this->table . ' a')
                        ->join('employees e', 'e.id = a.employee_id')
                        ->where('a.id', $id)
                        ->get()
                        ->row();
    }
    
    public function get_all($where = array(), $order_by = 'a.date DESC') {
        $this->db->select('a.*, e.full_name, e.employee_code, d.name as department_name');
        $this->db->from($this->table . ' a');
        $this->db->join('employees e', 'e.id = a.employee_id');
        $this->db->join('departments d', 'd.id = e.department_id', 'left');
        
        if (!empty($where)) {
            $this->db->where($where);
        }
        
        return $this->db->order_by($order_by)->get()->result();
    }
    
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }
    
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    
    public function get_employee_attendance($employee_id, $date = null) {
        if (!$date) {
            $date = date('Y-m-d');
        }
        
        return $this->db->where('employee_id', $employee_id)
                        ->where('date', $date)
                        ->get($this->table)
                        ->row();
    }
    
    public function check_in($employee_id) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        // Check if already checked in today
        $existing = $this->get_employee_attendance($employee_id, $date);
        
        if ($existing) {
            return false; // Already checked in
        }
        
        // Get employee shift
        $employee = $this->db->select('e.*, s.start_time')
                            ->from('employees e')
                            ->join('shifts s', 's.id = e.shift_id', 'left')
                            ->where('e.id', $employee_id)
                            ->get()
                            ->row();
        
        $is_late = false;
        if ($employee && $employee->start_time) {
            $is_late = strtotime($time) > strtotime($employee->start_time);
        }
        
        $data = array(
            'employee_id' => $employee_id,
            'date' => $date,
            'in_time' => $time,
            'is_late' => $is_late ? 1 : 0,
            'status' => $is_late ? 'late' : 'present'
        );
        
        return $this->create($data);
    }
    
    public function check_out($employee_id) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        $attendance = $this->get_employee_attendance($employee_id, $date);
        
        if (!$attendance || $attendance->out_time) {
            return false; // Not checked in or already checked out
        }
        
        // Calculate worked hours
        $in_time = strtotime($attendance->in_time);
        $out_time = strtotime($time);
        $worked_hours = round(($out_time - $in_time) / 3600, 2);
        
        $data = array(
            'out_time' => $time,
            'worked_hours' => $worked_hours
        );
        
        return $this->update($attendance->id, $data);
    }
    
    public function count_present_today() {
        return $this->db->where('date', date('Y-m-d'))
                        ->where('status', 'present')
                        ->count_all_results($this->table);
    }
    
    public function get_attendance_trend($days = 7) {
        $result = array();
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            
            $present = $this->db->where('date', $date)
                               ->where('status', 'present')
                               ->count_all_results($this->table);
            
            $absent = $this->db->where('date', $date)
                              ->where('status', 'absent')
                              ->count_all_results($this->table);
            
            $result[] = array(
                'date' => $date,
                'present' => $present,
                'absent' => $absent
            );
        }
        
        return $result;
    }
    
    public function get_recent_attendances($limit = 10) {
        return $this->db->select('a.*, e.full_name, e.employee_code')
                        ->from($this->table . ' a')
                        ->join('employees e', 'e.id = a.employee_id')
                        ->order_by('a.created_at', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }
    
    public function get_monthly_summary($employee_id, $month, $year) {
        return $this->db->select('COUNT(*) as total_days,
                                 SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days,
                                 SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_days,
                                 SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_days,
                                 SUM(worked_hours) as total_hours')
                        ->where('employee_id', $employee_id)
                        ->where('MONTH(date)', $month)
                        ->where('YEAR(date)', $year)
                        ->get($this->table)
                        ->row();
    }
}