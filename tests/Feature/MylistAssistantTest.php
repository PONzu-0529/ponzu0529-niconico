<?php

namespace Tests\Feature;

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
        $mylist_assistant_service = new MylistAssistantService();

        $parameter = new CreateMylistDTO(
            'yusuke19970529@gmail.com',
            'wdxtyhbijm',
            'CustomMylist',
            [
                'sm41964627',
                'sm39581209'
            ]
        );

        $mylist_assistant_service->createMylist($parameter);

        $this->assertTrue(true);
    }
}
