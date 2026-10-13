<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url', env('API_BASE_URL', 'http://localhost:8000/api'));
    }

    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(10)
            ->retry(3, 100);
    }

    // Siswa methods
    public function getSiswa(array $params = []): array
    {
        $response = $this->client()->get('/siswa', $params);
        return $this->handleResponse($response);
    }

    public function getSiswaById(int $id): array
    {
        $response = $this->client()->get("/siswa/{$id}");
        return $this->handleResponse($response);
    }

    public function createSiswa(array $data): array
    {
        $response = $this->client()->post('/siswa', $data);
        return $this->handleResponse($response);
    }

    public function updateSiswa(int $id, array $data): array
    {
        $response = $this->client()->put("/siswa/{$id}", $data);
        return $this->handleResponse($response);
    }

    public function deleteSiswa(int $id): bool
    {
        $response = $this->client()->delete("/siswa/{$id}");
        return $response->successful() || $response->status() === 204;
    }

    // Kelas methods
    public function getKelas(array $params = []): array
    {
        $response = $this->client()->get('/kelas', $params);
        return $this->handleResponse($response);
    }

    public function getKelasById(int $id): array
    {
        $response = $this->client()->get("/kelas/{$id}");
        return $this->handleResponse($response);
    }

    public function createKelas(array $data): array
    {
        $response = $this->client()->post('/kelas', $data);
        return $this->handleResponse($response);
    }

    public function updateKelas(int $id, array $data): array
    {
        $response = $this->client()->put("/kelas/{$id}", $data);
        return $this->handleResponse($response);
    }

    public function deleteKelas(int $id): bool
    {
        $response = $this->client()->delete("/kelas/{$id}");
        return $response->successful() || $response->status() === 204;
    }

    // Pendaftaran methods
    public function getPendaftaran(array $params = []): array
    {
        $response = $this->client()->get('/pendaftaran-osis', $params);
        return $this->handleResponse($response);
    }

    public function getPendaftaranById(int $id): array
    {
        $response = $this->client()->get("/pendaftaran-osis/{$id}");
        return $this->handleResponse($response);
    }

    public function createPendaftaran(array $data): array
    {
        $response = $this->client()->post('/pendaftaran-osis', $data);
        return $this->handleResponse($response);
    }

    public function updatePendaftaran(int $id, array $data): array
    {
        $response = $this->client()->put("/pendaftaran-osis/{$id}", $data);
        return $this->handleResponse($response);
    }

    public function deletePendaftaran(int $id): bool
    {
        $response = $this->client()->delete("/pendaftaran-osis/{$id}");
        return $response->successful() || $response->status() === 204;
    }

    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            $json = $response->json();
            return $json['data'] ?? $json ?? [];
        }

        if ($response->status() === 422) {
            throw new \Illuminate\Validation\ValidationException(
                \Illuminate\Validation\Factory::make()->make($response->json('errors', []), [])
            );
        }

        throw new \Exception("API Error: {$response->status()} - {$response->body()}");
    }
}