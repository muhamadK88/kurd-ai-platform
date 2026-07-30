<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';

// First, get all courses
$response = @file_get_contents($firebaseUrl);
if ($response === false) {
    die("Failed to fetch courses\n");
}
$courses = json_decode($response, true);
if (!$courses) {
    die("No courses found\n");
}

$success = 0;
$failed = 0;

foreach ($courses as $id => $course) {
    // Update price to 0 (free)
    $course['price'] = 0;
    
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
        echo "✅ Updated: {$course['title_so']} - Price set to 0 (Free)\n";
        $success++;
    } else {
        echo "❌ Failed: {$course['title_so']}\n";
        $failed++;
    }
    usleep(100000);
}

echo "\nDone! Success: $success, Failed: $failed\n";
