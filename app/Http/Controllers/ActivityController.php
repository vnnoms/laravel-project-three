<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;

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

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());
        return redirect()->route('activities.index')->with('success', 'Aktivitas berhasil diperbarui!');
    }

    public function create()
    {
        return view('create');
    }

    public function edit(Activity $activity)
    {
        return view('edit', compact('activity'));
    }
}
