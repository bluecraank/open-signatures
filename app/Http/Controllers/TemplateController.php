<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'html_content' => 'required',
            'plain_text_content' => 'required',
        ]);

        $request->merge(['created_by' => Auth::user()->name]);

        Template::create($request->only(['name', 'html_content', 'plain_text_content', 'created_by']));

        return redirect()->route('templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function edit(Template $template)
    {
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required',
            'html_content' => 'required',
            'plain_text_content' => 'required',
        ]);

        $template->update($request->only(['name', 'html_content', 'plain_text_content']));

        return redirect()->route('templates.index')
            ->with('success', 'Template updated successfully');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('templates.index')
            ->with('success', 'Template deleted successfully');
    }
}
