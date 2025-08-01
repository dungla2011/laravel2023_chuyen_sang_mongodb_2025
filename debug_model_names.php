<?php
/**
 * Debug script to see how model names are being extracted
 */

function parseCleanOutput($filePath) {
    $content = file_get_contents($filePath);
    $models = [];
    
    // Split by model sections - handle both with and without leading spaces
    $sections = preg_split('/(\n|^)\s*\/\/ ==========/', $content);
    
    echo "=== Model Name Extraction Debug ===\n";
    echo "Total sections found: " . count($sections) . "\n";
    
    foreach ($sections as $i => $section) {
        // Skip first section (header)
        if (strpos($section, 'Model ==========') === false) {
            continue;
        }
        
        // Extract model name
        if (preg_match('/^([^=]+?)Model ==========/', $section, $nameMatch)) {
            $modelName = trim($nameMatch[1]);
            echo "Section {$i}: '{$modelName}'\n";
            
            // Extract first few lines for context
            $lines = explode("\n", $section);
            if (count($lines) > 0) {
                echo "  First line: '{$lines[0]}'\n";
            }
            
            if (in_array($modelName, ['CrmMessag', 'HrEmploye', 'MenuTre', 'PersonalAccesToken', 'ProductUsag'])) {
                echo "  ❌ FOUND PROBLEMATIC NAME: '{$modelName}'\n";
                echo "  Full first line: '{$lines[0]}'\n";
            }
        }
    }
}

parseCleanOutput('mongo_fields_fixed.txt');
