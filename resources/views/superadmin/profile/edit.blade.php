<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Superadmin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .section-header {
            margin-bottom: 30px;
        }
        
        .page-header {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title h4 {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 1.5rem;
        }
        
        .header-title p {
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .btn-light {
            background-color: #f1f2f6;
            color: var(--dark);
        }
        
        .btn-light:hover {
            background-color: #e2e6ea;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-icon-prepend {
            margin-right: 8px;
            font-size: 18px;
        }
        
        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-body {
            padding: 25px;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .alert ul {
            margin-left: 20px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .form-control.is-invalid {
            border-color: var(--danger);
        }
        
        .text-danger {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }
        
        .form-footer {
            border-top: 1px solid #eee;
            padding-top: 25px;
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 15px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-title {
                margin-bottom: 15px;
            }
            
            .form-footer {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <section class="section-header">
            <div class="page-header">
                <div class="header-title">
                    <h4 class="card-title">Edit Profil</h4>
                    <p class="card-description">Ubah nama admin atau kata sandi</p>
                </div>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-light">
                    <span class="material-icons btn-icon-prepend">arrow_back</span>
                    Kembali ke Dashboard
                </a>
            </div>
        </section>

        <section class="section-content">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form class="forms-sample" action="{{ route('superadmin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nama_admin">Nama Admin</label>
                            <input type="text" id="nama_admin" name="nama_admin" 
                                   class="form-control @error('nama_admin') is-invalid @enderror" 
                                   placeholder="Masukkan Nama Admin" 
                                   value="{{ old('nama_admin', auth()->user()->nama_admin) }}">
                            @error('nama_admin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Kata Sandi Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan Kata Sandi Baru">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Konfirmasi Kata Sandi Baru">
                        </div>
                        
                        <div class="form-footer">
                            <button type="reset" class="btn btn-light">
                                <span class="material-icons btn-icon-prepend">refresh</span>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span class="material-icons btn-icon-prepend">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>