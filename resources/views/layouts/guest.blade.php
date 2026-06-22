<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'e-LACT Telkom')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #E3000F;
            --primary-dark: #c4000d;
            --radius: 12px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .auth-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 1.5rem;
            text-align: center;
        }
        
        .auth-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .auth-header p {
            margin: 0.25rem 0 0;
            opacity: 0.9;
            font-size: 0.875rem;
        }
        
        .auth-body {
            padding: 1.5rem;
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
        
        .form-control-soft {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            transition: var(--transition);
            background: #fff;
            color: #1f2937;
        }
        
        .form-control-soft:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(227, 0, 15, 0.1);
        }
        
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
            width: 100%;
            justify-content: center;
        }
        
        .btn-primary-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(227, 0, 15, 0.3);
            color: #fff;
        }
        
        .form-error {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h2>e-LACT Telkom</h2>
            <p>@yield('title')</p>
        </div>
        <div class="auth-body">
            @yield('content')
        </div>
    </div>
</body>
</html>
