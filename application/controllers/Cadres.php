<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadres extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Cadre_model');
    }

    public function index() {
        $data['cadres'] = $this->Cadre_model->get_all();
        $this->render('cadres/index', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Cadre Name', 'required|trim|is_unique[cadres.name]');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => 1
                ];
                $this->Cadre_model->create($data);
                $this->session->set_flashdata('success', 'Cadre added successfully');
                redirect('cadres');
            }
        }
        $this->render('cadres/add');
    }

    public function edit($id) {
        $cadre = $this->Cadre_model->get_by_id($id);
        if (!$cadre) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Cadre Name', 'required|trim');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];
                $this->Cadre_model->update($id, $data);
                $this->session->set_flashdata('success', 'Cadre updated successfully');
                redirect('cadres');
            }
        }
        $data['cadre'] = $cadre;
        $this->render('cadres/edit', $data);
    }

    public function delete($id) {
        $cadre = $this->Cadre_model->get_by_id($id);
        if (!$cadre) show_404();
        $this->Cadre_model->delete($id);
        $this->session->set_flashdata('success', 'Cadre deleted successfully');
        redirect('cadres');
    }
}