<?php
$content = file_get_contents('mongo_fields_clean.txt');

echo "=== Clean File Test ===\n";
echo "File size: " . strlen($content) . " bytes\n";
echo "Contains 'BlockUi Model': " . (strpos($content, 'BlockUi Model') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 'mongoFieldTypes': " . (strpos($content, 'mongoFieldTypes') !== false ? 'YES' : 'NO') . "\n";

// Show first few lines
echo "\n=== First 5 lines ===\n";
$lines = explode("\n", $content);
for ($i = 0; $i < min(5, count($lines)); $i++) {
    echo ($i + 1) . ": '" . trim($lines[$i]) . "'\n";
}

// Test regex with the clean file
if (preg_match_all('/BlockUi Model/', $content, $matches)) {
    echo "\nRegex found: " . count($matches[0]) . " matches\n";
}

// Test mongoFieldTypes
if (preg_match_all('/mongoFieldTypes/', $content, $matches)) {
    echo "mongoFieldTypes found: " . count($matches[0]) . " matches\n";
}
