<?php

namespace App\DataTables;

use App\Models\Comment;
use App\Models\Ticket;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CommentsDataTable extends DataTable
{

    /**
     * @var App\Models\Ticket
     */
    private $ticket;

    public function __construct(Ticket $ticket=null) {
        $this->ticket = $ticket;
    }
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
            ->editColumn('author', function (Comment $model) {
                return Str::limit($model->author->name, 20, '...');
            })
            ->editColumn('created', function (Comment $model) {
                return (new Carbon($model->data['created_at']))->format('Y-m-d H:m');
            })
            /* ->editColumn('content', function (Comment $model) {
                return $model->data['html_body'];
            }) 
            */
            ->addColumn('details_content', 'components.tickets.html_body')
            ->rawColumns(['details_content']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Comment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Comment $model)
    {
        return $model->newQuery()
                    ->when(!empty($this->ticket), function ($query) {
                        $query->where('ticket_id', $this->ticket->api_id)
                                ->where('service_id', $this->ticket->service_id);
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
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
                    ->lengthMenu([
                        [ 10 , 25 , 50 , - 1 ],
                        [ '10 rows' , '25 rows' , '50 rows' , 'Show all' ]
                    ])
                    ->orderBy(2)
                    ->parameters([
                        'drawCallback' => 'function(e) { drawTableCallback(e) }',
                        'initComplete' => 'function() { myTable = window.LaravelDataTables["my-table"]; }',
                        /* 'responsive' => true,
                        'autoWidth' => false */
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
            Column::make('api_id')->addClass('icon-collapsed'),
            Column::make('author')->searchable(false)->orderable(false),
            Column::make('created')->searchable(false)->orderable(false),
            // Column::make('content')->searchable(false)->orderable(false)->className('none'),
        ];
        /* $table->unsignedBigInteger('api_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('author_id');
            $table->json('data')->nullable(); */
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Comments_' . date('YmdHis');
    }
}
