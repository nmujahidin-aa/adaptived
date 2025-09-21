@extends('layouts.app')

@section('title', 'Data Instruksi | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('teacher.worksheet.index') }}" class="btn btn-white">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="ms-3">
                        <h3 class="card-header-title">
                            <i class="bi-people me-2"></i>
                                Data Instruksi <span class="badge bg-soft-dark text-dark ms-2">{{ $instruction_count }}</span>
                        </h3>
                        <p class="mb-0">Mohon isi data dengan benar dan teliti</p>
                    </div>
                </div>

                <div>
                    <a class="btn btn-primary" href="{{ route('teacher.instruction.edit', ['worksheet_id' => $worksheet_id]) }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Instruksi</span>
                    </a>
                </div>
            </div>
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
    @if(session()->has('alert.instruction.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.instruction.success') }}');
    @endif
</script>
@endsection