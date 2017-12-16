<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoonApplicationRequest;
use App\SoonApplication;
use Illuminate\Http\Request;

class SoonApplicationController extends Controller
{

    public function create($term)
    {
        $user = auth()->user();

        $application = SoonApplication
            ::where('user_id', $user->id)
            ->where('term', $term)
            ->get();




        return $application->count() ?
            view('soon-application.already-registered', ['application' => $application[0]]) :
            view('soon-application.register', compact('term'));

    }

    public function store(SoonApplicationRequest $request)
    {
        auth()->user()->soon_applications()->create($request->all());

        return view('soon-application.registered', $request->all());
    }


}
