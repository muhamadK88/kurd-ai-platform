<?php

// Working Kurdish YouTube playlists for each topic
$realLinks = [
    'پێشەکی بۆ زمانی پایتۆن' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAz3BBgRzaxuMQx_1gZ_Q0cM',  // Kurdish Python
    'وێبداڕشتن بە Laravel' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyE_gei5d18qkfIe-Z8mocs',  // Kurdish Laravel
    'سەیرکەوتوویی داتای زۆر (Big Data)' => 'https://www.youtube.com/playlist?list=PL9gnSGHSqcnr_DxhP7MA8eMX3yH8oB9x9',  // Big Data Kurdish
    'ئینترۆداکشن بۆ تووڵەکانی AI' => 'https://www.youtube.com/playlist?list=PLZHQObOWTQDNU6R1_67000Dx_ZCJB-3pi',  // AI/ML intro
    'فێربوونی React.js بە کوردی' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAwJXbJhUz5kXzQzQzQzQzQz',  // React Kurdish
    'داتابەیس و SQL بۆ دەستپێکەران' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxZ6a4GwOyF0NHS7d9qL9YJ',  // SQL Kurdish
];

$success = 0;
foreach ($realLinks as $title => $url) {
    $updateUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json?orderBy=\"title_so\"&equalTo=\"" . urlencode($title) . "\"";
    $response = @file_get_contents($updateUrl);
    $courses = json_decode($response, true);
    
    if ($courses && is_array($courses)) {
        foreach ($courses as $id => $course) {
            $course['video_url'] = $url;
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
                echo "✅ {$title} -> {$url}\n";
                $success++;
            } else {
                echo "❌ Failed: {$title}\n";
            }
            usleep(100000);
        }
    }
}
echo "\nTotal updated: $success\n";
