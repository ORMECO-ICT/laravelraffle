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
            // $model = ConsumerAll::with('consumer_data')->select('consumer_all.*');
            $model = ConsumerAll::with('manual_registration')->select('consumer_all.*');

            return \DataTables::eloquent($model)
            // ->addColumn('consumer_data', function (ConsumerAll $consumer) {
            //     if ($consumer->consumer_data)
            //         return 'Registered';
            //     else{
            //         $code = $consumer->account_code;
            //         $name = $consumer->consumer_name;
            //         $town = $this->getTownDesc(substr($code, 0, 2));
            //         $contact = '';
            //         return view('verify.action-register', compact('code', 'name', 'town', 'contact'));
            //     }
            // })
            ->addColumn('action', function (ConsumerAll $consumer) {
                if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'register')
                    return \Livewire::mount('registration.manual-register', ['consumer' => $consumer])->html();
                else{
                    if($consumer->manual_registration)
                    return 'Registered';
                    else
                    return '';
                }
            })
            ->toJson();

            // return \DataTables::of(ConsumerAll::with('consumer_data')->select('consumer_all.*'))->toJson();
        }

        return $dataTable->render('verify.index');
    }

    public function getTownDesc($town_code){
        switch ($town_code) {
            case '01': return 'Puerto Galera';
            case '02': return 'San Teodoro';
            case '03': return 'Baco';
            case '04': return 'Calapan';
            case '05': return 'Naujan';
            case '06': return 'Victoria';
            case '07': return 'Socorro';
            case '08': return 'Pola';
            case '09': return 'Pinamalayan';
            case '10': return 'Gloria';
            case '11': return 'Bansud';
            case '12': return 'Bongabong';
            case '13': return 'Roxas';
            case '14': return 'Mansalay';
            case '15': return 'Bulalacao';
            default:
              return 'Calapan';
          }
    }
}
