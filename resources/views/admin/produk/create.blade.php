<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Produk - POS Admin</title>
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

    <!-- SIDEBAR (sama persis) -->
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
            <!-- menu lain tetap sama -->
            <hr class="bg-secondary my-4">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-danger bg-transparent border-0 text-start w-100 p-2">
                    <i class="bi bi-box-arrow-right"></i> <span class="text">Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- KONTEN TAMBAH PRODUK -->
    <div class="content">
        <div class="bg-white rounded shadow p-4 p-md-5">
            <h3 class="text-primary mb-4"><i class="bi bi-plus-circle"></i> Tambah Produk Baru</h3>

            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kode Produk</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                               value="{{ old('kode') }}" placeholder="CTK001" required>
                        @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
                               value="{{ old('harga_beli') }}" required>
                        @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
                               value="{{ old('harga_jual') }}" required>
                        @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Stok Awal</label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                               value="{{ old('stok', 0) }}" required>
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Foto Produk <small class="text-muted">(opsional)</small></label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                               accept="image/*">
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-lg"></i> Simpan Produk
                    </button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>