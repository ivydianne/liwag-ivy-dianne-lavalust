<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->database();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $this->api->require_jwt();
        $this->api->respond(['data' => $this->ProductModel->all()]);
    }

    public function show($id)
    {
        $this->api->require_jwt();
        $product = $this->ProductModel->find((int) $id);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond(['data' => $product]);
    }

    public function store()
    {
        $this->require_admin();
        $data = $this->validated_product($this->api->body());
        $id = $this->ProductModel->insert($data);

        $this->api->respond(['data' => $this->ProductModel->find((int) $id)], 201);
    }

    public function update($id)
    {
        $this->require_admin();
        $id = (int) $id;
        if (!$this->ProductModel->find($id)) {
            $this->api->respond_error('Product not found.', 404);
        }

        $data = $this->validated_product($this->api->body(), false);
        if (!$data) {
            $this->api->respond_error('At least one product field is required.', 422);
        }

        $this->ProductModel->update($id, $data);
        $this->api->respond(['data' => $this->ProductModel->find($id)]);
    }

    public function destroy($id)
    {
        $this->require_admin();
        $id = (int) $id;
        if (!$this->ProductModel->find($id)) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->ProductModel->delete($id);
        $this->api->respond(['message' => 'Product deleted successfully.']);
    }

    private function require_admin()
    {
        $payload = $this->api->require_jwt();
        if (($payload['role'] ?? '') !== 'admin') {
            $this->api->respond_error('Admin access is required for this action.', 403);
        }
    }

    private function validated_product(array $input, $required = true)
    {
        $fields = ['product_name', 'description', 'price', 'quantity'];
        $data = array_intersect_key($input, array_flip($fields));

        if ($required && (!isset($data['product_name']) || trim($data['product_name']) === '')) {
            $this->api->respond_error('product_name is required.', 422);
        }

        if (isset($data['product_name']) && (trim($data['product_name']) === '' || strlen($data['product_name']) > 100)) {
            $this->api->respond_error('product_name must be 1 to 100 characters.', 422);
        }

        if ($required && !array_key_exists('price', $data)) {
            $this->api->respond_error('price is required.', 422);
        }

        if (array_key_exists('price', $data) && (!is_numeric($data['price']) || $data['price'] < 0)) {
            $this->api->respond_error('price must be a non-negative number.', 422);
        }

        if ($required && !array_key_exists('quantity', $data)) {
            $this->api->respond_error('quantity is required.', 422);
        }

        if (array_key_exists('quantity', $data) && filter_var($data['quantity'], FILTER_VALIDATE_INT) === false) {
            $this->api->respond_error('quantity must be a non-negative integer.', 422);
        }

        if (array_key_exists('quantity', $data) && $data['quantity'] < 0) {
            $this->api->respond_error('quantity must be a non-negative integer.', 422);
        }

        return $data;
    }
}