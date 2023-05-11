<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\ConsumerAll;
use App\Models\ConsumerData;
use App\DataTables\ConsumersDataTable;

class VerifyController extends Controller
{

    public const BASE = 'verify';

    public function __construct()
    {
        // $consumer = ConsumerAll::where('account_code', '11-50080-1528')->first();
        // dd($consumer->entry);
    }

    public function index(ConsumersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = ConsumerAll::with('consumer_data')->select('consumer_all.*');

            return \DataTables::eloquent($model)
            ->addColumn('consumer_data', function (ConsumerAll $consumer) {
                if ($consumer->consumer_data)
                    return 'Registered';
                else
                    return '';
            })
            ->toJson();

            // return \DataTables::of(ConsumerAll::with('consumer_data')->select('consumer_all.*'))->toJson();
        }

        return $dataTable->render('verify.index');
    }
}
