<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\GoogleData;
use App\Models\ConsumerData;
use App\DataTables\GoogleDataTable;
use App\DataTables\RaffleEntriesDataTable;

class RegistrationController extends Controller
{
    public const BASE = 'registration';

    public function __construct()
    {
    }

    public function index(GoogleDataTable $dataTable, RaffleEntriesDataTable $dataTableRaffle)
    {

        $last = \DB::table('google_data')->select(\DB::raw('MAX(regdate) asof'))->first();
        $asof = $last->asof;
        return view('registration.index', [
            'dataTable' => $dataTable->html(),
            'dataTableRaffle' => $dataTableRaffle->html(),
            'dateAsOf' => $asof,
        ]);
    }


    public function ajaxData(GoogleDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = GoogleData::with('consumer_data')->select('google_data.*');

            return \DataTables::eloquent($model)
            ->addColumn('consumer_data', function (GoogleData $consumer) {
                if ($consumer->consumer_data)
                    return 'Verified';
                else
                    return '';
                // else{
                //     $code = $consumer->account_code;
                //     $name = $consumer->consumer_name;
                //     $town = $this->getTownDesc(substr($code, 0, 2));
                //     $contact = '';
                //     return view('verify.action-register', compact('code', 'name', 'town', 'contact'));
                // }
            })
            ->toJson();

            // return \DataTables::of(ConsumerAll::with('consumer_data')->select('consumer_all.*'))->toJson();
        }
    }


    public function ajaxRaffleEntries(RaffleEntriesDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = ConsumerData::select('consumer_data.*');

            return \DataTables::eloquent($model)
            ->toJson();

            // return \DataTables::of(ConsumerAll::with('consumer_data')->select('consumer_all.*'))->toJson();
        }
    }
}
