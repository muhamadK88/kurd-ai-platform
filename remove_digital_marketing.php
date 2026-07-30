<?php

$url = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($url);
$courses = json_decode($response, true);

$targetTitle = 'بنەماکانی بەبازاڕکردنی دیجیتاڵی';
$removed = 0;

foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    if ($title === $targetTitle) {
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
    }
}
echo "\nTotal removed: $removed\n";
