<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadre_model extends CI_Model {
    
    protected $table = 'cadres';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
    
    public function get_all($where = array(), $order_by = 'name ASC') {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->order_by($order_by)->get($this->table)->result();
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
}