<?php

namespace Tests\Unit\Services;

use Auth, Exception;
use Tests\TestCase;
use App\Services\MylistAssistantService;

class MylistAssistantServiceTest extends TestCase
{
    public function test_getAll_unauthorized()
    {
        $service = new MylistAssistantService();
        try {
            $service->getAll();
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This User is unauthorized.');
        }
    }

    public function test_getAll()
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );

        $service = new MylistAssistantService();
        $result = $service->getAll();

        $this->assertArrayHasKey('music_id', $result[0]);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('niconico_id', $result[0]);
        $this->assertArrayHasKey('user_id', $result[0]);
        $this->assertArrayHasKey('favorite', $result[0]);
        $this->assertArrayHasKey('skip', $result[0]);
        $this->assertArrayHasKey('memo', $result[0]);
    }

    public function test_getRandomMusics()
    {
        $COUNT = 10;

        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );

        $service = new MylistAssistantService();
        $result = $service->getRandomMusics($COUNT);

        $this->assertCount($COUNT, $result);
    }

    public function test_getById_unauthorized()
    {
        $service = new MylistAssistantService();
        try {
            $service->getById(1);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This User is unauthorized.');
        }
    }

    public function test_getById()
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );

        $service = new MylistAssistantService();
        $result = $service->getById(1);

        $this->assertArrayHasKey('music_id', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('niconico_id', $result);
        $this->assertArrayHasKey('user_id', $result);
        $this->assertArrayHasKey('favorite', $result);
        $this->assertArrayHasKey('skip', $result);
        $this->assertArrayHasKey('memo', $result);
    }

    public function test_add_unauthorized()
    {
        $service = new MylistAssistantService();
        try {
            $service->add('', '', false, false, '');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This User is unauthorized.');
        }
    }

    public function test_add()
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );

        $title = 'TEST_TITLE';
        $id = 'TEST_NICONICO_ID_' . time();
        $favorite = true;
        $skip = false;
        $memo = 'TEST_MEMO';

        $service = new MylistAssistantService();
        $service->add($title, $id, $favorite, $skip, $memo);

        $response = $service->getAll();
        $result = end($response);

        $this->assertEquals($result['title'], $title);
        $this->assertEquals($result['niconico_id'], $id);
        $this->assertEquals($result['favorite'], $favorite);
        $this->assertEquals($result['skip'], $skip);
        $this->assertEquals($result['memo'], $memo);
    }

    public function test_update_unauthorized()
    {
        $service = new MylistAssistantService();
        try {
            $service->update(1, '', '', false, false, '');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This User is unauthorized.');
        }
    }

    public function test_update()
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );

        $title = 'TEST_TITLE';
        $id = 'TEST_NICONICO_ID_UPDATE_' . time();
        $favorite = false;
        $skip = true;
        $memo = 'TEST_MEMO';

        $service = new MylistAssistantService();
        $music_id = $service->add($title, $id, $favorite, $skip, $memo);

        $title = 'TEST_TITLE_NEW';
        $id = 'TEST_NICONICO_ID_UPDATE_NEW_' . time();
        $favorite = true;
        $skip = false;
        $memo = 'TEST_MEMO_NEW';

        $service->update($music_id, $title, $id, $favorite, $skip, $memo);

        $response = $service->getAll();
        $result = end($response);

        $this->assertEquals($result['title'], $title);
        $this->assertEquals($result['niconico_id'], $id);
        $this->assertEquals($result['favorite'], $favorite);
        $this->assertEquals($result['skip'], $skip);
        $this->assertEquals($result['memo'], $memo);
    }

    // /**
    //  * Get Niconico Info
    //  *
    //  * @return void
    //  */
    // public function test_getNiconicoInfo()
    // {
    //     $service = new MylistAssistantService();
    //     $result = $service->getNiconicoInfo('sm40663116');
    //     var_dump($result);
    // }

    // /**
    //  * Get NowPlaying Info
    //  *
    //  * @return void
    //  */
    // public function test_getNowPlayingInfo()
    // {
    //     $service = new MylistAssistantService();
    //     $result = $service->getNowPlayingInfo();
    //     var_dump($result);
    // }

    /**
     * Check Unique Music ID
     *
     * @return void
     */
    public function test_checkUniqueId()
    {
        $method = new \ReflectionMethod(MylistAssistantService::class, 'checkIdDuplication');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new MylistAssistantService(), ['NiconicoID999']);
        $this->assertFalse($result);
    }

    /**
     * Check Duplicate Music ID
     *
     * @return void
     */
    public function test_checkExistId()
    {
        $method = new \ReflectionMethod(MylistAssistantService::class, 'checkIdDuplication');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new MylistAssistantService(), ['NiconicoID1']);
        $this->assertTrue($result);
    }
}
