<?php

namespace App\Objects\NicoMylistAutoGen;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;

class CreateCustomMylistResponseObject
{
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function createJsonResponse(): JsonResponse
    {
        return ResponseHelper::jsonResponse([
            'status' => $this->status
        ]);
    }
}
