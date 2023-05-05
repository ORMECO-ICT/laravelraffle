<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

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
    public function index(): Response
    {
        return response(view("draw.index"));
    }

    /**
     * Display a listing of the resource.
     */
    public function success(): Response
    {
        return response(view("draw.index"));
    }

}
