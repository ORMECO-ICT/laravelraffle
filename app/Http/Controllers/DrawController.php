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
            return \DataTables::of(RaffleWinner::query())->toJson();
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
                'name'=> $query->prize_name,
                'items'=> [$query]
            ];
        }

        return $dataTable->render('draw.index', compact("venue", "prize"));

        // return response(view("draw.index", compact("dataTable")));
        // return $dataTable->render('draw.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function success(): Response
    {
        return response(view("draw.index"));
    }




    // public function ajax_source_winners(): JsonResponse
    // {
    //     // if ($request->ajax()) {
    //     //     $data = Blog::select('*');
    //     //     return Datatables::of($data)
    //     //         ->addIndexColumn()
    //     //         ->addColumn('action', function($row){
    //     //             $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
    //     //             return $actionBtn;
    //     //         })
    //     //         ->rawColumns(['action'])
    //     //         ->make(true);
    //     // }

    //     if(!Request::ajax()){
    //         abort(403);
    //     }

    //     $json = Datatables()->of(RaffleWinner::select('*'))
    //         // ->addColumn('action', 'company-action')
    //         // ->rawColumns(['action', 'edit'])
    //         // ->addIndexColumn()
    //         ->make(true);
    //     // dd($json);
    //     return $json;
    // }
}
