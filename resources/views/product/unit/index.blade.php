<x-app-layouts>
    <x-slot:header>
        <div class="page-header d-print-none">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col row g-2">
                        <h2 class="page-title">
                            Satuan Produk
                        </h2>
                        <div class="btn-list">
                            <span class="d-none d-sm-inline">
                                <a href="{{ route('unit.create') }}" class="btn text-uppercase">
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
                        </div>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <form action="./" method="get" autocomplete="off" novalidate="">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>
    <div class="card">
        <div class="card-body">
            <div id="table-default" class="table-responsive" style="zoom: 90%">
                <table class="table">
                    <thead>
                        <tr>
                        <th><button class="table-sort" data-sort="sort-name">Nama Satuan</button></th>
                        {{-- <th><button class="table-sort" data-sort="sort-quantity">Created At</button></th> --}}
                        </tr>
                    </thead>
                    <tbody class="table-tbody">
                        @forelse ($units as $unit)
                        <tr>
                            <td class="sort-name"> <a href="{{ route('unit.edit', $unit->id) }}">{{ $unit->name }}</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                Belum ada Satuan yang dibuat, <a href="{{ route('unit.create') }}">Buat satuan baru</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layouts>
