<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'e-LACT Telkom')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #E3000F;
            --primary-dark: #b71c1c;
            --primary-light: #ff4d4d;
            --sidebar-width: 260px;
            --bg-main: #f8f9fa;
            --card-bg: #ffffff;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-main);
            color: #1f2937;
            line-height: 1.6;
        }

        /* Sidebar Modern */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            box-shadow: 2px 0 6px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }

        .sidebar-brand h4 {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .sidebar-brand small {
            color: #6b7280;
            font-size: 0.75rem;
            letter-spacing: 0.03em;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-nav .nav-section {
            padding: 0.75rem 1.25rem 0.25rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #9ca3af;
            font-weight: 600;
        }

        .sidebar-nav .nav-item { padding: 0 0.75rem; }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: var(--radius-sm);
            margin: 0.15rem 0;
            transition: var(--transition);
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
        }

        .sidebar-nav .nav-link:hover {
            color: #111827;
            background: #f9fafb;
            transform: none;
        }

        .sidebar-nav .nav-link.active {
            color: var(--primary);
            background: #fee2e2;
            box-shadow: none;
        }

        .sidebar-nav .nav-link.active i { color: var(--primary); }

        .sidebar-nav .nav-link i { color: currentColor; }

        .sidebar-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #e5e7eb;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 0;
            min-height: 100vh;
            transition: var(--transition);
        }

        .has-sidebar .main-wrapper {
            margin-left: var(--sidebar-width);
        }

        .top-header {
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-header .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(227, 0, 15, 0.25);
        }

        .user-badge .user-name {
            font-weight: 500;
        }

        .content-area {
            padding: 2rem;
        }

        /* Cards Modern */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header-custom {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-custom h5,
        .card-header-custom h6 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Stats Card Modern Alias */
        .stat-card-modern {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Buttons Modern */
        .btn {
            border-radius: var(--radius-sm);
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: var(--transition);
            border: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: 0 2px 8px rgba(227, 0, 15, 0.25);
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(227, 0, 15, 0.35);
            color: #fff;
        }

        .btn-secondary-custom {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary-custom:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid transparent;
        }

        .btn-ghost:hover {
            background: rgba(227, 0, 15, 0.05);
            color: var(--primary);
            border-color: rgba(227, 0, 15, 0.2);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Tables Modern - Alias */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background: #f9fafb;
            padding: 0.875rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .table-modern tbody td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: var(--transition);
        }

        .table-modern tbody tr:hover {
            background: #f9fafb;
        }

        /* Forms Modern - Aliases */
        .form-control-soft,
        .form-select-soft {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            transition: var(--transition);
            background: #fff;
            color: #1f2937;
        }

        .form-control-soft:focus,
        .form-select-soft:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(227, 0, 15, 0.1);
        }

        .form-label-soft {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }

        /* Badges Modern */
        .badge-modern {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

.badge-info {
             background: #dbeafe;
             color: #1e40af;
         }

         .badge-warning {
             background: #fef3c7;
             color: #92400e;
         }

         /* View/Edit/Generate/Download action button variants */
         .btn-view { background: #eff6ff; color: #3b82f6; }
         .btn-view:hover { background: #dbeafe; }
         .btn-edit { background: #fef3c7; color: #d97706; }
         .btn-edit:hover { background: #fde68a; }
         .btn-generate { background: #dcfce7; color: #166534; }
         .btn-generate:hover { background: #bbf7d0; }
         .btn-download { background: #fef2f2; color: #dc2626; }
         .btn-download:hover { background: #fee2e2; }
         .btn-delete { background: #fee2e2; color: #dc2626; }
         .btn-delete:hover { background: #fecaca; }

         /* Monospace input */
         .input-mono {
             font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
         }

        .badge-modern .badge-secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        .badge-primary {
            background: #fee2e2;
            color: var(--primary-dark);
        }

        /* Buttons - Additional aliases */
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(227, 0, 15, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(227, 0, 15, 0.3);
            color: #fff;
        }

        .btn-soft-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: var(--radius-sm);
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-soft-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
            color: #374151;
            text-decoration: none;
        }

        .btn-danger-sm {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-danger-sm:hover {
            background: #fecaca;
        }

        .badge-modern-sm {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        /* Detail Card Styles */
        .detail-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .detail-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: #fafafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-card-header h5,
        .detail-card-header h6 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .card-surface {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Editor Styles */
        .step-content { display: none; }
        .step-content.active { display: block; }

        .step-sidebar-inner { padding: 1rem; }

        /* Action Icon Buttons */
        .action-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            transition: var(--transition);
            cursor: pointer;
        }

        .action-icon-btn:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        .action-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Photo Grid Styles */
        .photo-grid-modern {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
        }

        .photo-tile-modern {
            position: relative;
            aspect-ratio: 1;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: #f9fafb;
        }

        .photo-tile-modern img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay-modern {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            padding: 0.25rem;
            opacity: 0;
            transition: var(--transition);
        }

        .photo-tile-modern:hover .photo-overlay-modern {
            opacity: 1;
        }

        .photo-label-input {
            width: 100%;
            font-size: 0.7rem;
            border: none;
            background: transparent;
            color: #fff;
        }

        .photo-remove-btn {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: none;
            background: rgba(220, 38, 38, 0.9);
            color: #fff;
            font-size: 0.75rem;
            cursor: pointer;
        }

        /* Editor Header */
        .editor-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .editor-header-left h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .step-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Step Sidebar Styles */
        .step-list-modern {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .step-item-modern {
            margin-bottom: 0.5rem;
        }

        .step-btn-modern {
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.7);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .step-btn-modern:hover,
        .step-btn-modern.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .step-btn-modern.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .step-number-modern {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-right: 0.5rem;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1rem 0;
        }

        /* Pagination - Alias */
        .pagination-soft {
            margin-top: 1.5rem;
        }

        .pagination-soft .page-link {
            border: none;
            background: transparent;
            color: var(--text-muted);
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .pagination-soft .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(227, 0, 15, 0.25);
        }

        .pagination-soft .page-link:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        /* Page Header */
        .page-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-header-modern h2 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        /* Filter Card */
        .filter-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .filter-card .card-body {
            padding: 1.25rem 1.5rem;
        }

        /* Data Table Wrapper */
        .data-table-wrapper {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .data-table-wrapper .table-responsive {
            padding: 0 1.5rem 1.5rem;
        }

        /* Detail Header */
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .detail-header h2 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        /* Info Table */
        .info-table {
            width: 100%;
        }

        .info-table th {
            width: 150px;
            font-weight: 600;
            color: #6b7280;
            padding: 0.5rem 0;
            vertical-align: top;
        }

        .info-table td {
            padding: 0.5rem 0;
            color: #1f2937;
        }

        .info-table tr {
            border-bottom: 1px solid var(--border-color);
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        /* Info Row (for show pages) */
        .info-row {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .info-item {
            flex: 1;
            min-width: 150px;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1f2937;
            font-weight: 500;
        }

        /* Avatar Styles */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-circle i {
            font-size: 1.25rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 3rem;
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Section Divider */
        .section-divider {
            height: 1px;
            background: var(--border-color);
            margin: 2rem 0 1.5rem;
        }

        /* Section Title & Subtitle */
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        /* Nav Tabs Modern */
        .nav-tabs-modern {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .nav-tabs-modern .nav-link {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            color: var(--text-muted);
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .nav-tabs-modern .nav-link.active,
        .nav-tabs-modern .nav-link:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .tab-content-modern {
            margin-top: 1rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.875rem;
        }

        /* Sub-stat cards (for projects/show) */
        .sub-card-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .sub-stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow);
        }

        .sub-header h6 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
        }

        .sub-stat-count {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        /* Alert Modern */
        .alert-custom {
            border: none;
            border-radius: var(--radius-sm);
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success-custom {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error-custom {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--primary);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Pagination Modern */
        .pagination-custom {
            gap: 0.25rem;
        }

        .pagination-custom .page-link {
            border: none;
            background: transparent;
            color: var(--text-muted);
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(227, 0, 15, 0.25);
        }

        .pagination-custom .page-link:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .has-sidebar .sidebar {
                transform: translateX(-100%);
            }
            .has-sidebar .main-wrapper {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body @if(Auth::check()) class="has-sidebar" @endif>
    @if(Auth::check())
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <h4>e-LACT</h4>
            <small>Telkom Indonesia</small>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('lokasi.*') ? 'active' : '' }}" href="{{ route('lokasi.index') }}">
                    <i class="bi bi-geo-alt"></i> Lokasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('waspang.*') ? 'active' : '' }}" href="{{ route('waspang.index') }}">
                    <i class="bi bi-people"></i> Personel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('branch.*') ? 'active' : '' }}" href="{{ route('branch.index') }}">
                    <i class="bi bi-diagram-3"></i> Branch
                </a>
            </li>
            @if(Auth::user()?->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear"></i> Manajemen User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear"></i> Logo Perusahaan
                </a>
            </li>
            @endif
        </ul>

        <div class="sidebar-footer">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
               href="{{ route('profile.edit') }}"
               style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem 0.75rem;border-radius:8px;text-decoration:none;margin-bottom:4px;">
                <i class="bi bi-person-circle" style="font-size:1.1rem;flex-shrink:0;"></i>
                <div style="flex:1;min-width:0;overflow:hidden;">
                    <p style="margin:0;font-size:0.83rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</p>
                    <p style="margin:0;font-size:0.71rem;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</p>
                </div>
            </a>
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem 0.75rem;border-radius:8px;text-decoration:none;">
                <i class="bi bi-box-arrow-right" style="font-size:1rem;"></i>
                <span style="font-size:0.875rem;font-weight:500;">Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <div class="main-wrapper">
        @if(Auth::check())
        <header class="top-header">
            <p style="font-size:0.85rem;color:#9ca3af;margin:0;">Sistem Manajemen Dokumen LACT</p>
            <div class="d-flex align-items-center gap-2">
                <span class="user-badge" style="font-size:0.75rem;padding:0.3rem 0.7rem;">
                    <i class="bi bi-shield-check"></i>
                    <span>{{ ucfirst(Auth::user()->role) }}</span>
                </span>
                <span style="font-size:0.85rem;color:#4b5563;font-weight:500;">{{ Auth::user()->name }}</span>
            </div>
        </header>
        @endif

        <main class="content-area">
            @if(session('success'))
                <div class="alert-custom alert-success-custom">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-custom alert-error-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
