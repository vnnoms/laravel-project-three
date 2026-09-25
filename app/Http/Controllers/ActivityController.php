<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityRequest;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        return view('show', compact('activity'));
    }

    public function store(StoreActivityRequest $request)
    {
        Activity::create($request->validated());

        return redirect()->route('activities.index')->with('success', 'Aktivitas berhasil ditambahkan!');
    }
}
