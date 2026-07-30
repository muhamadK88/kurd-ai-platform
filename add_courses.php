<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';

$courses = [
    [
        'title_so' => 'پێشەکی بۆ زمانی پایتۆن',
        'title_ba' => 'پێشەکی بۆ زمانی پایتۆن',
        'desc_so' => 'فێربوونی بنەماکانی زمانی پایتۆن بۆ دەستپێکەران، لەناو کۆرسەکەدا توێژینەوە دەکەین بە گۆڕاوەکان، جۆری داتا، و ڕێکخستنی ڕێکەوت.',
        'desc_ba' => 'فێربوونی بنەماکانی زمانی پایتۆن بۆ دەستپێکەران، لەناو کۆرسەکەدا توێژینەوە دەکەین بە گۆڕاوەکان، جۆری داتا، و ڕێکخستنی ڕێکەوت.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyE_gei5d18qkfIe-Z8mocs',
        'price' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=800&h=450&fit=crop'
    ],
    [
        'title_so' => 'وێبداڕشتن بە Laravel',
        'title_ba' => 'وێبداڕشتن بە Laravel',
        'desc_so' => 'فێربوونی فریمەوەرکی Laravel بۆ دروستکردنی وێبە یارییەکان و API، لەگەڵ داتابەیس، تایبەتمەندی Authentication، و Deployment.',
        'desc_ba' => 'فێربوونی فریمەوەرکی Laravel بۆ دروستکردنی وێبە یارییەکان و API، لەگەڵ داتابەیس، تایبەتمەندی Authentication، و Deployment.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAz3BBgRzaxuMQx_1gZ_Q0cM',
        'price' => 25,
        'image_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=450&fit=crop'
    ],
    [
        'title_so' => 'سەیرکەوتوویی داتای زۆر (Big Data)',
        'title_ba' => 'سەیرکەوتوویی داتای زۆر',
        'desc_so' => 'بنەماکانی کار بە داتای گەورە، هەندێکین بە Spark، Hadoop، و Kafka، بۆ بەرھەمھێنانی بینین و داتای کارام.',
        'desc_ba' => 'بنەماکانی کار بە داتای گەورە، هەندێکین بە Spark، Hadoop، و Kafka، بۆ بەرھەمھێنانی بینین و داتای کارام.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxZ6a4GwOyF0NHS7d9qL9YJ',
        'price' => 40,
        'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=450&fit=crop'
    ],
    [
        'title_so' => 'ئینترۆداکشن بۆ تووڵەکانی AI',
        'title_ba' => 'ئینترۆداکشن بۆ تووڵەکانی AI',
        'desc_so' => 'ناسینی تووڵەکان و مۆدێلەکانی ژیری دەستکرد (Generative AI) وەک ChatGPT، Midjourney، و دەروازەی نوێی تەکنەلۆژی.',
        'desc_ba' => 'ناسینی تووڵەکان و مۆدێلەکانی ژیری دەستکرد وەک ChatGPT، Midjourney، و دەروازەی نوێی تەکنەلۆژی.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAyJXbJhUz5kXzQzQzQzQzQz',
        'price' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=450&fit=crop'
    ],
    [
        'title_so' => 'فێربوونی React.js بە کوردی',
        'title_ba' => 'فێربوونی React.js بە کوردی',
        'desc_so' => 'دروستکردنی وێبە ئینتەرئەکتیڤەکان بە React، Hooks، Context API، و State Management بە Redux Toolkit.',
        'desc_ba' => 'دروستکردنی وێبە ئینتەرئەکتیڤەکان بە React، Hooks، Context API، و State Management بە Redux Toolkit.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAwJXbJhUz5kXzQzQzQzQzQz',
        'price' => 30,
        'image_url' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=450&fit=crop'
    ],
    [
        'title_so' => 'داتابەیس و SQL بۆ دەستپێکەران',
        'title_ba' => 'داتابەیس و SQL بۆ دەستپێکەران',
        'desc_so' => 'فێربوونی SQL، طراحی داتابەیس، Query نوسین، JOIN، Indexing، و Optimization بۆ پەرەپێدانی پێرەپێدانی داتا.',
        'desc_ba' => 'فێربوونی SQL، دەزاینکردنی داتابەیس، Query نوسین، JOIN، Indexing، و Optimization بۆ پەرەپێدانی داتا.',
        'video_url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxXbJhUz5kXzQzQzQzQzQz',
        'price' => 20,
        'image_url' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&h=450&fit=crop'
    ],
];

$success = 0;
$failed = 0;

foreach ($courses as $course) {
    $response = @file_get_contents($firebaseUrl, false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($course),
            'timeout' => 10
        ]
    ]));
    
    if ($response !== false) {
        $result = json_decode($response, true);
        if (isset($result['name'])) {
            echo "✅ Added: {$course['title_so']} (ID: {$result['name']})\n";
            $success++;
        } else {
            echo "❌ Failed: {$course['title_so']} - " . json_encode($result) . "\n";
            $failed++;
        }
    } else {
        echo "❌ Network error for: {$course['title_so']}\n";
        $failed++;
    }
    usleep(100000); // 100ms delay
}

echo "\nDone! Success: $success, Failed: $failed\n";
