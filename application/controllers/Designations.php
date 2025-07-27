<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designations extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Designation_model');
    }

    public function index() {
        $data['designations'] = $this->Designation_model->get_all();
        $this->render('designations/index', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Designation Name', 'required|trim|is_unique[designations.name]');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => 1
                ];
                $this->Designation_model->create($data);
                $this->session->set_flashdata('success', 'Designation added successfully');
                redirect('designations');
            }
        }
        $this->render('designations/add');
    }

    public function edit($id) {
        $designation = $this->Designation_model->get_by_id($id);
        if (!$designation) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Designation Name', 'required|trim');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];
                $this->Designation_model->update($id, $data);
                $this->session->set_flashdata('success', 'Designation updated successfully');
                redirect('designations');
            }
        }
        $data['designation'] = $designation;
        $this->render('designations/edit', $data);
    }

    public function delete($id) {
        $designation = $this->Designation_model->get_by_id($id);
        if (!$designation) show_404();
        $this->Designation_model->delete($id);
        $this->session->set_flashdata('success', 'Designation deleted successfully');
        redirect('designations');
    }
}