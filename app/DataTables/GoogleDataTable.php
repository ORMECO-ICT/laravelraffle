<?php

namespace App\DataTables;

use App\Models\GoogleData;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GoogleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'consumers.action')
            ->setRowId('id')
            ;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(GoogleData $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table_google_data')
                    ->columns($this->getColumns())
                    // ->minifiedAjax()
                    ->minifiedAjax( route('registration.ajax-data') )
                    ->searchDelay(1000)
                    //->dom('Bfrtip')
                    ->orderBy(1, 'asc')
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('add'),
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                        // Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    ;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            // Column::make('account_no')->title('No')->width('5%')->addClass('text-center'),
            Column::make('account_code')->title('Account Number')->width('15%')->addClass('text-center'),
            Column::make('consumer_name')->title('Name')->width('35%'),
            Column::make('address')->width('50%'),
            Column::computed('consumer_data')
                ->exportable(false)
                ->printable(false)
                ->title('Account')->width('10%')->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Google_forms_data_' . date('YmdHis');
    }
}
