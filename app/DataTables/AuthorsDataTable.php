<?php

namespace App\DataTables;

use App\Models\Author;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class AuthorsDataTable extends DataTable
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
            ->addColumn('action', 'components.author.crud_buttons')
            ->editColumn('service_id', function (Author $model) {
                return $model->service->name;
            })
            ->removeColumn('data');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Author $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Request $request, Author $model)
    {
        return $model->newQuery()
                    ->when($request->has('show_tickets'), function ($query) {
                        $query->where('show_tickets', false);
                    });
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
            Column::make('api_id'),
            Column::make('service_id'),
            Column::make('name'),
            Column::make('email'),
            Column::computed('action')
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
        return 'Authors_' . date('YmdHis');
    }
}
