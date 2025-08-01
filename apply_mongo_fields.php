<?php
/**
 * Script to automatically apply MongoDB field types to all model files
 * Based on the field types generated from SQL structure
 */

require_once __DIR__ . '/vendor/autoload.php';

$fieldDefinitions = [
    'ConferenceCat' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
    ],
    'ConferenceInfo' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'sub_title' => 'string',
        'summary' => 'string',
        'images' => 'string',
        'cat' => 'int',
        'key_notes' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'conf1_video' => 'string',
        'conf1_images' => 'string',
        'conf1_image_title' => 'string',
        'conf1_timesheet' => 'string',
        'conf1_keynote' => 'string',
        'conf1_name' => 'string',
        'conf2_name' => 'string',
        'conf2_keynote' => 'string',
        'conf2_timesheet' => 'string',
        'conf2_images' => 'string',
        'conf2_image_title' => 'string',
        'conf2_video' => 'string',
        'conf3_video' => 'string',
        'conf3_images' => 'string',
        'conf3_image_title' => 'string',
        'conf3_timesheet' => 'string',
        'conf3_keynote' => 'string',
        'conf3_name' => 'string',
        'video_bottom' => 'string',
        'supporters' => 'string',
        'right_column' => 'string',
        'orders' => 'int',
    ],
    'CostItem' => [
        '_id' => 'objectId',
        'id' => 'int',
        'item_name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'category' => 'int',
        'cost' => 'int',
        'quantity' => 'int',
        'depreciation' => 'int',
    ],
    'CrmAppInfo' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
    ],
    'CrmMessage' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'type' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'msg_id' => 'string',
        'cli_msg_id' => 'string',
        'action_id' => 'string',
        'msg_type' => 'string',
        'uid_from' => 'string',
        'id_to' => 'string',
        'd_name' => 'string',
        'ts' => 'int',
        'content' => 'string',
        'notify' => 'int',
        'ttl' => 'int',
        'uin' => 'string',
        'user_id_ext' => 'string',
        'cmd' => 'int',
        'st' => 'int',
        'at' => 'int',
        'real_msg_id' => 'string',
        'thread_id' => 'string',
        'is_self' => 'int',
        'property_ext' => 'string',
        'params_ext' => 'string',
        'channel_name' => 'string',
    ],
    'CrmMessageGroup' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'gid' => 'string',
        'avatar' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'link_group' => 'string',
        'channel_name' => 'string',
        'full_info' => 'string',
    ],
    'DepartmentEvent' => [
        '_id' => 'objectId',
        'id' => 'int',
        'user_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'log' => 'string',
        'event_id' => 'int',
        'department_id' => 'int',
    ],
    'DepartmentUser' => [
        '_id' => 'objectId',
        'id' => 'int',
        'user_id' => 'int',
        'department_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'log' => 'string',
    ],
    'DownloadLog' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'log' => 'string',
        'sid_download' => 'double',
        'file_refer_id' => 'int',
        'file_id' => 'int',
        'file_id_enc' => 'string',
        'filename' => 'string',
        'size' => 'int',
        'ip_request' => 'string',
        'ip_download_done' => 'string',
        'time_download_done' => 'date',
        'count_dl' => 'int',
        'sid_encode' => 'string',
        'price_k' => 'int',
        'user_id_file' => 'int',
    ],
    'EventAndUser' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'user_event_id' => 'int',
        'event_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'sent_mail_at' => 'date',
        'sent_sms_at' => 'date',
        'confirm_join_at' => 'date',
        'deny_join_at' => 'date',
        'attend_at' => 'date',
        'note' => 'string',
        'extra_info1' => 'string',
        'extra_info2' => 'string',
        'extra_info3' => 'string',
        'extra_info4' => 'string',
        'extra_info5' => 'string',
        'signature' => 'int',
    ],
    'EventFaceInfo' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'user_event_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'extra_info' => 'string',
        'face_vector' => 'string',
    ],
    'EventRegister' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'user_event_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'event_id' => 'int',
        'phone' => 'string',
        'address' => 'string',
        'organization' => 'string',
        'note' => 'string',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'reg_code' => 'string',
        'reg_confirm_time' => 'date',
        'lang' => 'string',
        'gender' => 'int',
        'designation' => 'string',
        'content_mail1' => 'string',
        'content_mail2' => 'string',
        'sub_event_list' => 'string',
    ],
    'FileUpload' => [
        '_id' => 'objectId',
        'id' => 'int',
        'id__' => 'string',
        'name' => 'string',
        'user_id' => 'int',
        'created_at' => 'date',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'file_path' => 'string',
        'file_size' => 'int',
        'log' => 'string',
        'parent_id' => 'int',
        'cloud_id' => 'int',
        'md5' => 'string',
        'crc32' => 'string',
        'comment' => 'string',
        'mime' => 'string',
        'refer' => 'string',
        'count_download' => 'int',
        'idlink' => 'int',
        'checksum' => 'string',
        'link1' => 'string',
        'ip_upload' => 'string',
    ],
    'FolderFile' => [
        '_id' => 'objectId',
        'id' => 'int',
        'id__' => 'string',
        'name' => 'string',
        'created_at' => 'date',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'parent_id' => 'int',
        'orders' => 'int',
        'user_id' => 'int',
        'link1' => 'string',
    ],
    'NewsFolder' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'created_at' => 'date',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'parent_id' => 'int',
        'log' => 'string',
        'status' => 'int',
        'orders' => 'int',
        'front' => 'int',
    ],
    'ProductFolder' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'parent_id' => 'int',
        'summary' => 'string',
        'content' => 'string',
        'orders' => 'int',
        'meta_desc' => 'string',
        'front' => 'int',
    ],
    'ProductTag' => [
        '_id' => 'objectId',
        'id' => 'int',
        'product_id' => 'int',
        'tag_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
    ],
    'Tag' => [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
    ],
];

function generateFieldTypeCode($modelName, $fields) {
    $code = "    /**\n";
    $code .= "     * Define MongoDB field types for {$modelName} model\n";
    $code .= "     * Based on SQL table structure\n";
    $code .= "     */\n";
    $code .= "    protected static \$mongoFieldTypes = [\n";
    
    foreach ($fields as $field => $type) {
        $code .= "        '{$field}' => '{$type}',\n";
    }
    
    $code .= "    ];";
    
    return $code;
}

function updateModelFile($modelName, $fields) {
    $modelFile = __DIR__ . "/app/Models/{$modelName}.php";
    
    if (!file_exists($modelFile)) {
        echo "Model file not found: {$modelFile}\n";
        return false;
    }
    
    $content = file_get_contents($modelFile);
    
    // Check if field types already exist
    if (strpos($content, 'protected static $mongoFieldTypes') !== false) {
        echo "Model {$modelName} already has field types defined\n";
        return true;
    }
    
    // Find the class declaration and protected $guarded line
    $patterns = [
        '/^class\s+' . $modelName . '\s+extends\s+\w+\s*\{.*?protected\s+\$guarded\s*=\s*\[.*?\];/ms',
        '/^class\s+' . $modelName . '\s+extends\s+\w+\s*\{.*?use\s+.*?;.*?protected\s+\$guarded\s*=\s*\[.*?\];/ms'
    ];
    
    $fieldTypeCode = generateFieldTypeCode($modelName, $fields);
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            $replacement = $matches[0] . "\n\n" . $fieldTypeCode;
            $content = str_replace($matches[0], $replacement, $content);
            
            file_put_contents($modelFile, $content);
            echo "✅ Updated {$modelName} model with field types\n";
            return true;
        }
    }
    
    echo "❌ Could not find insertion point in {$modelName} model\n";
    return false;
}

echo "Starting to apply MongoDB field types to models...\n\n";

$updated = 0;
$total = count($fieldDefinitions);

foreach ($fieldDefinitions as $modelName => $fields) {
    if (updateModelFile($modelName, $fields)) {
        $updated++;
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Summary:\n";
echo "✅ Successfully updated: {$updated} models\n";
echo "📁 Total models processed: {$total}\n";
echo "📊 Success rate: " . round(($updated / $total) * 100, 1) . "%\n";
echo str_repeat("=", 50) . "\n";
