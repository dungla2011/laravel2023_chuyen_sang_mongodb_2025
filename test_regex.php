<?php
$test = '// ========== AffiliateLog Model ==========

    /**
     * Define MongoDB field types for AffiliateLog model
     * Based on SQL: CREATE TABLE `affiliate_logs` (...)
     */
    protected static $mongoFieldTypes = [
        \'_id\' => \'objectId\',
        \'id\' => \'int\',
        \'name\' => \'string\',
    ];';

$regex = '/\/\/ ==========\s+(\w+)\s+Model\s+==========.*?protected static \$mongoFieldTypes = \[(.*?)\];/s';

if (preg_match($regex, $test, $matches)) {
    echo "✅ Regex matched!\n";
    echo "Model name: '" . $matches[1] . "'\n";
    echo "Fields: '" . $matches[2] . "'\n";
} else {
    echo "❌ Regex didn't match\n";
    echo "Testing with: '" . substr($test, 0, 50) . "...'\n";
}

// Test alternative regex
$regex2 = '/\/\/ ==========\s*(\w+)\s+Model\s+==========.*?protected static \$mongoFieldTypes = \[(.*?)\];/s';
if (preg_match($regex2, $test, $matches2)) {
    echo "✅ Alternative regex matched!\n";
    echo "Model name: '" . $matches2[1] . "'\n";
} else {
    echo "❌ Alternative regex didn't match\n";
}
