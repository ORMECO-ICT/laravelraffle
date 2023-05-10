<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Models\RaffleWinner;
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
            return DataTables::of(RaffleWinner::query())->toJson();
        }

        // return response(view("draw.index", compact("dataTable")));
        return $dataTable->render('draw.index');
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
