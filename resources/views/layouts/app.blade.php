<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SmartKasir')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
    :root {
        --bg: #F8F9FA;
        --text: #000;
        --card: #FFF;
        --border: #DDD;
        --sidebar: #1F3A5F;
        --navbar: #F47C20;
        --hover: #F47C20;
        --input-bg: #FFF;
        --input-text: #000;
        --input-border: #CCC;
        --modal-bg: #FFF;
        --modal-text: #000;
    }

    body.bg-dark {
        --bg: #121212;
        --text: #E5E5E5;
        --card: #1E1E1E;
        --border: #333;
        --sidebar: #1A1A1A;
        --navbar: #1F2937;
        --hover: #333;
        --input-bg: #2B2B2B;
        --input-text: #FFF;
        --input-border: #444;
        --modal-bg: #1F1F1F;
        --modal-text: #EEE;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
        transition: 0.3s ease all;
    }

    .sidebar {
        width: 230px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        background: var(--sidebar);
        color: #FFF;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.3s;
        z-index: 1101;
    }

    .sidebar .logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar .logo img {
        width: 80px;
        border-radius: 50%;
    }

    .sidebar .menu {
        flex: 1;
    }

    .sidebar .menu h6 {
        padding: 10px 20px;
        text-transform: uppercase;
        font-size: 12px;
        color: #ccc;
    }

    .sidebar a {
        color: #FFF;
        padding: 12px 20px;
        display: block;
        text-decoration: none;
        transition: 0.25s;
    }

    .sidebar a:hover {
        background: var(--hover);
        padding-left: 28px;
    }

    .sidebar .bottom-menu a,
    .btn-logout {
        padding: 10px 20px;
        width: 100%;
    }

    .navbar-custom {
        background: var(--navbar);
        position: fixed;
        top: 0;
        left: 230px;
        width: calc(100% - 230px);
        z-index: 1000;
        transition: 0.3s;
        padding: 12px 20px;
    }

    .main-content {
        margin-left: 230px;
        padding: 80px 20px 20px;
        min-height: 100vh;
        transition: 0.3s;
    }

    .card {
        background: var(--card) !important;
        color: var(--text);
        border-color: var(--border) !important;
    }

    .table {
        color: var(--text);
    }

    input,
    select,
    textarea {
        background: var(--input-bg) !important;
        color: var(--input-text) !important;
        border-color: var(--input-border) !important;
    }

    .modal-content {
        background: var(--modal-bg) !important;
        color: var(--modal-text);
    }

    .modal-header,
    .modal-footer {
        border-color: var(--border) !important;
    }

    .btn {
        transition: 0.25s;
    }

    .btn-primary {
        background: var(--navbar);
        border: none;
    }

    .btn-primary:hover {
        opacity: 0.85;
    }

    .btn-logout {
        background: var(--sidebar);
        border: none;
        color: #FFF;
        transition: 0.3s;
    }

    .btn-logout:hover {
        background: var(--hover);
    }

    /* Hamburger toggle */
    .toggle-btn {
        font-size: 26px;
        cursor: pointer;
        display: none;
        color: white;
    }

    @media (max-width: 992px) {
        .toggle-btn {
            display: block;
        }

        .sidebar {
            transform: translateX(-230px);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .navbar-custom {
            left: 0;
            width: 100%;
        }

        .main-content {
            margin-left: 0;
        }
    }

    /* Overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 1000;
    }

    /* Navbar dark mode fix */
    body.bg-dark .navbar-custom {
        background-color: var(--navbar) !important;
    }

    body.bg-dark .sidebar {
        background-color: var(--sidebar) !important;
    }

    body.bg-dark .navbar-brand,
    body.bg-dark .navbar a {
        color: #fff !important;
    }

    /* FIX: Modal harus muncul di depan sidebar */
    .modal {
        z-index: 2000 !important;
    }

    .modal-backdrop {
        z-index: 1999 !important;
    }
    </style>
</head>

<body class="bg-dark">
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div>
            <div class="logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
                <h5>SmartKasir</h5>
            </div>

            <div class="menu">
                <h6>Menu Utama</h6>
                <a href="/dashboard"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
                <a href="/barang"><i class="bi bi-box-seam me-2"></i> Kelola Barang</a>
                <a href="/transaksi"><i class="bi bi-cash-stack me-2"></i> Transaksi</a>

                <h6>Laporan</h6>
                <a href="/laporan/barang"><i class="bi bi-clipboard-data me-2"></i> Laporan Barang</a>
                <a href="/laporan/transaksi"><i class="bi bi-bar-chart-line me-2"></i> Laporan Transaksi</a>

                <h6>Akun</h6>
                <a href="{{ route('profile.index') }}"><i class="bi bi-person-circle me-2"></i> Profil</a>
            </div>
        </div>

        <div class="bottom-menu">
            <button class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-custom px-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <span class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></span>
            <span class="navbar-brand text-white">SmartKasir</span>
            <div class="d-flex align-items-center gap-3 text-white">
                <a href="{{ route('profile.index') }}" class="text-white text-decoration-none">
                    <i class="bi bi-person-fill me-1"></i> Halo, {{ Auth::user()->name ?? 'Kasir' }}
                </a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Logout</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-box-arrow-right" style="font-size: 60px; color:#dc3545"></i>
                    <h5 class="mt-3">Yakin ingin keluar?</h5>
                    <p>Pastikan semua transaksi sudah tersimpan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger">Ya, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    function toggleSidebar() {
        sidebar.classList.toggle("active");
        overlay.style.display = sidebar.classList.contains("active") ? "block" : "none";
    }

    overlay.onclick = () => {
        sidebar.classList.remove("active");
        overlay.style.display = "none";
    };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
