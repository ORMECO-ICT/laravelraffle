<?php

namespace App\DataTables;

use App\Models\RaffleWinner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WinnersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'winners.action')
            ->addColumn('raffle_prize', function(RaffleWinner $winner){
                return $winner->raffle_prize->prize_name;
            })
            ->setRowId('win_draw');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RaffleWinner $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table_raffle_winner')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
                    //->dom('Bfrtip')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
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
            Column::make('win_draw')->title('Draw')->width('5%')->addClass('text-center'),
            Column::make('account_code')->title('Account')->width('15%')->addClass('text-center'),
            Column::make('consumer_name')->title('Name')->width('25%'),
            Column::make('address')->width('30%'),
            Column::computed('raffle_prize')
                ->title('Prize')->width('20%')->addClass('text-center'),
                // Column::make('raffle_prize.prize_name')
                //     ->title('Prize')->width('20%')->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Winners_' . date('YmdHis');
    }
}
