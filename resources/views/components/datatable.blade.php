<div class="card">
    <div class="card-header card-header-content-sm-between">
        <div class="mb-2 mb-sm-0">
            <form>
                {{-- DO NOT REMOVE THIS --}}
                {{-- Start DataTable Search --}}
                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input id="datatableSearch" type="search" class="form-control" placeholder="{{ $search_text }}" aria-label="{{ $search_text }}">
                </div>
                {{-- End DataTable Search --}}
            </form>
        </div>

        <div class="d-grid d-sm-flex justify-content-sm-end align-items-sm-center gap-2">
            {{-- DO NOT REMOVE THIS --}}
            {{-- Start DataTable Select Counter and Button --}}
            <div id="datatableCounterInfo" class="d-none">
                <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                              <span id="datatableCounter">0</span>
                              Dipilih
                            </span>

                    {{-- Start Button --}}
                    <button class="btn btn-outline-danger btn-sm" id="btn_mass_delete">
                        <i class="bi-trash"></i> Hapus
                    </button>
                    {{-- You can add button here --}}
                    {{-- End Button --}}

                </div>
            </div>
            {{-- End DataTable Select Counter and Button --}}

            {{-- DO NOT REMOVE THIS --}}
            {{-- Start Column Filtering (item automatically set by DataTable Helper) --}}
            @stack('custom_buttons')
            @if(isset($show_filter))
                @if($show_filter)
                    <button class="btn btn-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#dataTableFilter" aria-controls="dataTableFilter">
                        <i class="bi-filter me-1"></i> Filter
                    </button>
                @endif
            @endif
            <div class="dropdown">
                <button type="button" class="btn btn-white w-100" id="showHideDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="bi-table me-1"></i> Kolom <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="datatableColumnsFilteringCounter">-</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="showHideDropdown" style="width: 15rem;">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="d-grid gap-3" id="datatableColumnsFiltering">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Column Filtering --}}
        </div>
    </div>
    <div class="table-responsive datatable-custom position-relative">
        {{-- Render DataTable --}}
        {{ $table->table() }}
        {{-- End Render DataTable --}}
    </div>
    <div class="card-footer">
        <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
                <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                    <span class="me-2">Menampilkan:</span>
                    <div class="tom-select-custom">
                        <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true,
                                    "dropdownWidth": "min-content"
                                  }'>
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="-1">Semua</option>
                        </select>
                    </div>
                    <span class="text-secondary me-2">dari</span>
                    <span id="datatableWithPaginationInfoTotalQty"></span>
                    <span class="text-secondary ms-2">total data</span>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex justify-content-center justify-content-sm-end">
                    <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
