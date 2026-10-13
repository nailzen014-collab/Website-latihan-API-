@extends('layouts.app')

@section('title', 'Edit Pendaftaran OSIS')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Edit Pendaftaran OSIS</h1>
        <p class="text-slate-500 mt-1">Perbarui data pendaftaran calon pengurus OSIS</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 animate-fade-in">
        <form method="POST" action="{{ route('pendaftaran.update', $pendaftaran['id']) }}" class="space-y-6" novalidate>
            @csrf
            @method('PUT')
            
            {{-- Hidden field for siswa_id (cannot be changed) --}}
            <input type="hidden" name="siswa_id" value="{{ $pendaftaran['siswa']['id'] }}">

            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h3 class="text-sm font-medium text-slate-700 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Siswa (Tidak dapat diubah)
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-500 block mb-1">Nama</span>
                        <p class="font-medium text-slate-900">{{ $pendaftaran['siswa']['nama'] }}</p>
                    </div>
                    <div>
                        <span class="text-slate-500 block mb-1">NIS</span>
                        <p class="font-medium text-slate-900">{{ $pendaftaran['siswa']['nis'] }}</p>
                    </div>
                    <div>
                        <span class="text-slate-500 block mb-1">Kelas</span>
                        <p class="font-medium text-slate-900">{{ $pendaftaran['siswa']['kelas']['nama_kelas'] }}</p>
                    </div>
                    <div>
                        <span class="text-slate-500 block mb-1">Jenis Kelamin</span>
                        <p class="font-medium text-slate-900">{{ $pendaftaran['siswa']['jenis_kelamin']['nama'] }}</p>
                    </div>
                </div>
            </div>

            <div>
                <label for="pilihan_bidang" class="block text-sm font-medium text-slate-700 mb-2">Pilihan Bidang <span class="text-red-500">*</span></label>
                <select name="pilihan_bidang" id="pilihan_bidang" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white" required>
                    <option value="">-- Pilih Bidang --</option>
                    <option value="kepemimpinan" {{ old('pilihan_bidang', $pendaftaran['pilihan_bidang']) === 'kepemimpinan' ? 'selected' : '' }}>Kepemimpinan</option>
                    <option value="keagamaan" {{ old('pilihan_bidang', $pendaftaran['pilihan_bidang']) === 'keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                    <option value="olahraga" {{ old('pilihan_bidang', $pendaftaran['pilihan_bidang']) === 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="seni" {{ old('pilihan_bidang', $pendaftaran['pilihan_bidang']) === 'seni' ? 'selected' : '' }}>Seni</option>
                </select>
            </div>

            <div>
                <label for="motivasi" class="block text-sm font-medium text-slate-700 mb-2">Motivasi <span class="text-red-500">*</span></label>
                <textarea name="motivasi" id="motivasi" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all resize-none" placeholder="Tuliskan motivasi Anda ingin bergabung di OSIS (minimal 20 karakter)..." required minlength="20">{{ old('motivasi', $pendaftaran['motivasi']) }}</textarea>
                <p class="mt-1 text-sm text-slate-500">Minimal 20 karakter. Jelaskan alasan dan motivasi Anda ingin bergabung di organisasi OSIS</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-200">
                <a href="{{ route('pendaftaran.index') }}" class="flex-1 sm:flex-none bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-medium transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-primary-500 to-indigo-600 hover:from-primary-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Perbarui Pendaftaran</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection