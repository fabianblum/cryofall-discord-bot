<?php

namespace App\Listener;

interface ListenerInterface
{
    public function listen(): callable;

    public function getEvent(): string;
}