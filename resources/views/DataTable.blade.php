@extends('layouts.app')

@push('css_before')
    <!-- Page JS Plugins CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/sb-1.0.0/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
    <style>
        .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
            width: 50%;
            display: inline-block;
        }
        td {
            white-space: nowrap;
        }
        .dataTables_processing {
            position: fixed !important;
            top: 50% !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            z-index: 999998 !important;
            font-weight: 900 !important;
            width: 100% !important;
            margin: 0 !important;
            text-align: center;
            padding: 0 !important;
        }
        table.dataTable {
            width: 100% !important;
        }
        .selected {
            background-color: #acbad4 !important;
        }
        .sorting_1 {
            background-color: #f1f1f1;
        }
        /* tfoot {
            display: table-header-group;
        }
        tfoot input {
            width: 100%;
        } */
    </style>
@endpush

@section('content')

<!-- Page Content -->
<div class="content">
    {{-- <h2 class="content-heading">Host</h2> --}}
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $block_title }}</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" id="reLoad">
                    <i class="fa fa-repeat"></i> ReLoad
                </button>
             </div>
        </div>
        
        <div class="block-content block-content-full">
            <div class="row justify-content-between">
                <div class="ml-1 p-10">
                    @if (!empty($ShowButtonCreate))
                    <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create">
                        <button 
                            type="button" 
                            class="btn btn-sm btn-primary createItem" 
                            data-toggle="modal" 
                            data-target="#modal_form"
                            data-id="" 
                            data-metod="create"
                        >
                            <i class="fa fa-plus"></i>&nbsp;Create
                        </button>
                    </span>
                    @endif
                </div>
                <div class="p-10">
                    <a href="{{ route('home') }}" class="btn btn-alt-danger mr-5 mb-5">
                        <i class="fa fa-download mr-5"></i>Import
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-alt-warning mr-5 mb-5">
                        <i class="fa fa-upload mr-5"></i>Export
                    </a>
                </div>
            </div>

            @if (!empty($showFiltersForm))
                @include('components.tickets.filters-form')
            @endif

            {{ $dataTable->table() }}
        </div>
    </div>
    <!-- END Dynamic Table Full -->
</div>
<!-- END Page Content -->

{{-- @include('components.smodal') --}}
@include('components.modal_form')
@include('components.modal_show_item')
@endsection
@push('js_after')
    <!-- Page JS Plugins -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/sb-1.0.0/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
    <script>
        var myTable = null;
        function drawTableCallback(e) {
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        }
        function filterColumn (i, val) {
            myTable.column(i).search(val, false, false, true).draw()
        }
    </script>

    {{ $dataTable->scripts() }}

    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

            $('body').on('click', '#reLoad', function () {
                myTable.draw()
            })
            
            $(".columns-show-menu").change(function() {
                var column = myTable.column($(this).data("column"));
                if(this.checked) {
                    column.visible(true);
                } else {
                    column.visible(false);
                }
            })
            
            $('#modal_form').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) 
                if (button.data('metod') === 'create') {
                    $(this).find(".modal-content").load('{{ route($jsroute) }}/create');
                } else {
                    $(this).find(".modal-content").load('{{ route($jsroute) }}/'+ button.data('id') + '/edit');
                }
            })

            $('#modal_show_item').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) 
                $(this).find("#show_content").load('{{ route($jsroute) }}/'+ button.data('id'));
            })
            
            $('body').on('submit', '#ajaxUpdateForm', function (event) {
                event.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(), 
                    dataType: 'json',
                    beforeSend: function() {
                        // Codebase.loader('show')
                    },
                    success: function(json) {
                        $('#modal_form').modal('hide')
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $('#modal_form').modal('hide')
                        showNotify('danger', 'Update failed! :-(')
                    },
                    complete: function() {
                        // Codebase.loader('hide')
                        $('#modal_form').find(".modal-content").html(editDefaultForm()) 
                        myTable.draw()
                    }
                })
            })
    

            $('body').on('click', '.deleteItem', function () {
                var model_id = $(this).data("id");
                var confirmtext = $(this).data("confirm");
                if(!confirm(confirmtext)) { 
                    return false 
                }
                $.ajax({
                    type: "delete",
                    url: '{{ route($jsroute) }}/'+ model_id,
                    dataType: 'json',
                    success: function (json) {
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        showNotify('danger', 'delete failed! :-(')
                    },
                    complete: function() {
                        myTable.draw()
                    }
                })
            })

            $('body').on('click', '.eventItem', function () {
                let model_id = $(this).data("id")
                let metod = $(this).data("metod")
                let confirmtext = $(this).data("confirm")
                if(!confirm(confirmtext)) { 
                    return false 
                }
                $.ajax({
                    type: "post",
                    url: '{{ route($jsroute) }}/'+ model_id + '/' + metod,
                    dataType: 'json',
                    success: function (json) {
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        showNotify('danger', metod + ' failed! :-(')
                    },
                    complete: function() {
                        myTable.draw()
                    }
                })
            })
            
            /* $('body').on('click', '.updatednsItem', function () {
                var model_id = $(this).data("id");
                var confirmtext = $(this).data("confirm");
                // confirm(confirmtext);
                $.ajax({
                    type: "post",
                    url: '{{ route($jsroute) }}/'+ model_id + '/updatedns',
                    dataType: 'json',
                    success: function (json) {
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        showNotify('danger', 'add to update dns failed! :-(')
                    },
                    complete: function() {
                        myTable.draw()
                    }
                })
            }) */

            /* $('body').on('click', '.importItemDns', function () {
                var model_id = $(this).data("id");
                var confirmtext = $(this).data("confirm");
                // confirm(confirmtext);
                $.ajax({
                    type: "post",
                    url: '{{ route($jsroute) }}/'+ model_id + '/importdns',
                    dataType: 'json',
                    success: function (json) {
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        showNotify('danger', 'add to update dns failed! :-(')
                    },
                    complete: function() {
                        myTable.draw()
                    }
                })
            } */)

            /* $('body').on('click', '.importItemSubdomains', function () {
                var model_id = $(this).data("id");
                var confirmtext = $(this).data("confirm");
                // confirm(confirmtext);
                $.ajax({
                    type: "post",
                    url: '{{ route($jsroute) }}/'+ model_id + '/importsubdomains',
                    dataType: 'json',
                    success: function (json) {
                        showNotify('success', json.success)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        showNotify('danger', 'add to update dns failed! :-(')
                    },
                    complete: function() {
                        myTable.draw()
                    }
                })
            }) */
            
            function showNotify(type, message) {
                Codebase.helpers('notify', { align: 'right', from: 'top', type: type, icon: 'fa fa-times', message: message })
            }

            function editDefaultForm() {
                return ` @include('components.editDefaultForm') `;
            }

            $('body').on('keyup click', '#filter-author', function () {
                filterColumn (1, $(this).val())
            })
            $('body').on('keyup click', '#filter-domain', function () {
                filterColumn (4, $(this).val())
            })
            $('body').on('keyup click', '#filter-ip-address', function () {
                filterColumn (5, $(this).val())
            })
        })
    </script>
@endpush
