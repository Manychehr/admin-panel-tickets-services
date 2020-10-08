<?php

namespace App\DataTables;

use App\Models\Domain;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DomainsDataTable extends DataTable
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
            ->rawColumns(['host'])
            ->editColumn('created_at', function (Domain $model) {
                return $model->created_at->format('Y-m-d H:m');
            })
            ->editColumn('host', function (Domain $model) {
                return '<button type="button" class="btn btn-secondary showItem" data-toggle="modal" data-target="#modal_show_item" data-id="'
                . $model->id . '" style="width: 100%">'
                . $model->host .'</button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Domain $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Domain $model)
    {
        return $model->newQuery();
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
                    ->dom('lfrtip')
                    ->orderBy(2)
                    ->lengthMenu([[ 100, 250, 500], [ '100 rows', '250 rows', '500 rows']])
                    ->parameters([
                        'drawCallback' => 'function(e) { drawTableCallback(e) }',
                        'initComplete' => 'function() { myTable = window.LaravelDataTables["my-table"]; }',
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
            Column::make('host'),
            Column::make('rank'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Domains_' . date('YmdHis');
    }
}
