<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PSS')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme Detection Script (Prevents Flickering) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <style>
        :root {
            /* Light Theme Variables */
            --bg-body: #f5f6f8;
            --bg-sidebar: #ffffff;
            --bg-main: #f5f6f8;
            --bg-card: #ffffff;
            --bg-surface: #ffffff;
            --bg-input: #ffffff;
            --bg-table-head: #f5f6f8;

            --text-main: #242424;
            --text-muted: #919191;
            --text-sidebar: #74747c;

            --border-color: #e5e5e5;
            --border-soft: #eee;

            --primary: #FF7C19;
            --primary-hover: #ff8c33;
            --primary-soft: #fff3e9;

            /* Icon Colors Light */
            --icon-total-bg: #FFF3EB;
            --icon-total-color: #FF7C19;
            --icon-pending-bg: #FFF7EB;
            --icon-pending-color: #FFB84D;
            --icon-review-bg: #EFFBFA;
            --icon-review-color: #4ECDC4;
            --icon-completed-bg: #F2FDED;
            --icon-completed-color: #52C41A;

            --action-view-bg: #EFFBFA;
            --action-view-color: #4ECDC4;
            --action-delete-bg: #FFF0F1;
            --action-delete-color: #FF4757;
            --action-edit-bg: #fff4e6;
            --action-edit-color: #FF9632;

            --shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        [data-theme='dark'] {
            /* Dark Theme Variables */
            --bg-body: #0f1115;
            --bg-sidebar: #1a1d23;
            --bg-main: #0f1115;
            --bg-card: #1a1d23;
            --bg-surface: #1a1d23;
            --bg-input: #242831;
            --bg-table-head: #242831;

            --text-main: #f0f2f5;
            --text-muted: #9ba1a9;
            --text-sidebar: #a0a7b1;

            --border-color: #2d323c;
            --border-soft: #242831;

            --primary: #FF7C19;
            --primary-hover: #ff8c33;
            --primary-soft: #2d2016;

            /* Icon Colors Dark */
            --icon-total-bg: #2d2016;
            --icon-total-color: #FF7C19;
            --icon-pending-bg: #2d2616;
            --icon-pending-color: #FFB84D;
            --icon-review-bg: #162a28;
            --icon-review-color: #4ECDC4;
            --icon-completed-bg: #1a2d16;
            --icon-completed-color: #52C41A;

            --action-view-bg: #162a28;
            --action-delete-bg: #2d1618;
            --action-edit-bg: #2d2216;

            --shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            --shadow-hover: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            transition: background 0.3s, color 0.3s;
        }

        /* Layout */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--bg-sidebar);
            padding: 24px 16px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.04);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease, background 0.3s;
            z-index: 1000;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 32px;
        }

        .menu-section {
            margin-bottom: 24px;
        }

        .menu-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
            padding: 0 12px;
        }

        .menu li {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            cursor: pointer;
            color: var(--text-sidebar);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-link {
            color: inherit;
            text-decoration: none;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            /* spacing between icon and text */
        }

        .menu li i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .menu li:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .menu li.active {
            background: var(--primary);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255, 124, 25, 0.2);
        }

        .menu li.active a {
            color: white;
        }

        .menu-link {
            color: inherit;
            text-decoration: none;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            /* reduce distance between icon & text */
        }

        .menu {
            list-style: none;
            padding-bottom: 80px;
            /* Space for logout button */
        }

        .logout-btn {
            position: absolute;
            bottom: 24px;
            left: 16px;
            right: 16px;
            width: calc(100% - 32px);
            padding: 12px;
            border: none;
            background: transparent;
            color: #FF4757;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: var(--action-delete-bg);
        }

        /* Main Content */
        .main {
            flex: 1;
            margin-left: 260px;
            padding: 24px 32px;
            min-width: 0;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .mobile-toggle {
            display: none;
        }

        .topbar-left h1 {
            font-size: 28px;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .topbar-left p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .theme-toggle {
            display: flex;
            background: var(--bg-table-head);
            border-radius: 20px;
            padding: 4px;
            cursor: pointer;
        }

        .theme-toggle-btn {
            padding: 8px 16px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            color: var(--text-sidebar);
            border-radius: 18px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .theme-toggle-btn.active {
            background: var(--primary);
            color: white;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-sidebar);
            transition: 0.2s;
        }

        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .card {
            background: var(--bg-card);
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }


        .card h3 {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            margin-bottom: 8px;
            font-weight: 500;
        }


        .card p {
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .card-desc {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        .filter-section {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr) auto;
            gap: 16px;
            align-items: end;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-item label {
            font-size: 13px;
            margin-bottom: 6px;
            color: #666;
        }

        .filter-input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
        }

        .filter-input:focus {
            outline: none;
            border-color: #4A90E2;
        }

        .filter-action {
            display: flex;
            align-items: flex-end;
        }

        .filter-apply {
            padding: 10px 20px;
            border: none;
            background: #4A90E2;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-apply:hover {
            background: #357ABD;
        }



        /* Sections */
        .table-section {
            background: var(--bg-card);
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            justify-content: flex-end;
            min-width: 300px;
        }

        .table-header h3 {
            color: var(--text-main);
            white-space: nowrap;
        }

        .search-box {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 12px 16px 12px 36px;
            border-radius: 10px;
            width: 100%;
            outline: none;
            font-size: 14px;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            max-width: 300px;
            width: 100%;
        }

        .search-wrapper i {
            position: absolute;
            left: 12px;
            color: var(--text-muted);
            z-index: 10;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--bg-table-head);
            color: var(--text-sidebar);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
        }

        td {
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-main);
            padding: 16px;
            font-size: 14px;
        }

        /* Action Colors */
        /* Actions */
        .filter-btn {
            padding: 12px 16px;
            border: 1px solid var(--primary);
            border-radius: 10px;
            background: var(--primary);
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: 0.15s ease;
        }

        .filter-btn i {
            color: #ffffff;
        }

        .filter-btn:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #ffffff;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .card-link:hover .card {
            transform: translateY(-4px);
            transition: 0.2s;
            cursor: pointer;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 20px;
            margin-bottom: 16px;
            transition: 0.3s;
        }

        .card-icon.total {
            background: var(--icon-total-bg);
            color: var(--icon-total-color);
        }

        .card-icon.pending {
            background: var(--icon-pending-bg);
            color: var(--icon-pending-color);
        }

        .card-icon.review {
            background: var(--icon-review-bg);
            color: var(--icon-review-color);
        }

        .card-icon.completed {
            background: var(--icon-completed-bg);
            color: var(--icon-completed-color);
        }

        /* Status badges (small colored dot + text to the right) */
        .status-pending,
        .status-review,
        .status-completed,
        .status-repair,
        .status-done {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            background: transparent;
        }

        .status-pending {
            background: var(--icon-pending-bg);
            color: var(--icon-pending-color);
        }

           .status-user {
            background: #EFF6FF;
            color: #3B82F6;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--icon-pending-color);
            display: inline-block;
        }

        .status-user::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #3B82F6;
            display: inline-block;
        }

        .status-review,
        .status-repair {
            background: var(--icon-review-bg);
            color: var(--icon-review-color);
        }

        .status-review::before,
        .status-repair::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--icon-review-color);
            display: inline-block;
        }

        .status-completed,
        .status-done {
            background: var(--icon-completed-bg);
            color: var(--icon-completed-color);
        }

        .status-completed::before,
        .status-done::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--icon-completed-color);
            display: inline-block;
        }

        /* Actions */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
        }

        .action-btn.view {
            background: var(--action-view-bg);
            color: var(--action-view-color);
        }

        .action-btn.delete {
            background: var(--action-delete-bg);
            color: var(--action-delete-color);
        }

        .action-btn.edit {
            background: var(--action-edit-bg);
            color: var(--action-edit-color);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.95);
        }

        /* Responsive */
        @media(max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-toggle {
                display: block;
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                color: var(--text-sidebar);
            }
        }

        /* Modal compatibility (added for general use) */
        .modal-content {
            background-color: var(--bg-surface);
            color: var(--text-main);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-surface);
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            background: var(--bg-surface);
        }

        input,
        textarea,
        select {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="overlay"></div>

    <div class="layout">

        @include('components.sidebar')

        <div class="main">

            <header class="topbar">
                <div class="topbar-left" style="display: flex; align-items: center;">
                    <button class="mobile-toggle" id="sidebarToggle"
                        style="margin-right: 16px; padding: 8px 12px; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>@yield('header_title')</h1>
                        <p>@yield('header_subtitle')</p>
                    </div>
                </div>
                <div class="topbar-right" style="display: flex; align-items: center; gap: 12px;">
                    <div class="theme-toggle" id="themeToggleWrapper">
                        <button class="theme-toggle-btn" data-theme-val="light">
                            <i class="fas fa-sun"></i>
                            Light
                        </button>
                        <button class="theme-toggle-btn" data-theme-val="dark">
                            <i class="fas fa-moon"></i>
                            Dark
                        </button>
                    </div>
                    <button class="icon-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="profile-avatar">AB</div>
                </div>
            </header>

            @yield('content')

        </div>
    </div>

    @stack('modals')

    <script>
        // Sidebar Toggle
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('overlay');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Dark Mode Toggle Logic
        const themeBtns = document.querySelectorAll('.theme-toggle-btn');
        const htmlEl = document.documentElement;

        function setTheme(theme) {
            htmlEl.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);

            // Update UI
            themeBtns.forEach(btn => {
                if (btn.getAttribute('data-theme-val') === theme) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        // Initialize Active Button
        const currentTheme = localStorage.getItem('theme') || 'light';
        setTheme(currentTheme);

        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const theme = btn.getAttribute('data-theme-val');
                setTheme(theme);
            });
        });
    </script>
    <script>
        // SweetAlert2 Flash Messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                background: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1a1d23' : '#fff',
                color: document.documentElement.getAttribute('data-theme') === 'dark' ? '#f0f2f5' : '#242424'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                background: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1a1d23' : '#fff',
                color: document.documentElement.getAttribute('data-theme') === 'dark' ? '#f0f2f5' : '#242424'
            });
        @endif
    </script>
    @stack('scripts')

</body>

</html>
