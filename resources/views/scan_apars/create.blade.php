@extends('layouts.app')
@section('title', 'Scan QR Code')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Scan QR Code APAR
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
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('apar_scan.create') }}" class="text-muted">Scan QR &nbsp;</a>
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
    <form action="{{route('apar_scan.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body fs-6 text-gray-700">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-5">
                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Scan QR</Label>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div id="reader"></div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <input type="hidden" name="apar_id" id="apar_id">
                <input type="hidden" name="member_id" id="member_id">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Tipe APAR</Label>
                        <input type="text" name="apar_type" id="apar_type" class="form-control" disabled>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Isi APAR (kg)</Label>
                        <input type="text" name="apar_size" id="apar_size" class="form-control" disabled>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Lokasi APAR</Label>
                <textarea name="apar_location" id="apar_location" class="form-control" rows="5" disabled></textarea>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Nama Petugas</Label>
                <input type="text" name="member_name" id="member_name" class="form-control" disabled>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Selang APAR</Label>
                        <select name="hose" id="hose" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B">B (Baik)</option>
                            <option value="R">R (Rusak)</option>
                            <option value="K">K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Segel APAR</Label>
                        <select name="seal" id="seal" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B">B (Baik)</option>
                            <option value="R">R (Rusak)</option>
                            <option value="K">K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Tabung APAR</Label>
                        <select name="tube" id="tube" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B">B (Baik)</option>
                            <option value="R">R (Rusak)</option>
                            <option value="K">K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Speedo Meter</Label>
                        <select name="speedo" id="speedo" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B">B (Baik)</option>
                            <option value="R">R (Rusak)</option>
                            <option value="K">K (Kurang)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Keterangan (opsional)</Label>
                <input type="text" name="note" id="note" class="form-control" placeholder="Masukkan keterangan">
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <a href="{{route('apar_scan.index')}}" id="cancelButton"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</a>
                    <button id="save-apar_scan" type="submit" class="btn btn-active-primary btn-primary"
                        data-kt-indicator="off">
                        <span class="indicator-label">
                            Simpan
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner;
    function getScanData(decodedText) {
        $.ajax({
            url: "{{route('apar_scan.scan')}}",
            method: 'GET',
            data: {
                _token: $("meta[name='csrf-token']").attr("content"), 
                qrCodeData: decodedText 
            },
            success: function (data) {
                // Handle response dari server di sini
                $('#apar_id').val(data.apar_id);
                $('#member_id').val(data.member_id);
                $('#apar_type').val(data.apar_type);
                $('#apar_size').val(data.apar_size);
                $('#apar_location').text(data.apar_location);
                $('#member_name').val(data.member_name);
            },
            error: function (error) {
                console.error('Error in AJAX request:', error);
            }
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        // console.log(`Code matched = ${decodedText}`, decodedResult);
        getScanData(decodedText);
    }

    function onScanFailure(error) {
        // console.warn(`Code scan error = ${error}`);
    }

    html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250}, formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ], facingMode: "environment", supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA] },
    /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush