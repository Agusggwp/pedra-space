<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User - POS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; margin: 0; }
        .sidebar { 
            position: fixed; top: 0; left: 0; width: 280px; min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50, #1a2530); z-index: 1000; 
        }
        .content { margin-left: 280px; padding: 20px; }
        .nav-link { color: #bdc3c7; border-radius: 8px; margin: 4px 15px; padding: 12px 15px; }
        .nav-link:hover, .nav-link.active { background-color: #34495e; color: white !important; }
        .nav-link i { width: 28px; text-align: center; }
        @media (max-width: 992px) {
            .sidebar { width: 80px; }
            .sidebar .text, .sidebar .logo-text { display: none; }
            .content { margin-left: 80px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR (sama persis seperti index) -->
    <div class="sidebar text-white p-3">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white mb-1 logo-text">POS ADMIN</h4>
            <small class="text-info d-block">{{ auth()->user()->name }}</small>
            <small class="text-warning">{{ ucfirst(auth()->user()->role) }}</small>
        </div>
        <hr class="bg-secondary">

        <nav class="nav flex-column">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="bi bi-house-door"></i> <span class="text">Dashboard</span></a>
            <a class="nav-link active" href="{{ url('/admin/users') }}"><i class="bi bi-people"></i> <span class="text">Manajemen User</span></a>
            <a class="nav-link" href="{{ url('/admin/produk') }}"><i class="bi bi-box-seam"></i> <span class="text">Produk</span></a>
            <a class="nav-link" href="{{ url('/admin/stok') }}"><i class="bi bi-bar-chart-line"></i> <span class="text">Stok</span></a>
            <a class="nav-link" href="{{ url('/admin/void') }}"><i class="bi bi-arrow-counterclockwise"></i> <span class="text">Void / Refund</span></a>
            <a class="nav-link" href="{{ url('/admin/laporan') }}"><i class="bi bi-graph-up-arrow"></i> <span class="text">Laporan</span></a>
            <a class="nav-link" href="{{ url('/admin/pengaturan') }}"><i class="bi bi-gear"></i> <span class="text">Pengaturan</span></a>
            <a class="nav-link" href="{{ url('/admin/backup') }}"><i class="bi bi-cloud-download"></i> <span class="text">Backup</span></a>

            <hr class="bg-secondary my-4">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100 p-2"
                        onclick="return confirm('Yakin logout?')">
                    <i class="bi bi-box-arrow-right"></i> <span class="text">Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- KONTEN EDIT USER -->
    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">

            <h3 class="text-primary mb-4">
                <i class="bi bi-pencil-square"></i> Edit User: {{ $user->name }}
            </h3>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Password Baru <small class="text-muted">(kosongkan jika tidak diganti)</small></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-lg"></i> Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>