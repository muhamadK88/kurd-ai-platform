<?php

$url = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/courses.json';
$response = @file_get_contents($url);
$courses = json_decode($response, true);

// Relevant Unsplash images for each course
$imageUpdates = [
    'فێربوونی پڕۆگرامینگی پایتۆن بۆ سەرەتاییەکان' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=800&h=450&fit=crop',  // Python code
    'گەشەپێدانی وێبسایت (HTML و CSS)' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=450&fit=crop',  // HTML/CSS code
    'بنەماکانی دیزاینی گرافیک' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800&h=450&fit=crop',  // Graphic design tools
    'فێربوونی ئینگلیزی بۆ دەستپێکەران' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=450&fit=crop',  // English learning
    'بنەماکانی بەبازاڕکردنی دیجیتاڵی' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop',  // Digital marketing
    'فێربوونی مایکرۆسۆفت ئێکسڵ' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=800&h=450&fit=crop',  // Excel/spreadsheet
];

$updated = 0;
foreach ($courses as $id => $course) {
    $title = $course['title_so'] ?? $course['title'] ?? '';
    
    if (isset($imageUpdates[$title])) {
        $newImage = $imageUpdates[$title];
        $course['image_url'] = $newImage;
        
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
            echo "✅ Updated image: {$title}\n";
            $updated++;
        } else {
            echo "❌ Failed: {$title}\n";
        }
        usleep(100000);
    }
}
echo "\nTotal updated: $updated\n";
