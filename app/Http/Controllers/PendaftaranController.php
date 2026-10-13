<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PendaftaranController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request): View
    {
        try {
            $response = $this->api->getPendaftaran();
            $allData = $response['data'] ?? $response ?? [];
        } catch (\Exception $e) {
            $allData = [];
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }

        $collection = collect($allData);

        if ($request->filled('search')) {
            $search = strtolower($request->get('search'));
            $collection = $collection->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['siswa']['nama'] ?? ''), $search) ||
                       str_contains(strtolower($item['siswa']['nis'] ?? ''), $search) ||
                       str_contains(strtolower($item['pilihan_bidang'] ?? ''), $search);
            });
        }

        if ($request->filled('bidang')) {
            $collection = $collection->filter(function ($item) use ($request) {
                return strtolower($item['pilihan_bidang'] ?? '') === strtolower($request->get('bidang'));
            });
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $collection->values()->forPage($currentPage, $perPage);

        $pagination = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('pendaftaran.index', [
            'pendaftaran' => $items->all(),
            'pagination' => $pagination,
        ]);
    }

    public function create(): View
    {
        try {
            $response = $this->api->getSiswa();
            $siswa = $response['data'] ?? $response ?? [];
        } catch (\Exception $e) {
            $siswa = [];
            session()->flash('error', 'Gagal memuat data siswa: ' . $e->getMessage());
        }

        return view('pendaftaran.create', compact('siswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|integer',
            'pilihan_bidang' => 'required|string|max:255',
            'motivasi' => 'required|string|min:20',
        ]);

        try {
            $this->api->createPendaftaran($validated);
            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran OSIS berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(int $id): View
    {
        try {
            $pendaftaran = $this->api->getPendaftaranById($id);
            $response = $this->api->getSiswa();
            $siswa = $response['data'] ?? $response ?? [];
        } catch (\Exception $e) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }

        return view('pendaftaran.edit', compact('pendaftaran', 'siswa'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|integer',
            'pilihan_bidang' => 'required|string|max:255',
            'motivasi' => 'required|string|min:20',
        ]);

        try {
            $this->api->updatePendaftaran($id, $validated);
            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran OSIS berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->api->deletePendaftaran($id);
            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran OSIS berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Gagal menghapus pendaftaran: ' . $e->getMessage());
        }
    }
}