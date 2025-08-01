<?php

use Illuminate\Support\Str;

$GLOBALS['mMapDomainDb'] = [
    'abc.vn' => ['siteid' => 1, 'db_name' => env('DB_DATABASE'), 'layout_name' => 'sandbo',
        'logo' => '/images/logo/mytree1.png',
        'rand_in_redis'=> 1
    ],
    'a1.abc.vn' => ['siteid' => 1, 'db_name' => env('DB_DATABASE'), 'layout_name' => 'sandbo',
        'logo' => '/images/logo/mytree1.png',
        'rand_in_redis'=> 1
    ],
    '127.0.0.1' => ['siteid' => 1, 'db_name' => env('DB_DATABASE'), 'layout_name' => 'sandbox',
        'logo' => '/images/logo/mytree1.png',
        'rand_in_redis'=> 1
    ],
];

//if(isDebugIp())
//    $GLOBALS['mMapDomainDb']['tapdanhmay.mytree.vn'] = ['siteid' => 26, 'db_name' => 'glx_typing_train', 'layout_name' => 'tap-danh-may2'];

$dbName = env('DB_DATABASE');

//GRANT ALL ON glx2022db.* TO 'glx2022db_user'@'12.0.0.0/255.255.255.0' IDENTIFIED BY '...';
$hostname = env('DB_HOST', '127.0.0.1');

$domainName = \LadLib\Common\UrlHelper1::getDomainHostName();

if(isCli()){
    //DOMAIN_CLI
    $DOMAIN_CLI = getenv("DOMAIN_CLI") ?? '';
    if($DOMAIN_CLI){
        $domainName = $DOMAIN_CLI;
    }
}

//Nếu là localhost domain truy cập, và app url local, thì db local:
if (isCli() || $domainName == 'localhost') {
    $hostname = '127.0.0.1';
    $user = 'root';
    $pw = '';
} else {

    //VPN, để testing có thể kết nối vào 12.0.0.1
    $hostname = env('DB_HOST_VPN');
    $user = env('DB_USERNAME_DEFAULT');
    $pw = env('DB_PASSWORD_DEFAULT');

    if (isset($GLOBALS['mMapDomainDb'][$domainName])) {

        $dbName = $GLOBALS['mMapDomainDb'][$domainName]['db_name'];

        if(str_starts_with($dbName, 'DB_RM_HOST-')){

            $num = explode('-', $dbName)[1];
            $hostname = env('DB_RM_HOST' . $num);
            $dbName = env('DB_RM_NAME' . $num);
//            $dbName0 = $dbName = env('DB_RM_NAME' . $num);
            $user = env('DB_RM_USER' . $num);
            $pw = env('DB_RM_PW' . $num);
        }
        else {
            $user = env('DB_USERNAME_DEFAULT');
            $pw = env('DB_PASSWORD_DEFAULT');
            $hostname = env('DB_HOST_VPN');
            if($tmpHost = $GLOBALS['mMapDomainDb'][$domainName]['db_host'] ?? ''){
                $hostname = $tmpHost;
            }
        }

        $GLOBALS['GLX_SITE_ID'] = $GLOBALS['mMapDomainDb']['siteid'] ?? 0;

    } else {
    }
    
}


// die("DB name = $dbName, host = $hostname, user = $user, pw = $pw\n");

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'mongodb' => [
            'driver' => 'mongodb',
            'dsn' => env('DB_URI', 'mongodb://127.0.0.1:27017/'.$dbName),
            'database' => $dbName,
        ],

        'mongodb_testdb3' => [
            'driver' => 'mongodb',
            'dsn' => env('DB_URI_TESTDB3', 'mongodb://127.0.0.1:27017/testdb3'),
            'database' => 'testdb3',
        ],

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => $hostname,
            'port' => env('DB_PORT', '3306'),
            'database' => $dbName,
            'username' => $user,
            'password' => $pw,
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_for_dev' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_VPN'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE_GLX_TESTING'),
            'username' => env('DB_USERNAME_DEFAULT'),
            'password' => env('DB_PASSWORD_DEFAULT'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Our secondary database connection
        'mysql_for_common' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => $hostname,
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE'),
            'username' => $user,
            'password' => $pw,
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),
//        'client' => env('REDIS_CLIENT', 'predis'),

//        'options' => [
//            'cluster' => env('REDIS_CLUSTER', 'redis'),
//            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
//        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
