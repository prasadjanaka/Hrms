<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->require_role(['admin', 'hr']);
        $this->load->model('Shift_model');
    }

    public function index() {
        $data['shifts'] = $this->Shift_model->get_all();
        $this->render('shifts/index', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Shift Name', 'required|trim|is_unique[shifts.name]');
            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
            $this->form_validation->set_rules('working_days', 'Working Days', 'required');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'start_time' => $this->input->post('start_time'),
                    'end_time' => $this->input->post('end_time'),
                    'working_days' => implode(',', $this->input->post('working_days')),
                    'is_active' => 1
                ];
                $this->Shift_model->create($data);
                $this->session->set_flashdata('success', 'Shift added successfully');
                redirect('shifts');
            }
        }
        $this->render('shifts/add');
    }

    public function edit($id) {
        $shift = $this->Shift_model->get_by_id($id);
        if (!$shift) show_404();
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Shift Name', 'required|trim');
            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
            $this->form_validation->set_rules('working_days', 'Working Days', 'required');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'start_time' => $this->input->post('start_time'),
                    'end_time' => $this->input->post('end_time'),
                    'working_days' => implode(',', $this->input->post('working_days')),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];
                $this->Shift_model->update($id, $data);
                $this->session->set_flashdata('success', 'Shift updated successfully');
                redirect('shifts');
            }
        }
        $shift->working_days = explode(',', $shift->working_days);
        $data['shift'] = $shift;
        $this->render('shifts/edit', $data);
    }

    public function delete($id) {
        $shift = $this->Shift_model->get_by_id($id);
        if (!$shift) show_404();
        $this->Shift_model->delete($id);
        $this->session->set_flashdata('success', 'Shift deleted successfully');
        redirect('shifts');
    }
}