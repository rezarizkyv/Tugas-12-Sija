<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduVerse — SMKN 1 Medelin')</title>
    
    <!-- Google Fonts: Inter + Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* ===== PAGE BACKGROUND ===== */
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-bg {
            background: linear-gradient(180deg, #0c4a6e 0%, #075985 40%, #0369a1 100%);
            position: relative;
            overflow: hidden;
        }
        .sidebar-bg::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.12);
            pointer-events: none;
        }
        .sidebar-bg::after {
            content: '';
            position: absolute;
            bottom: 100px;
            left: -70px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(14, 165, 233, 0.1);
            pointer-events: none;
        }

        /* ===== LOGO BRAND ===== */
        .logo-icon {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            box-shadow: 0 8px 24px rgba(56, 189, 248, 0.45), 0 0 0 3px rgba(56, 189, 248, 0.2);
        }

        /* ===== NAV ITEMS ===== */
        .nav-item {
            position: relative;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item:not(.nav-active):hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(4px);
        }
        .nav-item.nav-active {
            background: linear-gradient(90deg, rgba(56,189,248,0.28), rgba(14,165,233,0.12));
            color: #fff;
            border-left: 3px solid #38bdf8;
        }
        .nav-item.nav-active .nav-dot { display: block; }
        .nav-dot { display: none; }

        /* ===== HEADER ===== */
        .header-glass {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(14, 165, 233, 0.18);
            box-shadow: 0 2px 20px rgba(3, 105, 161, 0.08);
        }

        /* ===== SEARCH BAR ===== */
        .search-input {
            background: rgba(240, 249, 255, 0.9);
            border: 1.5px solid rgba(125, 211, 252, 0.5);
            color: #0c4a6e;
            transition: all 0.2s ease;
            border-radius: 1rem;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            font-size: 0.875rem;
            width: 100%;
        }
        .search-input:focus {
            outline: none;
            border-color: #0ea5e9;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.12);
        }
        .search-input::placeholder { color: #7dd3fc; }

        /* ===== SCROLLBAR ===== */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f0f9ff; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #7dd3fc, #0ea5e9);
            border-radius: 999px;
        }

        /* ===== AVATAR RING ===== */
        .avatar-ring {
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #0ea5e9;
        }

        /* ===== PULSE ONLINE ===== */
        @keyframes pulse-green {
            0%   { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.6); }
            70%  { box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
            100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
        }
        .pulse-online { animation: pulse-green 2s infinite; }

        /* ===== STATUS CARD ===== */
        .status-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(125, 211, 252, 0.2);
        }

        /* ===== FOOTER ===== */
        .footer-bar {
            background: rgba(255,255,255,0.75);
            border-top: 1px solid rgba(125, 211, 252, 0.35);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 custom-scrollbar"
      x-data="{ sidebarOpen: false, notifOpen: false, searchModal: false }">

    <div class="min-h-screen flex">

        <!-- ===================== SIDEBAR ===================== -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-72 sidebar-bg text-white transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-2xl lg:static lg:z-auto">

            <div class="relative z-10">
                <!-- Brand / Logo -->
                <div class="px-5 py-5 flex items-center justify-between"
                     style="border-bottom: 1px solid rgba(125,211,252,0.12);">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 logo-icon rounded-2xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 style="font-family:'Poppins',sans-serif; font-weight:900; font-size:1.125rem; line-height:1; letter-spacing:-0.02em;">
                                <span class="text-white">Edu</span><span style="color:#38bdf8;">Verse</span>
                            </h1>
                            <p class="text-[10px] font-semibold tracking-widest uppercase mt-0.5"
                               style="color: rgba(125,211,252,0.75);">SMKN 1 Medelin &bull; LMS</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false"
                            class="lg:hidden p-1.5 rounded-lg hover:bg-white/10 transition-colors"
                            style="color: #7dd3fc;">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Menu Label -->
                <p class="px-6 pt-6 pb-2 text-[9px] font-black uppercase tracking-[0.2em]"
                   style="color: rgba(125,211,252,0.4);">Navigasi Utama</p>

                <!-- Navigation Links -->
                <nav class="px-3 space-y-0.5">

                    <a href="{{ route('dashboard') }}"
                       class="nav-item {{ request()->routeIs('dashboard') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('dashboard') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-gauge-high text-base w-5 text-center flex-shrink-0"></i>
                        <span>Dashboard</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('elearning') }}"
                       class="nav-item {{ request()->routeIs('elearning') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('elearning') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-book-open-reader text-base w-5 text-center flex-shrink-0"></i>
                        <span>E-Learning &amp; Tugas</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('presensi') }}"
                       class="nav-item {{ request()->routeIs('presensi') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('presensi') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-fingerprint text-base w-5 text-center flex-shrink-0"></i>
                        <span>Presensi Realtime</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('jadwal') }}"
                       class="nav-item {{ request()->routeIs('jadwal') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('jadwal') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-calendar-week text-base w-5 text-center flex-shrink-0"></i>
                        <span>Jadwal Pelajaran</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('ujian') }}"
                       class="nav-item {{ request()->routeIs('ujian') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('ujian') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-file-circle-check text-base w-5 text-center flex-shrink-0"></i>
                        <span>Ujian Online (CBT)</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('gradebook') }}"
                       class="nav-item {{ request()->routeIs('gradebook') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('gradebook') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-chart-line text-base w-5 text-center flex-shrink-0"></i>
                        <span>Nilai &amp; Rapor</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('monitoring-osis') }}"
                       class="nav-item {{ request()->routeIs('monitoring-osis') ? 'nav-active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold"
                       style="{{ request()->routeIs('monitoring-osis') ? 'color:#fff;' : 'color:rgba(186,230,253,0.75);' }}">
                        <i class="fa-solid fa-person-booth text-base w-5 text-center flex-shrink-0"></i>
                        <span>E-Voting OSIS</span>
                        <span class="nav-dot ml-auto w-2 h-2 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                </nav>
            </div>

            <!-- Sidebar Footer Status Card -->
            <div class="relative z-10 m-4 p-3 rounded-2xl status-card">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-400 pulse-online flex-shrink-0"></span>
                    <span class="text-xs font-bold" style="color:#7dd3fc;">Sistem: Online &amp; Aktif</span>
                </div>
                <p class="text-[10px] leading-relaxed" style="color: rgba(186,230,253,0.45);">
                    EduVerse v4.0 &bull; Tahun Ajaran 2025/2026
                </p>
            </div>
        </aside>

        <!-- Mobile backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 z-40 lg:hidden"
             style="background: rgba(7,89,133,0.55); backdrop-filter: blur(4px);"
             x-cloak></div>

        <!-- ===================== MAIN WRAPPER ===================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- TOP HEADER -->
            <header class="h-[70px] header-glass sticky top-0 z-30 px-4 lg:px-7 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <!-- Hamburger (mobile) -->
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl transition-colors"
                            style="color:#0369a1;">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <!-- Brand breadcrumb (desktop) -->
                    <div class="hidden lg:flex items-center gap-2">
                        <span style="font-family:'Poppins',sans-serif; font-weight:900; font-size:1.1rem; color:#0c4a6e;">
                            Edu<span style="color:#0ea5e9;">Verse</span>
                        </span>
                        <span class="text-slate-300 text-lg font-light">/</span>
                        <span class="text-sm font-semibold text-slate-500">@yield('page-title', 'Portal Belajar')</span>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative hidden sm:block" style="width:280px;">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm" style="color:#38bdf8;"></i>
                        <input type="text"
                               placeholder="Cari modul, tugas, mapel..."
                               class="search-input">
                    </div>
                </div>

                <!-- Header Right -->
                <div class="flex items-center gap-2 sm:gap-4">

                    <!-- Search Icon Mobile -->
                    <button @click="searchModal = true"
                            class="sm:hidden p-2.5 rounded-xl transition-colors" style="color:#0369a1;">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen"
                                class="relative p-2.5 rounded-2xl transition-colors hover:bg-sky-50"
                                style="color:#0369a1;">
                            <i class="fa-regular fa-bell text-xl"></i>
                            <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500" style="box-shadow:0 0 0 2px #fff;"></span>
                            </span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="notifOpen" @click.outside="notifOpen = false"
                             class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl p-4 z-50"
                             style="border: 1px solid rgba(125,211,252,0.4); box-shadow: 0 20px 60px rgba(3,105,161,0.14);"
                             x-cloak>
                            <div class="flex items-center justify-between pb-3 mb-3"
                                 style="border-bottom: 1px solid #e0f2fe;">
                                <h3 class="font-black text-slate-800 text-sm">Notifikasi &amp; Pengumuman</h3>
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold"
                                      style="background:#dbeafe; color:#1d4ed8;">2 Baru</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex gap-3 p-2.5 rounded-xl" style="background: rgba(240,249,255,0.8);">
                                    <div class="w-9 h-9 rounded-xl text-white flex items-center justify-center shrink-0"
                                         style="background: linear-gradient(135deg,#38bdf8,#0ea5e9);">
                                        <i class="fa-solid fa-bullhorn text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">Jadwal PTS Genap 2026 Dirilis</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Ujian online CBT dimulai Senin depan pukul 08.00 WIB.</p>
                                        <span class="text-[10px] font-bold" style="color:#0ea5e9;">1 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="flex gap-3 p-2.5 rounded-xl" style="background: rgba(255,251,235,0.8);">
                                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-file-pen text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">Tugas Baru: Pemrograman Web</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Bpk. Ahmad Fauzi menambahkan tugas CRUD Laravel.</p>
                                        <span class="text-[10px] text-amber-600 font-bold">10 menit yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-8 w-px" style="background: rgba(125,211,252,0.4);"></div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-2.5 pl-1">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=MedelinStudent"
                             alt="Siswa Profile"
                             class="w-9 h-9 rounded-2xl avatar-ring"
                             style="background: #dbeafe;">
                        <div class="hidden sm:block text-left">
                            <h4 class="text-sm font-black leading-none" style="color:#0c4a6e;">Siswa Medelin</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black tracking-wider"
                                      style="background:#dbeafe; color:#0369a1;">XII RPL</span>
                                <span class="text-xs font-bold text-green-500 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>Online
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- MAIN CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="footer-bar px-6 py-3 text-center sm:flex sm:items-center sm:justify-between text-xs text-slate-500">
                <p class="font-semibold">
                    <i class="fa-solid fa-location-dot mr-1" style="color:#0ea5e9;"></i>
                    Jl. Pendidikan, Medelin &nbsp;&bull;&nbsp;
                    <a href="mailto:info@smkn1medelin.sch.id"
                       class="font-bold hover:underline" style="color:#0ea5e9;">info@smkn1medelin.sch.id</a>
                </p>
                <p class="mt-2 sm:mt-0 font-semibold">
                    &copy; 2026 <span class="font-black" style="color:#0369a1;">EduVerse — SMKN 1 Medelin</span> &middot; Hak Cipta Dilindungi.
                </p>
            </footer>

        </div>
    </div>

</body>
</html>
