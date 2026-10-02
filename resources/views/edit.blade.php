<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Aktivitas — Through The Lenses.</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Stack+Sans+Headline:wght@200..700&family=Space+Grotesk:wght@400..600&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] antialiased min-h-screen flex flex-col justify-between p-6 lg:p-12">

  <div id="canvas" class="max-w-2xl mx-auto w-full">

    <nav class="navbar flex justify-between items-center py-4 border-b border-[#19140035] mb-12" id="navbar">
      <a href="/" class="wordmark font-bold tracking-wider">Through The Lenses.</a>
      <ul class="nav-links flex gap-6 text-sm">
        <li><a href="/" class="hover:underline">← Back to Archive</a></li>
      </ul>
    </nav>

    <main class="py-4">
      <h1 class="text-4xl font-serif font-bold mb-6">Edit Aktivitas</h1>

      @include('partials.alerts')

      <form action="{{ route('activities.update', $activity) }}" method="POST" class="space-y-6">
          @csrf
          @method('PUT')

          @include('partials.activity-form-fields')

          <div class="flex justify-end gap-4 pt-4">
              <a href="{{ route('activities.show', $activity) }}" class="px-6 py-3 border border-gray-300 rounded text-sm font-semibold hover:bg-gray-100 transition">Batal</a>
              <button type="submit" class="px-6 py-3 bg-black text-white rounded text-sm font-semibold hover:bg-gray-800 transition">Perbarui Aktivitas</button>
          </div>
      </form>
    </main>

  </div>

  <footer class="max-w-2xl mx-auto w-full pt-8 border-t border-[#19140035] flex justify-between text-xs text-gray-500">
    <span>Callista Rahma © 2026</span>
    <span>Informatics Engineering Student at Politeknik Negeri Bandung</span>
  </footer>

</body>
</html>