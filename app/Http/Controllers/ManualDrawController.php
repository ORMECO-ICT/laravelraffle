<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\RaffleWinnerManual;
use App\Models\Settings;
use App\DataTables\ManualWinnersDataTable;

use App\Http\Requests\ManualDraw\StoreRequest;

class ManualDrawController extends Controller
{
    public const BASE = 'manual-draw';

    public function __construct()
    {
    }

    public function index(ManualWinnersDataTable $dataTable)
    {
        // if (request()->ajax()) {
        //     $model = RaffleWinnerManual::with('raffle_prize')->with('venue')->select('raffle_winner_manual.*');

        //     return \DataTables::eloquent($model)
        //     ->addColumn('raffle_prize', function(RaffleWinnerManual $winner){
        //         return $winner->raffle_prize->prize_name;
        //     })
        //     ->addColumn('venue', function(RaffleWinnerManual $winner){
        //         return $winner->venue->venue_name;
        //     })
        //     ->toJson();
        //     // return \DataTables::of(RaffleWinnerManual::query())->toJson();
        // }

        $venue = $this->getVenue();

        return $dataTable->render('manual-draw.index', compact("venue"));
    }

    private function getVenue()
    {
        $user = \Auth::user();
        $venue_code =  $user->venue_id;
        if ($user->venue_id == ''){
            $venue = [
                'code'=> '',
                'name'=> 'Contact admin for assignment of venue!',
                'towns'=> [],
            ];
        }elseif(\Str::startsWith($venue_code, 'V')){
            $query = \DB::table('venue')->select('*')->where('venue_id', $venue_code)->first();
            $towns = \DB::table('venue_town')->leftJoin('tbl_town', 'vt_town','=','town_code')->select('tbl_town.*')->where('vt_venue', $venue_code)->get();

            $venue = [
                'code'=> $venue_code,
                'name'=> $query->venue_name,
                'towns'=> $towns->pluck('town_desc'),
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
        return $venue;
    }

    public function ajaxTambioloWinners(ManualWinnersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $user = \Auth::user();
            $venue_id =  $user->venue_id;
            $model = RaffleWinnerManual::with('raffle_prize')->with('venue')->select('raffle_winner_manual.*');
            if($venue_id != '')
                $model = $model->where('venue_id', $venue_id);

            return \DataTables::eloquent($model)
            ->addColumn('raffle_prize', function(RaffleWinnerManual $winner){
                return $winner->raffle_prize->prize_name;
            })
            ->addColumn('venue', function(RaffleWinnerManual $winner){
                return $winner->venue->venue_name;
            })
            ->toJson();
            // return \DataTables::of(RaffleWinnerManual::query())->toJson();
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $venue = $this->getVenue();
        return response(view("manual-draw.create", compact("venue")));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest  $request): RedirectResponse
    {
        $validatedData = $request->validated();
        // dd($validatedData);
        // $validatedData['password'] = bcrypt($validatedData['password']);
        $portal = RaffleWinnerManual::create($validatedData);
        return redirect()->route('manual-draw.')->with('status', 'Record saved successfully.');
    }

}
