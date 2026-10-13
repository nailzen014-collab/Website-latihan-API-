<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pendaftaran OSIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'scale-in': 'scaleIn 0.2s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.7' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="font-sans bg-slate-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full lg:relative">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-slate-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/25">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-md font-bold text-slate-900 gradient-text hidden lg:block">Sistem Pendaftaran OSIS</span>
                        <span class="text-md font-bold text-slate-900 gradient-text lg:hidden">OSIS</span>
                    </div>
                    <button id="sidebar-close" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('pendaftaran.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 group {{ request()->routeIs('pendaftaran*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="hidden lg:inline">Daftar Pendaftaran</span>
                    </a>
                    <a href="{{ route('pendaftaran.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-primary-500 to-indigo-600 text-white font-semibold shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:from-primary-600 hover:to-indigo-700 transition-all duration-300 flex items-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="hidden font-md md:inline">Tambah Pendaftaran</span>
                    </a>
                    
                    <hr class="my-4 border-slate-200">
                    
                    <a href="{{ route('siswa.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 group {{ request()->routeIs('siswa*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="hidden lg:inline">Data Siswa</span>
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 group {{ request()->routeIs('kelas*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="hidden lg:inline">Data Kelas</span>
                    </a>
                </nav>

                <!-- Footer -->
                <div class="p-4 border-t border-slate-200">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-slate-500">v1.0.0</p>
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0 min-w-0">
            <!-- Top Bar -->
            <header class="sticky top-0 z-40 bg-white border-b border-slate-200 lg:hidden">
                <div class="flex items-center justify-between h-16 px-4">
                    <button id="sidebar-toggle" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="text-lg font-bold text-slate-900 gradient-text">Sistem Pendaftaran OSIS</span>
                    <div class="w-10"></div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '{{ session('success') }}',
                                timer: 3000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end',
                                timerProgressBar: true,
                                background: '#fff',
                                color: '#1e293b',
                                customClass: {
                                    popup: 'rounded-xl shadow-xl'
                                }
                            });
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: '{{ session('error') }}',
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'OK',
                                background: '#fff',
                                color: '#1e293b',
                                customClass: {
                                    popup: 'rounded-xl shadow-xl',
                                    confirmButton: 'rounded-lg px-6 py-2'
                                }
                            });
                        });
                    </script>
                @endif

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const errors = @json($errors->messages());
                            let errorHtml = '<ul style="text-align: left; margin: 0; padding-left: 1.25rem;">';
                            for (const [field, messages] of Object.entries(errors)) {
                                messages.forEach(msg => {
                                    errorHtml += `<li style="margin-bottom: 0.5rem;"><strong>${field}:</strong> ${msg}</li>`;
                                });
                            }
                            errorHtml += '</ul>';
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal!',
                                html: errorHtml,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'Perbaiki',
                                width: '500px',
                                background: '#fff',
                                color: '#1e293b',
                                customClass: {
                                    popup: 'rounded-xl shadow-xl',
                                    confirmButton: 'rounded-lg px-6 py-2'
                                }
                            });
                        });
                    </script>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-slate-200 bg-white/50 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-center md:text-left text-slate-500 text-sm">
                            &copy; {{ date('Y') }} Sistem Pendaftaran OSIS. Dibangun dengan <span class="text-primary-600 font-medium">Laravel</span> & <span class="text-indigo-600 font-medium">Tailwind CSS</span>.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Close sidebar on link click (mobile)
        document.querySelectorAll('#sidebar nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Reset any stuck loading buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('button[type="submit"]').forEach(btn => {
                btn.disabled = false;
                if (btn.dataset.originalHtml) {
                    btn.innerHTML = btn.dataset.originalHtml;
                    delete btn.dataset.originalHtml;
                }
            });
        });

        // Confirm delete with SweetAlert2
        document.querySelectorAll('form[data-confirm]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
                const message = this.dataset.confirm;
                
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: '#fff',
                    color: '#1e293b',
                    customClass: {
                        popup: 'rounded-xl shadow-xl',
                        confirmButton: 'rounded-lg px-6 py-2',
                        cancelButton: 'rounded-lg px-6 py-2'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        formElement.submit();
                    }
                });
            });
        });

        // Add loading state to submit buttons (on form submit, not click)
        document.querySelectorAll('form[method="POST"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Don't add loading for delete forms (they use SweetAlert)
                if (this.dataset.confirm) return;
                
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && this.checkValidity()) {
                    submitBtn.disabled = true;
                    submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
                    
                    // Safety timeout to re-enable button if something goes wrong
                    setTimeout(() => {
                        if (submitBtn.disabled) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = submitBtn.dataset.originalHtml || submitBtn.innerHTML;
                        }
                    }, 10000);
                }
            });
        });

        // Animate table rows on load
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>