<?php

namespace SoulDoit\PhpDBWow\Traits;

trait ErrorHandler {
    private function die($message)
    {
        die($this::class . " : $message");
    }
}