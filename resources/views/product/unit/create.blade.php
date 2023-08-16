<x-app-layouts>
    <x-slot:header>
        <div class="page-header d-print-none">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col row g-2">
                        <h2 class="page-title">
                            Satuan Produk
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">

                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>
    <div class="card w-50">
        <div class="card-body">
            {{-- {{ $errors }} --}}
            <form action="{{ route('unit.store') }}" method="POST" class="row g-4" style="zoom: 90%" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12">
                    <label for="" class="form-label">Nama Satuan</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-lg" placeholder="contohnya Pcs, Box">
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layouts>
