<x-app-layouts>
    <x-slot:header>
        <div class="page-header d-print-none">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col row g-2">
                        <h2 class="page-title">
                            Varian Produk / Baru
                        </h2>
                        {{-- <div class="btn-list">
                            <span class="d-none d-sm-inline">
                                <a href="#" class="btn text-uppercase">
                                    Baru
                                </a>
                            </span>
                            <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-report" aria-label="Create new report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Search…"
                                    aria-label="Search in website">
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>
    @push('scripts')
    <script src="{{ asset('libs/tom-select/dist/js/tom-select.base.min.js?1684106062') }}" defer></script>
    @endpush
    <div class="card w-50">
        <div class="card-body">
            {{ $errors }}
            <form action="{{ route('product.store') }}" method="POST" class="row g-4"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12">
                    <label for="" class="form-label">Nama Produk</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-lg"
                        placeholder="contohnya Cheese Burger">
                </div>
                <div class="col-6">
                    <div class="mb-3 row">
                        <label for="" class="col-4 col-form-label required">Tipe Produk</label>
                        <div class="col">
                            <select name="category_id" id="" class="form-select">
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}" class="text-capitalize">{{ $category->name }}
                                </option>
                                @empty
                                <option value="">Tidak ada kategori, <a href="">tambah kategori baru</a></option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-4 col-form-label required">Satuan</label>
                        <div class="col" id="list-unit">
                            <select name="unit_id" id="select-units" class="form-select mb-3">
                                {{-- <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option> --}}
                                {{-- @forelse ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @empty
                                <option value="">Belum ada satuan, tambahkan baru</option>
                                @endforelse --}}
                            </select>
                            {{-- <div class="row mb-3" id="conversion-unit-1">
                                <div class="col">
                                    <div class="input-group">
                                        <input name="unit_name" type="text" class="form-control">
                                        <span class="input-group-text">
                                            =
                                        </span>
                                        <input name="buy_price" type="number" class="form-control">
                                        <span class="input-group-text">
                                            Pcs
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                            @push('scripts')
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    var el;
                                    window.TomSelect && (mainSelect = new TomSelect(el = document.getElementById('select-units'), {
                                        valueField: 'id',
                                        labelField: 'name',
                                        searchField: 'name',
                                        load: function(query, callback) {
                                            var url = '{{ route('unit.getData') }}';
                                            fetch(url)
                                                .then(response => response.json())
                                                .then(json => {
                                                    callback(json.items);
                                                }).catch(()=>{
                                                    callback();
                                                });
                                            },
                                        render:{
                                            option: function(data,escape){
                                                console.log(data, escape);
                                                return `<div>${escape(data.name)}</div>`;
                                            },
                                        },
                                    }));
                                    // jika mainSelect sudah ada isinya generate inputan baru lagi dibawahnya
                                    // mainSelect.on('change', function(){
                                    //     var selected = mainSelect.getValue();
                                    //     console.log(selected);
                                    //     var unit = document.getElementById('list-unit');
                                    //     var unitInput = document.createElement('div');
                                    //     unitInput.classList.add('row', 'mb-3');
                                    //     unitInput.id = 'conversion-unit-1';
                                    //     unitInput.innerHTML = `
                                    //         <div class="col">
                                    //             <div class="input-group">
                                    //                 <input name="unit_name" type="text" class="form-control">
                                    //                 <span class="input-group-text">
                                    //                     =
                                    //                 </span>
                                    //                 <input name="buy_price" type="number" class="form-control">
                                    //                 <span class="input-group-text">
                                    //                     ${selected}
                                    //                 </span>
                                    //             </div>
                                    //         </div>
                                    //     `;
                                    //     unit.appendChild(unitInput);
                                    // });
                                });
                            </script>
                            @endpush
                        </div>
                    </div>

                    {{-- <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">&nbsp;</label>
                        <div class="col">
                            <input name="quantity" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Harga Beli</label>
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">
                                    Rp
                                </span>
                                <input name="buy_price" type="number" class="form-control">
                            </div>
                        </div>
                    </div> --}}

                </div>
                <div class="col-6">
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label">KODE</label>
                        <div class="col my-auto">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="manage_code">
                                <span class="form-check-label">Aktifkan No. Seri/Produksi</span>
                            </label>
                            {{-- <input type="text" class="form-control" name="code"> --}}
                        </div>
                    </div>

                    {{-- <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Satuan</label>
                        <div class="col">
                            <select name="unit" type="text" class="form-select">
                                <option value="pcs">Pcs</option>
                                <option value="mm">mm</option>
                                <option value="in">in</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="" class="col-3 col-form-label required">Pemasok</label>
                        <div class="col">
                            <input name="supplier" type="text" class="form-control">
                        </div>
                    </div> --}}
                </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layouts>
