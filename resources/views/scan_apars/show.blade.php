@extends('layouts.app')
@section('title', 'Detail Scan APAR')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Scan APAR
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('apar_scan.index') }}" class="text-muted">Daftar Scan APAR &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('apar_scan.show', $apar_scan->id) }}" class="text-muted">Detail Scan APAR &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="card card-flush">
    <form action="{{route('apar_scan.update', $apar_scan->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                <input type="hidden" name="apar_id" id="apar_id">
                <input type="hidden" name="member_id" id="member_id">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Tipe APAR</Label>
                        <input type="text" name="apar_type" id="apar_type" class="form-control" value="{{$apar_scan->apar->type}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Isi APAR (kg)</Label>
                        <input type="text" name="apar_size" id="apar_size" class="form-control" value="{{$apar_scan->apar->size}}" disabled>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Lokasi APAR</Label>
                <textarea name="apar_location" id="apar_location" class="form-control" rows="5" disabled>{{{$apar_scan->apar->location}}}</textarea>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Nama Petugas</Label>
                <input type="text" name="member_name" id="member_name" class="form-control" value="{{$apar_scan->member->name}}" disabled>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Selang APAR</Label>
                        <select name="hose" id="hose" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B" {{$apar_scan->hose == "B" ? 'selected' : ''}}>B (Baik)</option>
                            <option value="R" {{$apar_scan->hose == "R" ? 'selected' : ''}}>R (Rusak)</option>
                            <option value="K" {{$apar_scan->hose == "K" ? 'selected' : ''}}>K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Segel APAR</Label>
                        <select name="seal" id="seal" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B" {{$apar_scan->seal == "B" ? 'selected' : ''}}>B (Baik)</option>
                            <option value="R" {{$apar_scan->seal == "R" ? 'selected' : ''}}>R (Rusak)</option>
                            <option value="K" {{$apar_scan->seal == "K" ? 'selected' : ''}}>K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Tabung APAR</Label>
                        <select name="tube" id="tube" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B" {{$apar_scan->tube == "B" ? 'selected' : ''}}>B (Baik)</option>
                            <option value="R" {{$apar_scan->tube == "R" ? 'selected' : ''}}>R (Rusak)</option>
                            <option value="K" {{$apar_scan->tube == "K" ? 'selected' : ''}}>K (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Kondisi Speedo Meter</Label>
                        <select name="speedo" id="speedo" class="form-select" data-control="select2"
                            data-placeholder="Pilih kondisi" required>
                            <option></option>
                            <option value="B" {{$apar_scan->speedo == "B" ? 'selected' : ''}}>B (Baik)</option>
                            <option value="R" {{$apar_scan->speedo == "R" ? 'selected' : ''}}>R (Rusak)</option>
                            <option value="K" {{$apar_scan->speedo == "K" ? 'selected' : ''}}>K (Kurang)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Keterangan (opsional)</Label>
                <input type="text" name="note" id="note" class="form-control" value="{{$apar_scan->note}}" placeholder="Masukkan keterangan">
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="update-apar_scan" type="submit" class="btn btn-active-primary btn-primary"
                        data-kt-indicator="off">
                        <span class="indicator-label">
                            Simpan
                        </span>
                    </button>
                    {{-- <button id="send-wa" type="button" class="btn btn-active-success btn-success ms-5">
                        Kirim
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path
                                d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                        </svg>
                    </button> --}}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- @push('scripts')
<script>
    $('#send-wa').on('click', function(){

        var message = $('#desc').text();
        if($('#note').val() != ""){
            let catatan = "\n\nCatatan : " + $('#note').val();
            message += catatan;
        }

        var whatsappUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(message);

        window.location.href = whatsappUrl;
    });
</script>
@endpush --}}