<?php

namespace Javaabu\Forms\Tests\TestSupport;

/**
 * Values for the get_setting() stand-in in helpers.php. TestCase clears them before each test.
 */
class FakeSettings
{
    /** @var array<string, mixed> */
    public static array $values = [];
}
