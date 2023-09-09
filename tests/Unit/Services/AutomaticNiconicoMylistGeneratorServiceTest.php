<?php

namespace Tests\Unit\Services;

use App\Objects\NicoMylistAutoGen\CreateCustomMylistRequestObject;
use App\Services\AutomaticNiconicoMylistGeneratorService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Tests\TestCase;

class AutomaticNiconicoMylistGeneratorServiceTest extends TestCase
{
    private AutomaticNiconicoMylistGeneratorService $service;

    public function __construct()
    {
        parent::__construct();

        $this->service = new AutomaticNiconicoMylistGeneratorService();
    }

    public function test_fail_create_mylist_unauthorized()
    {
        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'email' => 'test@sample.com',
            'password' => 'password',
            'mylist_title' => 'Test Mylist Title',
            'count' => '10'
        ]));

        try {
            $this->service->createMylist($request);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This User is Unauthorized.');
        }
    }

    public function test_fail_create_mylist_no_email()
    {
        $this->login();

        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'password' => 'password',
            'mylist_title' => 'Test Mylist Title',
            'count' => '10'
        ]));

        try {
            $this->service->createMylist($request);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'Parameter \'Email\' is Missing.');
        }
    }

    public function test_fail_create_mylist_no_password()
    {
        $this->login();

        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'email' => 'test@sample.com',
            'mylist_title' => 'Test Mylist Title',
            'count' => '10'
        ]));

        try {
            $this->service->createMylist($request);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'Parameter \'Password\' is Missing.');
        }
    }

    public function test_fail_create_mylist_no_mylist_title()
    {
        $this->login();

        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'email' => 'test@sample.com',
            'password' => 'password',
            'count' => '10'
        ]));

        try {
            $this->service->createMylist($request);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'Parameter \'Mylist Title\' is Missing.');
        }
    }

    public function test_fail_create_mylist_no_count()
    {
        $this->login();

        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'email' => 'test@sample.com',
            'password' => 'password',
            'mylist_title' => 'Test Mylist Title'
        ]));

        try {
            $this->service->createMylist($request);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'Parameter \'Count\' is Missing.');
        }
    }

    public function test_success_create_mylist()
    {
        $this->login();

        $request = new CreateCustomMylistRequestObject(Request::create('/api/nico-mylist-auto-gen/create-mylist', 'POST', [
            'email' => 'test@sample.com',
            'password' => 'password',
            'mylist_title' => 'Test Mylist Title',
            'count' => '10'
        ]));

        $response = $this->service->createMylist($request);

        $this->assertEquals($response->getStatus(), 'success');
    }

    private function login(): void
    {
        Auth::attempt([
            'email' => 'test1@sample.com',
            'password' => 'password'
        ]);
    }
}
