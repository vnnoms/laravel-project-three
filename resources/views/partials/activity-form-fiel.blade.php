@php
    $a = $activity ?? null;
    $input = 'w-full border border-gray-300 rounded p-3 text-sm focus:outline-none focus:border-black';
    $label = 'block text-sm font-semibold uppercase tracking-wider mb-2';
@endphp

<div>
    <label class="{{ $label }}">Kategori</label>
    <select name="category_id" required class="{{ $input }} bg-white">
        <option value="">— Pilih kategori —</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $a?->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="{{ $label }}">Kode Kegiatan</label>
    <input type="text" name="code" value="{{ old('code', $a?->code) }}" required class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Judul Aktivitas</label>
    <input type="text" name="title" value="{{ old('title', $a?->title) }}" required class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Tanggal Mulai</label>
    <input type="datetime-local" name="start_at" value="{{ old('start_at', $a?->start_at?->format('Y-m-d\TH:i')) }}" class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Tanggal Selesai</label>
    <input type="datetime-local" name="end_at" value="{{ old('end_at', $a?->end_at?->format('Y-m-d\TH:i')) }}" class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Lokasi</label>
    <input type="text" name="location" value="{{ old('location', $a?->location) }}" class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Kapasitas (1–500)</label>
    <input type="number" name="capacity" min="1" max="500" value="{{ old('capacity', $a?->capacity) }}" class="{{ $input }}">
</div>

<div>
    <label class="{{ $label }}">Deskripsi</label>
    <textarea name="description" rows="4" class="{{ $input }}">{{ old('description', $a?->description) }}</textarea>
</div>