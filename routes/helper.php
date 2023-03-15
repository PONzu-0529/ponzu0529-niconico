<?php

class RouteHelper
{
    public static function makeVueResponse()
    {
        return response()
            ->file('index.html', ['Content-Type' => 'text/html']);
    }
}
