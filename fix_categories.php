<?php

$coursesUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($coursesUrl);
$courses = json_decode($response, true);

$fixes = [
    'زمانی پایسۆن' => 'پرۆگرامسازی',
    'سی پڵەس پڵەس ++C' => 'پرۆگرامسازی',
    'سی پڵەس پڵەس' => 'پرۆگرامسازی', 
    'کۆرسی پایسۆن (بادینی)' => 'پرۆگرامسازی',
    'کۆرسی فڵەتەر (Flutter Course | Kurdish)' => 'پرۆگرامسازی',
    'کۆرسی سی شارپ (C# Full Course [Kurdish])' => 'پرۆگرامسازی',
    '(HTML and CSS Course [Kurdish])' => 'پرۆگرامسازی',
    'C++ Full Course (Kurdish))' => 'پرۆگرامسازی',
    'گەشەپێدانی وێبسایت (HTML و CSS)' => 'پرۆگرامسازی',
    'دروستکردنی ئەپڵیکەیشنی مۆبایل بە زمانی فڵەتەر (Flutter)' => 'پرۆگرامسازی',
    'فێربوونی پڕۆگرامینگی جاڤاسکریپت لە سفرەوە تا ئاستی پێشکەوتوو' => 'پرۆگرامسازی',
    'کۆرسی فێربوونی زمانی پڕۆگرامینگی جاڤا' => 'پرۆگرامسازی',
    'کۆرسی گشتگیری CSS بۆ دیزاینی وێبسایت' => 'پرۆگرامسازی',
    'فێربوونی زمانی پڕۆگرامینگی ++C بۆ دەستپێکەران' => 'پرۆگرامسازی',
    'بەکارهێنانی ئێکسڵ بۆ شیکردنەوەی داتا' => 'بزنس و بەرھەمھێنان',
];

$success = 0;
foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    
    if (isset($fixes[$title])) {
        $category = $fixes[$title];
        $patchUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses/{$id}.json";
        $data = json_encode(['category' => $category]);
        $result = @file_get_contents($patchUrl, false, stream_context_create([
            'http' => [
                'method' => 'PATCH',
                'header' => 'Content-Type: application/json',
                'content' => $data,
                'timeout' => 10
            ]
        ]));
        
        if ($result !== false) {
            echo "✅ {$title} -> {$category}\n";
            $success++;
        } else {
            echo "❌ Failed: {$title}\n";
        }
        usleep(50000);
    }
}

echo "\nFixed: $success\n";
