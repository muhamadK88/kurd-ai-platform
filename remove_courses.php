<?php

$url = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($url);
$courses = json_decode($response, true);

$toRemove = [
    'پێشەکی بۆ زمانی پایتۆن',
    'وێبداڕشتن بە Laravel',
    'سەیرکەوتوویی داتای زۆر (Big Data)',
    'ئینترۆداکشن بۆ تووڵەکانی AI',
    'فێربوونی React.js بە کوردی',
    'داتابەیس و SQL بۆ دەستپێکەران',
];

$removed = 0;
foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    if (in_array($title, $toRemove)) {
        $deleteUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses/{$id}.json";
        $result = @file_get_contents($deleteUrl, false, stream_context_create([
            'http' => ['method' => 'DELETE', 'timeout' => 10]
        ]));
        if ($result !== false) {
            echo "✅ Removed: {$title}\n";
            $removed++;
        } else {
            echo "❌ Failed: {$title}\n";
        }
        usleep(100000);
    }
}
echo "\nTotal removed: $removed\n";
