<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use LadLib\Laravel\Database\TraitModelExtra;
use LadLib\Laravel\Database\TraitModelTree;
use Illuminate\Support\Facades\Schema;

/**
 * Chứa base cho models...
 */
class ModelGlxBase extends Model
{
    use TraitModelExtra, TraitModelTree;
    
    protected $connection = 'mongodb';
    protected $afterSaveCalled = false;
    
    // MongoDB configuration
    protected $primaryKey = '_id'; // Explicitly set primary key
    public $incrementing = false; // MongoDB doesn't auto-increment
    protected $keyType = 'mixed'; // Allow various key types, nhờ có cái này mà ->_id hoặc ->id đều được

    static $is_has_field_id__ = null;

    public function getDatabaseName()
    {
        $databaseName = Config::get('database.connections.'.Config::get('database.default'));
        return $databaseName['database'];
    }

    function getNameTitle()
    {
        if($this->name)
            return $this->name;
        if($this->title)
            return $this->title;
        if($this->first_name && $this->last_name)
            return $this->last_name . " " . $this->first_name ;

    }

    public static $createRules;

    function hasField($field)
    {
        $table = $this->getTable();
        return Schema::hasColumn($table, $field);
    }

    public function save(array $options = [])
    {
        $saved = parent::save($options);
        if ($saved) {
            $this->afterSave();
        }
        return $saved;
    }

    public static function create(array $attributes = [])
    {
        $model = static::query()->create($attributes);
        if(isDebugIp()){
//            die("xxxx");
        }
        $model->afterSave();
        return $model;
    }

//    public function insert(array $attributes = [])
//    {
////        $inserted = parent::insert($attributes);
//        $inserted = DB::table($this->getTable())->insert($attributes);
//        if ($inserted) {
//            $this->afterSave();
//        }
//        return $inserted;
//    }

    protected function afterSave()
    {
//        if (isDebugIp())
        {
            if ($this->afterSaveCalled) {
                return;
            }
            $this->afterSaveCalled = true;

            if(method_exists($this, 'afterInsertModel'))
            {
                $this->afterInsertModel();
            }

            if($this->hasField('ide__') && !$this->ide__) {
                $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
                $shortUuid = substr($uuid, 0, 13); // Lấy 18 ký tự đầu
                $this->ide__ = $shortUuid;
                $this->addLog("update new ide__ $shortUuid");
                $this->save();
            }

//            die("8o08080");
            if($this->hasField('id__') && !$this->id__) {
                if(isIPDebug()){
//                        die("ID__ = 0");
                }
                $ide = qqgetRandFromId_($this->id);
//                die("IDE = $ide");
                $this->id__ = $ide;
                $this->addLog("update new id__ $ide");
                $this->save();
            }
            $this->afterSaveCalled = false;
        }
    }

    public static function getArrayFieldFullInfo(){
        $instance = new static;
        $tableName = $instance->getTable();
        $connectionName = $instance->getConnectionName();
        $databaseName = $instance->getDatabaseName();
        $m1 = \DB::connection($connectionName)->select("
    SELECT COLUMN_NAME AS Field,
           COLUMN_TYPE AS Type,
           IS_NULLABLE AS `Null`,
           COLUMN_KEY AS `Key`,
           COLUMN_DEFAULT AS `Default`,
           EXTRA AS Extra,
           COLUMN_COMMENT AS Comment
    FROM information_schema.columns
    WHERE table_schema = ? AND table_name = ?
", [$databaseName, $tableName]);

        $ret = [];
        foreach ($m1 as $m2) {
            $ret[$m2->Field] = (array)$m2;
        }
        return $ret;

    }
    public static function getArrayField()
    {
        $instance = new static;
        $connectionName = $instance->getConnectionName();
        
        // Check if this is MongoDB connection
        if ($connectionName === 'mongodb' || strpos($connectionName, 'mongo') !== false) {
            // For MongoDB, return fields from static property if defined
            $mongoTypes = static::getMongoFieldTypes();
            if (!empty($mongoTypes)) {
                return array_keys($mongoTypes);
            }
            
            // Fallback: try to get fields from a sample document
            $tableName = $instance->getTable();
            $sampleDoc = DB::connection($connectionName)->table($tableName)->first();
            if ($sampleDoc) {
                return array_keys((array)$sampleDoc);
            }
            
            // If no sample document, return empty array
            return [];
        }
        
        // For SQL databases, use original DESCRIBE method
        $tableName = $instance->getTable();
        $m1 = DB::connection($connectionName)->select('DESCRIBE ' . $tableName);
        $ret = [];
        foreach ($m1 as $m2) {
            $ret[$m2->Field] = $m2->Type;
        }
        return array_keys($ret);
    }

    /**
     * Get MongoDB field types safely
     */
    public static function getMongoFieldTypes()
    {
        if (property_exists(static::class, 'mongoFieldTypes')) {
            return static::$mongoFieldTypes ?? [];
        }
        return [];
    }
    
    public static function getArrayFieldAndDataType()
    {
        $instance = new static;
        $connectionName = $instance->getConnectionName();
        
        // Check if this is MongoDB connection
        if ($connectionName === 'mongodb' || strpos($connectionName, 'mongo') !== false) {
            // For MongoDB, return field types from static property if defined
            $mongoTypes = static::getMongoFieldTypes();
            if (!empty($mongoTypes)) {
                return $mongoTypes;
            }
            
            // Fallback: try to infer types from a sample document
            $tableName = $instance->getTable();
            $sampleDoc = DB::connection($connectionName)->table($tableName)->first();
            if ($sampleDoc) {
                $ret = [];
                foreach ((array)$sampleDoc as $field => $value) {
                    $ret[$field] = self::inferMongoFieldType($value);
                }
                return $ret;
            }
            
            // If no sample document, return empty array
            return [];
        }
        
        // For SQL databases, use original DESCRIBE method
        $tableName = $instance->getTable();
        $m1 = DB::connection($connectionName)->select('DESCRIBE ' . $tableName);
        $ret = [];
        foreach ($m1 as $m2) {
            $ret[$m2->Field] = $m2->Type;
        }
        return $ret;
    }
    
    /**
     * Infer MongoDB field type from value
     */
    private static function inferMongoFieldType($value)
    {
        if (is_null($value)) return 'mixed';
        if (is_bool($value)) return 'boolean';
        if (is_int($value)) return 'int';
        if (is_float($value)) return 'double';
        if (is_array($value)) return 'array';
        if (is_object($value)) {
            if (isset($value->{'$oid'})) return 'objectId';
            if (isset($value->{'$date'})) return 'date';
            return 'object';
        }
        return 'string';
    }

    public function delete()
    {
        //        if(isSupperAdmin_())

        //die("ABC = " . $this->id);
        $m1 = [];
        $m1['user_id'] = getUserIdCurrent_();
        if ($iad = isSupperAdmin_()) {
            $m1['user_id_admin'] = $iad;
        }
        //$m1['change_log'] = serialize($mret);
        $m1['tables'] = $this->getTable();
        $m1['id_row'] = $this->getId();
        $m1['cmd'] = 'delete';
        $m1['ip_address'] = @$_SERVER['REMOTE_ADDR'];
        ChangeLog::insert($m1);

        return parent::delete(); // TODO: Change the autogenerated stub
    }

    public function getEditLinkAdm()
    {
        $meta = $this::getMetaObj();

        return $meta->getAdminUrlWeb()."/edit/".$this->getId();
    }

    public function getLinkAdmIndex()
    {
        $meta = $this::getMetaObj();

        return $meta->getAdminUrlWeb();
    }

    public function updateNotWriteLog(array $attributes = [], array $options = [])
    {
        return $this->update($attributes, $options, 0);
    }

    public function getLinkPublic()
    {
        return null;
    }

    public function addLog($log, $updateDb = 0)
    {
        //if (property_exists($this, 'log'))

        if(!$this->hasField('log'))
            return;

        if(strlen($this->log ) > 60000){
            $this->log = substr($this->log , 0,30000);
        }

        if (! isset($this->log) || ! $this->log) {
            $this->log = "\n#".nowyh()."#$log";
        } else {
            $this->log .= "\n#".nowyh()."#$log";
        }
        //return 1;
        if ($updateDb) {
            $this->updateNotWriteLog();
        }

    }

    /**
     * Ghi log với tag
     *
     * @param  array  $attributes
     * @return bool|void
     */
    public function updateAndTag($tagLog, $attributes = [], array $options = [])
    {
        return $this->update($attributes, $options, 1, $tagLog);
    }

    public function update(array $attributes = [], array $options = [], $writeLog = 1, $tagLog = null)
    {
        $meta = $this::getMetaObj();

        if($meta && $idBlock = $meta::getIdReadOnlyIfNotSupperAdmin())
        {
            if($idBlock == $this->getId())
            if(!isAdminACP_()){
                loi("NOT ALLOW UPDATE DEMO-ID1 ($idBlock) - " . get_class($meta));
            }
        }




        $inDb0 = null;
        //Update change Log:
        if ($writeLog && $this->getTable() != 'change_logs') {
            //Lấy obj từ DB ra
            if (! $inDb0 = static::find($this->getId())) {
                loi("Not found obj: $this->id");
            }
            $inDb = $inDb0->toArray();
            $md = [];

            $mmMeta = $this::getApiMetaArray();

            if ($attributes) {

                foreach ($attributes as $k1 => $v1) {
                    //Không update trường pw nếu rỗng, vì rỗng là ko set, chứ ko phải set rỗng
                    //Todo need re-test tính năng không update pw nếu rỗng
                    if (isset($mmMeta[$k1]) && $mmMeta[$k1]->isPassword($k1)) {
                        if (! $v1) {
                            unset($attributes[$k1]);

                            //Và rỗng thì ko update changelog vào db
                            continue;
                        }
                    }

                    if (($v1 && ! isset($inDb[$k1])) || (isset($inDb[$k1]) && $v1 != $inDb[$k1])) {
                        $md[$k1] = $v1;
                    }
                }

            } else {
                //                $md = array_diff($this->toArray(), $inDb);
                foreach ($this->toArray() as $k1 => $v1) {

                    //Không update trường pw nếu rỗng, vì rỗng là ko set, chứ ko phải set rỗng
                    //Todo need re-test tính năng không update pw nếu rỗng
                    if (isset($mmMeta[$k1]) && $mmMeta[$k1]->isPassword($k1)) {
                        if (! $v1) {
                            unset($this->$k1);

                            //Và rỗng thì ko update changelog vào db
                            continue;
                        }
                    }
                    if (($v1 && ! isset($inDb[$k1])) || (isset($inDb[$k1]) && $v1 != $inDb[$k1])) {
                        $md[$k1] = $v1;
                    }
                }
            }

            if(isCli()){

//                echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//                print_r($attributes);
//                echo "</pre>";
//                die();
            }
            $mret = [];
            foreach ($md as $k => $v) {

                //một số trường không update log:
                if(in_array($k, ['log', 'updated_at', 'count_download', 'count_view' ])){
                    continue;
                }
//                if ($k == 'log' || $k == 'updated_at' || $k == 'count_download' || $k == 'count_view') {
//                    continue;
//                }
                if ($k == 'token_user' || $k == 'password' || $k == 'secret') {
                    $inDb[$k] = $v = '(not show)';
                }

                //Nếu post lên là _ thì không ghi log
                if ($k[0] == '_') {
                    continue;
                }

                //                echo "<br/>\n DIF: " . $inDb[$k] . " / $v";
                $fd = '';
                if ($meta) {
                    $fd = $meta->getDescOfField($k);
                    if (in_array($k, $meta->getDisableChangeLogField())) {
                        continue;
                    }

                    //Dạng date trong db khác với của php
                    if ($meta->getDbDataType($k) == 'datetime') {
                        if (strtotime($inDb[$k]) == strtotime($v)) {
                            continue;
                        }
                    }
                }
                $mret[$k] = ['from' => $inDb[$k], 'to' => $v, 'field_des' => $fd];
            }

            if ($mret) {
                $m1 = [];
                $m1['user_id'] = getUserIdCurrent_();
                if ($iad = isSupperAdmin_()) {
                    $m1['user_id_admin'] = $iad;
                }
                $m1['change_log'] = serialize($mret);
                $m1['tables'] = $this->getTable();
                $m1['id_row'] = $this->getId();
                $m1['cmd'] = 'update';
                $m1['ip_address'] = @$_SERVER['REMOTE_ADDR'];
                $m1['tag_log'] = $tagLog;
                ChangeLog::insert($m1);
            }
        }

        $thisArray = $this->toArray();
        //Nếu có parent, thì phải update parent


        //                $mx = (object) $this->toArray();
        if (array_key_exists('parent_id', $thisArray) && array_key_exists('parent_extra', $thisArray)) {
            if (! $inDb0) {
                $inDb0 = static::find($this->getId());
            }

            ////////////////////////////////////////////////////////
            //Cập nhât lại list PID:
            if (array_key_exists('parent_id', $attributes)) {
                if ($inDb0->parent_id != $attributes['parent_id']
                || (array_key_exists('parent_extra', $thisArray) &&
                        array_key_exists('parent_extra', $attributes) &&
                        $inDb0->parent_extra != $attributes['parent_extra'])
                ) {
                    $this->parent_id = $attributes['parent_id'];
                    if (array_key_exists('parent_extra', $attributes)) {
                        $this->parent_extra = $attributes['parent_extra'];
                    }
                    $this->updateParentList(1);
                    if (isset($this->parent_all)) {
                        $attributes['parent_all'] = $this->parent_all;
                    }
                }
            }
        }

        //Bỏ các trường tiền tố _ đi?
        //        foreach ($attributes AS $key=>$val){
        //            if($key[0] == '_')
        //                unset($attributes[$key]);
        //        }
//        if(0)
            if (isDebugIp()) {

                //Bo tat cac $attributes co key bat dau bang _
                foreach ($attributes AS $key=>$val){
                    if($key[0] == '_')
                        unset($attributes[$key]);
                }

//                $attributes['id'] = $this->id;
//                echo "id = $this->id <pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//                print_r($attributes);
//                echo "</pre>";


//                die();
            }


        return parent::update($attributes, $options); // TODO: Change the autogenerated stub
    }

    /**
    $mm = \App\Models\QuizQuestion::all();
    foreach ($mm AS $obj){
        if($obj instanceof \App\Models\QuizQuestion);
        if($obj->updateParentList()){
            echo "<br/>\n OK PR : $obj->parent_list";
        }
        else
            echo "<br/>\n NOT PR? ";
    }
     * @return int
     */
    public function updateParentList($notsave = 0)
    {
        //        if(!isSupperAdmin_())
        //            return;
        $metaA = static::getApiMetaArray();
        //        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
        //        print_r($metaA);
        //        echo "</pre>";
        //        echo "<br/>\n " . $metaA->parent_id;


        if (($metaA['parent_id'] ?? '') && ($metaA['parent_extra'] ?? '')) {
            //Gan vao de lay PID list:
            $mPid = $this->getListParentId();
            $metaObj = static::getMetaObj();
            $clsPr = $metaObj::$folderParentClass;
            //            echo "<pre> == $this->id >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
            //            print_r($mPid);
            //            echo "</pre>";
            //            die();
            //            $this->parent_list = implode(",", $mPid);

            $mIdPrEx = [];
            if ($metaA['parent_all'] ?? '') {
                //                $this->parent_all = $this->parent_list;
                if ($metaA['parent_extra'] ?? '') {
                    //                    $this->parent_all .= ','.$this->parent_extra;
                    $mIdExtra = explode(',', $this->parent_extra);
                    //                    if(isSupperAdmin_()){
                    //
                    //                        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
                    //                        print_r($mIdExtra);
                    //                        echo "</pre>";
                    //                       die("ABC = ");
                    //                    }
                    foreach ($mIdExtra as $idE) {
                        if ($idE && $objPr = $clsPr::find($idE)) {
                            if ($objPr instanceof ModelGlxBase);
                            $more = $objPr->getListParentId(1);
                            if ($more && is_array($more)) {
                                $mIdPrEx = array_merge($mIdPrEx, $more);
                            }
                        }
                    }
                }
                $allId = array_merge($mPid, $mIdPrEx);
                $allId = array_unique($allId);
                $this->parent_all = implode(',', $allId);
            }

            if (! $notsave) {
                $this->save();
            }

            return 1;
        } else {
            //            return rtJsonApiError("Not valid pr to update?")
        }

        return 0;
    }

    /*

    function create($pr){
        //Update parent_list
        //Xử lý trường hợp save bằng hàm ->create($param):
        //Đoạn này sẽ thêm parent_list vào
        //Sau đó hàm save bên dưới sẽ được gọi, mới là Thực save vào DB
        if($pr['parent_id'] ?? '' && is_numeric($pr['parent_id'])){
            $metaA = static::getApiMetaArray();
            if(array_key_exists('parent_id', $metaA) && array_key_exists('parent_list', $metaA)){
                    //Gan vao de lay PID list:
                    $this->parent_id = $pr['parent_id'];
                    $mPid = $this->getListParentId();
                    if($mPid)
                        $pr['parent_list'] = implode(",", $mPid);
                    unset($this->parent_id);
            }
        }

        return parent::create($pr);
    }*/

    /**
     * Hàm create sẽ gọi save này???
     *
     * @return bool
     */
//    public function save(array $options = [])
//    {
//        $thisArray = $this->toArray();
//        if (array_key_exists('parent_id', $thisArray) && array_key_exists('parent_extra', $thisArray)) {
//            //Chỗ này bị conflick, vì khi chưa save pid, thì ko có pid list mới, sẽ bị sai
//            //            $mPid = $this->getListParentId();
//            //            $this->parent_extra = implode(",", $mPid);
//
//        }
//
//        return parent::save($options); // TODO: Change the autogenerated stub
//    }
}
