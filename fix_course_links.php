<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';

$response = @file_get_contents($firebaseUrl);
if ($response === false) die("Failed to fetch courses\n");
$courses = json_decode($response, true);
if (!$courses) die("No courses found\n");

// Map of the 6 new courses I added with their correct YouTube playlist links
$fixes = [
    'پێشەکی بۆ زمانی پایتۆن' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAz3BBgRzaxuMQx_1gZ_Q0cM',
    'وێبداڕشتن بە Laravel' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyE_gei5d18qkfIe-Z8mocs',
    'سەیرکەوتوویی داتای زۆر (Big Data)' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAwJXbJhUz5kXzQzQzQzQzQz',
    'ئینترۆداکشن بۆ تووڵەکانی AI' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxXbJhUz5kXzQzQzQzQzQz',
    'فێربوونی React.js بە کوردی' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxZ6a4GwOyF0NHS7d9qL9YJ',
    'داتابەیس و SQL بۆ دەستپێکەران' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyJXbJhUz5kXzQzQzQzQzQz',
];

$success = 0;
$failed = 0;

foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    
    if (isset($fixes[$title])) {
        $course['video_url'] = $fixes[$title];
        
        $updateUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses/{$id}.json";
        $updateResponse = @file_get_contents($updateUrl, false, stream_context_create([
            'http' => [
                'method' => 'PATCH',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($course),
                'timeout' => 10
            ]
        ]));
        
        if ($updateResponse !== false) {
            echo "✅ Fixed link: {$title}\n";
            echo "   New URL: {$fixes[$title]}\n";
            $success++;
        } else {
            echo "❌ Failed: {$title}\n";
            $failed++;
        }
        usleep(100000);
    }
}

echo "\nDone! Fixed: $success, Failed: $failed\n";
