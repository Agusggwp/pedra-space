<!DOCTYPE html>
<html><head><title>Buka Kasir</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-primary text-white">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white">
                <div class="card-header text-center"><h3>Buka Kasir</h3></div>
                <div class="card-body">
                    <form action="{{ route('kasir.buka') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Saldo Awal Cash Drawer</label>
                            <input type="number" name="saldo_awal" class="form-control form-control-lg text-end" 
                                   value="0" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">BUKA KASIR SEKARANG</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body></html>