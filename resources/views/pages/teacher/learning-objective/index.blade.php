@extends('layouts.app')

@section('title', 'Data Tujuan Pembelajaran | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Data Tujuan Pembelajaran <span class="badge bg-soft-dark text-dark ms-2">{{ $learningObjective_count }}</span></h1>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('teacher.learning-objective.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Tujuan Pembelajaran</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari tujuan pembelajaran...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.learning_resource.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.learning_resource.success') }}');
    @endif
</script>
@endsection
