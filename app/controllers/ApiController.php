<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    public function index()
    {
        $this->api->respond([
            'name' => 'LavaLust Product Management API',
            'status' => 'ok',
            'message' => 'LavaLust API is running',
            'endpoints' => [
                'login' => '/api/login',
                'register' => '/api/register',
                'products' => '/api/products',
            ],
        ]);
    }
}