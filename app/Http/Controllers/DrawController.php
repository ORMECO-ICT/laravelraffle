<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\Datatables;
use App\Models\RaffleWinner;
use App\Models\Settings;
use App\DataTables\WinnersDataTable;
use App\Http\Requests\Draw\StoreRequest;

class DrawController extends Controller
{
    public const BASE = 'draw';

    public function __construct()
    {
        // $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(WinnersDataTable $dataTable)
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
            $query = \DB::table('raffle_prize')->select('*')->where('id', $prize_id)->first();

            $prize = [
                'code'=> $prize_id,
                'name'=> $query->prize_category . ' : ' . $query->prize_name,
                'items'=> [$query]
            ];
        }

        return $dataTable->render('draw.index', compact("venue", "prize"));

        // return response(view("draw.index", compact("dataTable")));
        // return $dataTable->render('draw.index');
    }


    private function getVenues()
    {
        $venues = \DB::table('venue')->select('*')->whereNot('venue_id', 'V00')->get();
        // $venues =  array_merge($venues->pluck('venue_id', 'venue_name')->toArray(), $towns->pluck('dist_code', 'district_desc')->toArray());
        $result = [];
        array_push($result, [
            'id' => '00',
            'name' => 'All Municipalities'
        ]);
        foreach($venues as $v)
        {
            array_push($result, [
                'id' => $v->venue_id,
                'name' => $v->venue_name
            ]);
        }
        $towns = \DB::table('tbl_town')->select('dist_code', 'district_desc')->groupBy('dist_code', 'district_desc')->orderBy('tranid')->get();
        foreach($towns as $v)
        {
            array_push($result, [
                'id' => $v->dist_code,
                'name' => $v->district_desc
            ]);
        }


        return $result;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function settings(): Response
    {
        $settings = Settings::where('code', 'PRIZE')->first();
        $settings_prize = $settings->value;
        $setter_prize = $settings->setter;

        $settings = Settings::where('code', 'VENUE')->first();
        $settings_venue = $settings->value == ''? '00' : $settings->value;
        $setter_venue = $settings->setter;

        // dd($setter_venue);

        $venues = $this->getVenues();
        return response(view("draw.settings", compact("venues", "settings_prize", "settings_venue", "setter_prize", "setter_venue")));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest  $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $settings = Settings::where('code', 'PRIZE')->first();
        if($settings->value != $validatedData['prize_id']){
            $settings->value = $validatedData['prize_id'];
            $settings->setter = \Auth::user()->email;
            $settings->update();
            // Settings::update($settings);
        }

        $settings = Settings::where('code', 'VENUE')->first();
        if($settings->value != $validatedData['venue_id']){
            $settings->value = $validatedData['venue_id'];
            $settings->setter = \Auth::user()->email;
            $settings->update();
            // Settings::update($settings);
        }

        return redirect()->route('draw.settings')->with('status', 'Settings saved successfully.');
    }
}
