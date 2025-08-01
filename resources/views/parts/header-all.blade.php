<style>
    #ul_top_bar select.hide_pos {
        display: none;
    }
    #ul_top_bar li.hide_pos {
        display: none;
    }

    #ul_top_bar:hover select.hide_pos {
        display: block;
    }

    #ul_top_bar:hover li.hide_pos {
        display: list-item;
    }



</style>




<nav data-code-pos="qqq1709196309063" class="main-header navbar navbar-expand navbar-white navbar-light">

    <?php
if(1)
    if (isDebugIp()){

        ?>

    <div style="border:  0px solid #ccc; padding: 0px; position: fixed; top: 0px; z-index: 100000; right: 350px"
         data-code-pos='ppp17402744724801'>
            <?php
            try {
                $adm = \App\Models\User::where("email", env('AUTO_SET_EMAIL_DB_MATRIX_ACCESS'))->first();
                $mm = \App\Models\UploaderInfo::all();
                if (count($mm)) {
                    echo "\n <select style='border: 0px' id='changeUserOther2' onchange='changeUser_()'>";
                    echo "\n<option value='0'>--- </option>";
                    echo "\n<option value='$adm->id'>- ADM - </option>";

                    foreach ($mm as $m) {
                        $user = \App\Models\User::find($m->user_id);
                        $email = $user->email;
//        echo $m->id . " " . $m->name . "<br>";
                        echo "\n<option value='$m->user_id'>$email</option>";
                    }
                    echo "\n </select>";
                }
            }
            catch (Exception $e){
//            echo $e->getMessage();
            }
            ?>
    </div>
        <?php
    }
    ?>


        <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">

            <?php

                //Nếu là member module
            $padColor = '';
            if(\App\Components\Helper1::isMemberModule())
                $padColor = ' style = "color: black"';

            ?>

            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars {{$padColor}}"></i></a>
        </li>
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a href="index3.html" class="nav-link">Home</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a href="#" class="nav-link">Contact</a>--}}
{{--        </li>--}}
    </ul>

    <?php
    $linkAdm = \App\Components\Helper1::isMemberModule() ? '/member' : '/admin';
    $titleAdm = \App\Components\Helper1::isMemberModule() ? 'Member':  'Admin';
    $linkAdm = "<a data-pos='489753947593745' href='$linkAdm' style=''>$titleAdm</a>
    <i class='fa fa-fw fa-angle-right'> </i> ";
    ?>

    <b style="color: gray">


        <span data-code-pos='ppp17134889478761' data-code-pos="qqq1709221833500" style="white-space: nowrap;">

            {!! $linkAdm !!} @yield('title_nav_bar')
{{--            @if(\App\Components\Helper1::isMemberModule())--}}
{{--                {{}} / @yield('title_nav_bar')--}}
{{--            @else--}}
{{--                Admin / @yield('title_nav_bar')--}}
{{--            @endif--}}


        <?php
            $rqId = request('id');
            if(isUUidStr($rqId))
                $ide = $rqId;
            else
                $ide = qqgetRandFromId_(request('id'));

            if(isSupperAdmin_()){
                echo "<span style='color: transparent'>$ide</span>";
            }
        ?>
        </span>

    </b>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" id="ul_top_bar">

        <?php

        $user = \Illuminate\Support\Facades\Auth::user();

        if(\App\Models\User::isSupperAdmin())
        //if(isAdminACP_())
        {



        if ($setUid = request('_goto_us_')) {
            if ($us1 = \App\Models\User::find($setUid)) {
//                auth()->logout();
//                \Illuminate\Support\Facades\Auth::login($us1);
                auth()->login($us1);

//                if(!$us1->token_user){
//                    bl("Not found token user: $setUid");
//                }
                if(!setcookie("_tglx863516839", $us1->getJWTUserToken(), time() + 3600 * 24 * 180, "/"))
                {
                    bl("Can not set id!!!");
                }

                $fileC = sys_get_temp_dir() . "/user_list_change_glx." . \LadLib\Common\UrlHelper1::getDomainHostName();
                if (!file_exists(dirname($fileC)))
                    mkdir(dirname($fileC), 0755, 1);

                $other_uid = $us1->id;
                if (file_exists($fileC)) {
                    $cont = file_get_contents($fileC);
                    // die(" 0001 / $cont / $other_uid");
                    if($cont)
                    if (!\LadLib\Common\cstring2::checkElementInString($cont, $other_uid)) {
                        $cont = \LadLib\Common\cstring2::addElementToStringToBegin($cont, $other_uid);
                        $cont = \LadLib\Common\cstring2::removeKeepNFirstElement($cont, 20);
                        outputW($fileC, $cont);
                    } else {
                        //Remove sau đó add lại vào đầu
                        $cont = \LadLib\Common\cstring2::removeElementInString($cont, $other_uid);
                        $cont = \LadLib\Common\cstring2::addElementToStringToBegin($cont, $other_uid);
                        $cont = \LadLib\Common\cstring2::removeKeepNFirstElement($cont, 20);
                        outputW($fileC, $cont);
                    }
                } else {
                    $cont = \LadLib\Common\cstring2::addElementToString(null, $other_uid);
                    $cont = \LadLib\Common\cstring2::removeKeepNFirstElement($cont, 20);
                    outputW($fileC, $cont);
                }

            }
        }
        ?>
        <style>
            .ui-menu .ui-menu-item{
                font-size: small;
                padding: 1px;
            }
            .ui-menu {
                z-index: 10000;
            }
        </style>

        <select class="hide_pos" data-code-pos="ppp1675573422318" name="" title="Các tài khoản user khác Bạn đã vào gần đây (Admin có thể vào các Tài khoản user khác tại đây)"
                style="border: 1px solid #eee; color: gray; width: 40px; height: 22px; margin-top: 10px; border-radius: 5px; " onchange="changeUser_()"
                id="changeUserOther">
            <option value="">-</option>
            <?php

            $fileC = sys_get_temp_dir() . "/user_list_change_glx." . \LadLib\Common\UrlHelper1::getDomainHostName();
            //$mu = explode(",", $cont);
            $mm = [];
            if (file_exists($fileC) && $cont = file_get_contents($fileC)) {
                $cont = trim($cont, ',');
                $mm = explode(",", $cont);
            }
            if ($mm) {
                $mm = \App\Models\User::whereIn('id', $mm)->get();
            }
            if (!$mm)
                $mm = \App\Models\User::limit(20)->get();

            foreach ($mm AS $ouser){
            ?>
            <option style="color: black;" value="<?php echo $ouser->id ?>">
                <?php
                echo $ouser->email . " - $ouser->id "
                ?>
            </option>
            <?php
            }
            ?>
        </select>



        <li class="hide_pos dropdown notifications-menu">

            <?php
            //if(!isAdminEmail()){
            if(1){
            ?>
            <button class="" style="background-color: transparent; border: 0px; color: white"
                    onclick="ClassApi.changeOtherUser(<?php echo '1' ?>)">
                <i class="fa fa-gear" title="return admin"></i>
            </button>
            <?php
            }
            ?>
            <input id="loginAsUser1" title="Nhập email hoặc UID tài khoản của User bạn muốn vào  (Admin có thể vào các Tài khoản user khác tại đây)" type="text" style="display: inline-block; width: 50px; margin-top: 10px;
                        background-color: transparent; border: 1px solid #eee; border-radius: 5px; font-size: small; padding: 0px 5px">
        </li>

    <?php
    } //End of supper admin
    ?>

    <!-- Navbar Search -->
        <li class="nav-item">
{{--            <a class="nav-link" data-widget="navbar-search" href="#" role="button">--}}
{{--                <i class="fas fa-search"></i>--}}
{{--            </a>--}}
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
{{--                            <button class="btn btn-navbar" type="submit">--}}
{{--                                <i class="fas fa-search"></i>--}}
{{--                            </button>--}}
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item" data-code-pos='ppp17373368826041'>
            <a class="nav-link" style="color: dodgerblue"  href="/member" title="<?php
            if ($user)
                echo ($user->email)
            ?>">


                <?php
                if ($user)
                    echo substr($user->email, 0,8).'...'
                ?>


            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>



        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>


{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">--}}
{{--                <i class="fas fa-th-large"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</nav>

@section('js1')
    <?php
    if(\App\Models\User::isSupperAdmin())
    {
    ?>
    <script>
        $(function () {

            $("#loginAsUser1").autocomplete({
                source: "/api/get-user-id?start_with=1",
                minLength: 0,
                select: function (event, ui) {
                    console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
                    let url = jctool.setCurrentUrlParamAndGo('_goto_us_', ui.item.id, 1);
                    window.location.href = url;
                }
            }).focus(function(){
                console.log(" click0....");
                // The following works only once.
                // $(this).trigger('keydown.autocomplete');
                // As suggested by digitalPBK, works multiple times
                // $(this).data("autocomplete").search($(this).val());
                // As noted by Jonny in his answer, with newer versions use uiAutocomplete
                $(this).autocomplete("search");
            });;
        });

        function changeUser_() {

            console.log(" changeUser_ ...");

            // alert(document.getElementById("changeUserOther").value);
            if(document.getElementById("changeUserOther2") && document.getElementById("changeUserOther2").value){
                let url = jctool.setCurrentUrlParamAndGo('_goto_us_', document.getElementById("changeUserOther2").value, 1);
                window.location.href = url;
                return;
            }
            if (document.getElementById("changeUserOther").value) {
                let url = jctool.setCurrentUrlParamAndGo('_goto_us_', document.getElementById("changeUserOther").value, 1);
                window.location.href = url;
            }
        }

        // Nếu click vào #ul_top_bar, thì .hide_pos sẽ hiện ra
        $("#ul_top_bar").click(function () {
            console.log("click111...");
            $("#ul_top_bar select.hide_pos").show();
            $("#ul_top_bar li.hide_pos").show();
        });

    </script>
    <?php
    }
    ?>
@endsection
