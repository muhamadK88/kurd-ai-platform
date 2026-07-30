<?php

$url = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($url);
$courses = json_decode($response, true);

$seen = [];
$duplicates = [];

foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    $normalized = trim($title);
    
    if (isset($seen[$normalized])) {
        $duplicates[] = ['id' => $id, 'title' => $title, 'keep' => $seen[$normalized]];
    } else {
        $seen[$normalized] = $id;
    }
}

echo "Found " . count($duplicates) . " duplicates:\n\n";
$removed = 0;

foreach ($duplicates as $dup) {
    $deleteUrl = "https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses/{$dup['id']}.json";
    $result = @file_get_contents($deleteUrl, false, stream_context_create([
        'http' => ['method' => 'DELETE', 'timeout' => 10]
    ]));
    if ($result !== false) {
        echo "🗑️ Removed duplicate: {$dup['title']}\n";
        $removed++;
    } else {
        echo "❌ Failed: {$dup['title']}\n";
    }
    usleep(100000);
}

echo "\nTotal removed: $removed\n";
