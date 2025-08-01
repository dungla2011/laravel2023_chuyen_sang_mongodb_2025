<?php
$content = file_get_contents('mongo_fields_fixed.txt');

echo "File size: " . strlen($content) . " bytes\n";
echo "First 200 chars:\n";
echo substr($content, 0, 200) . "\n\n";

$regex = '/\/\/ ==========\s+(\w+)\s+Model\s+==========.*?protected static \$mongoFieldTypes = \[(.*?)\];/s';

// Try preg_match first
if (preg_match($regex, $content, $matches)) {
    echo "✅ preg_match found a match!\n";
    echo "Model name: '" . $matches[1] . "'\n";
} else {
    echo "❌ preg_match found no match\n";
}

// Try preg_match_all
if (preg_match_all($regex, $content, $allMatches, PREG_SET_ORDER)) {
    echo "✅ preg_match_all found " . count($allMatches) . " matches!\n";
} else {
    echo "❌ preg_match_all found no matches\n";
}

// Debug regex errors
$error = preg_last_error();
if ($error !== PREG_NO_ERROR) {
    echo "❌ Regex error: $error\n";
}
