@extends('layouts.app')

@section('title', 'Data Siswa | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Data Siswa <span class="badge bg-soft-dark text-dark ms-2">{{ $student_count }}</span></h1>
                    <div class="d-sm-flex mt-2">
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#importCustomersModal">
                            <i class="bi-upload me-1"></i> Impor
                        </a>
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="bi-download me-1"></i> Ekspor
                        </a>
                    </div>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.student.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Siswa</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari siswa...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.student.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.student.success') }}');
    @endif
</script>
@endsection