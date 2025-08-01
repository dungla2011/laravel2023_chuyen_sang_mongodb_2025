<?php

namespace Tests\Feature;

use App\Models\GiaPha_Meta;
use App\Models\User;
use Illuminate\Testing\TestResponse;

class ApiGiaPhaTest extends TestCase1
{
    /**
     * @var TestResponse
     */
    protected function setUp(): void
    {
        parent::setUp();
        // set your headers here
        $tk = User::find(1)->getUserToken();
        dump("Token : $tk");
        //$this->withToken("123456")->getJson(route("api.demo.list"));
        $this->withHeader('Authorization', 'Bearer '.$tk);
    }

    public function testNotAllowPid0()
    {

        if ((new GiaPha_Meta())->isUseRandId()) {

            //id = 0, guest sẽ không được truy cập data
            $url = '/api/member-tree-mng/tree?pid=0&get_all=1&order_by=orders&order_type=DESC';
            //Guest:
            $this->withHeader('Authorization', 'Bearer ');
            $res = $this->getCurl1($url);
            dump($res->status().' / / ');
            dump($res->getContent());
            $cont = $res->getContent();

            //        self::assertStringContainsString("Not valid PID", $cont);
            self::assertTrue($res->status() == 403 || $res->status() == 400, $res->status());

            //user login sẽ duoc truy cập data
            $member = User::findUserWithEmail('member@abc.com');
            $tk = $member->getUserToken();
            $this->withHeader('Authorization', 'Bearer '.$tk);

            $url = '/api/member-tree-mng/tree?pid=0&get_all=1&order_by=orders&order_type=DESC';
            $res = $this->getCurl1($url);
            dump('STAUT: '.$res->status().' / / ');
            dump($res->getContent());
            $cont = $res->getContent();
            //        self::assertStringContainsString("Not valid PID", $cont);
            self::assertTrue($res->status() == 200);

            //User khong duoc truy cap pid la number vi day la so INT, phai Encode
            $url = '/api/member-tree-mng/tree?pid=123';
            $res = $this->getCurl1($url);
            dump('STT = '.$res->status().' / / ');
            dump($res->getContent());
            $cont = $res->getContent();
            //        self::assertStringContainsString("Not valid PID Number", $cont);
            self::assertTrue($res->status() == 400 || $res->status() == 403);
        }
    }

    //Todo: cần ktra Quota GP của userid, cần thêm 1 hàm tính quota...
    //GP giới hạn
    public function testGPQuota()
    {
        $this->assertTrue(true);
    }
}
