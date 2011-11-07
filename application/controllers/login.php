<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('mlogin');
    }

    function index() {
        if ($this->session->userdata('login') == true) {
            redirect('admin');
        }
        $this->load->view('login');
    }

    function auth() {
        $this->form_validation->set_rules("username", "username", "required");
        $this->form_validation->set_rules("password", "password", "required");
        if ($this->form_validation->run() == true) {
            $username = $this->input->post("username", true);
            $password = $this->input->post("password", true);
            if ($this->mlogin->cek($username, $password) == true) {
                $session = $this->mlogin->proses($username, $password);
                $this->session->set_userdata("id", $session['id']);
                $this->session->set_userdata("login", "true");
                redirect("admin", "refresh");
            } else {
                $this->session->set_flashdata("notifikasi", "Tidak ada dalam system");
                redirect("login", "refresh");
            }
        } else {
            $this->index();
        }
    }

    function logout() {
        $this->session->unset_userdata("id");
        $this->session->unset_userdata("login");
        $this->session->sess_destroy();
        $this->session->set_flashdata("notifikasi", "Sudah keluar dari sistem");
        redirect('login');
    }

}
?>