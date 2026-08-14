<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    // Ø¨Û•Ø³ØªÛ•Ø±ÛŒ Ø¨Ù†Û•Ú•Û•ØªÛŒ Ø¯Ø§ØªØ§Ø¨Û•ÛŒØ³ÛŒ ÙØ§ÛŒÛ•Ø±Ø¨Û•ÛŒØ³Û•Ú©Û•Øª
    private $firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';

    // ==========================================
    // Ø¨Û•Ø´ÛŒ Ø³Û•Ø±Û•Ú©ÛŒ Ùˆ Ù„Û†Ú¯ÛŒÙ†
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
    // Ø¨Û•Ø´ÛŒ Ú©Û†Ø±Ø³Û•Ú©Ø§Ù† (Courses)
    // ==========================================
    public function showCourses()
    {
        $url = $this->firebaseUrl;
        $courses = Cache::remember('firebase.courses.v1', now()->addMinutes(5), function () use ($url) {
            return Http::timeout(5)->get($url . 'courses.json')->json() ?: [];
        });
        return view('courses_list', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'courses.json', $data);
        Cache::forget('firebase.courses.v1');
        return redirect()->back()->with('success', 'Ú©Û†Ø±Ø³Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø²ÛŒØ§Ø¯Ú©Ø±Ø§!');
    }

    public function destroyCourse($id)
    {
        Http::delete($this->firebaseUrl . 'courses/' . $id . '.json');
        Cache::forget('firebase.courses.v1');
        return redirect()->back()->with('success', 'Ú©Û†Ø±Ø³Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø³Ú•Ø§ÛŒÛ•ÙˆÛ•!');
    }

    // --- Ø¨Û•Ø´ÛŒ Ø¯Û•Ø³ØªÚ©Ø§Ø±ÛŒ Ú©Û†Ø±Ø³Û•Ú©Ø§Ù† ---
    public function editCourse($id)
    {
        $response = Http::get($this->firebaseUrl . 'courses/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'course']);
    }

    public function updateCourse(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'courses/' . $id . '.json', $data);
        Cache::forget('firebase.courses.v1');
        return redirect('/courses')->with('success', 'Ú©Û†Ø±Ø³Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ù†ÙˆÛŽÚ©Ø±Ø§ÛŒÛ•ÙˆÛ•!');
    }

    // --- Ø¨Û•Ø´ÛŒ Ø¯Û•Ø³ØªÚ©Ø§Ø±ÛŒ Ø¦Ø§Ù…Ø±Ø§Ø²Û•Ú©Ø§Ù†ÛŒ AI ---
    public function editAiTool($id)
    {
        $response = Http::get($this->firebaseUrl . 'ai_tools/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'ai_tool']);
    }

    public function updateAiTool(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'ai_tools/' . $id . '.json', $data);
        Cache::forget('firebase.ai_tools.v1');
        return redirect('/ai-tools')->with('success', 'Ø¦Ø§Ù…Ø±Ø§Ø²Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ù†ÙˆÛŽÚ©Ø±Ø§ÛŒÛ•ÙˆÛ•!');
    }

    // --- Ø¨Û•Ø´ÛŒ Ø¯Û•Ø³ØªÚ©Ø§Ø±ÛŒ Ú•ÛŽÙ†ÛŒØ´Ø§Ù†Ø¯Û•Ø± ---
    public function editAcademicGuide($id)
    {
        $response = Http::get($this->firebaseUrl . 'academic_guide/' . $id . '.json');
        return view('edit', ['data' => $response->json(), 'id' => $id, 'type' => 'academic_guide']);
    }

    public function updateAcademicGuide(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        Http::patch($this->firebaseUrl . 'academic_guide/' . $id . '.json', $data);
        Cache::forget('firebase.academic_guide.v1');
        return redirect('/academic-guide')->with('success', 'Ù¾Ø±Ø³ÛŒØ§Ø±Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ù†ÙˆÛŽÚ©Ø±Ø§ÛŒÛ•ÙˆÛ•!');
    }

   


    // ==========================================
    // Ø¨Û•Ø´ÛŒ Ø¦Ø§Ù…Ø±Ø§Ø²Û•Ú©Ø§Ù†ÛŒ Ú˜ÛŒØ±ÛŒ Ø¯Û•Ø³ØªÚ©Ø±Ø¯ (AI Tools)
    // ==========================================
    public function showAiTools()
    {
        $url = $this->firebaseUrl;
        $aiTools = Cache::remember('firebase.ai_tools.v1', now()->addMinutes(5), function () use ($url) {
            return Http::timeout(5)->get($url . 'ai_tools.json')->json() ?: [];
        });
        return view('ai_tools', compact('aiTools'));
    }

    public function storeAiTool(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'ai_tools.json', $data);
        Cache::forget('firebase.ai_tools.v1');
        return redirect()->back()->with('success', 'Ø¦Ø§Ù…Ø±Ø§Ø²Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø²ÛŒØ§Ø¯Ú©Ø±Ø§!');
    }

    public function destroyAiTool($id)
    {
        Http::delete($this->firebaseUrl . 'ai_tools/' . $id . '.json');
        Cache::forget('firebase.ai_tools.v1');
        return redirect()->back()->with('success', 'Ø¦Ø§Ù…Ø±Ø§Ø²Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø³Ú•Ø§ÛŒÛ•ÙˆÛ•!');
    }




    // ==========================================
    // Ø¨Û•Ø´ÛŒ Ú•ÛŽÙ†ÛŒØ´Ø§Ù†Ø¯Û•Ø±ÛŒ Ø¦Û•Ú©Ø§Ø¯ÛŒÙ…ÛŒ (Academic Guide)
    // ==========================================
    public function showAcademicGuide()
    {
        $url = $this->firebaseUrl;
        $faqs = Cache::remember('firebase.academic_guide.v1', now()->addMinutes(5), function () use ($url) {
            return Http::timeout(5)->get($url . 'academic_guide.json')->json() ?: [];
        });
        return view('academic_guide', compact('faqs'));
    }

    public function storeAcademicGuide(Request $request)
    {
        $data = $request->except('_token');
        Http::post($this->firebaseUrl . 'academic_guide.json', $data);
        Cache::forget('firebase.academic_guide.v1');
        return redirect()->back()->with('success', 'Ù¾Ø±Ø³ÛŒØ§Ø±Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø²ÛŒØ§Ø¯Ú©Ø±Ø§!');
    }

    public function destroyAcademicGuide($id)
    {
        Http::delete($this->firebaseUrl . 'academic_guide/' . $id . '.json');
        Cache::forget('firebase.academic_guide.v1');
        return redirect()->back()->with('success', 'Ù¾Ø±Ø³ÛŒØ§Ø±Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø³Ú•Ø§ÛŒÛ•ÙˆÛ•!');
    }

// ==========================================
    // Ø¨Û•Ø´ÛŒ ÙÛŽØ±Ú¯Û• (Ferga - Learning Platform)
    // ==========================================
    public function showFerga()
    {
        // Ù‡ÛŽÙ†Ø§Ù†ÛŒ Ø²Ø§Ù†ÛŒØ§Ø±ÛŒÛŒÛ•Ú©Ø§Ù†ÛŒ ÙÛŽØ±Ú¯Û• Ù„Û• ÙØ§ÛŒÛ•Ø±Ø¨Û•ÛŒØ³Û•ÙˆÛ• Ø¨Û† Ø¦Û•Ú¯Û•Ø±ÛŒ Ø¨Û•Ú©Ø§Ø±Ù‡ÛŽÙ†Ø§Ù†ÛŒ Ù„Û• Ø¨Ø§Ú©ÛŽÙ†Ø¯
        $response = Http::get($this->firebaseUrl . 'ferga_lessons.json');
        $lessons = $response->json();
        
        return view('ferga', compact('lessons'));
    }

    public function destroyFergaLesson($id)
    {
        Http::delete($this->firebaseUrl . 'ferga_lessons/' . $id . '.json');
        return redirect()->back()->with('success', 'ÙˆØ§Ù†Û•Ú©Û• Ø¨Û• Ø³Û•Ø±Ú©Û•ÙˆØªÙˆÙˆÛŒÛŒ Ø³Ú•Ø§ÛŒÛ•ÙˆÛ•!');
    }

    public function runPhpCode(Request $request)
    {
        $code = $request->input('code', '');
        if (trim($code) === '') {
            return response()->json(['output' => '', 'error' => 'Ù‡ÛŒÚ† Ú©Û†Ø¯ÛŽÚ© Ù†Û•Ù†ÙˆÙˆØ³Ø±Ø§ÙˆÛ•'], 400);
        }
        if (!str_starts_with(trim($code), '<?php')) {
            $code = "<?php\n" . $code;
        }
        $data = $this->compileOnWandbox('php-8.2.24', $code);
        if (isset($data['message'])) {
            return response()->json(['output' => $data['message'], 'code' => 1]);
        }
        $status = (int) ($data['status'] ?? 1);
        $output = $status === 0
            ? trim((string) ($data['program_output'] ?? ''))
            : trim((string) ($data['compiler_error'] ?? $data['program_error'] ?? ''));
        return response()->json([
            'output' => $output,
            'code' => $status
        ]);
    }

    protected function compileOnWandbox(string $compiler, string $code)
    {
        $payload = [
            'code' => $code,
            'compiler' => $compiler,
        ];
        $lastData = null;
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $response = Http::asJson()->timeout(35)->post('https://wandbox.org/api/compile.json', $payload);
                $data = $response->json();
                if (!is_array($data)) {
                    $lastData = ['message' => 'ÙˆÛ•ÚµØ§Ù…ÛŽÚ©ÛŒ Ù†Û•Ú†Ø§ÙˆÛ•Ú•ÙˆØ§Ù†Ú©Ø±Ø§Ùˆ Ù„Û• Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ú•Ø§Ù†Ø¯Ù† (HTTP ' . $response->status() . ')'];
                } else {
                    $errText = trim(
                        (string) ($data['compiler_error'] ?? '') . ' ' .
                        (string) ($data['compiler_message'] ?? '') . ' ' .
                        (string) ($data['program_error'] ?? '')
                    );
                    $status = $data['status'] ?? '';
                    $isBackendFailure = stripos($errText, 'OCI runtime error') !== false
                        || stripos($errText, 'Resource temporarily unavailable') !== false
                        || (is_string($status) && $status !== '' && !ctype_digit($status));
                    if (!$isBackendFailure) {
                        return $data;
                    }
                    $lastData = $data;
                }
            } catch (\Throwable $e) {
                $lastData = ['message' => 'Ù¾Û•ÛŒÙˆÛ•Ù†Ø¯ÛŒ Ø¨Û• Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ú•Ø§Ù†Ø¯Ù† Ù†Û•Ú©Ø±Ø§: ' . $e->getMessage()];
            }
            if ($attempt < 3) {
                usleep(1000000 * $attempt);
            }
        }
        return $lastData ?? ['message' => 'Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ú•Ø§Ù†Ø¯Ù† Ø¦ÛŽØ³ØªØ§ Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÛŒÛ•ØŒ Ø¯ÙˆØ§ÛŒ Ú†Û•Ù†Ø¯ Ø®ÙˆÙ„Û•Ú© Ù‡Û•ÙˆÚµØ¨Ø¯Û•ÙˆÛ•'];
    }

    protected function compileOnPiston(string $language, string $code)
    {
        $configs = [
            'php' => ['php', '8.2.3', 'main.php'],
            'js' => ['javascript', '18.15.0', 'main.js'],
            'java' => ['java', '15.0.2', 'Main.java'],
            'rs' => ['rust', '1.68.2', 'main.rs'],
            'cs' => ['csharp', '6.12.0', 'main.cs'],
        ];
        $cfg = $configs[$language] ?? null;
        if (!$cfg) {
            return ['message' => 'Ø¦Û•Ù… Ø²Ù…Ø§Ù†Û• Ù„Û•Ø³Û•Ø± Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ù¾Ø§ÛŒØ³Û†Ù† Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÛŒÛ•'];
        }
        [$pistonLang, $version, $filename] = $cfg;
        try {
            $response = Http::asJson()->timeout(20)->post('https://emkc.org/api/v2/piston/execute', [
                'language' => $pistonLang,
                'version' => $version,
                'files' => [['name' => $filename, 'content' => $code]],
                'stdin' => '',
                'args' => [],
                'compile_timeout' => 10000,
                'run_timeout' => 5000,
                'compile_memory_limit' => -1,
                'run_memory_limit' => -1,
            ]);
            $httpStatus = $response->status();
            $data = $response->json();
            if (!is_array($data) || (!isset($data['run']) && !isset($data['compile']))) {
                return ['message' => 'Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ù¾Ø§ÛŒØ³Û†Ù† ÙˆÛ•ÚµØ§Ù…ÛŒ Ú•Ø§Ù†Ø¯Ù† Ù†Û•Ø¯Ø§ÛŒÛ•ÙˆÛ• (HTTP ' . $httpStatus . ')'];
            }
            return $this->normalizePistonResult($data);
        } catch (\Throwable $e) {
            return ['message' => 'Ù¾Û•ÛŒÙˆÛ•Ù†Ø¯ÛŒ Ø¨Û• Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ù¾Ø§ÛŒØ³Û†Ù† Ù†Û•Ú©Ø±Ø§: ' . $e->getMessage()];
        }
    }

    protected function normalizePistonResult(array $data)
    {
        $compile = $data['compile'] ?? null;
        $run = $data['run'] ?? null;
        if (is_array($compile) && isset($compile['code']) && (int) $compile['code'] !== 0) {
            $err = trim((string) ($compile['stderr'] ?? '') . "\n" . (string) ($compile['output'] ?? ''));
            return [
                'status' => (string) (int) $compile['code'],
                'compiler_error' => $err,
                'compiler_message' => '',
                'program_error' => $err,
                'program_output' => '',
            ];
        }
        if (is_array($run)) {
            $code = (int) ($run['code'] ?? 0);
            $stdout = trim((string) ($run['stdout'] ?? $run['output'] ?? ''));
            $stderr = trim((string) ($run['stderr'] ?? ''));
            if ($code !== 0) {
                $err = $stderr !== '' ? $stderr : $stdout;
                return [
                    'status' => (string) $code,
                    'compiler_error' => $err,
                    'compiler_message' => '',
                    'program_error' => $err,
                    'program_output' => '',
                ];
            }
            return [
                'status' => '0',
                'program_output' => $stdout,
                'program_error' => $stderr,
                'compiler_error' => '',
                'compiler_message' => '',
            ];
        }
        return ['message' => 'Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ù¾Ø§ÛŒØ³Û†Ù† ÙˆÛ•ÚµØ§Ù…ÛŒ Ø¯Û•Ø±Ú©Û•ÙˆØªÙ† Ù†Û•Ø¯Ø§ÛŒÛ•ÙˆÛ•'];
    }

    public function runCloud(Request $request)
    {
        $language = $request->input('language', '');
        $code = $request->input('code', '');
        if (trim($code) === '') {
            return response()->json(['message' => 'Ù‡ÛŒÚ† Ú©Û†Ø¯ÛŽÚ© Ù†Û•Ù†ÙˆÙˆØ³Ø±Ø§ÙˆÛ•'], 400);
        }
        $compilerMap = [
            'php' => 'php-8.2.24',
            'js' => 'nodejs-20.17.0',
            'java' => 'openjdk-jdk-21+35',
            'rs' => 'rust-1.82.0',
            'cs' => 'mono-6.12.0.199',
        ];
        $compiler = $compilerMap[$language] ?? null;
        if (!$compiler) {
            return response()->json(['message' => 'Ú©Ø§Ø±Ù¾ÛŽÚ©Ø±Ø¯Ù†ÛŒ Ø¦Û•Ù… Ø²Ù…Ø§Ù†Û• Ù„Û•Ø³Û•Ø± Ú•Ø§Ú˜Û•Ú©Ø§Ø± Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÛŒÛ•'], 400);
        }
        $backends = ['piston'];
        if (in_array($language, ['java', 'rs', 'cs'], true)) {
            $backends[] = 'godbolt';
        }
        $backends[] = 'wandbox';
        $data = null;
        foreach ($backends as $backend) {
            if ($backend === 'piston') {
                $data = $this->compileOnPiston($language, $code);
            } elseif ($backend === 'godbolt') {
                $data = $this->compileOnGodbolt($language, $code);
            } else {
                $data = $this->compileOnWandbox($compiler, $code);
            }
            if (!isset($data['message'])) {
                break;
            }
        }
        return response()->json($data);
    }

    public function runCode(Request $request)
    {
        $language = $request->input('language', '');
        $code = $request->input('code', '');
        if (trim($code) === '') {
            return response()->json(['output' => '', 'error' => 'Ù‡ÛŒÚ† Ú©Û†Ø¯ÛŽÚ© Ù†Û•Ù†ÙˆÙˆØ³Ø±Ø§ÙˆÛ•'], 400);
        }
        $cloudMap = [
            'js' => 'nodejs-20.17.0',
            'java' => 'openjdk-jdk-21+35',
            'rs' => 'rust-1.82.0',
        ];
        $compiler = $cloudMap[$language] ?? null;
        if (!$compiler) {
            return response()->json(['output' => '', 'error' => 'Ú©Ø§Ø±Ù¾ÛŽÚ©Ø±Ø¯Ù†ÛŒ Ø¦Û•Ù… Ø²Ù…Ø§Ù†Û• Ù„Û•Ø³Û•Ø± Ú•Ø§Ú˜Û•Ú©Ø§Ø± Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÛŒÛ•'], 400);
        }
        $cloud = $this->compileOnPiston($language, $code);
        if (isset($cloud['message'])) {
            $cloud = $this->compileOnWandbox($compiler, $code);
        }
        $data = $cloud;
        if (isset($data['message'])) {
            return response()->json(['output' => $data['message'], 'code' => 1]);
        }
        $status = (int) ($data['status'] ?? 1);
        $output = $status === 0
            ? trim((string) ($data['program_output'] ?? ''))
            : trim((string) ($data['compiler_error'] ?? $data['program_error'] ?? ''));
        return response()->json([
            'output' => $output,
            'code' => $status
        ]);
    }

    protected function compileOnGodbolt(string $language, string $code)
    {
        $compilers = [
            'java' => ['java2102', 'java2200'],
            'rs' => ['r1800', 'r1930'],
            'cs' => ['dotnet90csharpcoreclr', 'dotnet80csharpcoreclr', 'dotnet90csharpmono'],
        ][$language] ?? [];
        if (!$compilers) {
            return ['message' => 'Ú©Ø§Ø±Ù¾ÛŽÚ©Ø±Ø¯Ù†ÛŒ Ø¦Û•Ù… Ø²Ù…Ø§Ù†Û• Ù„Û•Ø³Û•Ø± Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ú¯Û†Ø¯Ø¨Û†Ù„Øª Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÛŒÛ•'];
        }
        foreach ($compilers as $compiler) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $response = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
                    ])->asJson()->timeout(30)->post('https://godbolt.org/api/compiler/' . $compiler . '/compile', [
                        'source' => $code,
                        'lang' => ['java' => 'java', 'rs' => 'rust', 'cs' => 'csharp'][$language] ?? $language,
                        'allowStoreCodeDebug' => true,
                        'options' => [
                            'userArguments' => '',
                            'compilerOptions' => ['executorRequest' => true],
                            'filters' => [
                                'binary' => false,
                                'execute' => true,
                                'intel' => true,
                                'demangle' => true,
                                'directives' => true,
                                'labels' => true,
                                'commentOnly' => true,
                                'trim' => false,
                                'debugCalls' => true,
                            ],
                            'tools' => [],
                            'libraries' => [],
                            'executeParameters' => ['args' => [], 'stdin' => ''],
                        ],
                    ]);
                    $data = $response->json();
                    if (!is_array($data) || isset($data['error'])) {
                        continue;
                    }
                    return $this->normalizeGodboltResult($data);
                } catch (\Throwable $e) {
                    // next compiler
                }
            }
        }
        return ['message' => 'Ù‡Û•Ø±Ø¯ÙˆÙˆ Ø®Ø²Ù…Û•ØªÚ¯ÙˆØ²Ø§Ø±ÛŒ Ú•Ø§Ù†Ø¯Ù† Ø¦ÛŽØ³ØªØ§ Ø¨Û•Ø±Ø¯Û•Ø³Øª Ù†ÛŒÙ†ØŒ Ø¯ÙˆØ§ÛŒ Ú†Û•Ù†Ø¯ Ø®ÙˆÙ„Û•Ú© Ù‡Û•ÙˆÚµØ¨Ø¯Û•ÙˆÛ•'];
    }

    protected function normalizeGodboltResult(array $data)
    {
        $code = null;
        $stdout = '';
        $stderr = '';
        $exec = $data['execResult'] ?? null;
        if (is_array($exec)) {
            $code = (int) ($exec['code'] ?? 1);
            $stdout = $this->extractGodboltText($exec['stdout'] ?? null);
            $stderr = $this->extractGodboltText($exec['stderr'] ?? null);
        }
        if ($code === null) {
            $code = (int) ($data['code'] ?? 0);
            $stdout = $this->extractGodboltText($data['stdout'] ?? null);
            $stderr = $this->extractGodboltText($data['stderr'] ?? null);
        }
        if ($code !== 0) {
            return [
                'status' => (string) $code,
                'compiler_error' => $stderr,
                'compiler_message' => '',
                'program_error' => $stderr,
                'program_output' => '',
            ];
        }
        return [
            'status' => '0',
            'program_output' => $stdout,
            'program_error' => $stderr,
            'compiler_error' => '',
            'compiler_message' => '',
        ];
    }

    protected function extractGodboltText($lines)
    {
        if (is_string($lines)) {
            return trim($lines);
        }
        if (!is_array($lines)) {
            return '';
        }
        $parts = [];
        foreach ($lines as $line) {
            if (is_array($line) && array_key_exists('text', $line)) {
                $parts[] = $line['text'];
            } elseif (is_string($line)) {
                $parts[] = $line;
            }
        }
        return trim(implode("\n", $parts));
    }
}
