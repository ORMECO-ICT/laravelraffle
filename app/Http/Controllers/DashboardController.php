<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\RaffleWinner;
use App\Models\RaffleWinnerManual;
use App\Models\Settings;
use App\DataTables\WinnersDataTable;
use App\DataTables\ManualWinnersDataTable;
use App\DataTables\ManualRegistrationDataTable;
use Yajra\DataTables\Html\Column;

class DashboardController extends Controller
{
    public const BASE = 'dashboard';

    public function __construct()
    {
    }

    public function index(WinnersDataTable $dataTable, ManualWinnersDataTable $dataTableManual, ManualRegistrationDataTable $dataTableRegistration)
    {
        // if (request()->ajax()) {
        //     $model = RaffleWinner::with('raffle_prize')->select('raffle_winner.*');

        //     return \DataTables::eloquent($model)
        //     ->addColumn('raffle_prize', function(RaffleWinner $winner){
        //         return $winner->raffle_prize->prize_name;
        //     })
        //     ->toJson();
        //     // return \DataTables::of(RaffleWinner::query())->toJson();
        // }

        $setting = Settings::where('code', 'VENUE')->first();
        $venue_code = $setting->value == ''? '00' : $setting->value;
        if (\Str::startsWith($venue_code, 'V')){
            $query = \DB::table('venue')->select('*')->where('venue_id', $venue_code)->first();
            $towns = \DB::table('venue_town')->leftJoin('tbl_town', 'vt_town','=','town_code')->select('tbl_town.*')->where('vt_venue', $venue_code)->get();

            $venue = [
                'code'=> $venue_code,
                'name'=> $query->venue_name,
                'towns'=> $towns->pluck('town_desc'),
            ];
        }elseif ($venue_code=='00'){
            $query = \DB::table('tbl_town')->select('*')->get();

            $venue = [
                'code'=> $venue_code,
                'name'=> 'All Municipalities',
                'towns'=> $query->pluck('town_desc'),
            ];
        }else{
            $query = \DB::table('tbl_town')->select('*')->where('dist_code', $venue_code)->first();
            $towns = \DB::table('tbl_town')->select('*')->where('dist_code', $venue_code)->get();

            $venue = [
                'code'=> $venue_code,
                'name'=> $query->district_desc,
                'towns'=> $towns->pluck('town_desc'),
            ];
        }

        $setting = Settings::where('code', 'PRIZE')->first();
        $prize_id = $setting->value;
        if ($prize_id==''){
            $query = \DB::table('raffle_prize')->select('*')->get();
            $prize = [
                'code'=> $prize_id,
                'name'=> 'No prize is selected!',
                'items'=> $query,
            ];
        }else{
            // $query = \DB::table('raffle_prize')->select('*')->where('id', $prize_id)->first();
            $query = \DB::table('raffle_prize')->select('*')->where('id', $prize_id)->first();
            $items = \DB::table('raffle_prize')->select('*')->orderBy('prize_units')->get()->toArray();

            $prize = [
                'code'=> $prize_id,
                'name'=> $query->prize_category . ' : ' . $query->prize_name,
                'items'=> $items
            ];
        }

        $summary = \DB::select('SELECT v.venue_id, v.venue_name, count(*) cnt FROM venue v
        LEFT JOIN manual_registrations r ON r.venue_id=v.venue_id
        WHERE v.venue_id <> "V00"
        GROUP BY v.venue_id, v.venue_name');


        // return response(view("dashboard", compact("dataTable")));
        // return $dataTable->render('dashboard', compact("venue", "prize"));
        return view('dashboard', [
            'dataTable' => $dataTable->html(),
            'dataTableManual' => $dataTableManual->html(),
            'dataTableRegistration' => $dataTableRegistration->html()->columns([
                    Column::make('venue.venue_name')->title('Venue')->width('15%')->addClass('text-center'),
                    Column::make('account_code')->title('Account Number')->width('15%')->addClass('text-center'),
                    Column::make('consumer_name')->title('Name')->width('30%'),
                    Column::make('address')->width('40%'),
                    Column::computed('action')->title('Actions')->width('20%')->addClass('text-center'),
                ])->minifiedAjax( route('manual-registration.ajax-manual-registrations') ),
            'venue' => $venue,
            'prize' => $prize,
            'manual_summary' => $summary
        ]);
    }

    public function ajaxOnlineWinners(WinnersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = RaffleWinner::with('raffle_prize')->select('raffle_winner.*');

            return \DataTables::eloquent($model)
            ->addColumn('raffle_prize', function(RaffleWinner $winner){
                return $winner->raffle_prize->prize_name;
            })
            ->toJson();
            // return \DataTables::of(RaffleWinner::query())->toJson();
        }
    }

    public function ajaxManualRegistration(ManualRegistrationDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = ManualRegistration::with('venue')->select('manual_registrations.*');

            return \DataTables::eloquent($model)
            ->addColumn('action', function (ManualRegistration $consumer) {
                if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'register')
                    return \Livewire::mount('registration.manual-actions', ['consumer' => $consumer])->html();
                else
                    return '';
            })
            ->toJson();
        }
    }



}
