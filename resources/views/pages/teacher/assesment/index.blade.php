@extends('layouts.app')

@section('title', 'Assesment | Adaptived')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Assesment <span class="badge bg-soft-dark text-dark ms-2">{{ $assesment_count }}</span></h1>
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
                    <a class="btn btn-primary" href="{{ route('teacher.assesment.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Assesment</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari Assesment...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>



@endsection

@section('scripts')
<script>
    function getQueryStringFilter() {
        let statement_letter = [];
        $('input[name="filter_statement_letter"]:checked').each(function() {
            statement_letter.push($(this).val());
        });

        let traits = [];
        $('input[name="filter_traits"]:checked').each(function() {
            traits.push($(this).val());
        });

        const status = $('input[name="filter_status"]:checked').val();

        // build query string
        let query_string = '';
        if(statement_letter.length > 0) {
            query_string += 'statement_letter=' + statement_letter.join(',') + '&';
            console.log(query_string);
        }
        if(traits.length > 0) {
            query_string += 'traits=' + traits.join(',') + '&';
        }

        query_string += 'status=' + status + '&';

        return query_string;
    }

    function resetFilter() {
        // loop checkboxes inside statement_letter_container
        $('#statement_letter_container input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
        });
        // loop checkboxes inside traits_container
        $('#traits_container input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
        });

        // change radio of filter_status_all to checked
        $('#filter_status_all').prop('checked', true);
        // trigger click on btn_filter
        $('#btn_filter').trigger('click');
    }

    $('#btn_filter').on('click', function() {
        const query_string = getQueryStringFilter();
        const dataTable = window.LaravelDataTables['datatable'];
        dataTable.ajax.url(
            '{{ route('submission.general.index') }}?{{ request()->getQueryString() }}&' + query_string
        ).load();
        // close offcanvas
        $('#dataTableFilter').offcanvas('hide');
    });
    $('#btn_reset_filter').on('click', function() {
        resetFilter();
    });
</script>
@endsection