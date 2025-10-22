<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    protected $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
    
    public function get_by_username($username) {
        return $this->db->where('username', $username)->get($this->table)->row();
    }
    
    public function get_by_email($email) {
        return $this->db->where('email', $email)->get($this->table)->row();
    }
    
    public function authenticate($username, $password) {
        $user = $this->get_by_username($username);
        
        if (!$user) {
            return false;
        }
        
        if (!password_verify($password, $user->password)) {
            return false;
        }
        
        if (!$user->is_active) {
            return false;
        }
        
        // Update last login
        $this->update_last_login($user->id);
        
        return $user;
    }
    
    public function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)->update($this->table, $data);
    }
    
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    
    public function get_all($where = array(), $order_by = 'id DESC') {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->order_by($order_by)->get($this->table)->result();
    }
    
    public function count_all($where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }
    
    public function update_last_login($id) {
        return $this->db->where('id', $id)->update($this->table, array(
            'last_login' => date('Y-m-d H:i:s')
        ));
    }
    
    public function change_password($id, $new_password) {
        return $this->db->where('id', $id)->update($this->table, array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }
    
    public function get_employees() {
        return $this->db->select('u.*, e.full_name, e.employee_code')
                        ->from($this->table . ' u')
                        ->join('employees e', 'e.user_id = u.id', 'left')
                        ->where('u.role', 'employee')
                        ->get()
                        ->result();
    }
}