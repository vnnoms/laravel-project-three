<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(private ActivityService $activityService)
    {
    }

    public function index(Request $request)
    {
        $activities = Activity::query()
            ->with('category')
            ->search($request->query('search'))
            ->filterCategory($request->query('category_id'))
            ->filterStatus($request->query('status'))
            ->sortByStart($request->query('sort'))
            ->paginate(10)
            ->withQueryString();

        $categories = Category::ordered()->get();
        $statuses = Activity::STATUSES;

        return view('index', compact('activities', 'categories', 'statuses'));
    }

    public function show(Activity $activity)
    {
        return view('show', compact('activity'));
    }

    public function create()
    {
        $categories = Category::ordered()->get();

        return view('create', compact('categories'));
    }

    public function store(StoreActivityRequest $request)
    {
        $this->activityService->create(
            $request->safe()->except('poster'),
            $request->file('poster')
        );

        return redirect()->route('activities.index')->with('success', 'New activity has been added');
    }

    public function edit(Activity $activity)
    {
        $categories = Category::ordered()->get();

        return view('edit', compact('activity', 'categories'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $this->activityService->update(
            $activity,
            $request->safe()->except('poster'),
            $request->file('poster')
        );

        return redirect()->route('activities.index')->with('success', 'Activity has been updated');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity has been deleted');
    }

    public function publish(Activity $activity)
    {
        $this->activityService->publish($activity);

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dipublikasikan.');
    }

    public function complete(Activity $activity)
    {
        $this->activityService->complete($activity);

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Kegiatan ditandai selesai.');
    }

    public function trash()
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('trash', compact('activities'));
    }

    public function restore(int $id)
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()->route('activities.trash')
            ->with('success', 'Kegiatan berhasil dipulihkan.');
    }
}