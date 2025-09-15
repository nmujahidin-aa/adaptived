@extends('layouts.app')

@section('title', 'Data Kegiatan Belajar | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Data Kegiatan Belajar <span class="badge bg-soft-dark text-dark ms-2">{{ $worksheet_count }}</span></h1>
                    
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('teacher.worksheet.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Kegiatan Belajar</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="flex-shrink-0">
                <i class="bi-exclamation-triangle-fill"></i> <span class="fw-semibold">Perhatian!</span> Setelah menambahkan kegiatan belajar, jangan lupa membuat kelompok pada menu <a href="{{ route('teacher.group.index') }}" class="text-primary fw-bold">Kelompok Belajar</a>, agar siswa dapat mengerjakan LKPD. Tanpa pengaturan ini, menu LKPD tidak dapat diakses.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari Kegiatan Belajar...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.worksheet.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.worksheet.success') }}');
    @endif
</script>
@endsection