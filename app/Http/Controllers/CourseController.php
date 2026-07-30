<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // ١. پشکنینی وێنەکە
    if ($request->hasFile('course_image')) {
        // ئەپلۆدکردنی وێنەکە بۆ فۆڵدەری public/courses
        $imagePath = $request->file('course_image')->store('courses', 'public');
    } else {
        $imagePath = null;
    }

    // ٢. پاشەکەوتکردنی داتا لە داتابەیس
    Course::create([
        'title' => $request->title,
        'description' => $request->description,
        'video_url' => $request->video_url,
        'price' => $request->price,
        'image_url' => $imagePath, // لێرە ڕێگای وێنەکە پاشەکەوت دەکەین
    ]);

    return back()->with('success', 'کۆرسەکە بە سەرکەوتوویی زیادکرا!');
}

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
