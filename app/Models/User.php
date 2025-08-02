<?php

namespace App\Models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use LadLib\Laravel\Database\TraitModelExtra;
use Laravel\Sanctum\HasApiTokens;

class User2 extends UserGlx
{
    use HasFactory, SoftDeletes, TraitModelExtra;
}

/**
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 */
//class User extends Authenticatable
//Sử dụng UserGlx để có thể ghi ChangeLog:
class User extends UserGlx
{
    use HasFactory, SoftDeletes, TraitModelExtra;
//    protected $fillable = ['password'];

    //Token phan quyen ko dung cai nay van chay: use HasApiTokens;

    protected $guarded = [];
    
    /**
     * Define MongoDB field types for this model
     * Since MongoDB doesn't have DESCRIBE like SQL, we define it manually
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'name' => 'string',
        'email' => 'string', 
        'username' => 'string',
        'password' => 'string',
        'email_verified_at' => 'date',
        'remember_token' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'is_admin' => 'boolean',
        'token_user' => 'string',
        'role_ids' => 'array', // embedded role IDs
        'log' => 'string',
        'email_active_at' => 'date',
        'site_id' => 'int',
        'id__' => 'string',
        'ide__' => 'string',
    ];
    
    //
    //    function getTable()
    //    {
    ////        return "users";
    //    }

    public function getValidateRuleInsert()
    {
        return [
            'email' => 'sometimes|required|email:rfc,dns|max:100|min:6|unique:users',
            //            'username'=>'required|regex:/^[a-zA-Z]{1}/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users',
            'username' => 'sometimes|required|regex:/\w*$/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users,username,',
            'password' => 'nullable|max:50|min:8',
        ];
    }

    public function getValidateRuleUpdate($id = null)
    {
        return [
            'email' => 'sometimes|required|email:rfc,dns|max:100|min:6|unique:users,email,'.$id,
            //'username'=>'required|regex:/^[a-zA-Z]{1}/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users,username,'.$id,
            'username' => 'sometimes|required|regex:/\w*$/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users,username,'.$id,
            'password' => 'nullable|max:50|min:8',
        ];
    }

    public static function getTokenByUserId($uid)
    {
        $user = User::where('id', $uid)->first();
        if (! $user) {
            return null;
        }

        return $user->getJWTUserToken();
    }

    function hasRole($roleId)
    {
        $mRoleId = $this->getRoleIdUser(1);
        if($mRoleId)
        if(in_array($roleId, $mRoleId))
            return true;
        return false;
    }

    public function setUserTokenIfEmpty()
    {
        return;
        if ($this->token_user) {
            return;
        }
        $sid = getSiteIDByDomain();
        $tokenUs = eth1b($sid.'-uid.'.$this->id.'-'.microtime().'-'.rand());
        $this->token_user = $tokenUs;
        $this->update();
    }

    function getRoleNames()
    {
        $roles = $this->_roles(); // Remove ->get() since _roles() already returns Collection
        $ret = '';
        foreach ($roles as $role) {
            $ret .= $role->name.', ';
        }
        return trim($ret, ', ');
    }

    public function getJWTUserToken()
    {
        $payload = [
            'user_id' => $this->id,
            'exp' => time() + 60 * 60 * 24 * 180,
        ];
        return 'TK1_'.JWT::encode($payload, env('APP_KEY'), 'HS256');
    }

    public function getUserToken()
    {
        //        if(!$this->token_user)
        //            loi("Not found user token!");
        return $this->token_user;
    }

    public static function getTokenByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (! $user) {
            return null;
        }

        return $user->getJWTUserToken();
    }

    function getNameTitle()
    {
        return $this->name ?? $this->email ?? $this->username;
    }

    public static function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (! $user) {
            return null;
        }

        return $user;
    }

    /**
     * @return User
     */
    public static function getUserByTokenAccess($tk = null)
    {
        //Token được gửi từ Header
        //Lấy Token từ DB, sau đó tìm ra userid,

        if ($tk) {
            $tk1 = $tk;
        }
        else
            $tk1 = trim(request()->bearerToken());

        if(!$tk1){
            //Cho cac phien ban cu:
            $tk1 = request()->header("accesstoken01");
//            die("TK1 = $tk1");
        }
        if(!$tk1){
            $tk1 = $_COOKIE['_tglx863516839'] ?? '';
        }

        if(isDebugIp()){
//            die("TKx = $tk1");
        }

        //Neu token dang tk1_
        if(str_starts_with($tk1, 'TK1_')){
            // echo " 309840923 ";
            $tk1 = substr($tk1, 4);
            $payloadTk = JWT::decode($tk1, new Key(env('APP_KEY'), 'HS256'));
//            $payloadTk = JWT::decode($tk1, env('APP_KEY'), 'HS256');
            $userid = $payloadTk->user_id ?? null;

            // echo " UID = $userid ";

            $user = User::find($userid);

            // dump($user->toArray());

            return $user;
        }


        //get_headers();

        //
        //        die("TK1 = $tk1");

        if (! $tk1 || strlen($tk1) < 3) {
            return null;
        }
        //$tk1 = request()->header("token_user");
        //Lấy ra user với token nếu có

        //        DB::enableQueryLog();
        $user = User::where('token_user', $tk1)->first();
        //
        //        $qr = DB::getQueryLog();
        //        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
        //        print_r($qr);
        //        echo "</pre>";

        return $user;
    }

    /**
     * @return User|Model|object|null
     */
    public static function findUserWithEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function loginAndSetCookieToken($email)
    {
        if ($user = User::where('email', $email)->first()) {
            Auth::login($user);
            //            dump("Set cookie...");
            setcookie('_tglx863516839', $user->getJWTUserToken(), time() + 3600 * 24 * 180, '/');

            return $user;
        }

        return null;
    }

    /**
     * Get user roles using embedded role_ids approach (MongoDB best practice)
     * @return \Illuminate\Support\Collection
     */
    public function _roles()
    {
        // Use embedded role_ids instead of pivot table
        if (!isset($this->role_ids) || !is_array($this->role_ids)) {
            return collect(); // Return empty collection
        }
        
        return Role::whereIn('_id', $this->role_ids)->get();
    }

    /**
     * Kiểm tra quyền của user trên route hiện tại
     *
     * @return bool
     */
    public static function checkPermissionRouteName($routeName)
    {

        //        dump(auth()->user()->email);
        //Nếu là API
        if (request()->is('api/*')) {

            $user = User::getUserByTokenAccess();

            /////////////////////////////////////////////////////
            //Nếu ko đúng token thì return luôn, ko check session
            if (DEF_DISABLE_SESSION_FOR_API) {
                if (! $user) {
                    return null;
                }
            }

            $tokenUser = request()->bearerToken();

            //            echo "<br/>\n Email: $user->email";

            if ($user) {

                //Chỉ khi user Token và session khác nhau mới cần login lại Sesion với user Token
                //nếu ko sẽ bị logout web
                //Cũng có thể ko cần login webSession ở đây, nghĩa là bỏ đoạn này đi
                if (auth()->id() != $user->id) {
                    //Với API token, thiết lập user logined ở đây để báo lỗi 403 có thể nhận ra user đang login, Nếu ko sẽ nhận là Guest
                    //Login này sẽ xóa session cũ nếu có
                    Auth::login($user);
                }

            } else {
                //Nếu ko có token, vẫn có thể dựa trên Web Url, check session
                //Muốn check session ở đây, thì trong RouteServiceProvider::boot() , với api phải đặt ->middleware('web')
                //Với API, nếu token rỗng, thì mới xác thực bằng session
                //Vì có trường hợp session được SET khi Token đã login thành công, sau đó đổi 1 token lỗi, thì vẫn nhận session user cũ, là sai logic)
                if (! $tokenUser) {
                    if ($user = auth()->user()) {
                    } else {
                        return false;
                    }
                }
            }

        } //Nếu là Web, sẽ dùng session
        else {
            //            die("xxx");
            $user = auth()->user();
        }

        if ($user instanceof User);

        if (! $user) {
            return false;
        }

        //1. Lấy ra các role của user
        $roles = $user->_roles();

        foreach ($roles as $role) {
            if ($role instanceof Role);
            //2. Từng role, lấy ra list permission của role đó, so sánh
            if ($role->permissions->contains('route_name_code', $routeName)) {
                return true;
            }
            //            dump($role->permissions);
        }

        return false;
    }

    public function getAllRouteNameAllowThisUserAndUrl()
    {
        $roles = $this->_roles();
        $mRouteAllowUser = [];
        foreach ($roles as $role) {
            if ($role instanceof Role);
            $pers = ($role->permissions()->get());
            foreach ($pers as $per) {
                if ($per instanceof Permission);
                $mRouteAllowUser[$per->url] = $per->route_name_code;
            }
        }

        return $mRouteAllowUser;
    }

    public function getAllRouteNameAllowThisUser()
    {
        $roles = $this->_roles();
        $mRouteAllowUser = [];
        foreach ($roles as $role) {
            if ($role instanceof Role);
            $pers = ($role->permissions()->get());
            foreach ($pers as $per) {
                if ($per instanceof Permission);
                $mRouteAllowUser[] = $per->route_name_code;
            }
        }

        return $mRouteAllowUser;
    }

    public function removeAllPermissionOnUser()
    {
        $roles = $this->_roles();
        //Tìm tất cả role, sau đó tìm pers...
        foreach ($roles as $role) {
            if ($role instanceof Role);
            $role->permissions()->sync([]);
        }
    }

    //Kiểm tra guest có quyền này không:
    //echo \App\Models\User::checkGuestPermissionRoute('api.member-tree-mng.tree-index');
    public static function checkGuestPermissionRoute($routeName)
    {
        return DB::table('permission_role')->where(['role_id' => 0, 'permission_id' => trim($routeName)])->count();
    }

    public function removePermissionRouteNameOnUser($routeName)
    {
        if (! \Illuminate\Support\Facades\Route::has($routeName)) {
            dd("Not found route name: $routeName");
        }
        $roles = $this->_roles();
        //Tìm tất cả role, sau đó tìm pers...
        foreach ($roles as $role) {
            if ($role instanceof Role);
            $mRouteAllowUser = [];
            $pers = ($role->permissions()->get());
            //Tìm các permission,
            $haveRouteName = 0;
            foreach ($pers as $per) {
                if ($per instanceof Permission);
                //Nếu có 1 route đã tồn tại thì xóa đi để sync sau
                if ($per->route_name_code != $routeName) {
                    $mRouteAllowUser[] = $per->route_name_code;
                } else {
                    $haveRouteName = 1;
                }
            }
            if ($haveRouteName) {
                $role->permissions()->sync($mRouteAllowUser);
            }
        }
    }

    public function addAllowPermissionRouteNameOnUser($routeName)
    {
        if (! \Illuminate\Support\Facades\Route::has($routeName)) {
            dd("Not found route name: $routeName");
        }

        //Kiểm tra all Role của user có route này chưa:
        $mRouteAllowUser0 = $this->getAllRouteNameAllowThisUser();
        //Đã có route :
        if (in_array($routeName, $mRouteAllowUser0)) {
            return 1;
        }

        //Nếu chưa có thì thêm  route này vào role đầu tiên:
        //Tìm Role đầu tiên của user:
        $role = $this->_roles()->first();
        if (! $role) {
            return 0;
        }
        if ($role instanceof Role);

        $mRouteAllowUser = [];
        $pers = ($role->permissions()->get());
        //lấy ra all route đã có
        foreach ($pers as $per) {
            if ($per instanceof Permission);
            //Nếu có 1 route đã tồn tại thì xóa đi để sync sau
            $mRouteAllowUser[] = $per->route_name_code;
        }
        // nếu ko có route này trong mảng, thì thêm vào
        if (! in_array($routeName, $mRouteAllowUser)) {
            //            dump("Not have route: $routeName");
            $mRouteAllowUser[] = $routeName;
            //và đồng bộ:
            $role->permissions()->sync($mRouteAllowUser);

            return 1;
        } else {
            //            dump("++ Have route: $routeName");
        }

        return 0;
    }

    function hasRoleId($roleId)
    {
        $mRoleId = $this->getRoleIdUser(1);
        if($mRoleId)
        if(in_array($roleId, $mRoleId))
            return true;

        return false;
    }

    /**
     * Trả lại list role của user, ngăn cách dấu , nếu có nhiều
     *
     * @param  int  $firstIdOnly
     * @return string|null
     */
    public function getRoleIdUser($getArray = 0)
    {
        $mm = $this->_roles()->toArray();

        if (! $mm) {
            return null;
        }
        //        if($firstIdOnly)
        //            return $mm[0]['id'];
        $ret = '';
        $mR = [];
        foreach ($mm as $role) {
            $ret .= $role['id'].',';
            $mR[] = $role['id'];
        }
        if ($getArray) {
            return $mR;
        }

        return trim($ret, ',');
    }

    /**
     * @return User|Model|object|null
     */
    public static function createGuestForTest()
    {
        $user = \App\Models\User::where('email', '_guest_for_test@abc.com')->first();
        if (! $user) {
            $user = new User();
            $m1['username'] = 'guest_for_test_123456';
            $m1['email'] = '_guest_for_test@abc.com';
            $m1['password'] = microtime(1);
//            $m1['token_user'] = bcrypt(microtime(1));
            $ret = $user->create($m1);
            \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $ret->id, 'role_id' => 0]);

            return $ret;
        } else {

            if (! \Illuminate\Support\Facades\DB::table('role_user')->where(['user_id' => $user->id, 'role_id' => 0])->count()) {
                \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => 0]);
            }
        }

        return $user;
    }

    public function setRoleUserIfRoleNull($roleId = DEF_GID_ROLE_MEMBER)
    {
        if (!\Illuminate\Support\Facades\DB::table('role_user')->where(['user_id' => $this->id, 'role_id' => $roleId])->count()) {
            \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $this->id, 'role_id' => $roleId]);
        }
    }

    public static function setRoleUser($uid, $roleId = DEF_GID_ROLE_MEMBER)
    {
        if (! \Illuminate\Support\Facades\DB::table('role_user')->where(['user_id' => $uid, 'role_id' => $roleId])->count()) {
            \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $uid, 'role_id' => $roleId]);
        }
    }

    public static function createAMemberForTest($email, $pw)
    {
        $user = \App\Models\User::where('username', basename($email))->first();
        if (! $user) {
            $user = new User();
            $m1['username'] = basename($email);
            $m1['email'] = $email;
            $m1['password'] = $pw;
//            $m1['token_user'] = bcrypt($pw);
            $m1['email_active_at'] = nowyh();

            $ret = $user->create($m1);
            \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $ret->id, 'role_id' => DEF_GID_ROLE_MEMBER]);

            return $ret;
        } else {
            $user->email_active_at = nowyh();
            $user->password = $pw;
            $user->update();
            if (! \Illuminate\Support\Facades\DB::table('role_user')->where(['user_id' => $user->id, 'role_id' => DEF_GID_ROLE_MEMBER])->count()) {
                \Illuminate\Support\Facades\DB::table('role_user')->insert(['user_id' => $user->id, 'role_id' => DEF_GID_ROLE_MEMBER]);
            }
        }

        return $user;
    }

    /**
     * Always encrypt the password when it is updated.
     *
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        if(SiteMng::getAuthTypeSha1())
            $this->attributes['password'] = sha1($value . $this->getId());
        else
            $this->attributes['password'] = bcrypt($value);
    }

    /*
     * Lấy token admin: khi admin login AS khác, token admin này vẫn giữ nguyên
     */
    public static function isSupperAdmin()
    {
        $user = User::getUserByTokenAccess($_COOKIE['_tglx__863516839'] ?? '');

        
        if ($user && $user->is_admin) {
            return $user->getId();
        }


        return null;
    }



    public static function isAdminLrv_()
    {
        $user = User::getUserByTokenAccess($_COOKIE['_tglx863516839'] ?? '');
        if ($user && $user->is_admin) {
            return $user->id;
        }
        return null;

    }

    public static function isSupperAdminDevCookie()
    {
        if ($user = User::getUserByTokenAccess($_COOKIE['_tglx__863516839'] ?? '')) {
            if (in_array($user->email, explode(',', env('AUTO_SET_DEV_ADMIN_EMAIL')))) {
                return $user->id;
            }
        }
        return null;
    }

    public static function isSupperAdminDbMaxtrixCookie()
    {
        if ($user = User::getUserByTokenAccess($_COOKIE['_tglx__863516839'] ?? '')) {
            if ($user->is_admin && in_array($user->email, explode(',', env('AUTO_SET_EMAIL_DB_MATRIX_ACCESS')))) {
                return $user->id;
            }
        }

        return null;
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
