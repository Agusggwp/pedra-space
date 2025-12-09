<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Void / Refund - POS Admin</title>
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
        @media (max-width: 992px) { .sidebar { width: 80px; } .content { margin-left: 80px; } }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
     <div class="sidebar text-white p-3" style="width: 280px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-white">POS ADMIN</h4>
            <hr class="bg-light">
            <small class="text-info">{{ auth()->user()->name }}</small>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link " href="{{ url('/admin/dashboard') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>

            <hr class="bg-secondary">

            <a class="nav-link" href="{{ url('/admin/users') }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
            <a class="nav-link" href="{{ url('/admin/produk') }}">
                <i class="bi bi-box-seam"></i> Manajemen Produk
            </a>
            <a class="nav-link" href="{{ url('/admin/stok') }}">
                <i class="bi bi-bar-chart-line"></i> Manajemen Stok
            </a>
            <a class="nav-link active" href="{{ url('/admin/void') }}">
                <i class="bi bi-arrow-counterclockwise"></i> Void / Refund
            </a>
            <a class="nav-link" href="{{ url('/admin/laporan') }}">
                <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
            </a>
            <a class="nav-link" href="{{ url('/admin/pengaturan') }}">
                <i class="bi bi-gear"></i> Pengaturan Outlet
            </a>
            <a class="nav-link" href="{{ url('/admin/backup') }}">
                <i class="bi bi-cloud-download"></i> Backup & Restore
            </a>

            <hr class="bg-secondary">

            <!-- Logout di sidebar (POST) -->
            <form action="{{ url('/logout') }}" method="POST" class="m-2">
                @csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100"
                        onclick="return confirm('Yakin ingin keluar?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- KONTEN -->
    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">
            <h2 class="text-danger mb-4"><i class="bi bi-arrow-counterclockwise"></i> Void / Batalkan Transaksi</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $t)
                        <tr class="{{ $t->status === 'void' ? 'table-secondary' : '' }}">
                            <td><strong>#{{ $t->id }}</strong></td>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->user->name }}</td>
                            <td>Rp {{ number_format($t->total) }}</td>
                            <td>{{ $t->metode_pembayaran }}</td>
                            <td>
                                <span class="badge {{ $t->status === 'void' ? 'bg-secondary' : 'bg-success' }}">
                                    {{ $t->status === 'void' ? 'Dibatalkan' : 'Lunas' }}
                                </span>
                            </td>
                            <td>
                                @if($t->status !== 'void')
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#voidModal{{ $t->id }}">
                                        <i class="bi bi-x-circle"></i> Void
                                    </button>
                                @else
                                    <small class="text-muted">Dibatalkan oleh {{ $t->voidBy?->name ?? '-' }}</small>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Void -->
                        <div class="modal fade" id="voidModal{{ $t->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.void.proses', $t) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Konfirmasi Pembatalan Transaksi</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin ingin <strong>membatalkan</strong> transaksi ini?</p>
                                            <p>Total: <strong>Rp {{ number_format($t->total) }}</strong></p>
                                            <div class="mb-3">
                                                <label class="form-label">Alasan Void <span class="text-danger">(wajib)</span></label>
                                                <textarea name="keterangan" class="form-control" rows="3" required
                                                          placeholder="Contoh: Customer batal, salah input, barang rusak, dll"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Ya, Batalkan Transaksi!</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>