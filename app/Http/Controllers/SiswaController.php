<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SiswaController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request): View
    {
        try {
            $response = $this->api->getSiswa();
            $allData = $response['data'] ?? $response ?? [];
        } catch (\Exception $e) {
            $allData = [];
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }

        $collection = collect($allData);

        if ($request->filled('search')) {
            $search = strtolower($request->get('search'));
            $collection = $collection->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama'] ?? ''), $search) ||
                       str_contains(strtolower($item['nis'] ?? ''), $search) ||
                       str_contains(strtolower($item['kelas']['nama_kelas'] ?? ''), $search);
            });
        }

        if ($request->filled('kelas_id')) {
            $collection = $collection->filter(function ($item) use ($request) {
                return ($item['kelas']['id'] ?? '') == $request->get('kelas_id');
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $collection = $collection->filter(function ($item) use ($request) {
                return strtolower($item['jenis_kelamin']['nama'] ?? '') === strtolower($request->get('jenis_kelamin'));
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

        try {
            $kelasResponse = $this->api->getKelas();
            $kelasList = $kelasResponse['data'] ?? $kelasResponse ?? [];
        } catch (\Exception $e) {
            $kelasList = [];
        }

        return view('siswa.index', [
            'siswa' => $items->all(),
            'pagination' => $pagination,
            'kelasList' => $kelasList,
        ]);
    }

    public function create(): View
    {
        try {
            $kelasResponse = $this->api->getKelas();
            $kelasList = $kelasResponse['data'] ?? $kelasResponse ?? [];
        } catch (\Exception $e) {
            $kelasList = [];
            session()->flash('error', 'Gagal memuat data kelas: ' . $e->getMessage());
        }

        return view('siswa.create', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|integer',
            'jenis_kelamin_id' => 'required|integer|in:1,2',
        ]);

        try {
            $this->api->createSiswa($validated);
            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(int $id): View
    {
        try {
            $siswa = $this->api->getSiswaById($id);
            $kelasResponse = $this->api->getKelas();
            $kelasList = $kelasResponse['data'] ?? $kelasResponse ?? [];
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }

        return view('siswa.edit', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|integer',
            'jenis_kelamin_id' => 'required|integer|in:1,2',
        ]);

        try {
            $this->api->updateSiswa($id, $validated);
            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->api->deleteSiswa($id);
            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }
}