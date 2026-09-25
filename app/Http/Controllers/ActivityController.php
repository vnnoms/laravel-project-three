<?php

namespace App\Http\Controllers;

use App\Models\Activity; 
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;

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

        return redirect()->route('activities.index')->with('success', 'New activity has been added');
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());
        return redirect()->route('activities.index')->with('success', 'New activity has been updated');
    }

    public function create()
    {
        return view('create');
    }

    public function edit(Activity $activity)
    {
        return view('edit', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity has been deleted');
    }
}