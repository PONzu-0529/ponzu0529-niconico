<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use App\DTO\MylistAssistant\CreateMylistDTO;
use App\Services\MylistAssistantService;

/**
 * MylistAssistant Test
 */
class MylistAssistantTest extends TestCase
{
    public function test_success_create_mylist()
    {
        try {
            $mylist_assistant_service = new MylistAssistantService();

            $parameter = new CreateMylistDTO(
                '',
                '',
                'CustomMylist',
                [
                    'sm41964627',
                    'sm39581209'
                ]
            );

            $mylist_assistant_service->createMylist($parameter);
        } catch (Exception $ex) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}
