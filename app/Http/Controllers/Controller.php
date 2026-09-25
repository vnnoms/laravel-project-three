<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function show(Activity $activity)
{
    return view('activities.show', compact('activity'));
}
}
