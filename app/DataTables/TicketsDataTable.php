<?php

namespace App\DataTables;

use App\Models\Ticket;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class TicketsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->setFilteredRecords(100)
            ->filterColumn('domains_count', function($query, $value) {
                $query->whereHas('domains', function ($query) use ($value) {
                   // $query->where('steam_room_id', '=', $values);
                    $query->where('host', 'like', "%{$value}%");
                });
            })
            ->filterColumn('ip_addresses_count', function($query, $value) {
                $query->whereHas('ip_addresses', function ($query) use ($value) {
                   $query->where('ip', '=', $value);
                });
            })
            ->filterColumn('author', function($query, $value) {
                $query->whereHas('author', function ($query) use ($value) {
                    if (strpos($value, '@') === false) {
                        $query->where('name', 'like', "%{$value}%");
                    } else {
                        $query->where('email', 'like', "%{$value}%");
                    }
                });
            })

            ->setRowAttr([
                'style' => function(Ticket $model) {
                    if ($model->in_scheme) {
                        return 'background-color: #fae9e8!important';
                    }
                    return '';
                },
            ])
            ->addColumn('action', 'tickets.action')
            ->editColumn('created_at', function (Ticket $model) {
                // return (new Carbon($model->data['created_at']))->format('Y-m-d H:m');
                return $model->created_at->format('Y-m-d H:m');
            })
            ->editColumn('title', function (Ticket $model) {
                return '<a href="' . route('tickets.full-show', $model->id) . '" target="_blank">' . Str::limit($model->data['subject'], 20, ' (...)') . '</a>';
            })
            ->editColumn('author', function (Ticket $model) {
                return Str::limit($model->author->name, 20, '...');
            })
            ->rawColumns(['action', 'title']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Ticket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ticket $model)
    {
        return $model->newQuery()->where('show', true)->withCount('domains')->withCount('ip_addresses');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('my-table')
                    ->addTableClass('table table-bordered table-striped table-vcenter')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('rtip')
                    ->orderBy(0)
                    // ->lengthMenu([[ 100, 250, 500], [ '100 rows', '250 rows', '500 rows']])
                    ->parameters([
                        'drawCallback' => 'function(e) { drawTableCallback(e) }',
                        'initComplete' => 'function() { myTable = window.LaravelDataTables["my-table"]; }',
                        /* 'initComplete' => 'function(settings, json) { 
                            myTable = window.LaravelDataTables["my-table"]; 
                            console.log(settings, json);
                            this.api().columns().every(function () {
                                var column = this;
                                if(settings.aoColumns[column[0][0]].searchable) {
                                    var input = document.createElement("input");
                                    $(input).appendTo( $(column.footer()).empty() ).on("change", function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                                }
                            });
                        }', */
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            
            Column::make('api_id')->title('Id')->searchable(false),
            Column::make('author')->title('Author')->orderable(false),
            Column::make('title')->searchable(false)->searchable(false)->orderable(false),
            Column::make('created_at')->title('Date')
                    ->searchable(false),
            Column::make('domains_count')->title('Domains')->orderable(false),
            Column::make('ip_addresses_count')->title('Ip'),
            Column::computed('action')
                    ->searchable(false)
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Tickets_' . date('YmdHis');
    }
}
