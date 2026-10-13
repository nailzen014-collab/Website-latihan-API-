@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Siswa</h1>
            <p class="text-slate-500 mt-1">Kelola data siswa</p>
        </div>
        <a href="{{ route('siswa.create') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-primary-500 to-indigo-600 text-white font-semibold shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:from-primary-600 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center space-x-2 group">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Siswa</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-200 bg-slate-50/50">
            <form method="GET" action="{{ route('siswa.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 max-w-md">
                    <label for="search" class="sr-only">Cari siswa</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, atau kelas..." class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white">
                    </div>
                </div>
                <div class="flex-1 max-w-xs">
                    <label for="kelas_id" class="sr-only">Filter kelas</label>
                    <select name="kelas_id" id="kelas_id" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k['id'] }}" {{ request('kelas_id') == $k['id'] ? 'selected' : '' }}>{{ $k['nama_kelas'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 max-w-xs">
                    <label for="jenis_kelamin" class="sr-only">Filter jenis kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-3 rounded-xl bg-gradient-to-r from-primary-500 to-indigo-600 text-white font-medium transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 hover:from-primary-600 hover:to-indigo-700 whitespace-nowrap hidden sm:block">
                    Filter
                </button>
                <a href="{{ route('siswa.index') }}" class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition-all whitespace-nowrap hidden sm:block">
                    Reset
                </a>
                <div class="flex gap-2 sm:hidden">
                    <button type="submit" class="px-4 py-3 rounded-xl bg-gradient-to-r from-primary-500 to-indigo-600 text-white font-medium transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 hover:from-primary-600 hover:to-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('siswa.index') }}" class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition-all">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($siswa as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-4 text-sm text-slate-900">{{ (($pagination->currentPage() - 1) * $pagination->perPage()) + $index + 1 }}</td>
                            <td class="px-4 py-4 text-sm text-slate-900 font-mono">{{ $item['nis'] ?? '-' }}</td>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $item['nama'] ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-500">{{ $item['kelas']['nama_kelas'] ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ ($item['jenis_kelamin']['nama'] ?? '') === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $item['jenis_kelamin']['nama'] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('siswa.edit', $item['id']) }}" class="px-3 py-1.5 rounded-lg text-primary-600 hover:bg-primary-50 font-medium text-sm transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('siswa.destroy', $item['id']) }}" data-confirm="Apakah Anda yakin ingin menghapus siswa {{ $item['nama'] }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 font-medium text-sm transition-colors flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-slate-900">Belum ada data siswa</h3>
                                <p class="mt-2 text-slate-500">Mulai dengan menambahkan siswa baru.</p>
                                <div class="mt-6">
                                    <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-primary-500 to-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:from-primary-600 hover:to-indigo-700 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Siswa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pagination && $pagination->lastPage() > 1)
            <div class="px-4 py-4 border-t border-slate-200 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-700">
                        Menampilkan <span class="font-medium">{{ $pagination->firstItem() }}</span> sampai <span class="font-medium">{{ $pagination->lastItem() }}</span> dari <span class="font-medium">{{ $pagination->total() }}</span> data
                    </div>
                    <div class="flex items-center space-x-1">
                        @if ($pagination->currentPage() > 1)
                            <a href="{{ $pagination->url($pagination->currentPage() - 1) }}" class="px-3 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif
                        @for ($i = max(1, $pagination->currentPage() - 2); $i <= min($pagination->lastPage(), $pagination->currentPage() + 2); $i++)
                            @if ($i == $pagination->currentPage())
                                <span class="px-3 py-2 rounded-lg bg-primary-600 text-white font-medium">{{ $i }}</span>
                            @else
                                <a href="{{ $pagination->url($i) }}" class="px-3 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">{{ $i }}</a>
                            @endif
                        @endfor
                        @if ($pagination->currentPage() < $pagination->lastPage())
                            <a href="{{ $pagination->url($pagination->currentPage() + 1) }}" class="px-3 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection