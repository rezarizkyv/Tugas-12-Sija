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

        /* ===== PAGE BACKGROUND - abu gelap ===== */
        body {
            background-color: #0f172a;
            color: #e2e8f0;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-bg {
            background: linear-gradient(180deg, #0a1628 0%, #0d1f38 60%, #0f2545 100%);
            border-right: 1px solid rgba(56, 189, 248, 0.12);
        }

        /* ===== LOGO ICON ===== */
        .logo-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        }

        /* ===== NAV ITEMS ===== */
        .nav-item {
            color: #94a3b8;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .nav-item:hover {
            background: rgba(14, 165, 233, 0.1);
            color: #e2e8f0;
            border-left-color: rgba(56, 189, 248, 0.4);
        }
        .nav-item.nav-active {
            background: rgba(14, 165, 233, 0.15);
            color: #ffffff;
            border-left-color: #38bdf8;
            font-weight: 700;
        }
        .nav-item.nav-active .nav-dot { display: block; }
        .nav-dot { display: none; }

        /* ===== HEADER ===== */
        .header-glass {
            background: #111827;
            border-bottom: 1px solid rgba(56, 189, 248, 0.15);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.4);
        }

        /* ===== SEARCH BAR ===== */
        .search-input {
            background: #1e293b;
            border: 1.5px solid #334155;
            color: #e2e8f0;
            transition: all 0.2s ease;
            border-radius: 0.75rem;
            padding: 0.55rem 1rem 0.55rem 2.75rem;
            font-size: 0.875rem;
            width: 100%;
        }
        .search-input:focus {
            outline: none;
            border-color: #0ea5e9;
            background: #1e2d3d;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }
        .search-input::placeholder { color: #64748b; }

        /* ===== SCROLLBAR ===== */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #0ea5e9;
        }

        /* ===== AVATAR RING ===== */
        .avatar-ring {
            box-shadow: 0 0 0 2px #1e293b, 0 0 0 4px #0ea5e9;
        }

        /* ===== PULSE ONLINE ===== */
        @keyframes pulse-green {
            0%   { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.5); }
            70%  { box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
            100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
        }
        .pulse-online { animation: pulse-green 2s infinite; }

        /* ===== STATUS CARD ===== */
        .status-card {
            background: rgba(14, 165, 233, 0.07);
            border: 1px solid rgba(56, 189, 248, 0.18);
            border-radius: 0.875rem;
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notif-dropdown {
            background: #1e293b;
            border: 1px solid #334155;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .notif-item-blue {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.15);
        }
        .notif-item-amber {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.15);
        }

        /* ===== BADGE ===== */
        .badge-new {
            background: rgba(14, 165, 233, 0.2);
            color: #7dd3fc;
        }
        .badge-class {
            background: rgba(14, 165, 233, 0.15);
            color: #7dd3fc;
        }

        /* ===== FOOTER ===== */
        .footer-bar {
            background: #0d1829;
            border-top: 1px solid rgba(56, 189, 248, 0.12);
            color: #64748b;
        }

        /* ===== MAIN CONTENT AREA ===== */
        .main-area {
            background: #0f172a;
        }

        /* ===== DIVIDER ===== */
        .header-divider {
            background: #334155;
        }

        /* ===== MOBILE OVERLAY ===== */
        .mobile-overlay {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="h-full font-sans antialiased custom-scrollbar"
      x-data="{ sidebarOpen: false, notifOpen: false }">

    <div class="min-h-screen flex">

        <!-- ===================== SIDEBAR ===================== -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-68 sidebar-bg text-white transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-2xl lg:static lg:z-auto"
               style="width:300px;">

            <div>
                <!-- Brand / Logo -->
                <div class="px-5 py-5 flex items-center justify-between"
                     style="border-bottom: 1px solid rgba(56,189,248,0.1);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 logo-icon rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-graduation-cap text-white" style="font-size:1rem;"></i>
                        </div>
                        <div>
                            <h1 style="font-family:'Poppins',sans-serif; font-weight:900; font-size:1.15rem; line-height:1.1; color:#ffffff;">
                                Edu<span style="color:#38bdf8;">Verse</span>
                            </h1>
                            <p style="font-size:9px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#64748b; margin-top:2px;">
                                SMKN 1 Medelin &bull; LMS
                            </p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false"
                            class="lg:hidden p-1.5 rounded-lg transition-colors"
                            style="color:#64748b;" onmouseenter="this.style.color='#e2e8f0'" onmouseleave="this.style.color='#64748b'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Menu Label -->
                <p style="padding: 1.25rem 1.25rem 0.5rem; font-size:9px; font-weight:800; letter-spacing:0.18em; text-transform:uppercase; color:#475569;">
                    Navigasi Utama
                </p>

                <!-- Navigation Links -->
                <nav style="padding: 0 0.625rem; display:flex; flex-direction:column; gap:0.5rem; flex:1;">

                    <a href="{{ route('dashboard') }}"
                       class="nav-item {{ request()->routeIs('dashboard') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-gauge-high w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('dashboard') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>Dashboard</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('elearning') }}"
                       class="nav-item {{ request()->routeIs('elearning') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-book-open-reader w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('elearning') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>E-Learning &amp; Tugas</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('presensi') }}"
                       class="nav-item {{ request()->routeIs('presensi') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-fingerprint w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('presensi') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>Presensi Realtime</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('jadwal') }}"
                       class="nav-item {{ request()->routeIs('jadwal') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-calendar-week w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('jadwal') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>Jadwal Pelajaran</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('ujian') }}"
                       class="nav-item {{ request()->routeIs('ujian') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-file-circle-check w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('ujian') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>Ujian Online (CBT)</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('gradebook') }}"
                       class="nav-item {{ request()->routeIs('gradebook') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-chart-line w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('gradebook') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>Nilai &amp; Rapor</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                    <a href="{{ route('monitoring-osis') }}"
                       class="nav-item {{ request()->routeIs('monitoring-osis') ? 'nav-active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
                        <i class="fa-solid fa-person-booth w-5 text-center flex-shrink-0" style="font-size:0.9rem; {{ request()->routeIs('monitoring-osis') ? 'color:#38bdf8;' : '' }}"></i>
                        <span>E-Voting OSIS</span>
                        <span class="nav-dot ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#38bdf8;"></span>
                    </a>

                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div style="padding:1rem; border-top:1px solid rgba(56,189,248,0.1); display:flex; flex-direction:column; gap:0.75rem;">
                
                <!-- Account Quick Info Card -->
                <div class="status-card" style="padding:0.75rem;">
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                        <i class="fa-solid fa-circle-user" style="font-size:1.2rem; color:#38bdf8;"></i>
                        <div style="flex:1; min-width:0;">
                            <p style="font-size:11px; font-weight:700; color:#e2e8f0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ Auth::check() ? Auth::user()->name : 'Tamu' }}
                            </p>
                            <p style="font-size:9px; color:#64748b; margin-top:2px;">
                                {{ Auth::check() && Auth::user()->role === 'admin' ? 'Admin' : (Auth::check() && Auth::user()->kelas ? Auth::user()->kelas : 'Siswa') }}
                            </p>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 pulse-online flex-shrink-0"></span>
                        <span style="font-size:9px; color:#64748b;">Status: Online</span>
                    </div>
                </div>

                <!-- System Status Card -->
                <div class="status-card" style="padding:0.75rem;">
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.375rem;">
                        <i class="fa-solid fa-server" style="font-size:0.9rem; color:#38bdf8;"></i>
                        <span style="font-size:10px; font-weight:700; color:#94a3b8;">Sistem Online &amp; Aktif</span>
                    </div>
                    <p style="font-size:9px; color:#475569; line-height:1.5; margin-left:1.4rem;">
                        EduVerse v4.0 &bull; T.A. 2025/2026
                    </p>
                </div>

                <!-- Quick Shortcuts -->
                <div style="border-top:1px solid rgba(56,189,248,0.1); padding-top:0.75rem;">
                    <p style="font-size:8px; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#475569; margin-bottom:0.5rem;">
                        Shortcuts
                    </p>
                    <div style="display:flex; flex-direction:column; gap:0.375rem;">
                        <a href="#" style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem; border-radius:0.5rem; font-size:10px; font-weight:600; color:#94a3b8; transition:all 0.2s ease; text-decoration:none;" onmouseenter="this.style.background='rgba(14,165,233,0.1)'; this.style.color='#e2e8f0';" onmouseleave="this.style.background='transparent'; this.style.color='#94a3b8';">
                            <i class="fa-solid fa-gear" style="font-size:0.8rem;"></i> Setelan Akun
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem; border-radius:0.5rem; font-size:10px; font-weight:600; color:#94a3b8; transition:all 0.2s ease; text-decoration:none;" onmouseenter="this.style.background='rgba(14,165,233,0.1)'; this.style.color='#e2e8f0';" onmouseleave="this.style.background='transparent'; this.style.color='#94a3b8';">
                            <i class="fa-solid fa-circle-question" style="font-size:0.8rem;"></i> Bantuan & FAQ
                        </a>
                        <a href="#" style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem; border-radius:0.5rem; font-size:10px; font-weight:600; color:#94a3b8; transition:all 0.2s ease; text-decoration:none;" onmouseenter="this.style.background='rgba(14,165,233,0.1)'; this.style.color='#e2e8f0';" onmouseleave="this.style.background='transparent'; this.style.color='#94a3b8';">
                            <i class="fa-solid fa-envelope" style="font-size:0.8rem;"></i> Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             class="mobile-overlay fixed inset-0 z-30 lg:hidden" x-cloak></div>

        <!-- ===================== MAIN WRAPPER ===================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- TOP HEADER -->
            <header class="header-glass sticky top-0 z-40 flex items-center justify-between"
                    style="height:64px; padding: 0 1.5rem;">

                <div class="flex items-center gap-3">
                    <!-- Hamburger (mobile) -->
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl transition-colors"
                            style="color:#94a3b8; background:rgba(255,255,255,0.05);">
                        <i class="fa-solid fa-bars" style="font-size:1.1rem;"></i>
                    </button>

                    <!-- Brand breadcrumb (desktop) -->
                    <div class="hidden lg:flex items-center gap-2">
                        <span style="font-family:'Poppins',sans-serif; font-weight:900; font-size:1.05rem; color:#e2e8f0;">
                            Edu<span style="color:#38bdf8;">Verse</span>
                        </span>
                        <span style="color:#334155; font-size:1.1rem; font-weight:300; margin:0 2px;">/</span>
                        <span style="font-size:0.82rem; font-weight:600; color:#94a3b8;">@yield('page-title', 'Portal Belajar')</span>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative hidden sm:block" style="width:280px;">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2"
                           style="color:#64748b; font-size:0.8rem;"></i>
                        <input type="text"
                               placeholder="Cari modul, tugas, mapel..."
                               class="search-input">
                    </div>
                </div>

                <!-- Header Right -->
                <div class="flex items-center gap-2 sm:gap-3">

                    <!-- Search Icon Mobile -->
                    <button @click="searchModal = true"
                            class="sm:hidden p-2 rounded-xl transition-colors"
                            style="color:#94a3b8; background:rgba(255,255,255,0.05);">
                        <i class="fa-solid fa-magnifying-glass" style="font-size:1rem;"></i>
                    </button>

                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen"
                                class="relative p-2 rounded-xl transition-colors"
                                style="color:#94a3b8; background:rgba(255,255,255,0.05);"
                                onmouseenter="this.style.color='#e2e8f0'"
                                onmouseleave="this.style.color='#94a3b8'">
                            <i class="fa-regular fa-bell" style="font-size:1.1rem;"></i>
                            <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-60"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="notifOpen" @click.outside="notifOpen = false"
                             class="absolute right-0 mt-2 rounded-xl p-4 z-50 notif-dropdown"
                             style="width:340px;" x-cloak>
                            <div class="flex items-center justify-between pb-3 mb-3"
                                 style="border-bottom: 1px solid #1e293b;">
                                <h3 style="font-weight:800; color:#e2e8f0; font-size:0.85rem;">Notifikasi &amp; Pengumuman</h3>
                                <span class="badge-new px-2 py-0.5 rounded-full" style="font-size:11px; font-weight:700;">2 Baru</span>
                            </div>
                            <div style="display:flex; flex-direction:column; gap:0.625rem;">
                                <div class="notif-item-blue flex gap-3 p-2.5 rounded-xl">
                                    <div class="w-9 h-9 rounded-xl text-white flex items-center justify-center shrink-0"
                                         style="background: linear-gradient(135deg,#0ea5e9,#0284c7);">
                                        <i class="fa-solid fa-bullhorn" style="font-size:0.8rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size:12px; font-weight:700; color:#e2e8f0;">Jadwal PTS Genap 2026 Dirilis</p>
                                        <p style="font-size:11px; color:#94a3b8; margin-top:2px;">Ujian CBT dimulai Senin depan pukul 08.00 WIB.</p>
                                        <span style="font-size:10px; font-weight:700; color:#38bdf8;">1 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="notif-item-amber flex gap-3 p-2.5 rounded-xl">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white"
                                         style="background: linear-gradient(135deg,#f59e0b,#d97706);">
                                        <i class="fa-solid fa-file-pen" style="font-size:0.8rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size:12px; font-weight:700; color:#e2e8f0;">Tugas Baru: Pemrograman Web</p>
                                        <p style="font-size:11px; color:#94a3b8; margin-top:2px;">Bpk. Ahmad Fauzi menambahkan tugas CRUD Laravel.</p>
                                        <span style="font-size:10px; font-weight:700; color:#fbbf24;">10 menit yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-2.5 text-left focus:outline-none">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ Auth::check() ? Auth::user()->name : 'Guest' }}"
                                 alt="Profile"
                                 class="w-9 h-9 rounded-xl avatar-ring flex-shrink-0 transition-transform hover:scale-105"
                                 style="background: #1e293b;">
                            <div class="hidden sm:block">
                                <h4 style="font-size:0.82rem; font-weight:800; color:#e2e8f0; line-height:1.2;">
                                    {{ Auth::check() ? Auth::user()->name : 'Tamu' }}
                                </h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="badge-class px-2 py-0.5 rounded-lg" style="font-size:10px; font-weight:800; letter-spacing:0.05em;">
                                        {{ Auth::check() && Auth::user()->role === 'admin' ? 'ADMIN' : (Auth::check() && Auth::user()->kelas ? Auth::user()->kelas : 'SISWA') }}
                                    </span>
                                    <span style="font-size:11px; font-weight:700; color:#4ade80; display:flex; align-items:center; gap:4px;">
                                        <i class="fa-solid fa-chevron-down text-slate-500" style="font-size:0.7rem; margin-left:4px;"></i>
                                    </span>
                                </div>
                            </div>
                        </button>

                        <!-- Profile Menu -->
                        <div x-show="profileOpen" @click.outside="profileOpen = false"
                             class="absolute right-0 mt-3 w-48 rounded-2xl bg-slate-800 border border-slate-700 shadow-2xl z-50 overflow-hidden" x-cloak>
                            <div class="p-3 border-b border-slate-700/50">
                                <p class="text-xs text-slate-400 font-semibold mb-1">Masuk sebagai:</p>
                                <p class="text-sm font-bold text-slate-200 truncate">{{ Auth::check() ? Auth::user()->email : '-' }}</p>
                            </div>
                            <div class="p-1.5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 rounded-xl text-sm font-semibold text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- MAIN CONTENT -->
            <main class="main-area flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="footer-bar px-6 py-3 text-center sm:flex sm:items-center sm:justify-between" style="font-size:12px;">
                <p style="font-weight:600; color:#64748b;">
                    <i class="fa-solid fa-location-dot mr-1" style="color:#0ea5e9;"></i>
                    Jl. Pendidikan, Medelin &nbsp;&bull;&nbsp;
                    <a href="mailto:info@smkn1medelin.sch.id"
                       style="font-weight:700; color:#0ea5e9; text-decoration:none;"
                       onmouseenter="this.style.textDecoration='underline'"
                       onmouseleave="this.style.textDecoration='none'">info@smkn1medelin.sch.id</a>
                </p>
                <p class="mt-2 sm:mt-0" style="font-weight:600; color:#64748b;">
                    &copy; 2026 <span style="font-weight:900; color:#94a3b8;">EduVerse — SMKN 1 Medelin</span> &middot; Hak Cipta Dilindungi.
                </p>
            </footer>

        </div>
    </div>

</body>
</html>
