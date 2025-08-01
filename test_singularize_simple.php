<?php

// Copy the singularize function here for testing
function singularize($word) {
    // Specific rules first (most specific to least specific)
    $specificRules = [
        'access$' => 'access',
        'trees$' => 'tree',
        'employees$' => 'employee',  
        'certificates$' => 'certificate',
        'expenses$' => 'expense',
        'tokens$' => 'token',
        'responses$' => 'response',
        'enterprises$' => 'enterprise',
        'purchases$' => 'purchase',
        'licenses$' => 'license',
        'practices$' => 'practice',
        'devices$' => 'device',
        'invoices$' => 'invoice',
        'provinces$' => 'province',
        'images$' => 'image',
        'usages$' => 'usage',
        'advantages$' => 'advantage',
        'damages$' => 'damage',
        'packages$' => 'package',
        'messages$' => 'message',
        'passages$' => 'passage',
        'presences$' => 'presence',
        'references$' => 'reference',
        'differences$' => 'difference',
        'preferences$' => 'preference',
        'performances$' => 'performance',
        'instances$' => 'instance',
        'distances$' => 'distance',
        'sentences$' => 'sentence',
        'offenses$' => 'offense',
        'defenses$' => 'defense',
        'interfaces$' => 'interface',
        'surfaces$' => 'surface',
        'purposes$' => 'purpose',
        'promises$' => 'promise',
        'courses$' => 'course',
        'sources$' => 'source',
        'resources$' => 'resource',
        'forces$' => 'force',
        'horses$' => 'horse',
        'houses$' => 'house',
        'causes$' => 'cause',
        'clauses$' => 'clause',
        'uses$' => 'use',
        'bases$' => 'base',
        'cases$' => 'case',
        'phases$' => 'phase',
        'phrases$' => 'phrase',
        'releases$' => 'release',
        'increases$' => 'increase',
        'decreases$' => 'decrease',
        'leases$' => 'lease',
        'diseases$' => 'disease',
        'exercises$' => 'exercise',
        'compromises$' => 'compromise',
        'analyses$' => 'analysis',
        'syntheses$' => 'synthesis',
        'theses$' => 'thesis',
        'hypotheses$' => 'hypothesis',
        'crises$' => 'crisis',
        'oases$' => 'oasis',
        'diagnoses$' => 'diagnosis',
        'prognoses$' => 'prognosis',
        'parentheses$' => 'parenthesis',
        'ellipses$' => 'ellipsis',
        'synopses$' => 'synopsis',
        'metropolises$' => 'metropolis',
        'necropolises$' => 'necropolis',
        'acropolis$' => 'acropolis',
        'matrices$' => 'matrix',
        'vertices$' => 'vertex',
        'indices$' => 'index',
        'appendices$' => 'appendix',
        'radii$' => 'radius',
        'alumni$' => 'alumnus',
        'fungi$' => 'fungus',
        'cacti$' => 'cactus',
        'foci$' => 'focus',
        'nuclei$' => 'nucleus',
        'syllabi$' => 'syllabus',
        'children$' => 'child',
        'feet$' => 'foot',
        'teeth$' => 'tooth',
        'geese$' => 'goose',
        'mice$' => 'mouse',
        'men$' => 'man',
        'women$' => 'woman',
        'people$' => 'person',
        'oxen$' => 'ox',
        'sheep$' => 'sheep',
        'deer$' => 'deer',
        'fish$' => 'fish',
        'series$' => 'series',
        'species$' => 'species',
        'data$' => 'datum',
        'media$' => 'medium',
        'criteria$' => 'criterion',
        'phenomena$' => 'phenomenon',
    ];

    // Apply specific rules
    foreach ($specificRules as $pattern => $replacement) {
        if (preg_match('/' . $pattern . '/i', $word)) {
            return preg_replace('/' . $pattern . '/i', $replacement, $word);
        }
    }

    // General rules (applied after specific rules)
    $generalRules = [
        'ies$' => 'y',      // cities -> city, companies -> company
        'ves$' => 'fe',     // lives -> life, knives -> knife
        'oes$' => 'o',      // heroes -> hero, potatoes -> potato
        'ches$' => 'ch',    // matches -> match, watches -> watch
        'shes$' => 'sh',    // dishes -> dish, brushes -> brush
        'xes$' => 'x',      // boxes -> box, taxes -> tax
        'zes$' => 'z',      // quizzes -> quiz
        'sses$' => 'ss',    // classes -> class, addresses -> address
        's$' => '',         // cars -> car, books -> book (most common)
    ];

    // Apply general rules
    foreach ($generalRules as $pattern => $replacement) {
        if (preg_match('/' . $pattern . '/i', $word)) {
            return preg_replace('/' . $pattern . '/i', $replacement, $word);
        }
    }

    return $word; // If no rule matches, return the original word
}

function tableNameToModelName($tableName) {
    $parts = explode('_', $tableName);
    $modelName = '';
    
    foreach ($parts as $part) {
        $modelName .= ucfirst(singularize($part));
    }
    
    return $modelName;
}

// Test singularize function
echo "=== Testing Singularize Function ===\n";

$testWords = [
    'menu_trees' => 'MenuTree',
    'cache_key_values' => 'CacheKeyValue', 
    'crm_messages' => 'CrmMessage',
    'hateco_certificates' => 'HatecoCertificate',
    'hr_employees' => 'HrEmployee',
    'hr_job_titles' => 'HrJobTitle',
    'telescope_entries' => 'TelescopeEntry',
    'telescope_entry_tags' => 'TelescopeEntryTag',
    'personal_access_tokens' => 'PersonalAccessToken',
    'product_usages' => 'ProductUsage',
    'hr_user_expenses' => 'HrUserExpense'
];

foreach ($testWords as $tableName => $expected) {
    $result = tableNameToModelName($tableName);
    $status = ($result === $expected) ? '✅' : '❌';
    echo "{$status} {$tableName} -> {$result} (expected: {$expected})\n";
}
