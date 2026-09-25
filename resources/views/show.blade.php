<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1b1b18] text-white p-10 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full bg-zinc-900 border border-zinc-800 p-8 rounded-lg shadow-xl">
        <a href="/" class="text-sm text-zinc-400 hover:text-white mb-6 inline-block">&larr; Back to Home</a>
        
        <span class="text-xs uppercase tracking-wider bg-zinc-800 text-zinc-300 px-2.5 py-1 rounded border border-zinc-700">{{ $activity->category }}</span>
        <h1 class="text-3xl font-bold mt-4 mb-2 text-white">{{ $activity->title }}</h1>
        <p class="text-zinc-400 text-sm mb-6">{{ $activity->activity_date }} — <span class="font-semibold text-emerald-400">{{ $activity->status }}</span></p>
        
        <div class="border-t border-zinc-800 pt-4 text-zinc-300">
            <p>{{ $activity->description }}</p>
        </div>
    </div>

    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('You sure you want to delete this?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded text-sm font-semibold hover:bg-red-700 transition">
        Delete Activity
    </button>
    </form>
</body>
</html>