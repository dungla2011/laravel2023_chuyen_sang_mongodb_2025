<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;
use LadLib\Laravel\Database\TraitModelTree;

class MenuTree extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra, TraitModelTree;

    protected $guarded = [];

    public function isHaveChild(&$mMenu)
    {
        foreach ($mMenu as $obj) {
            if ($obj->parent_id == $this->id) {
                return 1;
            }
        }

        return 0;
    }

    static function showMenuPublicSandBox($pre = null, $after = null)
    {
        $mm = self::getMenuArrayPublic();
    // Helper function to build menu tree
    // Helper function to build menu tree
        function buildMenu($menuItems, $parentId) {
            $html = '';
            $items = array_filter($menuItems, function($item) use ($parentId) {
                return $item->parent_id === $parentId;
            });

            if (count($items) > 0) {
                $html .= '<ul class="dropdown-menu">';
                foreach ($items as $item) {
                    $children = buildMenu($menuItems, $item->id);
                    $hasChildren = !empty($children);
                    $html .= '<li class="nav-item ' . ($hasChildren ? 'dropdown' : '') . '">';
                    $html .= '<a class="dropdown-item ' . ($hasChildren ? 'dropdown-toggle' : '') . '" href="' . $item->link . '">' . $item->name . '</a>';
                    $html .= $children;
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }

            return $html;
        }

    // Render menu
        function renderMenu($menuItems) {
            $rootItems = array_filter($menuItems, function($item) {
                return $item->parent_id === 3;
            });

            foreach ($rootItems as $item) {
                $children = buildMenu($menuItems, $item->id);
                $hasChildren = !empty($children);
                echo '<li class="nav-item ' . ($hasChildren ? 'dropdown' : '') . '">';
                echo '<a class="nav-link ' . ($hasChildren ? 'dropdown-toggle' : '') . '" href="' . $item->link . '">' . $item->name . '</a>';
                echo $children;
                echo '</li>';
            }
        }


?>



    <?php
    \App\Models\BlockUi::showEditLink_("/admin/menu-tree/tree?pid=3&gid=0&open_all=1", 'edit menu', 'position: static!important; height: 40px');
    renderMenu($mm);
    ?>

        <?php
    }

    static function getMenuArrayPublic()
    {
        $menu = new \App\Models\MenuTree();
        $mm = $menu->getAllTreeDeep(3);


        //Mảng mm biến thành mảng các obj
        $mm = array_map(function($v){
            return (object)$v;
        }, $mm);


        //Sắp xêếp lại theo thứ tự orders
        usort($mm, function($a, $b){
            return $a->orders <=> $b->orders;
        });

        //mảng mm bỏ đi các obj co status = 0
        $mm = array_filter($mm, function($v){
            return str_contains(','.$v->gid_allow.',', ',0,');
        });
        return $mm;
    }

    public static function showMenuAdminLte($pid)
    {
        //$mMenu = \App\Models\MenuTree::where('parent_id', 4)->get();
        $mMenu0 = \App\Models\MenuTree::orderBy('orders', 'ASC')->get();

        // print_r($mMenu0->toArray());


        $gidCurrent = getGidCurrent_();

        echo "<!-- GID = $gidCurrent -->";

        $mGid = explode(',', $gidCurrent);
        //Nếu gid curent chứa gid allow thì ok
        $mMenu = [];
        foreach ($mMenu0 as $obj) {
            $obj->gid_allow = ",$obj->gid_allow,";
            foreach ($mGid as $gidC) {
                if (! $gidC) {
                    continue;
                }
                if (strstr($obj->gid_allow, ",$gidC,") !== false) {
                    $mMenu[] = $obj;
                    break;
                }
            }
            //            if(strstr($obj->gid_allow, ",$gidCurrent,") !== false){
            //                $mMenu[] = $obj;
            //            }
        }

        // print_r($mMenu);
        
        // echo "<br>";
        // die("PID = $pid");
        \App\Models\MenuTree::showMenuAdminLte0($pid, $mMenu, $gidCurrent);
    }

    public static function showMenuAdminLte0($pid, &$mMenu, &$gid)
    {
        //Xem có con không, nếu có thì mới tiếp tục
        $haveChild = 0;
        $isInRoot = 0;
        foreach ($mMenu as $obj) {
            if ($obj->parent_id == $pid) {
                $haveChild = 1;
            }
            if ($obj->id == $pid) {
                if ($obj->parent_id == 0) {
                    $isInRoot = 1;
                }
            }
        }
        if (! $haveChild) {
            return;
        }
        if (! $isInRoot) {
            echo '<ul class="nav nav-treeview nav-sidebar nav-child-indent">';
        }
        foreach ($mMenu as $obj) {
            if ($obj->parent_id == $pid) {

                $tg = '';
                if ($obj->open_new_window) {
                    $tg = " target='_blank' ";
                }
                if (! $obj->icon) {
                    $obj->icon = 'far fa-circle nav-icon';
                }

                echo "<li id='_menu_$obj->link' class='nav-item'><a $tg href='$obj->link' class='text-sm nav-link'><i class='$obj->icon'></i><p>".($obj->name);
                if ($obj->isHaveChild($mMenu)) {
                    echo "<i class='right fas fa-angle-left'></i>";
                }
                echo '</p></a>';
                self::showMenuAdminLte0($obj->id, $mMenu, $gid);
                echo '</li>';
            }
        }
        if (! $isInRoot) {
            echo '</ul>';
        }
    }

    public static function show_menu_recursive2024(&$arrObj, $parent = 0, $level = '')
    {

        $strRet = '';
        if (count($arrObj) < 1) {
            return;
        }

        //
        //        $objMenu0 = new ModelMenuCms();
        //        $objMenu1 = new ModelMenuCms();

        //        $baseUrl = ClassRoute::getBaseUri();
        $baseUrl = '';

        if (! $level) {
            $level = 0;
        }
        $level++;
        $levelUl = $level + 1;

        //Duyet tat ca mang
        foreach ($arrObj as $key0 => $objMenu0) {
            if ($objMenu0->id == -1) {
                continue;
            }

            $countChild = 0;
            $id = $pid = $objMenu0->id;

            //echo "\n XET: $objMenu0->name (id =$id, p=$objMenu0->parent_id , PInput = $parent)";
            //Neu co parent, thi xet
            if ($objMenu0->parent_id != $parent) {
                //  echo " ->bo qua";
                continue;
            }
            //echo "\n Tiep tuc XET: $objMenu0->name (id =$id, p=$objMenu0->parent_id )";
            //Xem phan tu hien tai co child khong
            foreach ($arrObj as $key1 => $objMenu1) {
                if ($objMenu1->parent_id == $id && $objMenu1->id != $id) {
                    $countChild++;
                    break;
                }
            }

            $aClass = 'nav-link';
            $liClass = 'nav-item';
            if ($level > 1) {
                $aClass = 'dropdown-item';
                $liClass = '';
            }

            $padIcon = '';
            //            if($objMenu0 instanceof ModelMenuCms);
            if ($objMenu0->icon) {
                $padIcon = "<i class='$objMenu0->icon'></i>";
            }
            // echo "<br/>$objMenu0->name : Co child";
            //Neu ko co con thi in ra luon
            if ($countChild == 0) {
                $padTs = '';
                //if(!$objMenu0->idnews)
                //  $padTs = "?ts=".time();
                $strRet .= "\n\n<li class='$liClass $level'> <a class=\"$aClass $level \" href='$baseUrl$objMenu0->link$padTs'> $padIcon $objMenu0->name</a> \n</li> ";
                // echo "<br/>  $objMenu0->name  ( KO CO Child?) \n</li> ";
                $objMenu0->id = -1;

                continue;
            }

            //echo "<br/>  $objMenu0->name  ( CO Child?) \n</li> ";
            //Neu phan tu con co con
            //echo " <br>countChild = $countChild ";
            $padTs = '';
            //if(!$objMenu0->idnews)
            //  $padTs = "?ts=" + time();
            $padCaret = '';
            //            if($level > 1)
            $padCaret = "<i class=\"fa fa-caret-right\" style=''></i>";

            if ($objMenu0->disable_href > 0) {
                $strRet .= "\n\n<li class='have_child $liClass  $level'> \n<a  class=\" $level \"> $padIcon  $objMenu0->name  </a> $padCaret ";
            } else {
                $strRet .= "\n\n<li class='have_child $liClass  $level '> \n<a  class=\" $level\" href='$baseUrl$objMenu0->link$padTs'> $padIcon  $objMenu0->name  </a> $padCaret ";
            }

            $strRet .= "\n\t<ul data-code-pos='qqq9086456456' class='sub-menu'>";

            $parentNext = $objMenu0->id;
            $objMenu0->id = -1;
            //unset($arrObj[$key0]);

            $strRet .= static::show_menu_recursive2024($arrObj, $parentNext, $level);

            $strRet .= "\n\t</ul>";

            $strRet .= "\n</li>";
        }

        return $strRet;
    }

    public static function showMenuPublic2024($pid)
    {
        //$mMenu = \App\Models\MenuTree::where('parent_id', 4)->get();
        $mMenu0 = \App\Models\MenuTree::orderBy('orders', 'ASC')->get();
        $gidCurrent = getGidCurrent_();
        $mGid = explode(',', $gidCurrent);
        //Nếu gid curent chứa gid allow thì ok
        $mMenu = [];
        foreach ($mMenu0 as $obj) {
            $obj->gid_allow = ",$obj->gid_allow,";
            foreach ($mGid as $gidC) {
                if (! $gidC) {
                    continue;
                }
                if (strstr($obj->gid_allow, ",$gidC,") !== false) {
                    $mMenu[] = $obj;
                    break;
                }
            }
            //            if(strstr($obj->gid_allow, ",$gidCurrent,") !== false){
            //                $mMenu[] = $obj;
            //            }
        }
        \App\Models\MenuTree::showMenuPublic2024_0($pid, $mMenu, $gidCurrent);
    }

    public static function showMenuPublic2024_0($pid, &$mMenu, &$gid)
    {
        //Xem có con không, nếu có thì mới tiếp tục
        $haveChild = 0;
        $isInRoot = 0;
        foreach ($mMenu as $obj) {
            if ($obj->parent_id == $pid) {
                $haveChild = 1;
            }
            if ($obj->id == $pid) {
                if ($obj->parent_id == 0) {
                    $isInRoot = 1;
                }
            }
        }
        if (! $haveChild) {
            return;
        }
        if (! $isInRoot) {

        }
        foreach ($mMenu as $obj) {
            if ($obj instanceof MenuTree);

            if ($obj->parent_id == $pid) {

                $tg = '';
                if ($obj->open_new_window) {
                    $tg = " target='_blank' ";
                }
                if (! $obj->icon) {
                    //                    $obj->icon = 'far fa-circle nav-icon';
                }
                echo "\n<li class=''>\n<a $tg href='$obj->link' class=''><i class='$obj->icon'></i>".($obj->name);
                if ($obj->isHaveChild($mMenu)) {
                    echo "<i class='right fas fa-angle-left'></i>";
                }
                echo "</a>\n";
                if ($obj->isHaveChild($mMenu)) {
                    echo "\t\n<ul class='sub-menu'>";
                    self::showMenuPublic2024_0($obj->id, $mMenu, $gid);
                    echo "\n</ul>";
                }
                echo "\n</li>\n";
            }
        }
        if (! $isInRoot) {
            echo "</ul>\n";
        }
    }
    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'parent_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'orders' => 'int',
        'link' => 'string',
        'gid_allow' => 'string',
        'open_new_window' => 'int',
        'icon' => 'string',
        'id_news' => 'int',
    ];

}
