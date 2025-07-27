<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {
    
    protected $table = 'employees';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_by_id($id) {
        return $this->db->select('e.*, d.name as department_name, des.name as designation_name, c.name as cadre_name, s.name as shift_name')
                        ->from($this->table . ' e')
                        ->join('departments d', 'd.id = e.department_id', 'left')
                        ->join('designations des', 'des.id = e.designation_id', 'left')
                        ->join('cadres c', 'c.id = e.cadre_id', 'left')
                        ->join('shifts s', 's.id = e.shift_id', 'left')
                        ->where('e.id', $id)
                        ->get()
                        ->row();
    }
    
    public function get_all($where = array(), $order_by = 'e.id DESC') {
        $this->db->select('e.*, d.name as department_name, des.name as designation_name, c.name as cadre_name, s.name as shift_name');
        $this->db->from($this->table . ' e');
        $this->db->join('departments d', 'd.id = e.department_id', 'left');
        $this->db->join('designations des', 'des.id = e.designation_id', 'left');
        $this->db->join('cadres c', 'c.id = e.cadre_id', 'left');
        $this->db->join('shifts s', 's.id = e.shift_id', 'left');
        
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
    
    public function count_all($where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }
    
    public function get_by_user_id($user_id) {
        return $this->db->where('user_id', $user_id)->get($this->table)->row();
    }
    
    public function get_shift_statistics() {
        return $this->db->select('s.name as shift_name, COUNT(e.id) as employee_count')
                        ->from('shifts s')
                        ->join($this->table . ' e', 'e.shift_id = s.id', 'left')
                        ->where('e.is_active', 1)
                        ->group_by('s.id')
                        ->get()
                        ->result();
    }
    
    public function get_department_statistics() {
        return $this->db->select('d.name as department_name, COUNT(e.id) as employee_count')
                        ->from('departments d')
                        ->join($this->table . ' e', 'e.department_id = d.id', 'left')
                        ->where('e.is_active', 1)
                        ->group_by('d.id')
                        ->get()
                        ->result();
    }
    
    public function search($keyword, $filters = array()) {
        $this->db->select('e.*, d.name as department_name, des.name as designation_name, c.name as cadre_name, s.name as shift_name');
        $this->db->from($this->table . ' e');
        $this->db->join('departments d', 'd.id = e.department_id', 'left');
        $this->db->join('designations des', 'des.id = e.designation_id', 'left');
        $this->db->join('cadres c', 'c.id = e.cadre_id', 'left');
        $this->db->join('shifts s', 's.id = e.shift_id', 'left');
        
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('e.full_name', $keyword);
            $this->db->or_like('e.employee_code', $keyword);
            $this->db->or_like('e.email', $keyword);
            $this->db->group_end();
        }
        
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (!empty($value)) {
                    $this->db->where('e.' . $key, $value);
                }
            }
        }
        
        return $this->db->where('e.is_active', 1)->get()->result();
    }
}