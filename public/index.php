<?php

//zzzzzz: allow all cors
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

//xhprof_enable();
require "fw.php";
class ladDebug
{
    public static $enable = 1;

    public static $strTime = [];

    public static $startTime1;

    public static $startTime2;

    public static function addTime($file, $line, $count = 0)
    {
        if (! static::$enable) {
            return null;
        }
        $file = basename($file);
        static::$strTime["$file($line)$count"] = microtime(1);
    }

    public static function dumpDebugTime()
    {
        //return;
        if (! static::$enable) {
            return null;
        }

        $ret = static::toStringTime();
//        dumpdebug(' TimeDebug: - '.$ret." \nREQUEST: ".serialize($_REQUEST), '/var/glx/weblog/timer_access.log');

        return $ret;
    }

    public static function toStringTime()
    {
        //return null;
        $dtime = 0;
        $tmp = '';
        if (count(static::$strTime)) {
            $cc = 0;
            $t0 = 0;
            $x = 0;
            $dt1 = 0;
            foreach (static::$strTime as $key => $value) {
                $tmp .= "\n|$key->$value";
                if ($cc == 0) {
                    $t0 = $value;
                } else {
                    $dt1 = number_format($value - $x, 2);
                }
                $cc++;

                $tmp .= "(DT = $dt1) ";

                $x = $value;
            }
            $dtime = number_format($x - $t0, 2);
        }

        return " $tmp \n DTIME = $dtime";
    }
}

////ladDebug::addTime(__FILE__, __LINE__);

use App\Models\LogUser;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
define('LARAVEL_START2', time());

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);


////ladDebug::addTime(__FILE__, __LINE__);
$response = $kernel->handle(
    $request = Request::capture()
)->send();


//ladDebug::addTime(__FILE__, __LINE__);
$kernel->terminate($request, $response);

//ladDebug::addTime(__FILE__, __LINE__);

//LogUser::FInsertLog('');

///////////////////////////////////////////////////////////////////////////////
$dtime = (time() - LARAVEL_START2);
if (! \App\Components\Helper1::isApiCurrentRequest() && ! \App\Components\Helper1::isToolCurrentRequest()) {
    if (0) {
        if (\App\Models\User::isSupperAdmin()) {
            $route = \request()->route();
            //    dump($route);
            echo "\n<!--";
            echo "\n---DebugInfo:";
            if (! $route) {
                return;
            }
            if ($route?->getActionName() != 'Closure') {
                echo "\n-".$route?->getActionName();
                $ctr = $route?->getController();
                echo "\n-".get_class($ctr);
            }
            $url = url()->current();
            echo "\n- $url ";

            //ladDebug::addTime(__FILE__, __LINE__);
            echo "\n DTIME = ".(time() - LARAVEL_START2);

            //echo "\nDTIME2 = ".//ladDebug::toStringTime();

            echo "\n\n";
            echo '</pre>Debugx : ';
            //    print_r(get_included_files());
            print_r(debug_print_backtrace());
            echo "</pre>\n\n";

            echo "\n-->";

            //    print_r(get_included_files());
        }
    }
}

if ($dtime >= 5) {
    $ipR = @$_SERVER['REMOTE_ADDR'] ?? '';
    outputT('/var/glx/weblog/slow_log.log',
        " DTime Slow = $dtime second | $ipR | ".(@$_SERVER['HTTP_HOST'] ?? '').@$_SERVER['REQUEST_URI']."\n\n\n");
    // Kết thúc ghi lại thông tin hiệu suất
    //    $xhprof_data = xhprof_disable();

    // Lưu thông tin hiệu suất vào tệp hoặc hiển thị nó
    // Lưu vào tệp
    //    outputT('/var/glx/weblog/slow_log_full/slow_xhprof_output.'.microtime(1).'.txt', serialize($xhprof_data));
}?>
