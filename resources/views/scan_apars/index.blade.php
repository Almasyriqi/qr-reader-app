@extends('layouts.app')
@section('title', 'Data Scan APAR')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Data Scan APAR
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('apar_scan.index') }}" class="text-muted">Data Scan APAR &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
    </div>
</div>
@endsection
@section('content')
<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="currentColor" />
                    </svg>
                </span>
                <input type="search" name="search" class="form-control form-control-solid w-250px ps-15" id="search"
                    placeholder="Cari.." />
            </div>
        </div>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <a type="button" class="btn btn-active-primary btn-primary ms-2" href="{{route('apar_scan.create')}}" id="addButton">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                            transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                    </svg>
                </span>
                Scan QrCode
            </a>
        </div>
    </div>
    <div class="card-body fs-6 text-gray-700">
        <table id="patroli-table" class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>No</th>
                    <th>Tipe APAR</th>
                    <th>Nama Petugas</th>
                    <th>Lokasi APAR</th>
                    <th>Periode</th>
                    <th>Waktu Scan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fw-semibold fs-7 text-gray-600">
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var datatable = $('#patroli-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            stateSave: false,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [{
                    targets: 0, // Sesuaikan dengan posisi kolom 'DT_RowIndex'
                    render: function (data, type, full, meta) {
                        return meta.row + 1; // Menampilkan nomor urutan baris
                    },
                    orderable: true,
                    searchable: false,
                    width: '5%'
                },
                {
                    data: 'apar_type',
                    name: 'apar_type',
                    orderable: true,
                    searchable: true,
                    width: '10%',
                },
                {
                    data: 'member_name',
                    name: 'member_name',
                    orderable: true,
                    searchable: true,
                    width: '10%',
                },
                {
                    data: 'apar_location',
                    name: 'apar_location',
                    orderable: false,
                    searchable: true,
                    width: '10%'
                },
                {
                    data: 'period',
                    name: 'period',
                    orderable: true,
                    searchable: true,
                    width: '10%'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true,
                    width: '10%'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    width: '10%'
                },
            ],
            order: [
                [5, "desc"]
            ],
            scrollX: true,
            columnDefs: [{
                targets: 'nosort',
                orderable: false,
            }],
        });

        // search data in datatable
        $('#search').on('keyup', function() {
            datatable.search(this.value).draw();
        });

        $('#search').on('click', function() {
            datatable.search("").draw();
        });
</script>
@endpush