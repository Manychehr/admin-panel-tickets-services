
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

        /* table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }
        table.dataTable.display tbody tr.odd>.sorting_1, table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
            background-color: #f1f1f1;
        }
        table.dataTable.row-border tbody tr:first-child th, table.dataTable.row-border tbody tr:first-child td, table.dataTable.display tbody tr:first-child th, table.dataTable.display tbody tr:first-child td {
            border-top: none;
        }
        table.dataTable.order-column tbody tr>.sorting_1, table.dataTable.order-column tbody tr>.sorting_2, table.dataTable.order-column tbody tr>.sorting_3, table.dataTable.display tbody tr>.sorting_1, table.dataTable.display tbody tr>.sorting_2, table.dataTable.display tbody tr>.sorting_3 {
            background-color: #fafafa;
        }
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            border-top: 1px solid #ddd;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 8px 10px;
        }
        table.dataTable, table.dataTable th, table.dataTable td {
            box-sizing: content-box;
        } */
        td.icon-collapsed {
            padding-left: 25px !important;
            cursor: pointer;
        }
        td.icon-collapsed::before {
            margin-left: -25px;
            margin-top: 1px;
            height: 14px;
            width: 14px;
            display: block;
            position: absolute;
            color: white;
            border: 2px solid white;
            border-radius: 14px;
            box-shadow: 0 0 3px #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: 'Courier New', Courier, monospace;
            line-height: 14px;
            content: '+';
            background-color: #31b131;
        }

        tr.shown>td.icon-collapsed::before {
            content: '-';
            background-color: #d33333;
        }
        .zd-comment {
            padding: 10px;
            background-color: #e3f4fc;
        }
    </style>
@endpush
@section('content')
<div class="content">
    <!-- ticket -->
    <h2 class="content-heading d-print-none"> Show Ticket </h2>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">#{{ $ticket->api_id }}</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <!-- ticket Info -->
            <div class="row my-20">
                <!-- Company Info -->
                <div class="col-6">
                    <p class="h3">{{ $ticket->data['subject'] }}</p>
                    <address>
                        Created: {{ $ticket->created_at->format('Y-m-d H:m') }}<br>
                        Author: {{ $ticket->author->name }}<br>
                        Author email: {{ $ticket->author->data['email']?? '' }}<br>
                    </address>
                </div>
                <!-- END Company Info -->
                <!-- Client Info -->
                <div class="col-6 text-right">
                    <p class="h5">Info</p>
                    <address>
                        Domains: {{ $ticket->domains_count() }}<br>
                        Ip: {{ $ticket->ip_addresses_count() }}<br>
                        Entries: {{ $ticket->in_scheme? 'yes' : 'no' }}<br>
                    </address>
                </div>
                <!-- END Client Info -->
            </div>
            <!-- END ticket Info -->
        </div>

    </div>
    <!-- END ticket -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Comments Attachments</h3>
        </div>
        <div class="block-content">
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Type</th>
                        <th class="text-center" style="width: 100px;">Size</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticket->comments_get_attachments() as $item)
                    <tr>
                        <th class="text-center" scope="row">{{ $item['id'] }}</th>
                        <td>
                            <a href="{{ $item['content_url'] }}" target="_blank" rel="noopener noreferrer">{{ $item['file_name'] }}</a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $item['content_type'] }}
                        </td>
                        <td class="text-center">
                            {{ $item['size'] }}
                        </td>
                    </tr>
                    @empty
                        no attachments
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-xl-3">
            <!-- Collapsible Inbox Navigation -->
            <div class="js-inbox-nav d-none d-md-block">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Domain</h3>
                    </div>
                    <div class="block-content">
                        <ul class="nav nav-pills flex-column push">
                            @forelse ($ticket->domains_order_rank() as $item)
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-between" href="javascript:void(0)" style="padding: .5rem 0;">
                                    <span>{{ $item->host }}</span>
                                    <span class="badge badge-pill badge-secondary">{{ $item->rank }}</span>
                                </a>
                            </li>
                            @empty
                            <li>no domains detected</li>
                            @endforelse
                            
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END Collapsible Inbox Navigation -->
            <div class="js-inbox-nav d-none d-md-block">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ip Addresses</h3>
                    </div>
                    <div class="block-content">
                        <ul class="nav nav-pills flex-column push">
                            @forelse ($ticket->ip_addresses as $item)
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-between" href="javascript:void(0)" style="padding: .5rem 0;">
                                    <span>{{ $item->ip }}</span>
                                </a>
                            </li>
                            @empty
                            <li>no domains detected</li>
                            @endforelse
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-xl-9">
            <!-- Message List -->
            <div class="block">
                <div class="block-header block-header-default">
                    <div class="block-title">
                        <strong>Message/Comments List</strong>
                    </div>
                </div>
                <div class="block-content">
                    <!-- Messages -->
                    {{ $dataTable->table() }}
                    <!-- END Messages -->
                </div>
            </div>
            <!-- END Message List -->
        </div>
    </div>
</div>
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
            /* $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); */

            $('body').on('click', 'td.icon-collapsed', function () {
                var tr = $(this).closest('tr');
                var row = myTable.row( tr );
        
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

            function format (data) {
                return data.details_content;
            }

            function htmlDecode(input) {
                var doc = new DOMParser().parseFromString(input, "text/html");
                return doc.documentElement.textContent;
            }
        })
    </script>
@endpush
