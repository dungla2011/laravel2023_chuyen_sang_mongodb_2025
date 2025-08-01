<?php

namespace App\Http\Controllers;

use App\Components\ClassMail1;
use App\Models\AffiliateLog;
use App\Models\LogUser;
use App\Models\Role;
use App\Models\SiteMng;
use App\Models\User;
use App\Support\HTMLPurifierSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use LadLib\Common\UrlHelper1;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {


            $userGG = Socialite::driver('google')->user();
            $objUser = User::where('email', $userGG->email)->first();
            if (! $objUser) {
                if ($objUser = User::withTrashed()->where('email', $userGG->email)->first()) {
                    bl('User đã bị xóa, bạn không thể đăng ký tài khoản này, hãy liên hệ Admin!');

                    return;
                }
            }

            if ($objUser) {
                $sid = getSiteIDByDomain();
                $objUser->setUserTokenIfEmpty();

                Auth::login($objUser);
                setcookie('_tglx863516839', $objUser->getJWTUserToken(), time() + 3600 * 24 * 180, '/');

                if (isEmailIsAutoSetAdmin($objUser->email)) {
                    if ($objUser->is_admin != 1) {
                        $objUser->is_admin = 1;
                        $objUser->update();
                    }
                    $objUser->_roles()->sync([1, 3]);
                    setcookie('_tglx__863516839', $objUser->getJWTUserToken(), time() + 3600 * 24 * 180, '/');
                }

                if ($objUser->is_admin) {
                    if(!setcookie('_tglx__863516839', $objUser->getJWTUserToken(), time() + 3600 * 24 * 180, '/')){
                    }
                }

                if (! $objUser->email_active_at) {
                    $objUser->email_active_at = nowyh();
                    $objUser->update();
                }

                //                bl3("Đăng nhập thành công!");
                //                echo "<br/>\n <a href='/member'> Member </a>";
                return redirect('/member');
                //                Auth::user()->_roles()->sync([DEF_GID_ROLE_MEMBER]);
            } else {

//                $newUser = User::create([
//                    //                    'username' => 'gg__'.$userGG->getId(),
//                    'username' => str_replace(['.', '@', '-'], '_', $userGG->email),
//                    'email' => $userGG->email,
//                    //                    'social_id'=> $user->id,
//                    //                    'social_type'=> 'google',
//                    //                    'password' => ''
//                ]);

                $newUser = new User();
                $newUser->username = str_replace(['.', '@', '-'], '_', $userGG->email);
                $newUser->email = $userGG->email;
//                $user->password = ($pr['password']);
//                $user->reg_str = $strActive;
                $newUser->save();

                $sid = getSiteIDByDomain();
//                $tokenUs = eth1b($sid.'-uid.'.$newUser->id.'-'.microtime().'-'.rand());
//                $newUser->token_user = $tokenUs;
                $newUser->setUserTokenIfEmpty();

                if (isEmailIsAutoSetAdmin($userGG->email)) {
                    $newUser->is_admin = 1;
                    setcookie('_tglx__863516839', $newUser->getJWTUserToken(), time() + 3600 * 24 * 180, '/');
                }
                $newUser->email_active_at = nowyh();
                $newUser->update();

                if (isEmailIsAutoSetAdmin($userGG->email)) {
                    $obj = User::findUserWithEmail($userGG->email);
                    $obj->_roles()->sync([1, 3]);
                }

                Auth::login($newUser);
                setcookie('_tglx863516839', Auth()->user()->getJWTUserToken(), time() + 3600 * 24 * 180, '/');
                Auth::user()->_roles()->sync([DEF_GID_ROLE_MEMBER]);
                tb3('Đăng ký thành công!', "<a href='/member'> Tiếp tục</a>");

                AffiliateLog::checkAffCode($newUser->id);
                //                return redirect('/home');
            }

        } catch (\Exception $e) {
            bl3('Có lỗi login:');
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
            if(isDebugIp()){
                echo "\n <hr> DEBUGIP <hr>";
                echo '<pre>';
                print_r($e->getTraceAsString());
                echo '</pre>';
            }
        }

    }

    public function ruleReg()
    {
        //            'title' => 'required|unique:posts|max:255',
        return [
            'username' => 'required|string|regex:/\w*$/|min:8|max:64|unique:users,username',
            'email' => 'required|email|unique:users|min:6|max:64',
            'password' => 'required|confirmed|min:8|max:64',
        ];
    }

    public function sendMailResetPw($email, $str)
    {

        $host = ucfirst(UrlHelper1::getDomainHostName());
        $urlBase = UrlHelper1::getUrlOrigin();
        $link = "$urlBase/reset-password-act?rs_string=$str";
        $cont = "Chào bạn!<br> Bạn đã yêu cầu đặt lại mật khẩu qua email.<br>Để đặt lại mật khẩu, bạn hãy <a href='$link'> Click vào link này </a> <br>  Hoặc copy link này lên trình duyệt: $link <br>
Link sẽ hết hạn trong 15 phút.<br>
Xin cảm ơn bạn!<br>
$urlBase<br>
";

        return ClassMail1::sendMail('admin@glx.com.vn', "$host", $email, "$host - Đặt lại mật khẩu tài khoản !", "$cont");
    }

    public function sendMailActive($email, $strActive)
    {

        $host = ucfirst(UrlHelper1::getDomainHostName());
        $urlBase = UrlHelper1::getUrlOrigin();
        $link = "$urlBase/register?active=$strActive";
        $cont = "Chào bạn!<br>Để hoàn tất đăng ký với email, bạn hãy <a href='$link'> Click vào link này </a> <br>  Hoặc copy link này lên trình duyệt: $link <br>
Link sẽ hết hạn trong 60 phút.<br>
Xin cảm ơn bạn!<br>
$urlBase<br>
";

        return ClassMail1::sendMail('admin@glx.com.vn', "$host", $email, "$host - Kích hoạt tài khoản !", "$cont");
    }

    public function register(Request $request)
    {

        $pr = $request->all();



        if (isset($pr['active'])) {
            $str = $pr['active'];
            if (strlen($str) > 256 || ! preg_match('#^[a-zA-Z0-9]+$#', $str)) {

                LogUser::FInsertLog('Chuỗi kích hoạt không hợp lệ 1!');
                bl3('Chuỗi kích hoạt không hợp lệ!', "<a href='/'> Trở lại</a>");

                return;
            }
            $strActDecode = dfh1b($str);
            if (! strstr($strActDecode, '#')) {
                LogUser::FInsertLog('Chuỗi kích hoạt không hợp lệ 1!');
                bl3('Chuỗi kích hoạt Không hợp lệ!', "<a href='/'> Trở lại</a>");

                return;
            }

            if (! $us = User::where('reg_str', $str)->first()) {
                LogUser::FInsertLog('Chuỗi kích hoạt không hợp lệ 1!');
                bl3('Chuỗi kích hoạt không hợp lệ!', "<a href='/'> Trở lại</a>");

                return;
            }

            if ($us->email_active_at) {
                $us->_roles()->sync([DEF_GID_ROLE_MEMBER]);
                LogUser::FInsertLog(null, null, 'Tài khoản đã kích hoạt thành công (1)', $us->id);
                tb3('Tài khoản đã kích hoạt thành công (1)!', "<a href='/login'> Tiếp tục</a>");

                return;
            }

            if (explode('#', $strActDecode)[1] < time() - 3600) {
                LogUser::FInsertLog(null, null, 'Quá hạn chuỗi kích hoạt', $us->id);

                bl3("Chuỗi kích hoạt đã quá hạn. Bạn có thể click hoạt lại <a href='/active-account'> tại đây!</a>", "<a href='/'> Trở lại</a>");

                return;
            }

            $sid = getSiteIDByDomain();
            $tokenUs = eth1b($sid.'-uid.'.$us->id.'-'.microtime().'-'.rand());
            $us->token_user = $tokenUs;
            $us->email_active_at = nowyh();
            $us->log .= 'Active at: '.nowyh();
            if ($us->update()) {

                LogUser::FInsertLog(null, null, 'Kích hoạt thành công!', $us->id);

                tb3('Tài khoản đã kích hoạt thành công!', "<a href='/login'> Tiếp tục</a>");
                //Cho quyền member:
                $us->_roles()->sync([DEF_GID_ROLE_MEMBER]);
            } else {
                LogUser::FInsertLog(null, null, 'Có lỗi kích hoạt!', $us->id);
                bl3('Có lỗi kích hoạt tài khoản!', "<a href='/login'> Tiếp tục</a>");
            }

            return;
        }

        if (isset($pr['submit'])) {
            unset($pr['_token']);
            unset($pr['submit']);

            $pr['username'] = trim(strtolower($pr['username']));
            $pr['email'] = trim(strtolower($pr['email']));

            if (! preg_match('/[a-zA-Z]/', $pr['username'][0])) {
                return back()->withErrors(
                    ['username' => 'Username phải bắt đầu bằng ký tự!'])->withInput();
            }

            if ($pr['password'] !== $pr['password2']) {
                return back()->withErrors(
                    ['password2' => 'Hai mật khẩu phải giống nhau!'])->withInput();
            }

            //            if($rl = $us->getValidateRuleInsert()){
            //                $validator = \Illuminate\Support\Facades\Validator::make($pr, $rl);
            //                if ($validator->fails())
            //                {
            //                    $mE = $validator->errors()->all();
            //                    bl(implode("\n<br> - ", $mE));
            //                    return;
            //                }
            //            }

            $us = new User();
            $rl = $us->getValidateRuleInsert();
            $validator = \Illuminate\Support\Facades\Validator::make($pr, $rl);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $email = trim($pr['email']);
            $strActive = eth1b($pr['email'].'#'.time());

            //            unset($pr['password2']);
            if(isDebugIp()){
//                echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//                print_r($pr);
//                echo "</pre>";
//                die();
            }

//            $ret = User::create([
//                'username' => $pr['username'],
//                'email' => $pr['email'],
//                //Không cần encrypt ở đây vì tự động enc rồi:
//                'password' => trim($pr['password']),
//                'reg_str' => $strActive,
//            ]);

            $user = new User();
            $user->username = $pr['username'];
            $user->email = $pr['email'];
            $user->password = ($pr['password']);
            $user->reg_str = $strActive;
            $user->save();




            if ($this->sendMailActive($pr['email'], $strActive)) {
                LogUser::FInsertLog(null, null, "Send mail kích hoạt $strActive / ".$pr['email']);

                tb3('Đăng ký thành công Tài khoản, Bạn hãy vào email để kích hoạt tài khoản (Kiểm tra cả trong Spam/Thư rác)!', 'Một email đã gửi đến: '.$email);
            } else {
                LogUser::FInsertLog(null, null, "Không thể gửi mail Kích hoạt $email");

                bl3('Có lỗi không thể gửi email kích hoạt!', " <a href='/active-account'> Gửi lại email kích hoạt Tại đây </a>");
            }

            return;
        }

        return $this->getViewLayout('login.register');

        return view('login.register');
    }

    public function resetPasswordAct(Request $request)
    {

        //        User::where("email",'dungla2011@gmail.com')->first()->update(['reset_pw'=>'36435f5269444546180207150700010302040e000106']);
        //

        if ($rss = $request->get('rs_string')) {

            $us = User::where('reset_pw', $rss)->first();
            if (! $us) {
                $str = ("Link đặt  mật khẩu không hợp lệ: $rss");
                bl3($str, "<a href='/'> Trở lại</a>");

                return;
                //                return back()->withErrors([
                //                    'ok' => $str,
                //                ]);
            } else {
                $time = explode('#', dfh1b($rss))[1];
                //Link RS PW Tồn tại 15 phút
                if (! is_numeric($time) || $time < time() - 900) {
                    $str = ("Link đặt  mật khẩu không hợp lệ (hết hạn): $rss");
                    bl3($str, "<a href='/'> Trở lại</a>");

                    return;
                    //                    return back()->withErrors([
                    //                        'ok' => $str,
                    //                    ]);
                }
            }

            if ($request->isMethod('post')) {
                if ($request->get('password1') && $request->get('password2')) {
                    $pw1 = trim($request->get('password1'));
                    $pw2 = trim($request->get('password2'));
                    $str = 'Hai mật khẩu phải trùng nhau!';
                    if ($pw1 != $pw2) {
                        return back()->withErrors([
                            'password1' => $str,
                            'password2' => $str,
                        ]);
                    }
                    $rule = [
                        'password1' => 'required|min:8|max:64'];
                    $validator = \Illuminate\Support\Facades\Validator::make(['password1' => $pw1], $rule);
                    if ($validator->fails()) {
                        //dump($validator->getMessageBag());
                        return back()->withErrors($validator);
                    }
                    //Thực hiện reset pw:
                    $us->password = ($pw1);

                    $us->reset_pw = '';
                    $us->update();
                    $str = 'Đặt mật khẩu thành công!';

                    return redirect()->route('login.login')->withErrors([
                        'ok' => $str,
                    ]);
                }
            }
        }

        //        if($dbn = getDbNameWithDomain())
        //            return view("auth.$dbn.resetPasswordAct");
        return view('login.resetPasswordAct');
    }

    public function resetPassword(Request $request)
    {

        if ($request->isMethod('post') && $email = trim($request->get('email'))) {
            $rule = ['email' => 'required|email|min:6|max:64'];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                $str = ("Email không hợp lệ: $email");

                return back()->withErrors([
                    'email' => $str,
                ]);
            } else {
                $us = User::where('email', $email)->first();
                if (! $us) {
                    $str = ("Email không chưa đăng ký trên hệ thống: '$email', bạn có thể đăng ký tài khoản với email này!");

                    return back()->withErrors([
                        'email' => $str,
                    ]);
                } else {
                    $us->reset_pw = eth1b('uid_rsp.'.$us->id.'#'.time());
                    $us->update();
                    ///reset-password-act?rs_string=384d515c674a4b48160c091b090e0f0d0c0a0a0c0908

                    if ($this->sendMailResetPw($email, $us->reset_pw)) {
                        tb3("Một Email đặt mật khẩu đã được gửi đến $email. <br> Bạn hãy vào mail để đặt lại mật khẩu! (Kiểm tra cả trong Spam/Thư rác)", "<a href='/'> Trở lại </a>");

                        return;
                    } else {
                        bl3('Có lỗi không thể gửi email!', " <a href='/'> Trở lại </a>");

                        return;
                    }
                }
            }
        }

        return view('login.resetPassword');
    }

    public function activeAccount(Request $request)
    {

        if ($request->isMethod('post') && $email = trim($request->get('email'))) {

            $rule = ['email' => 'required|email|min:6|max:64'];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                $str = ("Email không hợp lệ: $email");

                return back()->withErrors([
                    'email' => $str,
                ]);
            } else {
                $us = User::where('email', $email)->first();
                if (! $us) {
                    $str = ("Email không chưa đăng ký trên hệ thống: '$email', bạn có thể đăng ký tài khoản với email này!");

                    return back()->withErrors([
                        'email' => $str,
                    ]);
                } else {
                    if ($us->email_active_at) {
                        $str = ('Tài khoản đã được kích hoạt thành công?');

                        return back()->withErrors([
                            'ok' => $str,
                        ]);
                    } else {

                        $strActive = eth1b($email.'#'.time());
                        $us->reg_str = $strActive;
                        $us->update();

                        //                        $strActive = $us->reg_str;
                        if ($this->sendMailActive($email, $strActive)) {
                            $str = 'Một email đã gửi đến: '.$email.".\n Bạn hãy vào email để kích hoạt tài khoản! (Kiểm tra cả trong Spam/Thư rác)";

                            return back()->withErrors([
                                'ok' => $str,
                            ]);
                        } else {
                            $str = ('Có lỗi không thể gửi email kích hoạt!');

                            return back()->withErrors([
                                'ok' => $str,
                            ]);
                        }
                    }
                }
            }
        }

        return view('login.activeAccount');
    }

    public function login(Request $request)
    {
        //Nếu có cookie thì tự động login:
        //Bỏ qua vì đã chạy trong RunBeforeAll
//        if (isset($_COOKIE['_tglx863516839'])) {
//            $user = User::where('token_user', $_COOKIE['_tglx863516839'])->first();
//            if ($user) {
//                Auth::login($user);
//            }
//        }


        //nếu đã login rồi thì chuyển về member
        if (Auth::check()) {
//            return redirect()->intended();
            return redirect()->route('member.index');
        }

        //        $layout_name = getLayoutName();
        //        if($layout_name){
        //            $vi = "public.$layout_name.index";
        //            if(view()->exists($vi))
        //                return view($vi);
        //        }

        return $this->getViewLayout('login.login');

        return view('login.login');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        setcookie('_tglx863516839', null, 0);
        setcookie('_tglx__863516839', null, 0);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function postLogin(Request $request)
    {
        //        dd($request->all());

//        die("Đã tắt chức năng đăng nhập!");
        $credentials = $request->validate([
            'email' => ['required', 'min:6', 'max:128'],
            'password' => ['required'],
        ]);


        if(0)
//        if(isDebugIp())
        {
//            echo "\n " . $request->ip();
//            echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//            print_r($request->all());
//            echo "</pre>";
            try {
                $recaptchaResponse = trim($request->input('g-recaptcha-response'));
                $remoteIp = $request->ip();
                $secretKey = trim(env('RECAPTCHA_SECRET_2025'));

                $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $recaptchaResponse,
                    'remoteip' => $remoteIp,
                ]);

                $result = $response->json();

                if (!$response->successful() || !$result['success'] || ($result['score'] ?? 1) < 0.5) {
                    bl('reCAPTCHA verification failed. Please try again.');
                    return;
                }

                // Continue with your logic here...

            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'reCAPTCHA verification error: ' . $e->getMessage()
                ], 500);
            }
        }

        if ($request->isMethod('post')) {

            if ($email = $request->get('email')) {
                
                $us = User::where('email', $email)->orWhere('username', $email)->first();
                if(!$us){
                    bl("NOt found user with email/username: $email");
                    return;
                }
                if ($us) {

                    if(!$us->hasRole(DEF_GID_ROLE_MEMBER))
                    if (! $us->email_active_at) {
                        bl3("Tài khoản chưa được kích hoạt: $email", "- Hãy vào email để thấy link kích hoạt (kiểm tra thêm hộp thư Spam) <br>- <a href='/active-account'>Hoặc  Kích hoạt tài khoản tại đây </a>");
                        return;
                    }

                    if(SiteMng::getAuthType() == 2){
                        $sha = sha1($request->password . $us->id);
                        $check = ($sha == $us->password);
                    }
                    else
                        $check = Hash::check($request->password, $us->password);

                    if ($check) {
                        Auth::login($us);

                        AffiliateLog::checkAffCode($us->id);

                        if (isEmailIsAutoSetAdmin($us->email)) {
                            if ($us->is_admin != 1) {
                                $us->is_admin = 1;
                                $us->update();
                            }
                            $us->_roles()->sync([1, 3]);
                        }

                        setcookie('_tglx863516839', $us->getJWTUserToken(), time() + 3600 * 24 * 180, '/');

                        if ($us->is_admin) {
                            setcookie('_tglx__863516839', $us->getJWTUserToken(), time() + 3600 * 24 * 180, '/');
                        }
                        usleep(10000);

                        return redirect()->route('member.index');
                    }
                }
            }
            return redirect()->route('login.login')->withErrors('Đăng nhập không thành công, sai email/username hoặc mật khẩu?')->onlyInput('email');

        }

        //        return;
        //
        //        Auth::setUser();
        //
        //        $remember = $request->has('remember_me');
        //        if (Auth::attempt($credentials, $remember)) {
        //            $request->session()->regenerate();
        //            setcookie("_tglx863516839", Auth::user()->getUserToken() ,  time() + 3600 * 24 * 180, "/");
        //            return redirect()->route("member.index");
        ////            return redirect()->intended('/menu');
        //        }

        //        return back()->withErrors([
        //            'email' => 'The provided credentials do not match our records.',
        //        ])->onlyInput('email');

    }
}
