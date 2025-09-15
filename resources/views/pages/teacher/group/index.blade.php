@extends('layouts.app')

@section('title', 'Data Kelompok Belajar | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Data Kelompok Belajar <span class="badge bg-soft-dark text-dark ms-2">{{ $group_count }}</span></h1>

                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('teacher.group.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Kelompok Belajar</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="flex-shrink-0">
                <i class="bi-exclamation-triangle-fill"></i> <span class="fw-semibold">Perhatian!</span> Kelompok hanya berlaku untuk satu kegiatan belajar. Pastikan setiap kelompok sudah diatur sesuai kegiatan belajarnya. Saat ini Anda memiliki {{$worksheets->count()}} kegiatan belajar.".
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari Kelompok Belajar...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.group.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.group.success') }}');
    @endif
</script>
@endsection