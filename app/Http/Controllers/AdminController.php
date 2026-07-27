<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    // بەستەری بنەڕەتی داتابەیسی فایەربەیسەکەت
    private $firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';

    // ==========================================
    // بەشی سەرەکی و لۆگین
    // ==========================================
    public function index()
    {
        return view('home');
    }

    public function showLogin()
    {
        return view('login');
    }


    // ==========================================
    // بەشی کۆرسەکان (Courses)
    // ==========================================
    public function showCourses()
    {
        $response = Http::get($this->firebaseUrl . 'courses.json');
        $courses = $response->json();
        return view('courses_list', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'courses.json', $data);
        return redirect()->back()->with('success', 'کۆرسەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyCourse($id)
    {
        Http::delete($this->firebaseUrl . 'courses/' . $id . '.json');
        return redirect()->back()->with('success', 'کۆرسەکە بە سەرکەوتوویی سڕایەوە!');
    }

    // --- بەشی دەستکاری کۆرسەکان ---
    public function editCourse($id)
    {
        $response = Http::get($this->firebaseUrl . 'courses/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'course']);
    }

    public function updateCourse(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'courses/' . $id . '.json', $data);
        return redirect('/courses')->with('success', 'کۆرسەکە بە سەرکەوتوویی نوێکرایەوە!');
    }

    // --- بەشی دەستکاری ئامرازەکانی AI ---
    public function editAiTool($id)
    {
        $response = Http::get($this->firebaseUrl . 'ai_tools/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'ai_tool']);
    }

    public function updateAiTool(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'ai_tools/' . $id . '.json', $data);
        return redirect('/ai-tools')->with('success', 'ئامرازەکە بە سەرکەوتوویی نوێکرایەوە!');
    }

    // --- بەشی دەستکاری ڕێنیشاندەر ---
    public function editAcademicGuide($id)
    {
        $response = Http::get($this->firebaseUrl . 'academic_guide/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'academic_guide']);
    }

    public function updateAcademicGuide(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'academic_guide/' . $id . '.json', $data);
        return redirect('/academic-guide')->with('success', 'پرسیارەکە بە سەرکەوتوویی نوێکرایەوە!');
    }

   


    // ==========================================
    // بەشی ئامرازەکانی ژیری دەستکرد (AI Tools)
    // ==========================================
    public function showAiTools()
    {
        $response = Http::get($this->firebaseUrl . 'ai_tools.json');
        $aiTools = $response->json();
        return view('ai_tools', compact('aiTools'));
    }

    public function storeAiTool(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'ai_tools.json', $data);
        return redirect()->back()->with('success', 'ئامرازەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyAiTool($id)
    {
        Http::delete($this->firebaseUrl . 'ai_tools/' . $id . '.json');
        return redirect()->back()->with('success', 'ئامرازەکە بە سەرکەوتوویی سڕایەوە!');
    }




    // ==========================================
    // بەشی ڕێنیشاندەری ئەکادیمی (Academic Guide)
    // ==========================================
    public function showAcademicGuide()
    {
        $response = Http::get($this->firebaseUrl . 'academic_guide.json');
        $faqs = $response->json();
        return view('academic_guide', compact('faqs'));
    }

    public function storeAcademicGuide(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'academic_guide.json', $data);
        return redirect()->back()->with('success', 'پرسیارەکە بە سەرکەوتوویی زیادکرا!');
    }

    public function destroyAcademicGuide($id)
    {
        Http::delete($this->firebaseUrl . 'academic_guide/' . $id . '.json');
        return redirect()->back()->with('success', 'پرسیارەکە بە سەرکەوتوویی سڕایەوە!');
    }

// ==========================================
    // بەشی فێرگە (Ferga - Learning Platform)
    // ==========================================
    public function showFerga()
    {
        // هێنانی زانیارییەکانی فێرگە لە فایەربەیسەوە بۆ ئەگەری بەکارهێنانی لە باکێند
        $response = Http::get($this->firebaseUrl . 'ferga_lessons.json');
        $lessons = $response->json();
        
        return view('ferga', compact('lessons'));
    }

    public function destroyFergaLesson($id)
    {
        Http::delete($this->firebaseUrl . 'ferga_lessons/' . $id . '.json');
        return redirect()->back()->with('success', 'وانەکە بە سەرکەوتوویی سڕایەوە!');
    }
}