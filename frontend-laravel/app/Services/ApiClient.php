<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiClient
{
    private string $base_url;

    public function __construct()
    {
        $this->base_url = rtrim(env('API_BASE_URL', 'http://api:8000/api/v1'), '/');
    }

    private function headers(): array
    {
        $headers = ['Accept' => 'application/json'];
        $token = Session::get('token');
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }
        return $headers;
    }

    public function get(string $path): mixed
    {
        try {
            $response = Http::withHeaders($this->headers())->get($this->base_url . $path);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function post(string $path, array $data): mixed
    {
        try {
            $response = Http::withHeaders($this->headers())->post($this->base_url . $path, $data);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function put(string $path, array $data): mixed
    {
        try {
            $response = Http::withHeaders($this->headers())->put($this->base_url . $path, $data);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function patch(string $path, array $data): mixed
    {
        try {
            $response = Http::withHeaders($this->headers())->patch($this->base_url . $path, $data);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(string $path): mixed
    {
        try {
            $response = Http::withHeaders($this->headers())->delete($this->base_url . $path);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
