@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Tambah Kelas</h1>
        <p class="text-slate-500 mt-1">Isi form di bawah untuk menambahkan data kelas</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 animate-fade-in">
        <form method="POST" action="{{ route('kelas.store') }}" class="space-y-6" novalidate>
            @csrf

            <div>
                <label for="nama_kelas" class="block text-sm font-medium text-slate-700 mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white" required placeholder="Contoh: X RPL 1">
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-200">
                <a href="{{ route('kelas.index') }}" class="flex-1 sm:flex-none bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-medium transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-primary-500 to-indigo-600 hover:from-primary-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan Kelas</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection