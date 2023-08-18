<x-app-layouts>
    <x-slot:header>
        <div class="navbar">
            <div class="container-fluid row">
                <div class="col-md-8 col-xl-6">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="page-title">
                                Varian Produk / Baru
                            </h2>
                        </div>
                        <div class="ms-auto col-auto">
                            <div class="btn-list">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>
    @push('scripts')
    <script src="{{ asset('libs/tom-select/dist/js/tom-select.complete.min.js?1684106062') }}" defer></script>
    @endpush
    <div class="row">
        <div class="col-md-8 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" class="row g-4"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-12">
                            <label for="" class="form-label">Nama Produk</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-lg"
                                placeholder="contohnya Cheese Burger" required>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="" class="col-4 col-form-label required">Tipe Produk</label>
                                <div class="col d-flex">
                                    <select name="category_id" id="" class="form-select">
                                        @forelse ($categories as $category)
                                        <option value="{{ $category->id }}" class="text-capitalize" required>{{ $category->name }}
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
                                    <div class="form-group row mb-3 align-items-center">
                                        <div class="col-6">
                                            <select name="unit_id" id="select-units" class="form-select" required>
                                            </select>
                                        </div>
                                    </div>
                                    @push('scripts')
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            var el;
                                            var conversionCount = 0;
                                            var mainUnit;
                                            var selectedUnits = [];
                                            window.TomSelect && (mainSelect = new TomSelect(el = document.getElementById('select-units'), {
                                                plugins: ['remove_button'],
                                                persist: false,
                                                maxItems: 1,
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
                                                        return `<div>${escape(data.name)}</div>`;
                                                    },
                                                },
                                            }));
                                            // jika mainSelect sudah ada isinya generate inputan baru lagi dibawahnya
                                            mainSelect.on('change', function(value){
                                                this.blur()
                                                this.disabled = true
                                                if(conversionCount != 0){
                                                    conversionCount++
                                                }
                                                var selected = this.options[value].name;
                                                if (selected) {
                                                    deleteOtherForm()
                                                    mainUnit = selected
                                                    generateForm()
                                                    selectedUnits.push(selected)
                                                } else {
                                                    console.log('isinya kosong')
                                                    deleteOtherForm()
                                                    mainUnit = ''
                                                    selectedUnits = []
                                                    conversionCount = 0
                                                }
                                            });
                                            const generateForm = () => {
                                                var newInput = `
                                                <div class="form-group row align-items-center input-row mb-3" id="unit-conversion-${conversionCount}">
                                                    <div class="col-6">
                                                        <select name="conversion_id[]" id="form-unit-${conversionCount}" class="form-select"></select>
                                                    </div>
                                                    <span class="col-1">
                                                        =
                                                    </span>
                                                    <div class="col-3">
                                                        <input type="text" name="conversion_factor[]" class="form-control">
                                                    </div>
                                                    <span class="col-2">
                                                        ${mainUnit}
                                                    </span>
                                                </div>
                                                `;
                                                var wrapper = $('#list-unit');
                                                wrapper.append(newInput)
                                                new TomSelect($("#form-unit-" + conversionCount),{
                                                    plugins: ['remove_button'],
                                                    persist: false,
                                                    create: true,
                                                    maxItems: 1,
                                                    valueField: 'id',
                                                    labelField: 'name',
                                                    searchField: 'name',
                                                    load: function(query, callback) {
                                                        var url = '{{ route('unit.getData') }}';
                                                        fetch(url)
                                                            .then(response => response.json())
                                                            .then(json => {
                                                                let items = json.items.filter(item => !selectedUnits.includes(item.name))
                                                                callback(items);
                                                            }).catch(()=>{
                                                                callback();
                                                            });
                                                        },
                                                    render:{
                                                        option: function(data,escape){
                                                            return `<div>${escape(data.name)}</div>`;
                                                        },
                                                    },
                                                    onChange: function(selected) {
                                                        this.blur()
                                                        if (selected) {
                                                            conversionCount++
                                                            selectedUnits.push(selected)
                                                            generateForm()
                                                        }
                                                    },
                                                    onDelete: function() {
                                                        console.log($("#unit-conversion-" + conversionCount))
                                                    }
                                                });
                                            }
                                            const deleteOtherForm = () => {
                                                let inputs = $('.input-row')
                                                inputs.remove()
                                            }
                                        });
                                    </script>
                                    @endpush
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row align-items-center">
                                <label for="" class="col-2 col-form-label">KODE</label>
                                <div class="col-1">
                                    <label class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" value="1" {{ old('manage_code' ? 'checked':'') }} data-bs-toggle="tooltip" aria-label="Kode Generate Otomatis dari Sistem" data-bs-original-title="Kode Generate Otomatis dari Sistem" name="manage_code">
                                    </label>
                                </div>
                                <div class="col my-auto">
                                    <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                </div>
                                @push('scripts')
                                    <script>
                                        // check if input manage_code is checked
                                        const codeInput = $('input[name=code]')
                                        $('input[name=manage_code]').change(function () {
                                            // console.log(this.checked)
                                            codeInput.prop('disabled', this.checked);
                                        })
                                    </script>
                                @endpush
                            </div>
                        </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layouts>
