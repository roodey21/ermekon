<x-app-layouts>
    <x-slot:header>
        <div class="navbar">
            <div class="container-fluid row align-items-center">
                <div class="col-md-8 col-xl-6">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="page-title">
                                Satuan / Baru
                            </h2>
                        </div>
                        <div class="ms-auto col-auto">
                            <div class="btn-list">
                                <a href="{{ route('unit.index') }}" class="btn btn-outline-primary">Kembali</a>
                            </div>
                        </div>
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
