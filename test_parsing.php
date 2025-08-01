<?php
/**
 * Simple test to parse the generated output correctly
 */

$outputFile = __DIR__ . '/all_mongo_fields_output.txt';
$content = file_get_contents($outputFile);

echo "=== Testing Output Parsing ===\n\n";

// Test simple regex pattern
preg_match_all('/\\/\\/ ========== (.+?) Model ==========/', $content, $modelMatches);

echo "Found model names: " . count($modelMatches[1]) . "\n";
foreach (array_slice($modelMatches[1], 0, 10) as $i => $modelName) {
    echo ($i + 1) . ". " . trim($modelName) . "\n";
}

echo "\n";

// Test finding mongoFieldTypes
preg_match_all('/protected static \\$mongoFieldTypes = \\[(.*?)\\];/s', $content, $fieldMatches);
echo "Found mongoFieldTypes blocks: " . count($fieldMatches[0]) . "\n";

if (count($fieldMatches[0]) > 0) {
    echo "First block preview:\n";
    echo substr($fieldMatches[1][0], 0, 200) . "...\n";
}

// Test combined pattern
preg_match_all('/\\/\\/ ========== (.+?) Model ==========.*?protected static \\$mongoFieldTypes = \\[(.*?)\\];/s', $content, $combinedMatches);
echo "\nCombined pattern matches: " . count($combinedMatches[1]) . "\n";
if (count($combinedMatches[1]) > 0) {
    echo "First combined match: " . trim($combinedMatches[1][0]) . "\n";
}
