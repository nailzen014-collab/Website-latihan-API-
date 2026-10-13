<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class KelasController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request): View
    {
        try {
            $response = $this->api->getKelas();
            $allData = $response['data'] ?? $response ?? [];
        } catch (\Exception $e) {
            $allData = [];
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }

        $collection = collect($allData);

        if ($request->filled('search')) {
            $search = strtolower($request->get('search'));
            $collection = $collection->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama_kelas'] ?? ''), $search);
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

        return view('kelas.index', [
            'kelas' => $items->all(),
            'pagination' => $pagination,
        ]);
    }

    public function create(): View
    {
        return view('kelas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
        ]);

        try {
            $this->api->createKelas($validated);
            return redirect()->route('kelas.index')
                ->with('success', 'Data kelas berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan kelas: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $kelas = $this->api->getKelasById($id);
        } catch (\Exception $e) {
            return redirect()->route('kelas.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }

        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
        ]);

        try {
            $this->api->updateKelas($id, $validated);
            return redirect()->route('kelas.index')
                ->with('success', 'Data kelas berhasil diperbarui!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui kelas: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->api->deleteKelas($id);
            return redirect()->route('kelas.index')
                ->with('success', 'Data kelas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kelas.index')
                ->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }
}