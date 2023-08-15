<?php

namespace App\Objects\Log;

class LoggingObject
{
    private string $type;
    private string $message;
    private string $file;
    private string $trace;

    public function __construct(string $type, string $message, string $file = '', string $trace = '')
    {
        $this->type = $type;
        $this->message = $message;
        $this->file = $file;
        $this->trace = $trace;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function getTrace(): string
    {
        return $this->trace;
    }

    public function setTrace(string $trace): void
    {
        $this->trace = $trace;
    }
}
