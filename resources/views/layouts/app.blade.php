<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CatCare')</title>

    <style>
        :root {
            --blue: #72c8ed;
            --blue-hover: #4bb5e3;
            --blue-dark: #368fb9;
            --blue-sidebar: #eaf8ff;
            --blue-panel: #eaf8ff;
            --blue-light: #eaf8ff;
            --blue-soft: #f5fbff;
            --background: #f5fbff;
            --text: #304858;
            --muted: #8195a2;
            --border: #dcecf4;
            --white: #ffffff;
            --success: #23845f;
            --success-bg: #e5f8ef;
            --danger: #b9404e;
            --danger-bg: #fff0f1;
            --shadow: 0 4px 14px rgba(45, 115, 150, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: var(--background);
        }

        a {
            color: var(--blue-dark);
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        /* LOGIN DAN REGISTER */

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #eaf8ff 0%, #f5fbff 55%, #eaf8ff 100%);
        }

        .auth-card {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            align-items: center;
            width: 100%;
            max-width: 800px;
            height: auto;
            overflow: hidden;
            background: var(--blue-panel);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .auth-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            align-self: stretch;
            min-width: 0;
            min-height: 0;
            padding: 30px 16px 0;
            overflow: hidden;
            text-align: center;
            background: var(--blue-panel);
        }

        .brand-logo {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 12px;
            color: var(--blue-dark);
            font-size: 31px;
            font-weight: 750;
        }

        .brand-logo img {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            object-fit: contain;
        }

        .auth-brand p {
            max-width: 230px;
            margin: 0;
            flex-shrink: 0;
            color: #527b91;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.6;
        }

        .cat-illustration {
            display: flex;
            flex: 1;
            align-items: flex-end;
            justify-content: center;
            width: calc(100% + 32px);
            min-height: 0;
            margin: 8px -16px 0;
            overflow: hidden;
        }

        .cat-illustration img {
            display: block;
            width: 88%;
            height: 88%;
            min-height: 0;
            object-fit: contain;
            object-position: center bottom;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-self: center;
            width: calc(100% - 40px);
            height: auto;
            min-width: 0;
            min-height: 0;
            margin: 16px 20px;
            padding: 24px 26px;
            background: var(--white);
            border: 1px solid #edf5fa;
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(68, 166, 211, 0.10);
        }

        .auth-form h1 {
            margin: 0 0 12px;
            color: var(--blue-dark);
            font-size: 15px;
            font-weight: 700;
            line-height: 1.5;
        }

        .auth-subtitle {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #415b6b;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
        }

        .form-control {
            display: block;
            width: 100%;
            min-width: 0;
            height: 42px;
            padding: 9px 12px;
            outline: none;
            border: 1px solid var(--border);
            border-radius: 7px;
            color: var(--text);
            background: #fbfdff;
            font-size: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(114, 200, 237, 0.18);
        }

        .form-control::placeholder {
            color: #a4b4be;
        }

        textarea.form-control {
            height: auto;
            min-height: 75px;
            resize: vertical;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 42px;
            margin-top: 8px;
            padding: 9px 12px;
            border: none;
            border-radius: 7px;
            color: var(--white);
            background: var(--blue);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .btn:hover {
            background: var(--blue-hover);
        }

        .btn:active {
            transform: scale(0.99);
        }

        .auth-switch {
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
            text-align: center;
        }

        .auth-switch a {
            color: var(--blue-hover);
            font-weight: 700;
            cursor: pointer;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        /* NOTIFIKASI */

        .alert {
            margin-bottom: 12px;
            padding: 9px 11px;
            overflow-wrap: anywhere;
            border-radius: 7px;
            font-size: 12px;
            line-height: 1.5;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-bg);
            border: 1px solid #c8eedc;
        }

        .alert-danger {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid #ffd5d9;
        }

        .alert ul {
            margin: 4px 0 0;
            padding-left: 16px;
        }

        /* LOGIN */

        .auth-card:has(> .auth-form:not(.register-form)) {
            min-height: 0;
            height: auto;
            align-items: center;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form {
            width: calc(100% - 16px);
            min-height: 0;
            height: auto;
            margin: 16px 16px 16px 0;
            padding: 30px;
            justify-content: center;
            transform: translateX(-8px);
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form h1 {
            margin-bottom: 25px;
            font-size: 15px;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form > form {
            width: 100%;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .form-group {
            margin-bottom: 22px;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .form-group label {
            margin-bottom: 9px;
            font-size: 12px;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .form-control {
            height: 42px;
            padding: 10px 12px;
            font-size: 12px;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .btn {
            min-height: 42px;
            margin-top: 12px;
            font-size: 12px;
        }

        .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .auth-switch {
            margin-top: 25px;
            font-size: 12px;
        }

        /* REGISTER */

        .auth-card:has(.register-form) {
            min-height: 0;
            height: auto;
            align-items: center;
        }

        .auth-form.register-form {
            min-height: 0;
            height: auto;
            margin: 16px 20px 16px 12px;
            padding: 22px 26px;
            transform: translateX(-8px);
        }

        .auth-form.register-form h1 {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .auth-form.register-form .auth-subtitle {
            margin-bottom: 14px;
        }

        .auth-form.register-form .form-group {
            margin-bottom: 13px;
        }

        .auth-form.register-form .form-group label {
            margin-bottom: 5px;
            font-size: 12px;
        }

        .auth-form.register-form .form-control {
            height: 36px;
            font-size: 12px;
        }

        .auth-form.register-form .btn {
            min-height: 36px;
            margin-top: 7px;
            font-size: 12px;
        }

        .auth-form.register-form .auth-switch {
            margin-top: 14px;
            font-size: 12px;
        }

        /* DASHBOARD */

        .app-shell {
            display: flex;
            min-height: 100vh;
            background: var(--background);
        }

        .main-area {
            flex: 1;
            min-width: 0;
            background: var(--background);
        }

        /* SIDEBAR */

        .sidebar {
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            width: 250px;
            min-width: 250px;
            height: 100vh;
            padding: 22px 16px 18px;
            overflow-y: auto;
            background: #eaf8ff;
            border-right: 1px solid var(--border);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 10px;
            margin-bottom: 28px;
            color: #368fb9;
            font-size: 25px;
            font-weight: 800;
            text-decoration: none;
        }

        .sidebar-brand img {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            object-fit: contain;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 43px;
            padding: 11px 14px;
            border-radius: 9px;
            color: #527b91;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
        }

        .nav-link:hover {
            color: #368fb9;
            background: #dff4ff;
        }

        .nav-link.active {
            color: #ffffff;
            background: #72c8ed;
            font-weight: 700;
        }

        /* LOGOUT */

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 24px;
        }

        .sidebar-bottom form {
            width: 100%;
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: #368fb9;
            background: var(--white);
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }

        .logout-button:hover {
            background: #f5fbff;
            border-color: #bce8fa;
        }

        /* HEADER DASHBOARD */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            min-height: 65px;
            padding: 10px 24px;
            background: #eaf8ff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-title h1 {
            margin: 0;
            color: #368fb9;
            font-size: 19px;
            font-weight: 800;
        }

        /* PROFIL PADA HEADER */

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 280px;
            padding: 7px 11px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            background: var(--white);
            text-decoration: none;
            transition: background 0.2s;
        }

        .topbar-profile:hover {
            color: var(--text);
            background: #f5fbff;
        }

        .profile-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 50%;
            color: #368fb9;
            background: #dff4ff;
            font-size: 19px;
            font-weight: 700;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .profile-info strong {
            max-width: 170px;
            overflow: hidden;
            color: var(--text);
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-info small {
            color: var(--muted);
            font-size: 10px;
        }

        /* KONTEN */

        .page-content {
            width: 100%;
            max-width: 1600px;
            padding: 20px 26px 30px;
            margin: 0 auto;
        }

        /* BANNER SAMBUTAN DASHBOARD */

        .welcome-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            min-height: 125px;
            padding: 20px 25px;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            background: linear-gradient(115deg, #eaf8ff, #dff4ff);
        }

        .welcome-label {
            display: inline-block;
            margin-bottom: 7px;
            color: #368fb9;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .welcome-banner h2 {
            margin: 0 0 6px;
            color: var(--text);
            font-size: 20px;
            font-weight: 800;
            line-height: 1.4;
        }

        .welcome-banner p {
            margin: 0;
            color: #527b91;
            font-size: 12px;
            line-height: 1.6;
        }

        /* STATISTIK DASHBOARD */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card {
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--white);
            box-shadow: var(--shadow);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(45, 115, 150, 0.10);
        }

        .stat-top {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 14px;
        }

        .stat-label {
            color: #637b8a;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.5;
        }

        .stat-number {
            display: block;
            margin-bottom: 5px;
            color: var(--text);
            font-size: 25px;
            font-weight: 800;
        }

        .stat-card > small {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        /* BANNER KUCING CATCARE */

        .catcare-banner {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-top: 24px;
            padding: 20px 28px;
            min-height: 220px;
            background: #e4f1ff;
            border: 1px solid #d1e6ff;
            border-radius: 16px;
            overflow: hidden;
        }

        .catcare-banner-image {
            flex: 0 0 240px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .catcare-banner-image img {
            display: block;
            width: 100%;
            max-width: 240px;
            height: 190px;
            object-fit: contain;
        }

        .catcare-banner-text {
            flex: 1;
            min-width: 0;
        }

        .catcare-banner-text h2 {
            margin: 0 0 10px;
            color: #246bb2;
            font-size: 29px;
            font-weight: 700;
            line-height: 1.3;
        }

        .catcare-banner-text p {
            margin: 0;
            color: #246bb2;
            font-size: 14px;
            line-height: 1.7;
        }

        /* AKTIVITAS TERBARU */

        .activity-section {
            margin-top: 22px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .activity-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 17px 20px;
            border-bottom: 1px solid var(--border);
        }

        .activity-header h2 {
            margin: 0 0 5px;
            color: var(--text);
            font-size: 15px;
            font-weight: 800;
        }

        .activity-header p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .activity-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .activity-table th {
            padding: 12px 18px;
            color: #527b91;
            background: #eaf8ff;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .activity-table td {
            padding: 14px 18px;
            border-top: 1px solid var(--border);
            color: var(--text);
            font-size: 12px;
        }

        .empty-activity {
            padding: 25px 16px !important;
            color: var(--muted) !important;
            text-align: center;
        }

        .empty-activity strong {
            display: block;
            margin-bottom: 7px;
            color: var(--text);
            font-size: 13px;
        }

        .empty-activity p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        /* PROFIL PENGGUNA */

        .page-content:has(.profile-edit-card) {
            width: 100%;
            max-width: none;
            padding: 14px 26px 18px;
            margin: 0;
        }

        .page-content:has(.profile-edit-card) .profile-edit-card {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 20px 28px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .profile-edit-card h2 {
            margin: 0 0 5px;
            color: var(--blue-dark);
            font-size: 18px;
            font-weight: 800;
        }

        .profile-description {
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .profile-form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 11px;
        }

        .profile-form-group label {
            color: #415b6b;
            font-size: 12px;
            font-weight: 700;
        }

        .profile-form-group label span {
            color: var(--muted);
            font-size: 11px;
            font-weight: 400;
        }

        .profile-form-group input {
            display: block;
            width: 100%;
            height: 38px;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 7px;
            outline: none;
            color: var(--text);
            background: #fbfdff;
            font-size: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .profile-form-group input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(114, 200, 237, 0.15);
        }

        .profile-form-group input::placeholder {
            color: #a4b4be;
            font-size: 11px;
        }

        .profile-form-group small {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.4;
        }

        .profile-form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .profile-save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 170px;
            min-height: 39px;
            padding: 9px 22px;
            border: none;
            border-radius: 7px;
            color: var(--white);
            background: var(--blue);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .profile-save-button:hover {
            background: var(--blue-hover);
        }

        .profile-save-button:active {
            transform: scale(0.99);
        }

        .page-content:has(.profile-edit-card) .alert-success,
        .page-content:has(.profile-edit-card) .alert-error {
            margin: 0 0 10px;
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 12px;
            line-height: 1.4;
        }

        .page-content:has(.profile-edit-card) .alert-error ul {
            margin: 0;
            padding-left: 18px;
        }

        /* LAPTOP DENGAN TINGGI LAYAR TERBATAS */

        @media (min-width: 769px) and (max-height: 850px) {
            .topbar {
                min-height: 58px;
                padding-top: 8px;
                padding-bottom: 8px;
            }

            .page-content:has(.profile-edit-card) {
                padding-top: 10px;
                padding-bottom: 12px;
            }

            .page-content:has(.profile-edit-card) .profile-edit-card {
                padding: 16px 24px;
            }

            .page-content:has(.profile-edit-card) .profile-avatar {
                width: 54px !important;
                height: 54px !important;
                font-size: 23px !important;
            }

            .profile-form-group {
                gap: 4px;
                margin-bottom: 9px;
            }

            .profile-form-group input {
                height: 35px;
                padding-top: 7px;
                padding-bottom: 7px;
            }

            .profile-form-actions {
                margin-top: 12px;
            }

            .profile-save-button {
                min-height: 36px;
            }
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 1200px) {
            .sidebar {
                width: 225px;
                min-width: 225px;
            }

            .page-content {
                padding-right: 20px;
                padding-left: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .page-content:has(.profile-edit-card) {
                padding-right: 20px;
                padding-left: 20px;
            }
        }

        /* RESPONSIVE MOBILE */

        @media (max-width: 768px) {
            .app-shell {
                flex-direction: column;
            }

            .sidebar {
                position: static;
                width: 100%;
                min-width: 0;
                height: auto;
                padding: 16px 14px;
                overflow: visible;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .sidebar-brand {
                margin-bottom: 18px;
                font-size: 23px;
            }

            .sidebar-brand img {
                width: 35px;
                height: 35px;
            }

            .nav-menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 7px;
            }

            .nav-link {
                gap: 9px;
                padding: 10px;
                font-size: 12px;
            }

            .sidebar-bottom {
                margin-top: 15px;
                padding-top: 0;
            }

            .topbar {
                min-height: 60px;
                padding: 10px 16px;
            }

            .topbar-title h1 {
                font-size: 17px;
            }

            .topbar-profile {
                gap: 8px;
                padding: 6px 8px;
            }

            .profile-avatar {
                width: 32px;
                height: 32px;
                font-size: 17px;
            }

            .profile-info strong {
                max-width: 130px;
            }

            .page-content {
                padding: 17px 14px 25px;
            }

            .welcome-banner {
                min-height: 115px;
                padding: 17px;
            }

            .welcome-banner h2 {
                font-size: 18px;
            }

            .welcome-banner p {
                font-size: 11px;
            }

            .stats-grid {
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
            }

            .catcare-banner {
                flex-direction: column;
                gap: 12px;
                padding: 20px;
                text-align: center;
            }

            .catcare-banner-image {
                flex-basis: auto;
            }

            .catcare-banner-image img {
                height: 160px;
                max-width: 220px;
            }

            .catcare-banner-text h2 {
                font-size: 23px;
            }

            .activity-header {
                padding: 15px 16px;
            }

            .activity-table th,
            .activity-table td {
                padding-right: 13px;
                padding-left: 13px;
            }

            /* LOGIN DAN REGISTER MOBILE */

            .auth-page {
                min-height: 100vh;
                padding: 16px 12px;
            }

            .auth-card,
            .auth-card:has(.register-form) {
                grid-template-columns: 1fr;
                width: 100%;
                max-width: 420px;
                min-height: 0;
                height: auto;
            }

            .auth-brand {
                min-height: 0;
                padding: 22px 16px 0;
                border-radius: 16px 16px 0 0;
            }

            .brand-logo {
                gap: 10px;
                font-size: 28px;
            }

            .brand-logo img {
                width: 46px;
                height: 46px;
            }

            .auth-brand p {
                max-width: 280px;
            }

            .cat-illustration {
                flex: none;
                height: 100px;
                width: calc(100% + 32px);
                margin: 7px -16px 0;
            }

            .cat-illustration img {
                width: 84%;
                height: 84%;
            }

            .auth-form,
            .auth-form.register-form {
                width: calc(100% - 20px);
                min-height: 0;
                height: auto;
                max-height: none;
                margin: 5px 10px 10px;
                padding: 22px;
                overflow: visible;
                transform: none;
            }

            .auth-card:has(> .auth-form:not(.register-form)) {
                min-height: 0;
                height: auto;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form {
                width: calc(100% - 20px);
                min-height: 0;
                height: auto;
                margin: 5px 10px 10px;
                padding: 27px 22px;
                transform: none;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form h1 {
                margin-bottom: 22px;
                font-size: 15px;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .form-group {
                margin-bottom: 19px;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .form-control {
                height: 40px;
                font-size: 12px;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .btn {
                min-height: 40px;
                margin-top: 9px;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form .auth-switch {
                margin-top: 22px;
            }

            .auth-form.register-form .auth-subtitle {
                margin-bottom: 15px;
            }

            .auth-form.register-form .form-group {
                margin-bottom: 14px;
            }

            .auth-form.register-form .form-control {
                height: 37px;
            }

            .auth-form.register-form .auth-switch {
                margin-top: 15px;
            }

            /* PROFIL MOBILE */

            .page-content:has(.profile-edit-card) {
                padding: 12px 14px 20px;
            }

            .page-content:has(.profile-edit-card) .profile-edit-card {
                padding: 20px 16px;
            }

            .profile-form-group {
                margin-bottom: 14px;
            }

            .profile-form-actions {
                margin-top: 16px;
            }

            .profile-save-button {
                width: 100%;
            }
        }

        /* MOBILE KECIL */

        @media (max-width: 480px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .topbar-profile {
                width: 100%;
            }

            .profile-info {
                flex: 1;
            }

            .profile-info strong {
                max-width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .welcome-banner h2 {
                font-size: 17px;
            }

            .activity-header h2 {
                font-size: 14px;
            }

            .page-content:has(.profile-edit-card) .profile-edit-card {
                padding: 16px 13px;
            }
        }

        @media (max-width: 380px) {
            .auth-page {
                padding: 12px 8px;
            }

            .auth-brand {
                padding: 19px 13px 0;
            }

            .brand-logo {
                font-size: 26px;
            }

            .brand-logo img {
                width: 42px;
                height: 42px;
            }

            .cat-illustration {
                height: 90px;
            }

            .cat-illustration img {
                width: 82%;
                height: 82%;
            }

            .auth-form,
            .auth-form.register-form {
                padding: 19px 16px;
            }

            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form {
                padding: 24px 18px;
            }
        }

        @media (min-width: 701px) and (max-height: 520px) {
            .auth-page {
                padding: 8px 16px;
            }

            .auth-card,
            .auth-card:has(.register-form),
            .auth-card:has(> .auth-form:not(.register-form)) {
                min-height: 0;
                height: auto;
            }

            .auth-form,
            .auth-form.register-form,
            .auth-card:has(> .auth-form:not(.register-form)) > .auth-form {
                min-height: 0;
                height: auto;
            }

            .auth-brand {
                padding-top: 20px;
            }

            .brand-logo {
                margin-bottom: 7px;
                font-size: 27px;
            }

            .brand-logo img {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
