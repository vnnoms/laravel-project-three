<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('activities')->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function destroy(Category $category)
    {
        if ($category->isInUse()) {
            return redirect()->route('categories.index')
                ->with('error', "Kategori \"{$category->name}\" tidak dapat dihapus karena masih digunakan oleh kegiatan.");
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}