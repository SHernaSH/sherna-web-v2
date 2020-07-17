<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 *
 * Class to show the index page of administration
 */
class AdminController extends Controller
{
    /**
     * Show the view for the base bage of administration
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return view('admin.index');
    }
}
