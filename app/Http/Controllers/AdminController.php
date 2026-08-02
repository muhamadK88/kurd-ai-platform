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

    public function runPhpCode(Request $request)
    {
        $code = $request->input('code', '');
        if (trim($code) === '') {
            return response()->json(['output' => '', 'error' => 'هیچ کۆدێک نەنووسراوە'], 400);
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
                    $lastData = ['message' => 'وەڵامێکی نەچاوەڕوانکراو لە خزمەتگوزاری ڕاندن (HTTP ' . $response->status() . ')'];
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
                $lastData = ['message' => 'پەیوەندی بە خزمەتگوزاری ڕاندن نەکرا: ' . $e->getMessage()];
            }
            if ($attempt < 3) {
                usleep(1000000 * $attempt);
            }
        }
        return $lastData ?? ['message' => 'خزمەتگوزاری ڕاندن ئێستا بەردەست نییە، دوای چەند خولەک هەوڵبدەوە'];
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
            return ['message' => 'ئەم زمانە لەسەر خزمەتگوزاری پایسۆن بەردەست نییە'];
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
                return ['message' => 'خزمەتگوزاری پایسۆن وەڵامی ڕاندن نەدایەوە (HTTP ' . $httpStatus . ')'];
            }
            return $this->normalizePistonResult($data);
        } catch (\Throwable $e) {
            return ['message' => 'پەیوەندی بە خزمەتگوزاری پایسۆن نەکرا: ' . $e->getMessage()];
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
        return ['message' => 'خزمەتگوزاری پایسۆن وەڵامی دەرکەوتن نەدایەوە'];
    }

    public function runCloud(Request $request)
    {
        $language = $request->input('language', '');
        $code = $request->input('code', '');
        if (trim($code) === '') {
            return response()->json(['message' => 'هیچ کۆدێک نەنووسراوە'], 400);
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
            return response()->json(['message' => 'کارپێکردنی ئەم زمانە لەسەر ڕاژەکار بەردەست نییە'], 400);
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
            return response()->json(['output' => '', 'error' => 'هیچ کۆدێک نەنووسراوە'], 400);
        }
        $cloudMap = [
            'js' => 'nodejs-20.17.0',
            'java' => 'openjdk-jdk-21+35',
            'rs' => 'rust-1.82.0',
        ];
        $compiler = $cloudMap[$language] ?? null;
        if (!$compiler) {
            return response()->json(['output' => '', 'error' => 'کارپێکردنی ئەم زمانە لەسەر ڕاژەکار بەردەست نییە'], 400);
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
            return ['message' => 'کارپێکردنی ئەم زمانە لەسەر خزمەتگوزاری گۆدبۆلت بەردەست نییە'];
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
        return ['message' => 'هەردوو خزمەتگوزاری ڕاندن ئێستا بەردەست نین، دوای چەند خولەک هەوڵبدەوە'];
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