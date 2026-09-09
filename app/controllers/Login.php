<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Login extends Controller {
    public function index() {
        $this->call->library('session');
        $this->call->view('login_page', ['login_action' => site_url('login')]);
    }

    public function product_login()
    {
        $this->call->library('session');

        if ($this->session->has_userdata('is_logged_in') && $_SESSION['is_logged_in'] === true) {
            header('Location: ' . site_url('products'));
            exit;
        }

        $this->call->view('login_page', ['login_action' => site_url('admin/products/login')]);
    }

    public function login()
    {
        $this->call->library('session');

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['username'] = $username;
            $this->session->set_flashdata('success', 'Welcome back, admin!');
            header('Location: ' . site_url('products'));
            exit;
        }

        $this->session->set_flashdata('error', 'Invalid username or password.');
        header('Location: ' . site_url('admin/products'));
        exit;
    }

    public function logout()
    {
        $this->call->library('session');
        $this->session->sess_destroy();
        header('Location: ' . site_url('admin/products'));
        exit;
    }
}
?>
