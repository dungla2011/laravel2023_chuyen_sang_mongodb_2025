<?php
$content = file_get_contents('all_mongo_fields_output.txt');

// Simple string search
echo "=== Basic String Search ===\n";
echo "File size: " . strlen($content) . " bytes\n";
echo "Contains 'BlockUi Model': " . (strpos($content, 'BlockUi Model') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 'mongoFieldTypes': " . (strpos($content, 'mongoFieldTypes') !== false ? 'YES' : 'NO') . "\n";
echo "Contains '========': " . (strpos($content, '========') !== false ? 'YES' : 'NO') . "\n";

// Count occurrences
echo "Occurrences of 'Model ==========': " . substr_count($content, 'Model ==========') . "\n";
echo "Occurrences of 'mongoFieldTypes': " . substr_count($content, 'mongoFieldTypes') . "\n";

// Simple regex test
if (preg_match('/BlockUi Model/', $content)) {
    echo "Regex match for 'BlockUi Model': YES\n";
} else {
    echo "Regex match for 'BlockUi Model': NO\n";
}

// Show first few lines
echo "\n=== First 10 lines ===\n";
$lines = explode("\n", $content);
for ($i = 0; $i < min(10, count($lines)); $i++) {
    echo ($i + 1) . ": " . $lines[$i] . "\n";
}
