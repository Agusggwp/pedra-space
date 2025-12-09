<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Stok - POS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>/* CSS sidebar sama */</style>
</head>
<body>
    <!-- SIDEBAR (copy dari index) -->
    <div class="sidebar text-white p-3">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white mb-1 logo-text">POS ADMIN</h4>
            <small class="text-info d-block">{{ auth()->user()->name }}</small>
        </div>
        <hr class="bg-secondary">
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="bi bi-house-door"></i> <span class="text">Dashboard</span></a>
            <a class="nav-link active" href="{{ url('/admin/stok') }}"><i class="bi bi-bar-chart-line"></i> <span class="text">Manajemen Stok</span></a>
            <hr class="bg-secondary my-4">
            <form action="{{ url('/logout') }}" method="POST">@csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100 p-2">
                    <i class="bi bi-box-arrow-right"></i> <span class="text">Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">
            <h3 class="text-info mb-4"><i class="bi bi-clock-history"></i> Riwayat Stok</h3>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $h)
                        <tr>
                            <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $h->produk->nama }}</td>
                            <td>
                                <span class="badge {{ $h->tipe == 'masuk' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $h->tipe == 'masuk' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>
                            <td><strong>{{ $h->jumlah }}</strong></td>
                            <td>{{ $h->keterangan ?: '-' }}</td>
                            <td>{{ $h->user->name }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">Belum ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $histories->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>