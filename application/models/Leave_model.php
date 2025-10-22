<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {
    
    protected $table = 'leaves';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_by_id($id) {
        return $this->db->select('l.*, e.full_name, e.employee_code, lt.name as leave_type_name, u.username as approved_by_name')
                        ->from($this->table . ' l')
                        ->join('employees e', 'e.id = l.employee_id')
                        ->join('leave_types lt', 'lt.id = l.leave_type_id')
                        ->join('users u', 'u.id = l.approved_by', 'left')
                        ->where('l.id', $id)
                        ->get()
                        ->row();
    }
    
    public function get_all($where = array(), $order_by = 'l.created_at DESC') {
        $this->db->select('l.*, e.full_name, e.employee_code, lt.name as leave_type_name, u.username as approved_by_name');
        $this->db->from($this->table . ' l');
        $this->db->join('employees e', 'e.id = l.employee_id');
        $this->db->join('leave_types lt', 'lt.id = l.leave_type_id');
        $this->db->join('users u', 'u.id = l.approved_by', 'left');
        
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
    
    public function get_employee_leaves($employee_id) {
        return $this->db->select('l.*, lt.name as leave_type_name')
                        ->from($this->table . ' l')
                        ->join('leave_types lt', 'lt.id = l.leave_type_id')
                        ->where('l.employee_id', $employee_id)
                        ->order_by('l.created_at', 'DESC')
                        ->get()
                        ->result();
    }
    
    public function get_pending_leaves() {
        return $this->get_all(array('l.status' => 'pending'));
    }
    
    public function approve_leave($id, $approved_by, $remarks = '') {
        return $this->update($id, array(
            'status' => 'approved',
            'approved_by' => $approved_by,
            'approved_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ));
    }
    
    public function reject_leave($id, $approved_by, $remarks = '') {
        return $this->update($id, array(
            'status' => 'rejected',
            'approved_by' => $approved_by,
            'approved_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ));
    }
    
    public function count_on_leave_today() {
        $today = date('Y-m-d');
        
        return $this->db->where('start_date <=', $today)
                        ->where('end_date >=', $today)
                        ->where('status', 'approved')
                        ->count_all_results($this->table);
    }
    
    public function get_recent_leaves($limit = 10) {
        return $this->db->select('l.*, e.full_name, e.employee_code, lt.name as leave_type_name')
                        ->from($this->table . ' l')
                        ->join('employees e', 'e.id = l.employee_id')
                        ->join('leave_types lt', 'lt.id = l.leave_type_id')
                        ->order_by('l.created_at', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }
    
    public function get_leave_balance($employee_id, $leave_type_id) {
        // Get total approved leaves for this type
        $used_leaves = $this->db->select('SUM(total_days) as used_days')
                                ->where('employee_id', $employee_id)
                                ->where('leave_type_id', $leave_type_id)
                                ->where('status', 'approved')
                                ->get($this->table)
                                ->row();
        
        // Get default days for this leave type
        $leave_type = $this->db->where('id', $leave_type_id)->get('leave_types')->row();
        
        $used = $used_leaves ? $used_leaves->used_days : 0;
        $total = $leave_type ? $leave_type->default_days : 0;
        
        return array(
            'total' => $total,
            'used' => $used,
            'remaining' => $total - $used
        );
    }
    
    public function get_monthly_summary($employee_id, $month, $year) {
        return $this->db->select('COUNT(*) as total_leaves,
                                 SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_leaves,
                                 SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_leaves,
                                 SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_leaves,
                                 SUM(total_days) as total_days')
                        ->where('employee_id', $employee_id)
                        ->where('MONTH(start_date)', $month)
                        ->where('YEAR(start_date)', $year)
                        ->get($this->table)
                        ->row();
    }
    
    public function get_employee_stats($employee_id) {
        // Get leave counts by status
        $approved = $this->db->where('employee_id', $employee_id)
                            ->where('status', 'approved')
                            ->count_all_results($this->table);
        
        $pending = $this->db->where('employee_id', $employee_id)
                           ->where('status', 'pending')
                           ->count_all_results($this->table);
        
        $rejected = $this->db->where('employee_id', $employee_id)
                            ->where('status', 'rejected')
                            ->count_all_results($this->table);
        
        // Get leave balance for different types
        $sick_balance = $this->get_leave_balance($employee_id, 1); // Assuming 1 is sick leave type ID
        $casual_balance = $this->get_leave_balance($employee_id, 2); // Assuming 2 is casual leave type ID
        $annual_balance = $this->get_leave_balance($employee_id, 3); // Assuming 3 is annual leave type ID
        
        return array(
            'approved_leaves' => $approved,
            'pending_leaves' => $pending,
            'rejected_leaves' => $rejected,
            'sick_balance' => $sick_balance['remaining'],
            'casual_balance' => $casual_balance['remaining'],
            'annual_balance' => $annual_balance['remaining']
        );
    }
    
    public function get_employee_leaves($employee_id, $limit = 10) {
        return $this->db->select('l.*, lt.name as leave_type_name')
                        ->from($this->table . ' l')
                        ->join('leave_types lt', 'lt.id = l.leave_type_id')
                        ->where('l.employee_id', $employee_id)
                        ->order_by('l.created_at', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }
}