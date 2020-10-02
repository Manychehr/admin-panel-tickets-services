<?php

namespace App\DataTables;

use App\Models\ApiTicket;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ApiTicketDataTable extends DataTable
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
            ->addColumn('action', 'components.crud_buttons');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\ApiTicket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ApiTicket $model)
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
                    ->orderBy(0)
                    ->lengthMenu([[ 10, 25, 50, - 1], [ '10 rows', '25 rows', '50 rows', 'Show all']])
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
            Column::make('name'),
            Column::make('service'),
            Column::make('subdomain'),
            Column::computed('action', 'ACTIONS')
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
        return 'ApiTicket_' . date('YmdHis');
    }
}
