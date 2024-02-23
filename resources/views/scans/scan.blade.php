@extends('layouts.app')
@section('title', 'Scan QR Code')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Scan QR Code
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scan.filter') }}" class="text-muted">Filter Dataset &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scan.index', ['path'=>$path]) }}" class="text-muted">Dataset &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('scan.code', ['path'=>$path]) }}" class="text-muted">Scan &nbsp;</a>
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
    <div class="card-body">
        <div class="mb-5">
            <Label class="form-label fs-6 fw-bold mt-2 mb-3">Perangkat</Label>
            <select name="device" id="device" class="form-select" data-control="select2"
                data-placeholder="Pilih perangkat">
                <option value="1">Scanner</option>
                <option value="2" selected>Smartphone</option>
            </select>
        </div>

        <div class="mb-5">
            <div class="row justify-content-center" id="camera_qr">
                <div class="col-md-8">
                    <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Scan QR</Label>
                    <div id="reader"></div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <div id="scanner">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Kode</Label>
                <input type="text" name="code" id="code" class="form-control">
            </div>
        </div>

        <hr>

        <div class="mb-5">
            <h3>Data Scan</h3>
            <table id="table" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>Data</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner;
    var datatable = $('#table').DataTable({
        ajax:{
            url: '{{ route("getScanData") }}?path={{$path}}',
            dataSrc: ''
        },
        paging: false,
        ordering: false,
        dom: 'Brtip',
            buttons: [
                'excel', 'print'
            ],
        columns: [{
                    data: 'data',
                    name: 'data',
                    orderable: false,
                    searchable: false,
                    width: '5%'
                },
                {
                    data: 'value',
                    name: 'value',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                },
            ],
    });
    function getScanData(decodedText) {
        datatable.ajax.url('{{ route("getScanData") }}?path={{$path}}&code=' + decodedText).load();
        datatable.ajax.reload();
    }

    function onScanSuccess(decodedText, decodedResult) {
        $('#code').val(decodedText);
        // getScanData(decodedText);
    }

    function onScanFailure(error) {
        // console.warn(`Code scan error = ${error}`);
    }

    html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250}, formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ], facingMode: "environment", supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA] },
    /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    $(document).ready(function(){
        $('#scanner').hide();
    });

    $('#device').on('change', function(){
        if($(this).val() == '1'){
            $('#camera_qr').hide();
            $('#scanner').show();
            html5QrcodeScanner.clear();
        } else {
            $('#camera_qr').show();
            $('#scanner').hide();
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }
    });

    $('#code').on('change', function(){
        getScanData($(this).val());
    });
</script>
@endpush