<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Masuk - POS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>/* gunakan CSS sidebar yang sama seperti index */</style>
</head>
<body>
    <!-- SIDEBAR (sama persis seperti index.blade.php) -->
    <div class="sidebar text-white p-3">
        <!-- copy seluruh sidebar dari file index.blade.php -->
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
            <h3 class="text-success mb-4"><i class="bi bi-plus-circle"></i> Stok Masuk</h3>

            <form action="{{ route('admin.stok.masuk') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pilih Produk</label>
                        <select name="produk_id" class="form-select @error('produk_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}">{{ $p->kode }} - {{ $p->nama }} (Stok: {{ $p->stok }})</option>
                            @endforeach
                        </select>
                        @error('produk_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jumlah Masuk</label>
                        <input type="number" name="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan (opsional)</label>
                        <textarea name="keterangan" rows="3" class="form-control" placeholder="Contoh: Barang dari supplier X"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-check-lg"></i> Tambah Stok</button>
                    <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary btn-lg">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>