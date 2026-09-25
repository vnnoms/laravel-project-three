<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity has been deleted');
    }
}
