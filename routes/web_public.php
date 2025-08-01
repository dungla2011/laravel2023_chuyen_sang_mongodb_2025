<?php

use App\Components\Route2;

//echo "<br/>\n -- x=" . php_sapi_name();

//Nếu là CLI, thì bỏ qua controller, view
if (php_sapi_name() === 'cli') {
    Route2::get('/', function () {
        echo "\n --- IS_CLI01 --- | ".__FILE__."\n";
    });
    //    return;
} else {



    try{

        $mm = \App\Models\MenuTree::where('id_news', '>', 0)->get();
        foreach ($mm as $obj) {
            if ($ui = \App\Models\BlockUi::find($obj->id_news)) {
                Route2::get('/'.$obj->link, function () use ($obj) {
                    $data['id_ui_block'] = $obj->id_news;

                    return \Illuminate\Support\Facades\View::make('public.link_html', $data);
                });
            }
        }

    }
    catch (\Exception $e) {
        echo "Error Load Menu: " . $e->getMessage();
    }

    Route2::post('/', [
        \App\Http\Controllers\IndexController::class, 'public',
    ])->name('public')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route2::get('/', [
        \App\Http\Controllers\IndexController::class, 'public',
    ])->name('public')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route2::get('/run-multi-zalo-pc', function () {
        return redirect('/');
    });
}
