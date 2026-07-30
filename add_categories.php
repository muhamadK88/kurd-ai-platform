<?php

$coursesUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($coursesUrl);
$courses = json_decode($response, true);

$categoryMap = [];

foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    
    // Programming
    if (preg_match('/جاڤاسکریپت|JavaScript|جاڤا|Java|++C|C\+\+|سی پڵەس|سى پڵەس|سی شارپ|C#|HTML|CSS|فڵەتەر|Flutter|پڕۆگرامینگی پایتۆن/', $title)) {
        $categoryMap[$id] = 'پرۆگرامسازی';
    }
    // Data & AI
    elseif (preg_match('/فێربوونی ئامێر|Machine Learning|زانستی داتا|Data Science|شیکردنەوەی داتا|Big Data|زیرەکی دەستکرد|Cursor IDE|ئەندازیاری دەروازە|Prompt Engineering|AI|زیرەکی/', $title)) {
        $categoryMap[$id] = 'داتا و زیرەکی دەستکرد';
    }
    // Design
    elseif (preg_match('/UI\/UX|UI\/UX|دیزاینی گرافیک|Graphic Design|فگما|Figma|دیزاینی ڕووکار/', $title)) {
        $categoryMap[$id] = 'دیزاین';
    }
    // Security
    elseif (preg_match('/هاککردن|هەککردن|ئاسایشی ئەلیکترۆنی|Cyber Security|Ethical Hacking/', $title)) {
        $categoryMap[$id] = 'ئاسایشی ئەلیکترۆنی';
    }
    // Cloud & Database
    elseif (preg_match('/ژمێریاری هەوری|Cloud Computing|AWS|Azure|Google Cloud|بنکەی داتا|SQL|Database|داتابەیس/', $title)) {
        $categoryMap[$id] = 'کلود و داتابەیس';
    }
    // Business
    elseif (preg_match('/بەبازاڕکردنی دیجیتاڵی|Digital Marketing|بەڕێوەبردنی پڕۆژە|PMP|ئێکسڵ|Excel|پاوەر ئەپس|Power Apps|Project Management/', $title)) {
        $categoryMap[$id] = 'بزنس و بەرھەمھێنان';
    }
    // Language
    elseif (preg_match('/ئینگلیزی|English/', $title)) {
        $categoryMap[$id] = 'زمان';
    }
    // Video Editing
    elseif (preg_match('/مۆنتاژ|ڤیدیۆ|پرێمیەر پرۆ|Premiere Pro|Video Editing/', $title)) {
        $categoryMap[$id] = 'ڤیدیۆ و مۆنتاژ';
    }
    // Default - check title more broadly
    elseif (preg_match('/پایتۆن|Python/', $title)) {
        $categoryMap[$id] = 'پرۆگرامسازی';
    }
    elseif (preg_match('/جافاسکڕیپت/', $title)) {
        $categoryMap[$id] = 'پرۆگرامسازی';
    }
    else {
        $categoryMap[$id] = 'گشتی';
    }
}

$success = 0;
foreach ($categoryMap as $id => $category) {
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
        $title = $courses[$id]['title_so'] ?? $courses[$id]['title'] ?? 'Unknown';
        echo "✅ {$category} <- {$title}\n";
        $success++;
    } else {
        echo "❌ Failed for ID: {$id}\n";
    }
    usleep(50000);
}

echo "\nTotal categorized: $success\n";
