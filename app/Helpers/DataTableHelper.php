<?php

namespace App\Helpers;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataTableHelper
{
    /**
     * Build the DataTable instance.
     *
     * @param DataTable $instance DataTable instance
     * @param string $tableId Table ID
     * @return HtmlBuilder DataTable HTML builder
     */
    public static function builder(DataTable $instance, string $tableId) : HtmlBuilder {
        $csrf = csrf_token();
        $login_url = route('auth.login.index');
        return $instance->builder()
            ->setTableId($tableId)
            ->columns($instance->getColumns())
            ->minifiedAjax()
            ->parameters([
                'drawCallback' => <<<JS
                    function() {
                        // Select all checkbox
                        const checkboxAll = $('#checkbox-all');
                        const checkboxes = $('td:first-child input[type="checkbox"]');
                        const datatableCounterInfo = $('#datatableCounterInfo');
                        const datatableCounter = $('#datatableCounter');
                        const datatable = this.api();

                        checkboxAll.prop('checked', false);
                        datatableCounterInfo.addClass('d-none');

                        checkboxAll.on('change', function() {
                            const checked = $(this).is(':checked');
                            checkboxes.prop('checked', checked);
                            checkboxes.trigger('change');
                        });

                        checkboxes.on('change', function() {
                            const checked = $(this).is(':checked');
                            const totalCheckboxes = checkboxes.length;
                            const totalChecked = $('td:first-child input[type="checkbox"]:checked').length;

                            if (checked) {
                                if (totalChecked === totalCheckboxes) {
                                    checkboxAll.prop('checked', true);
                                }
                            } else {
                                checkboxAll.prop('checked', false);
                            }

                            datatableCounter.text(totalChecked);
                            if (totalChecked > 0) {
                                datatableCounterInfo.removeClass('d-none');
                            } else {
                                datatableCounterInfo.addClass('d-none');
                            }
                        });

                        // DataTable Entries
                        const datatableEntries = $('#datatableEntries');

                        datatableEntries.on('change', function() {
                            const value = $(this).val();
                            if (value == -1) {
                                datatable.page.len(datatable.page.info().recordsTotal).draw();
                            } else {
                                datatable.page.len(value).draw();
                            }
                        });

                        const datatableWithPaginationInfoTotalQty = $('#datatableWithPaginationInfoTotalQty');
                        const totalQty = this.api().page.info().recordsTotal;
                        datatableWithPaginationInfoTotalQty.text(totalQty);

                        // Get total pages
                        const totalPages = this.api().page.info().pages;

                        // Get current page
                        const currentPage = this.api().page.info().page + 1;

                        // build paging navigation
                        const paging = document.querySelector('#datatablePagination');

                        // clear paging navigation
                        paging.innerHTML = '';

                        const pagingNav = document.createElement('div');
                        pagingNav.classList.add('dataTables_paginate', 'paging_simple_numbers');
                        pagingNav.id = 'datatable_paginate';
                        paging.appendChild(pagingNav);

                        const pagingNavList = document.createElement('ul');
                        pagingNavList.classList.add('pagination', 'datatable-custom-pagination');
                        pagingNavList.id = 'datatable_pagination';
                        pagingNav.appendChild(pagingNavList);

                        const pagingNavPrev = document.createElement('li');
                        pagingNavPrev.classList.add('paginate_button', 'page-item');
                        if (currentPage === 1) {
                            pagingNavPrev.classList.add('disabled');
                        }
                        const prevLink = document.createElement('a');
                        prevLink.classList.add('page-link', 'paginate_button', 'previous');
                        prevLink.setAttribute('aria-controls', 'datatable');
                        prevLink.id = 'datatable_previous';
                        prevLink.innerHTML = '<span aria-hidden="true"><i class="bi bi-arrow-left"/></span>';
                        pagingNavPrev.appendChild(prevLink);
                        pagingNavList.appendChild(pagingNavPrev);

                        // loop through all pages and add page number, or ellipsis if needed (show max 5 pages)
                        for (let i = 1; i <= totalPages; i++) {
                            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                                const pagingNavPage = document.createElement('li');
                                pagingNavPage.classList.add('paginate_button', 'page-item');
                                if (i === currentPage) {
                                    pagingNavPage.classList.add('active');
                                }
                                const pageLink = document.createElement('a');
                                pageLink.classList.add('page-link', 'paginate_button');
                                pageLink.setAttribute('aria-controls', 'datatable');
                                pageLink.innerHTML = i;
                                pagingNavPage.appendChild(pageLink);
                                pagingNavList.appendChild(pagingNavPage);
                            } else if (i === currentPage - 3 || i === currentPage + 3) {
                                const pagingNavEllipsis = document.createElement('li');
                                pagingNavEllipsis.classList.add('paginate_button', 'page-item', 'disabled');
                                const ellipsisLink = document.createElement('a');
                                ellipsisLink.classList.add('page-link', 'paginate_button');
                                ellipsisLink.setAttribute('aria-controls', 'datatable');
                                ellipsisLink.innerHTML = '...';
                                pagingNavEllipsis.appendChild(ellipsisLink);
                                pagingNavList.appendChild(pagingNavEllipsis);
                            }
                        }

                        const pagingNavNext = document.createElement('li');
                        pagingNavNext.classList.add('paginate_button', 'page-item');
                        if (currentPage === totalPages) {
                            pagingNavNext.classList.add('disabled');
                        }
                        const nextLink = document.createElement('a');
                        nextLink.classList.add('page-link', 'paginate_button', 'next');
                        nextLink.setAttribute('aria-controls', 'datatable');
                        nextLink.id = 'datatable_next';
                        nextLink.innerHTML = '<span aria-hidden="true"><i class="bi bi-arrow-right"/></span>';
                        pagingNavNext.appendChild(nextLink);
                        pagingNavList.appendChild(pagingNavNext);

                        // change page if page number is clicked
                        const pagingNavLinks = document.querySelectorAll('#datatable_pagination .page-link');
                        for (const pagingNavLink of pagingNavLinks) {
                            pagingNavLink.addEventListener('click', function () {
                                if (this.classList.contains('previous')) {
                                    datatable.page('previous').draw('page');
                                } else if (this.classList.contains('next')) {
                                    datatable.page('next').draw('page');
                                } else {
                                    const page = this.innerHTML;
                                    datatable.page(page - 1).draw('page');
                                }
                            });
                        }

                        // enable tooltip
                        const tooltipTriggerList = document.querySelectorAll('[dt-tooltip="true"][data-bs-toggle="tooltip"]')
                        Array.from(tooltipTriggerList).forEach(function(tooltipTriggerEl) {
                            new bootstrap.Tooltip(tooltipTriggerEl)
                        })

                        function addDataTableImgTimeout(img) {
                            var timer;
                            function clearTimer() {
                                if (timer) {
                                    clearTimeout(timer);
                                    timer = null;
                                }
                            }
                            function handleFail() {
                                this.onload = this.onabort = this.onerror = function() {};
                                clearTimer();
                                const altSrc = this.getAttribute('data-alt-src');
                                if (altSrc) {
                                    this.src = altSrc;
                                } else {
                                    if (this.classList.contains('avatar-img')) {
                                        this.src = "/assets/img/160x160/img1.jpg";
                                    } else {
                                        if (this.width > 600 && this.height <= 200) {
                                            this.src = "/assets/img/600x200/img1.jpg";
                                        }else {
                                            this.src = "/assets/img/400x400/img2.jpg";
                                        }

                                    }
                                }
                            }
                            img.onerror = img.onabort = handleFail;
                            img.onload = function() {
                                clearTimer();
                            };
                            timer = setTimeout(function(theImg) {
                                return function() {
                                    handleFail.call(theImg);
                                };
                            }(img), 4000);
                            return(img);
                        }
                        $('img').each(function() {
                            if (!this.complete) {
                                addDataTableImgTimeout(this);
                            }
                        });
                    }
                JS,
                'initComplete' => <<<JS
                    function() {
                        $.fn.dataTable.ext.errMode = 'none';
                        // Apply the search
                        const datatable = this.api();

                        datatable.on('error.dt', function(e, settings, techNote, message) {
                            if ($('#modalErrorDataTable').length) {
                            } else {
                                $('body').append('<div class="modal fade" id="modalErrorDataTable" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="modalTitle">Terjadi Kesalahan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="modalBody"><p class="mb-0">' + message + '</p></div></div></div>');
                            }

                            let url = '';
                            let urlWithParams = '';
                            let ajaxResponse = '';
                            try {
                                url = datatable.ajax.url();
                                urlWithParams = url + '?' + $.param(datatable.ajax.params());
                                ajaxResponse = settings.jqXHR.responseText;
                            } catch (Exception) {
                            }

                            if (settings.jqXHR.status === 401) {
                                window.location.href = '{$login_url}';
                                return;
                            }

                            let errorID = '';
                            let statusCode = null;
                            // send log to server with csrf
                            try {
                                $.ajax({
                                    url: '/api/v1/services/log',
                                    type: 'POST',
                                    data: {
                                        level: 'error',
                                        messages: 'DataTable request to: ' + urlWithParams + ' failed with message: ' + message + '. Ajax response: ' + ajaxResponse,
                                        route: window.location.pathname,
                                        method_request: 'GET',
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': '{$csrf}'
                                    },
                                    success: function (response) {
                                        errorID = response.data.id;
                                        statusCode = response.data.code;
                                        $('#modalBody').html('');
                                        $('#modalErrorDataTable').modal('show');
                                        $('#modalTitle').text('Terjadi Kesalahan');
                                        $('#modalBody').append('<p class="mb-0">Mohon maaf saat ini sedang ada sedikit kendala. Mungkin ini hanya kesalahan sementara, silahkan coba lakukan refresh halaman. Jika hal ini terjadi lagi, silakan untuk menghubungi admin Fakultas.</p>');
                                        if (errorID != '') {
                                            $('#modalBody').append('<p class="mt-3"><small>ID Kesalahan: ' + errorID + '</small></p>');
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        statusCode = xhr.status;
                                        $('#modalBody').html('');
                                        $('#modalErrorDataTable').modal('show');
                                        $('#modalTitle').text('Terjadi Kesalahan');
                                        $('#modalBody').append('<p class="mb-0">Mohon maaf saat ini sedang ada sedikit kendala. Mungkin ini hanya kesalahan sementara, silahkan coba lakukan refresh halaman. Jika hal ini terjadi lagi, silakan untuk menghubungi admin Fakultas.</p>');
                                        if (statusCode == 419) {
                                            $('#modalBody').append('<p class="mt-3">Sesi Anda mungkin telah berakhir sehingga membutuhkan token baru. Silakan untuk melakukan refresh halaman.</p>');
                                        }
                                        if (statusCode == 500) {
                                            $('#modalBody').append('<p class="mb-3">Server mungkin sedang mengalami masalah saat ini.</p>');
                                        }
                                    }
                                });
                            } catch (Exception) {
                            }
                        });

                        const searchInput = $('#datatableSearch');
                        let oldSearch = '';

                        searchInput.on('keyup', function() {
                            if (oldSearch != this.value) {
                                datatable.search(this.value).draw();
                                oldSearch = this.value;
                            }
                        });

                        searchInput.on('mouseup', function() {
                            const that = this;
                            const oldValue = that.value;

                            if (oldValue == '') return;

                            setTimeout(function(){
                                const newValue = that.value;

                                if (newValue == '') {
                                    $(that).trigger('keyup');
                                }
                            }, 1);
                        });

                        // Get all columns
                        const columns = datatable.columns().header().toArray();
                        // Get all columns that are not checkbox
                        const columnsWithoutCheckbox = columns.filter(column => !column.classList.contains('table-column-pe-0'));
                        const filterContainer = document.querySelector('#datatableColumnsFiltering');
                        for (const column of columnsWithoutCheckbox) {
                            const title = column.title;
                            const cellIndex = column.cellIndex;

                            let hide = 'checked';

                            // check if column has class default-hide
                            if (column.classList.contains('default-hide')) {
                                hide = '';
                            }

                            // create toggle child
                            filterContainer.insertAdjacentHTML('beforeend', '<label class="row form-check form-switch" for="toggleColumn_' + cellIndex + '"><span class="col-8 col-sm-9 ms-0"><span class="me-2">' + title + '</span></span><span class="col-4 col-sm-3 text-end"><input type="checkbox" class="form-check-input" id="toggleColumn_' + cellIndex + '" data-index="' + cellIndex + '" ' + hide + '></span></label>');

                            // add event listener
                            const checkbox = document.querySelector('#toggleColumn_' + cellIndex);

                            if (checkbox) {
                                checkbox.addEventListener('change', function () {
                                    // get attributes
                                    const index = this.getAttribute('data-index');
                                    datatable.column(index).visible(this.checked);

                                    // count visible columns
                                    const visibleColumns = datatable.columns(':visible').header().toArray();
                                    const visibleColumnsCount = visibleColumns.length;

                                    $('#datatableColumnsFilteringCounter').text(visibleColumnsCount - 1);

                                });
                            }
                        }

                        // trigger change event
                        const toggles = document.querySelectorAll('#datatableColumnsFiltering input[type="checkbox"]');
                        for (const toggle of toggles) {
                            toggle.dispatchEvent(new Event('change'));
                        }
                    }
                JS,
                'responsive' => false,
                'showPaging' => false,
                'pageLength' => 20,
                'language' => [
                    'zeroRecords' => <<<HTML
                        <div class="text-center p-4">
                          <img class="mb-3" src="/assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                          <img class="mb-3" src="/assets/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                        <p class="mb-0">Tidak ada data untuk ditampilkan</p>
                        </div>
                    HTML,
                    'processing' => <<<HTML
                        <div class="align-items-start p-3">
                          <div class="spinner-border spinner-border-sm ms-auto" role="status" aria-hidden="true"></div>
                          <span>Sedang memproses, mohon tunggu sebentar...</span>
                        </div>
                    HTML,
                ],
            ])
            ->selectStyleSingle()
            ->addTableClass('table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table')
            ->setTableHeadClass('thead-light');
    }

    /**
     * Add checkbox column to DataTable
     *
     * @return Column Checkbox column
     */
    public static function addCheckbox() : Column {
        $col = Column::computed('checkbox')->title(<<<HTML
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkbox-all" name="checkbox-all">
                        <label class="form-check-label" for="checkbox-all"></label>
                    </div>
                    HTML)
            ->addClass('table-column-pe-0')
            ->exportable(false)
            ->printable(false);

        $col->attributes = ['scope' => 'col'];

        return $col;
    }

    /**
     * Add checkbox to each row in DataTable
     *
     * @param object $row Row data
     * @param string|null $name Name to saved in checkbox attribute data-name (default: $row->name)
     * @return string Checkbox HTML element
     */
    public static function checkbox(object $row, string $name = null) : string {
        $name = $name ?: $row->name;
        return <<<HTML
            <div class="form-check">
                <input type="checkbox" class="form-check-input mass-delete" id="checkbox-{$row->id}" name="checkbox[]" value="{$row->id}" data-name="{$name}">
                <label class="form-check-label" for="checkbox-{$row->id}"></label>
            </div>
        HTML;
    }

    public static function actionButton(object $row, string $edit_route, string $delete_route) : string {
        return <<<HTML
            <div class="btn-group" role="group">
            <a class="btn btn-white btn-sm" href="{$edit_route}">
              <i class="bi-pencil-fill me-1"></i> Ubah
            </a>

            <!-- Button Group -->
            <div class="btn-group">
              <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="tableEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
              <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="tableEditDropdown">
                <button class="dropdown-item" onclick="triggerDeleteFromTable(this)" data-endpoint="{$delete_route}">
                  <i class="bi-trash dropdown-item-icon"></i> Hapus
                </button>
              </div>
            </div>
        HTML;
    }

    public static function actionButtonAnalysis(object $row, string $route, string $count) : string {
        return <<<HTML
            <div class="btn-group" role="group">
            <a class="btn btn-white btn-sm" href="{$route}">
              <i class="bi-puzzle-fill me-1"></i> {$count} Jawaban
            </a>
        HTML;
    }

    public static function actionButtonAssesment(object $row, string $add_questions_route, string $edit_route, string $delete_route) : string {
        return <<<HTML
            <div class="btn-group" role="group">
            <a class="btn btn-white btn-sm" href="{$add_questions_route}">
              <i class="bi-plus-square-fill me-1"></i> Tambah Soal
            </a>

            <!-- Button Group -->
            <div class="btn-group">
              <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="tableEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
              <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="tableEditDropdown">
              <a class="dropdown-item" href="{$edit_route}">
                <i class="bi-pencil-fill dropdown-item-icon"></i> Ubah
              </a>  
              <button class="dropdown-item" onclick="triggerDeleteFromTable(this)" data-endpoint="{$delete_route}">
                  <i class="bi-trash dropdown-item-icon"></i> Hapus
                </button>
              </div>
            </div>
        HTML;
    }
}
