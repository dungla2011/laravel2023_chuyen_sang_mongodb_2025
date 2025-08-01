@extends(getLayoutNameMultiReturnDefaultIfNull())

@section('title')
    Tập đánh máy
@endsection

@section("css")

@endsection

@section('content')


    <div id="wrap">
        <div id="left" class="shadow_menu">
            <?php

            $file = '/var/www/html/public/tool1/doing/typing.glx/all.json';
            $cont = file_get_contents($file);

            $m1 = json_decode($cont);

            //echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
            //print_r($m1);
            //echo "</pre>";
            $c1 = $cc = 0;

            $fid = $_GET['fid'] ?? 0;
            $strTyping = '';
            foreach ($m1 as $obj) {

                $cc++;

                $link = '';
                if ($obj->sub) {
                    $link = \LadLib\Common\UrlHelper1::setUrlParamThisUrl('fid', $c1 + 1);
                }

                echo "<ul data-id='$cc'> <a href='$link'> $obj->name </a>  ";
                if ($obj->sub) {

                    foreach ($obj->sub as $s1) {

                        //                        dump("$obj->name / " . $s1->name);

                        $c1++;

                        if (! $tmp1 = \App\Models\TypingLesson::where('parent_name', $obj->name)->where('name', $s1->name)->first()) {
                            $baiGo = new \App\Models\TypingLesson();
                            $baiGo->parent_name = $obj->name;
                            $baiGo->name = $s1->name;
                            $baiGo->type_text = $s1->type_text;
                            $baiGo->lesson = $c1;
                            $baiGo->save();
                        } else {
                            $tmp1->refer = $s1->link;
                            $tmp1->save();
                        }

                        //            echo "<pre>";
                        //            print_r($s1);
                        //            echo "</pre>";
                        //            echo "<hr/>\n $c1. Name: <b> $s1->name </b>";
                        //            echo "<br/>\n Link: $s1->link";
                        $link = \LadLib\Common\UrlHelper1::setUrlParamThisUrl('fid', $c1);

                        $style = '';
                        if ($fid == $c1) {
                            echo "<span class='mark_selected' style='display: none'></span>";
                            $style = "style='color: red'";
                            $strTyping = $s1->type_text;
                        }

                        echo "\n <li style='display: none'>  $c1. <a $style href='$link'> $s1->name  </a> </li>";
                        //            echo "<br/>\n Text: $s1->type_text";
                    }
                } else {

                    if (isset($obj->type_text)) {
                        $c1++;
                        //            echo "<br/>\n <b> $c1 </b>";
                        //            echo "<br/>\n $obj->link";
                        echo "\n <li style='display: none'>  $c1.  $obj->link x </li>";
                        //            echo "<br/>\n $obj->type_text";
                    }
                }
                echo "\n</ul>";
            }
            ?>
        </div>

        <div id="middle">

            <?php
            if ($strTyping) {
                ?>

            <script type="text/javascript">
                var gAjaxUrl = '/tool1/doing/typing.glx/save_result.php?done=1';
                var gTimeUrl = '/tool1/doing/typing.glx/save_result.php?start=1';
                var gSession = '<?php echo microtime(1) ?>'
            </script>
            <script type="text/javascript" src="/tool1/doing/typing.glx/lesson.2.js"></script>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                    try {
                        Init(3);
                    }
                    catch(err) {
                        document.getElementById("js_error").innerHTML = "Please reload page Shift + F5";
                    }
                });
            </script>
            <?php
            }
            ?>


            <div id="typing">

                <?php

                if ($strTyping) {
                    ?>

                <div id="counter" class="shadow_counter">
                    <div class="counter_box">
                        <div id="counter_sign" class="counter_top">0</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">Signs</div>
                    </div>
                    <div class="counter_box">
                        <div id="counter_prog" class="counter_top">0%</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">Progress</div>
                    </div>
                    <div class="counter_box">
                        <div id="counter_wpmi" class="counter_top">0</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">WPM</div>
                    </div>
                    <div class="counter_box">
                        <div id="counter_erro" class="counter_top">0</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">Errors</div>
                    </div>
                    <div class="counter_box">
                        <div id="counter_accu" class="counter_top">100%</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">Accuracy</div>
                    </div>
                    <div class="counter_box">
                        <div id="counter_time" class="counter_top">00:00</div>
                        <div class="counter_middle"></div>
                        <div class="counter_bottom">Time</div>
                    </div>
                </div>


                <div id="text" class="text_type dir_ltr">
                </div>


                <div>
                    <form name="type_form" action="#" autocomplete="off">
            <textarea
                name="type"
                id="type"
                class="dir_ltr"
                autocomplete="off"
                autocorrect="off"
                autocapitalize="none"
                spellcheck="false"
                cols="10"
                rows="10"
                onkeydown="return OnKeyDown(this, event);"
                onkeypress="return OnKeyPress(this, event);"></textarea>
                        <input type="hidden" id="type_text" value="<?php
                            echo $strTyping
                    ?>" />
                        <input type="hidden" id="type_keys" value="96:101¶126:101;413¶49:102¶33:102;413¶50:103¶64:103;413¶51:104¶35:104;413¶52:105¶36:105;413¶53:106¶37:106;413¶54:107¶94:107;401¶55:108¶38:108;401¶56:109¶42:109;401¶57:110¶40:110;401¶48:111¶41:111;401¶45:112¶95:112;401¶61:113¶43:113;401¶113:202¶81:202;413¶119:203¶87:203;413¶101:204¶69:204;413¶114:205¶82:205;413¶116:206¶84:206;413¶121:207¶89:207;401¶117:208¶85:208;401¶105:209¶73:209;401¶111:210¶79:210;401¶112:211¶80:211;401¶91:212¶123:212;401¶93:213¶125:213;401¶92:214¶124:214;401¶97:302¶65:302;413¶115:303¶83:303;413¶100:304¶68:304;413¶102:305¶70:305;413¶103:306¶71:306;413¶104:307¶72:307;401¶106:308¶74:308;401¶107:309¶75:309;401¶108:310¶76:310;401¶59:311¶58:311;401¶39:312¶34:312;401¶122:403¶90:403;413¶120:404¶88:404;413¶99:405¶67:405;413¶118:406¶86:406;413¶98:407¶66:407;413¶110:408¶78:408;401¶109:409¶77:409;401¶44:410¶60:410;401¶46:411¶62:411;401¶47:412¶63:412;401¶32:504¶" />
                        <input type="hidden" name="utf8" value="&#x2713;" />
                    </form>
                </div>

                <?php
                }
            ?>

            </div> <!-- typing -->

            <div id="typing_info">
                <div id="suggestion" class="suggestion">

                    <div class="hand">
                        <div id="hand_left"></div>
                    </div>

                    <div class="kb">
                        <div id="key_101" class="key key_two key_tilde"><div class="key_top">~</div><div class="key_bottom">`</div></div>
                        <div id="key_102" class="key key_two key_1"><div class="key_top">!</div><div class="key_bottom">1</div></div>
                        <div id="key_103" class="key key_two key_2"><div class="key_top">@</div><div class="key_bottom">2</div></div>
                        <div id="key_104" class="key key_two key_3"><div class="key_top">#</div><div class="key_bottom">3</div></div>
                        <div id="key_105" class="key key_two key_4"><div class="key_top">$</div><div class="key_bottom">4</div></div>
                        <div id="key_106" class="key key_two key_5"><div class="key_top">%</div><div class="key_bottom">5</div></div>
                        <div id="key_107" class="key key_two key_6"><div class="key_top">^</div><div class="key_bottom">6</div></div>
                        <div id="key_108" class="key key_two key_7"><div class="key_top">&amp;</div><div class="key_bottom">7</div></div>
                        <div id="key_109" class="key key_two key_8"><div class="key_top">*</div><div class="key_bottom">8</div></div>
                        <div id="key_110" class="key key_two key_9"><div class="key_top">(</div><div class="key_bottom">9</div></div>
                        <div id="key_111" class="key key_two key_0"><div class="key_top">)</div><div class="key_bottom">0</div></div>
                        <div id="key_112" class="key key_two key_-"><div class="key_top">_</div><div class="key_bottom">-</div></div>
                        <div id="key_113" class="key key_two key_="><div class="key_top">+</div><div class="key_bottom">=</div></div>
                        <div id="key_114" class="key key_back">Back</div>
                        <div id="key_201" class="key key_tab">Tab</div>
                        <div id="key_202" class="key key_q">q</div>
                        <div id="key_203" class="key key_w">w</div>
                        <div id="key_204" class="key key_e">e</div>
                        <div id="key_205" class="key key_r">r</div>
                        <div id="key_206" class="key key_t">t</div>
                        <div id="key_207" class="key key_y">y</div>
                        <div id="key_208" class="key key_u">u</div>
                        <div id="key_209" class="key key_i">i</div>
                        <div id="key_210" class="key key_o">o</div>
                        <div id="key_211" class="key key_p">p</div>
                        <div id="key_212" class="key key_two key_bracket_lft"><div class="key_top">{</div><div class="key_bottom">[</div></div>
                        <div id="key_213" class="key key_two key_bracket_rgt"><div class="key_top">}</div><div class="key_bottom">]</div></div>
                        <div id="key_214" class="key key_two key_backslash_rgt"><div class="key_top">|</div><div class="key_bottom">\</div></div>
                        <div id="key_301" class="key key_caps">Caps</div>
                        <div id="key_302" class="key key_a">a</div>
                        <div id="key_303" class="key key_s">s</div>
                        <div id="key_304" class="key key_d">d</div>
                        <div id="key_305" class="key key_f">f</div>
                        <div id="key_306" class="key key_g">g</div>
                        <div id="key_307" class="key key_h">h</div>
                        <div id="key_308" class="key key_j">j</div>
                        <div id="key_309" class="key key_k">k</div>
                        <div id="key_310" class="key key_l">l</div>
                        <div id="key_311" class="key key_two key_semicolon"><div class="key_top">:</div><div class="key_bottom">;</div></div>
                        <div id="key_312" class="key key_two key_apostrophe"><div class="key_top">&quot;</div><div class="key_bottom">&#039;</div></div>
                        <div id="key_313" class="key key_enter">Enter</div>
                        <div id="key_401" class="key key_shift_lft_long">Shift</div>
                        <div id="key_403" class="key key_z">z</div>
                        <div id="key_404" class="key key_x">x</div>
                        <div id="key_405" class="key key_c">c</div>
                        <div id="key_406" class="key key_v">v</div>
                        <div id="key_407" class="key key_b">b</div>
                        <div id="key_408" class="key key_n">n</div>
                        <div id="key_409" class="key key_m">m</div>
                        <div id="key_410" class="key key_two key_comma"><div class="key_top">&lt;</div><div class="key_bottom">,</div></div>
                        <div id="key_411" class="key key_two key_period"><div class="key_top">&gt;</div><div class="key_bottom">.</div></div>
                        <div id="key_412" class="key key_two key_slash"><div class="key_top">?</div><div class="key_bottom">/</div></div>
                        <div id="key_413" class="key key_shift_rgt">Shift</div>
                        <div id="key_501" class="key key_ctrl_lft">Ctrl</div>
                        <div id="key_503" class="key key_alt_lft">Alt</div>
                        <div id="key_504" class="key key_space"> </div>
                        <div id="key_505" class="key key_alt_rgt">AltGr</div>
                        <div id="key_508" class="key key_ctrl_rgt">Ctrl</div>

                    </div>

                    <div class="hand">
                        <div id="hand_right"></div>
                    </div>

                    <div class="clr"></div>

                    <div id="finger_0"></div>
                    <div id="finger_1"></div>
                    <div id="finger_2"></div>
                    <div id="finger_3"></div>
                    <div id="finger_4"></div>

                </div>



            </div> <!-- typing_info -->

            <div class="middle_stuff">

            </div>
            <div id="debug">
            </div>
        </div> <!-- middle -->
    </div> <!-- wrap -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("ul").click(function(){
                $('li').css("display", 'none')
                $(this).children('li').css("display", 'block')
            });
            $(".mark_selected").parent().children("li").css("display", 'block');
        });
    </script>



@endsection
