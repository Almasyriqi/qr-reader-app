@extends('layouts.app')
@section('title', 'Scan QR Code')
@section('styles')
<style>
    #video-container {
        line-height: 0;
    }

    #video-container .scan-region-highlight-svg,
    #video-container .code-outline-highlight {
        stroke: #64a2f3 !important;
    }
</style>
@endsection
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
                <option value="2" selected>Smartphone / Camera</option>
            </select>
        </div>

        <div class="mb-5">
            <div class="row justify-content-center" id="camera_qr">
                <div class="col-md-8">
                    <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Scan QR</Label>
                    <div id="reader"></div>
                    <div id="video-container">
                        <video id="qr-video" class="w-100"></video>
                    </div>
                    <div class="row justify-content-center w-100 mt-3">
                        <div class="col-md-3">
                            <b>Status camera:</b>
                            <select id="action-list">
                                <option value="1" selected>Start</option>
                                <option value="2">Stop</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <b>Pilih camera:</b>
                            <select id="cam-list">
                                <option value="environment" selected>Environment Facing (default)</option>
                                <option value="user">User Facing</option>
                            </select>
                        </div>
                    </div>
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
                        <th>Nilai</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.4.2/qr-scanner.umd.min.js"
    integrity="sha512-a/IwksuXdv0Q60tVkQpwMk5qY+6cJ0FJgi33lrrIddoFItTRiRfSdU1qogP3uYjgHfrGY7+AC+4LU4J+b9HcgQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.4.2/qr-scanner.legacy.min.js"
    integrity="sha512-p8m79Tn59dsKFUelNkaMId11T6xaD6sIjtuHYduah5b97nLHBRItTDlibAQ1mVoaS3zRxbLewQEXLoJI8PRjBQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const camList = document.getElementById('cam-list');
    let videoElem = document.getElementById('qr-video');
    let status = 0;
    var datatable = $('#table').DataTable({
        ajax:{
            url: '{{ route("getScanData") }}?path={{$path}}',
            dataSrc: ''
        },
        paging: false,
        ordering: false,
        dom: 'Brtip',
            buttons: [
                'excel', 'print', 'pdf', 'copy'
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
        return new Promise((resolve, reject) => {
            datatable.ajax.url('{{ route("getScanData") }}?path={{$path}}&code=' + decodedText).load();
            datatable.ajax.reload(() => {
                resolve();
            });
        });
    }

    async function setResult(result) {
        $('#code').val(result.data);
        await getScanData(result.data);
    }

    const qrScanner = new QrScanner(
        videoElem,
        async result => await setResult(result),
        { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ 
        highlightScanRegion: true,
        highlightCodeOutline: true,
        },
    );

    qrScanner.start().then(() => {
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label;
            camList.add(option);
        }));
    });

    $('#action-list').on('change', function(){
        if($(this).val() == '1'){
            qrScanner.start();
        } else {
            qrScanner.stop();
        }
    });

    camList.addEventListener('change', event => {
        qrScanner.setCamera(event.target.value);
    });

    $(document).ready(function(){
        $('#scanner').hide();
    });

    $('#device').on('change', function(){
        if($(this).val() == '1'){
            $('#camera_qr').hide();
            $('#scanner').show();
            qrScanner.stop();
        } else {
            $('#camera_qr').show();
            $('#scanner').hide();
            qrScanner.start();
        }
    });

    $('#code').on('change', function(){
        getScanData($(this).val());
    });
</script>
@endpush