<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1b1b18] text-white p-10 min-h-screen flex items-center justify-center">
    @php
        $statusColor = [
            'draft'     => 'text-zinc-300',
            'published' => 'text-emerald-400',
            'completed' => 'text-sky-400',
        ][$activity->status] ?? 'text-zinc-300';
    @endphp

    <div class="max-w-2xl w-full">
        @include('partials.alerts')

        <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-lg shadow-xl">
            <a href="{{ route('activities.index') }}" class="text-sm text-zinc-400 hover:text-white mb-6 inline-block">&larr; Back to Archive</a>
            @if ($activity->poster_path)
                <img src="{{ $activity->posterUrl() }}" alt="Poster {{ $activity->title }}" class="w-full max-h-96 object-cover rounded-lg mb-6">
            @endif

            <div class="flex items-center gap-2">
                <span class="text-xs uppercase tracking-wider bg-zinc-800 text-zinc-300 px-2.5 py-1 rounded border border-zinc-700">{{ $activity->category->name }}</span>
                <span class="text-xs text-zinc-500">{{ $activity->code }}</span>
            </div>

            <h1 class="text-3xl font-bold mt-4 mb-2 text-white">{{ $activity->title }}</h1>
            <p class="text-sm mb-6">Status: <span class="font-semibold uppercase {{ $statusColor }}">{{ $activity->status }}</span></p>

            <dl class="grid grid-cols-2 gap-4 text-sm text-zinc-300 mb-6">
                <div><dt class="text-zinc-500">Mulai</dt><dd>{{ $activity->start_at?->format('d M Y, H:i') ?? '—' }}</dd></div>
                <div><dt class="text-zinc-500">Selesai</dt><dd>{{ $activity->end_at?->format('d M Y, H:i') ?? '—' }}</dd></div>
                <div><dt class="text-zinc-500">Lokasi</dt><dd>{{ $activity->location ?? '—' }}</dd></div>
                <div><dt class="text-zinc-500">Kapasitas</dt><dd>{{ $activity->capacity ?? '—' }}</dd></div>
            </dl>

            <div class="border-t border-zinc-800 pt-4 text-zinc-300">
                <p>{{ $activity->description }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-3 pt-6 mt-6 border-t border-zinc-800">
                @if ($activity->status === 'draft')
                    <form action="{{ route('activities.publish', $activity) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">Publish</button>
                    </form>
                @elseif ($activity->status === 'published')
                    <form action="{{ route('activities.complete', $activity) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-xs font-semibold hover:bg-sky-700 transition">Mark as Completed</button>
                    </form>
                @endif

                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('activities.edit', $activity) }}" class="px-3 py-1.5 border border-zinc-600 text-xs font-semibold rounded-lg text-zinc-200 hover:bg-zinc-800 transition">Edit Activity</a>

                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>