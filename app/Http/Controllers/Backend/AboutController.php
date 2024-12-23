<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:list-about-us')->only('index');
        $this->middleware('can:create-about-us')->only('store');
        $this->middleware('can:edit-about-us')->only('update');
        $this->middleware('can:delete-about-us')->only('destroy');
    }

    public function index(Request $request)
    {
        $aboutUs = About::query();
        if ($request->title) {
            $aboutUs = $aboutUs->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->description) {
            $aboutUs = $aboutUs->where('description', 'like', '%' . $request->description . '%');
        }
        $aboutUs = $aboutUs->get();
        return view('backend.pages.about-us.index', compact('aboutUs'));
    }


    public function create()
    {
        return view('backend.pages.about-us.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'sub_title' => 'nullable',
            'short_description' => 'nullable',
            'description' => 'required',
            'about_course_desc' => 'nullable',
        ]);

        $about = About::create($validated);

        if ($about) {
            toast('About Us created successfully!', 'success');
            return redirect()->route('about-us.index');
        } else {
            toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $about = About::find($id)->select('id', 'title', 'sub_title', 'short_description', 'description', 'about_course_desc')->first();
        return view('backend.pages.about-us.edit', compact('about'));
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'sub_title' => 'nullable',
            'short_description' => 'nullable',
            'description' => 'required',
            'about_course_desc' => 'nullable',
        ]);

        $about = About::where('id', $request->id)->update($validated);

        if ($about) {
            toast('About Us updated successfully!', 'success');
            return redirect()->route('about-us.index');
        } else {
            toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $about = About::find($id);
        $about->delete();
        if ($about) {
            toast('About Us deleted successfully!', 'success');
            return redirect()->route('about-us.index');
        } else {
            toast('Something went wrong!', 'error');
            return redirect()->back();
        }
    }
}
