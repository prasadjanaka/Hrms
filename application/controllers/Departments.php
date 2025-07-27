<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Department_model');
    }

    public function index() {
        $data['departments'] = $this->Department_model->get_all();
        $this->render('departments/index', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Department Name', 'required|trim|is_unique[departments.name]');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => 1
                ];
                $this->Department_model->create($data);
                $this->session->set_flashdata('success', 'Department added successfully');
                redirect('departments');
            }
        }
        $this->render('departments/add');
    }

    public function edit($id) {
        $department = $this->Department_model->get_by_id($id);
        if (!$department) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Department Name', 'required|trim');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];
                $this->Department_model->update($id, $data);
                $this->session->set_flashdata('success', 'Department updated successfully');
                redirect('departments');
            }
        }
        $data['department'] = $department;
        $this->render('departments/edit', $data);
    }

    public function delete($id) {
        $department = $this->Department_model->get_by_id($id);
        if (!$department) show_404();
        $this->Department_model->delete($id);
        $this->session->set_flashdata('success', 'Department deleted successfully');
        redirect('departments');
    }
}