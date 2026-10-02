<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trash — Through The Lenses.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] antialiased min-h-screen p-6 lg:p-12">
  <div class="max-w-3xl mx-auto w-full">
    <a href="{{ route('activities.index') }}" class="text-sm hover:underline">← Back to Archive</a>
    <h1 class="text-4xl font-serif font-bold my-6">Trash</h1>

    @include('partials.alerts')

    <table class="w-full text-sm">
      <thead>
        <tr class="text-left border-b border-gray-300">
          <th class="py-2">Kode</th><th>Judul</th><th>Kategori</th><th>Dihapus</th><th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($activities as $activity)
        <tr class="border-b border-gray-200">
          <td class="py-2">{{ $activity->code }}</td>
          <td>{{ $activity->title }}</td>
          <td>{{ $activity->category->name }}</td>
          <td>{{ $activity->deleted_at->format('d M Y H:i') }}</td>
          <td class="text-right">
            <form action="{{ route('activities.restore', $activity->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn-edit">Restore</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="py-6 text-center text-gray-500">Trash kosong.</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">{{ $activities->links() }}</div>
  </div>
</body>
</html>