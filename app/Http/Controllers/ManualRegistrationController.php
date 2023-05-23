<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\ManualRegistration;
use App\DataTables\ManualRegistrationDataTable;

class ManualRegistrationController extends Controller
{
    public const BASE = 'manual-registration';
    /**
     * Display a listing of the resource.
     */
    public function index(ManualRegistrationDataTable $dataTable)
    {
        $venue = $this->getVenue();

        return $dataTable->render('manual-registration.index', compact("venue"));
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


    public function ajaxManualRegistration(ManualRegistrationDataTable $dataTable)
    {
        if (request()->ajax()) {
            $user = \Auth::user();
            $venue_id =  $user->venue_id;
            $model = ManualRegistration::with('venue')->select('manual_registrations.*');
            if($venue_id != '')
                $model = $model->where('venue_id', $venue_id);

            return \DataTables::eloquent($model)
            ->addColumn('action', function (ManualRegistration $consumer) {
                return \Livewire::mount('registration.manual-actions', ['consumer' => $consumer])->html();

            })
            ->toJson();
        }
    }
}
