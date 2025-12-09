<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - POS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; margin: 0; font-family: 'Segoe UI', sans-serif; }
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

    <!-- SIDEBAR (sama persis seperti sebelumnya) -->
    <div class="sidebar text-white p-3">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white mb-1 logo-text">POS ADMIN</h4>
            <small class="text-info d-block">{{ auth()->user()->name }}</small>
            <small class="text-warning">{{ ucfirst(auth()->user()->role) }}</small>
        </div>
        <hr class="bg-secondary">

        <nav class="nav flex-column">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                <i class="bi bi-house-door"></i> <span class="text">Dashboard</span>
            </a>
            <a class="nav-link active bg-primary" href="{{ url('/admin/users') }}">
                <i class="bi bi-people"></i> <span class="text">Manajemen User</span>
            </a>
            <a class="nav-link" href="{{ url('/admin/produk') }}">
                <i class="bi bi-box-seam"></i> <span class="text">Produk</span>
            </a>
            <!-- menu lain tetap sama -->
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

    <!-- KONTEN UTAMA -->
    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary">
                    <i class="bi bi-people"></i> Manajemen User
                </h3>
                <a href="{{ url('/admin/users/create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah User
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-success">Kasir</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/users/'.$user->id.'/edit') }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ url('/admin/users/'.$user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus {{ $user->name }}?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>