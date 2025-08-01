<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class BlockUi extends ModelGlxBase
{
    use HasFactory, TraitModelExtra;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Define MongoDB field types for BlockUi model
     * Based on SQL: CREATE TABLE `block_uis` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'sname' => 'string',
        'summary' => 'string',
        'summary2' => 'string',
        'module_table' => 'string',
        'idModule' => 'string',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'log' => 'string',
        'siteid' => 'int',
        'extra_info' => 'string',
        'image_list' => 'string',
        'tags_list' => 'string',
        'created_at' => 'date',
        'status' => 'int',
        'content' => 'string',
        'guide_admin' => 'string',
        'extra_color_background' => 'string',
        'extra_color_text' => 'string',
        'group_name' => 'string',
    ];

    public static function showEditLink_($link, $title = '', $style = '')
    {
        if (! isAdminACP_()) {
            return;
        }
        echo "<a data-code-pos='ppp17364705733271' style='$style' class='icon-edit' href='$link' title='Sửa khối: $title' target='_blank'><i class=''>E</i></a>";
    }

    /**
     * @return BlockUi|void|null
     */
    public static function showEditButtonStatic($sname)
    {
        //        if(!isAdminACP_()) return;
        if ($ui = \App\Models\BlockUi::getOneSName_Static($sname)) {
            $ui->showEditButton();
            if (! $ui) {
                return null;
            }

            return $ui;
        }

        return null;
    }

    public function getName($lang = '')
    {
        return strip_tags($this->name);
    }

    public function getExtra()
    {
        return strip_tags($this->extra_info);
    }

    public function getSummary($stripTag = 0)
    {
        if ($stripTag) {
            return strip_tags($this->summary);
        }

        return $this->summary;
    }

    public function getSummary2($stripTag = 0)
    {
        if ($stripTag) {
            return strip_tags($this->summary2);
        }

        return $this->summary2;
    }

    public function getContent($stripTag = 0)
    {
        if ($stripTag) {
            return strip_tags($this->content);
        }

        return $this->content;
    }

    //Khối này Nằm cần trong class: qqqq1111
    public function showEditButton($visible = 0, $extStyle = null)
    {
        if (! isAdminACP_()) {
            return;
        }
        if (! $this->id) {
            $link = "/admin/block-ui/create?sname=$this->sname";
            $name = $sname = $this->sname;
            echo "<span onclick='window.open(\"$link\")' ppp09780s9dui class='icon-edit' style='background-color: orangered' data-sname='$this->sname' title='Tạo khối: $sname / name=$name' target='_blank'><i class=''>A</i></span>";

            return null;
        }

        $link = "/admin/block-ui/edit/$this->id";
        //Hiển trị trực tiếp, ko cần hover, 1 số chỗ cần vậy, ví dụ Edit content trong Input (place holder)
        if ($visible == 1 || $visible == true) {
            echo "<span ppp0989dui onclick='window.open(\"$link\")' data-sname='$this->sname' style='height: auto; display: inline-block; margin: 0px 5px; color: white; background-color: #ccc; margin: padding: 3px; border: 1px solid white; border-radius: 3px; $extStyle' ppp09780s9dui class='' title='Sửa khối: $this->name / sname=$this->sname' target='_blank'>
                    <i class='' style='color: white; height: auto;margin: 0px 0px'>[E]</i>
                  </span>";

            return;
        }
        echo "<span data-code-pos='ppp16966062234301' onclick='window.open(\"$link\")' class='icon-edit' href='$link' data-sname='$this->sname' title='Sửa khối: $this->name / sname=$this->sname' target='_blank'><i class=''>E</i></span>";
    }

    /**
     * @return $this
     */
    public static function getOneSName_Static($name)
    {
        $obj = new BlockUi();
        if ($obj1 = BlockUi::where('sname', $name)->first()) {
            return $obj1;
        }
        $obj->sname = $name;

        return $obj;
    }

    public function getOneSNameUI($name)
    {
        return $this->getOneSName($name);
    }

    public function getOneSName($name)
    {
        $name = addslashes($name);
        if (BlockUi::where("sname = '$name'")) {
            return $this->sname;
        }
        //Gán lại để show Add nếu ko thấy
        $this->sname = $name;

        return null;
    }

    public static function showCssHoverBlock()
    {
        if (! isAdminACP_()) {
            return;
        }
        ?>
        <style ppplk9080d9>
            .qqqq1111 {
                position: relative;
                transition: all 0.5s;
            }

            .qqqq1111:hover {
                box-shadow: 0px 0px 15px 5px #6f6d6dab;
                z-index: 100000 !important;

            }

            .qqqq1111:hover .icon-edit {
                opacity: 1;
            }

            .qqqq1111 .icon-add {
                margin-top: 60px;
            }

            .icon-edit:hover {
                color: springgreen;
                background-color: white;
                border: 3px solid springgreen;
            }

            .icon-edit {
                cursor: pointer;
                opacity: 0;
                color: white;
                border: 3px solid white;
                position: absolute !important;
                left: -5px;
                top: 0px;
                /*font-size: 20px;*/
                background: springgreen;
                padding: 2px 6px;
                border-radius: 10px;
                z-index: 100000;
                max-width: 50px;
            }
        </style>

<?php
    }
}
