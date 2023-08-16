<x-app-layouts>
    <x-slot:header>
        <div class="page-header d-print-none">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col row g-2">
                        <h2 class="page-title">
                            Varian Produk / Edit
                        </h2>
                        {{-- <div class="btn-list">
                            <span class="d-none d-sm-inline">
                                <a href="#" class="btn text-uppercase">
                                    Baru
                                </a>
                            </span>
                            <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                    <path d="M7 11l5 5l5 -5"></path>
                                    <path d="M12 4l0 12"></path>
                                </svg>
                            </a>
                        </div> --}}
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <!-- save button -->
                        {{-- <button class="btn btn-primary">
                            Simpan
                        </button> --}}
                        {{-- <form action="./" method="get" autocomplete="off" novalidate="">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>
    <div class="card w-50">
        <div class="card-body">
            {{-- {{ $errors }} --}}
            <form action="{{ route('product.store') }}" method="POST" class="row g-4" style="zoom: 90%" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12">
                    <label for="" class="form-label">Nama Produk</label>
                    <input name="name" value="{{ old('name',$product->name) }}" type="text" class="form-control form-control-lg" placeholder="contohnya Cheese Burger">
                </div>
                <div class="col-6">
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Tipe Produk</label>
                        <div class="col">
                            <select name="product_type" id="" class="form-select">
                                <option value="barang">Barang</option>
                                <option value="jasa">Jasa</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Quantity</label>
                        <div class="col">
                            <input name="quantity" value="{{ old('quantity',$product->quantity) }}" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Harga Beli</label>
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">
                                    Rp
                                </span>
                                <input name="buy_price" value="{{ old('buy_price',$product->buy_price) }}" type="number" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label">&nbsp</label>
                        <div class="col">
                            {{-- <select name="product_type" id="" class="form-select">
                                <option value="barang">Barang</option>
                                <option value="jasa">Jasa</option>
                            </select> --}}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Satuan</label>
                        <div class="col">
                            <select name="unit" type="text" class="form-select">
                                <option value="pcs" {{ $product->unit == 'pcs' ? 'selected':'' }}>Pcs</option>
                                <option value="mm" {{ $product->unit == 'mm' ? 'selected':'' }}>mm</option>
                                <option value="in" {{ $product->unit == 'in' ? 'selected':'' }}>in</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Pemasok</label>
                        <div class="col">
                            <input name="supplier" value="{{ $product->supplier }}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layouts>
