<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function getLocales()
    {
        return Language::pluck('code')->toArray();
    }

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->tag) {
            $query->where('tag', $request->tag);
        }

        if ($request->key) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        if ($request->search) {
            $locales = $this->getLocales();
            $query->where(function ($q) use ($request, $locales) {
                foreach ($locales as $locale) {
                    $q->orWhereRaw("JSON_EXTRACT(name, '$." . $locale . "') LIKE ?", ['%' . $request->search . '%'])
                        ->orWhereRaw("JSON_EXTRACT(description, '$." . $locale . "') LIKE ?", ['%' . $request->search . '%']);
                }
            });
        }

        return $query->paginate(100);
    }

    public function store(Request $request)
    {
        $locales = $this->getLocales();

        $request->validate([
            'key' => 'required|unique:categories',
            'name.en' => 'required',
            'description.en' => 'required',
            'tag' => 'required|in:web,mobile,desktop'
        ]);

        $name = [];
        $description = [];

        foreach ($locales as $locale) {
            $name[$locale] = $request->name[$locale] ?? $request->name['en'];
            $description[$locale] = $request->description[$locale] ?? $request->description['en'];
        }

        return Category::create([
            'key' => $request->key,
            'tag' => $request->tag,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name.en' => 'required',
            'description.en' => 'required'
        ]);

        $name = $category->name;
        $description = $category->description;

        foreach ($this->getLocales() as $locale) {
            if (isset($request->name[$locale])) {
                $name[$locale] = $request->name[$locale];
            }
            if (isset($request->description[$locale])) {
                $description[$locale] = $request->description[$locale];
            }
        }

        $category->update([
            'name' => $name,
            'description' => $description,
            'tag' => $request->tag ?? $category->tag
        ]);

        return $category;
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function exportByTag($tag)
    {
        return Category::where('tag', $tag)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => [
                    'name' => $item->name,
                    'description' => $item->description,
                    'tag' => $item->tag
                ]];
            });
    }

    public function exportAll()
    {
        return Category::all()->mapWithKeys(function ($item) {
            return [$item->key => [
                'name' => $item->name,
                'description' => $item->description,
                'tag' => $item->tag
            ]];
        });
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return response()->noContent();
    }

    public function forceDelete($id)
    {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return response()->noContent();
    }
}
