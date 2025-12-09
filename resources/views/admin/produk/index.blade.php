<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Produk - POS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; margin: 0; }
        .sidebar { position: fixed; top: 0; left: 0; width: 280px; min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50, #1a2530); z-index: 1000; }
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

    <!-- SIDEBAR -->
    <div class="sidebar text-white p-3">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white mb-1 logo-text">POS ADMIN</h4>
            <small class="text-info d-block">{{ auth()->user()->name }}</small>
        </div>
        <hr class="bg-secondary">
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="bi bi-house-door"></i> <span class="text">Dashboard</span></a>
            <a class="nav-link" href="{{ url('/admin/users') }}"><i class="bi bi-people"></i> <span class="text">Manajemen User</span></a>
            <a class="nav-link active" href="{{ url('/admin/produk') }}"><i class="bi bi-box-seam"></i> <span class="text">Manajemen Produk</span></a>
            <!-- menu lain... -->
            <hr class="bg-secondary my-4">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100 p-2">
                    <i class="bi bi-box-arrow-right"></i> <span class="text">Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- KONTEN -->
    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary"><i class="bi bi-box-seam"></i> Manajemen Produk</h3>
                <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Foto</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $p)
                        <tr>
                            <td>
                                @if($p->foto)
                                    <img src="{{ asset($p->foto) }}" width="50" class="rounded">
                                @else
                                    <div class="bg-secondary rounded" style="width:50px;height:50px;"></div>
                                @endif
                            </td>
                            <td><strong>{{ $p->kode }}</strong></td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->category->nama }}</td>
                            <td>Rp {{ number_format($p->harga_jual) }}</td>
                            <td>
                                <span class="badge {{ $p->stok <= 10 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $p->stok }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.produk.destroy', $p) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">Belum ada produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>