<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\UsersDataTable;

class UsersController extends Controller
{
    public const BASE = 'users';

    public function __construct()
    {
    }

    public function index(UsersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $model = User::select('*');

            return \DataTables::eloquent($model)
            ->addColumn('action', function (User $user) {
                // return view('users.manage-status', compact('user'));
                return \Livewire::mount('users.approval', ['user' => $user])->html();
            })
            ->addColumn('pass', function (User $user) {
                return \Livewire::mount('users.password', ['user' => $user])->html();
            })
            ->editColumn('created_at', function (User $outcome) {
                return \Carbon\Carbon::parse($outcome->created_at )->isoFormat('MM/DD/YYYY hh:mm A');
            })
            ->rawColumns(['action', 'pass'])
            ->toJson();

            // return \DataTables::of(ConsumerAll::with('consumer_data')->select('consumer_all.*'))->toJson();
        }

        return $dataTable->render('users.index');
    }
}
