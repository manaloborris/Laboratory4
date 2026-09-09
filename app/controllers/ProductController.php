<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('ProductModel');
        $this->call->library('session');
    }

    public function before_action()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            header('Location: ' . site_url('admin/products'));
            exit;
        }
    }

    public function index()
    {
        $products = $this->ProductModel->all();
        $this->call->view('products_index', ['products' => $products]);
    }

    public function create()
    {
        $this->call->view('product_form', ['product' => [], 'mode' => 'create']);
    }

    public function store()
    {
        $product_name = trim($_POST['product_name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $price        = trim($_POST['price'] ?? '0');
        $quantity     = (int)($_POST['quantity'] ?? 0);

        if ($product_name === '') {
            $this->call->view('product_form', ['errors' => ['Product name is required.'], 'product' => [], 'mode' => 'create']);
            return;
        }

        $this->ProductModel->create([
            'product_name' => $product_name,
            'description'  => $description,
            'price'        => (float)$price,
            'quantity'     => $quantity,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        $this->call->library('session');
        $this->session->set_flashdata('success', 'Product created successfully.');
        header('Location: ' . site_url('products'));
        exit;
    }

    public function edit($id)
    {
        $product = $this->ProductModel->find($id);
        if (!$product) {
            show_404();
        }

        $this->call->view('product_form', ['product' => $product, 'mode' => 'edit']);
    }

    public function update($id)
    {
        $product_name = trim($_POST['product_name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $price        = trim($_POST['price'] ?? '0');
        $quantity     = (int)($_POST['quantity'] ?? 0);

        if ($product_name === '') {
            $product = $this->ProductModel->find($id);
            $this->call->view('product_form', ['errors' => ['Product name is required.'], 'product' => $product, 'mode' => 'edit']);
            return;
        }

        $this->ProductModel->update($id, [
            'product_name' => $product_name,
            'description'  => $description,
            'price'        => (float)$price,
            'quantity'     => $quantity
        ]);

        $this->call->library('session');
        $this->session->set_flashdata('success', 'Product updated successfully.');
        header('Location: ' . site_url('products'));
        exit;
    }

    public function delete($id)
    {
        $this->ProductModel->delete($id);
        $this->call->library('session');
        $this->session->set_flashdata('success', 'Product deleted successfully.');
        header('Location: ' . site_url('products'));
        exit;
    }
}
