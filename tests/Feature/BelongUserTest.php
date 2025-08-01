<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class BelongUserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // set your headers here
        //$this->withToken("123456")->getJson(route("api.demo.list"));
        $tk = User::find(1)->getUserToken();
        dump("Token : $tk");
        //$this->withToken("123456")->getJson(route("api.demo.list"));
        $this->withHeader('Authorization', 'Bearer '.$tk);
    }

    /**
     * Kiểm tra CURD các bản ghi, thuộc user hay không... thì có quyền/ ko có quyền
     */
    public function testItemBelongUser()
    {
        dump('=== Check '.get_called_class().'/'.__FUNCTION__);
        //TODO: need test
        $this->assertTrue(true);
    }
}
