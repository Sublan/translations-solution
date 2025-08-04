<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        return Language::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:languages',
            'name' => 'required'
        ]);
        return Language::create($request->all());
    }

    public function show(Language $language)
    {
        return $language;
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'code' => 'required|unique:languages,code,' . $language->id,
            'name' => 'required'
        ]);
        $language->update($request->all());
        return $language;
    }

    public function restore($id)
    {
        Language::withTrashed()->findOrFail($id)->restore();
        return response()->noContent();
    }

    public function forceDelete($id)
    {
        Language::withTrashed()->findOrFail($id)->forceDelete();
        return response()->noContent();
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return response()->noContent();
    }
}
