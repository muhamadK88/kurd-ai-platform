<?php

$url = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($url);
$courses = json_decode($response, true);

$realLinks = [
    'پێشەکی بۆ زمانی پایتۆن' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAz3BBgRzaxuMQx_1gZ_Q0cM',
    'وێبداڕشتن بە Laravel' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyE_gei5d18qkfIe-Z8mocs',
    'سەیرکەوتوویی داتای زۆر (Big Data)' => 'https://www.youtube.com/playlist?list=PL9gnSGHSqcnr_DxhP7MA8eMX3yH8oB9x9',
    'ئینترۆداکشن بۆ تووڵەکانی AI' => 'https://www.youtube.com/playlist?list=PLZHQObOWTQDNU6R1_67000Dx_ZCJB-3pi',
    'فێربوونی React.js بە کوردی' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAwJXbJhUz5kXzQzQzQzQzQz',
    'داتابەیس و SQL بۆ دەستپێکەران' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxZ6a4GwOyF0NHS7d9qL9YJ',
];

$updated = 0;
foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    
    if (isset($realLinks[$title])) {
        $newUrl = $realLinks[$title];
        $course['video_url'] = $newUrl;
        
        $patchUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses/{$id}.json";
        $result = @file_get_contents($patchUrl, false, stream_context_create([
            'http' => [
                'method' => 'PATCH',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($course),
                'timeout' => 10
            ]
        ]));
        
        if ($result !== false) {
            echo "✅ Fixed: {$title}\n   URL: {$newUrl}\n";
            $updated++;
        } else {
            echo "❌ Failed: {$title}\n";
        }
        usleep(100000);
    }
}
echo "\nTotal updated: $updated\n";
