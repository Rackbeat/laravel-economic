<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use PHPUnit\Framework\TestCase;

class AutoloadTest extends TestCase
{
    #[Test]
    public function every_class_in_src_can_be_autoloaded()
    {
        $src   = realpath(__DIR__ . '/../../src');
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src));

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php' || str_contains($file->getPathname(), DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR)) {
                continue;
            }

            $class = 'LasseRafn\\Economic\\' . str_replace(
                [DIRECTORY_SEPARATOR, '.php'],
                ['\\', ''],
                substr($file->getPathname(), strlen($src) + 1)
            );

            $this->assertTrue(
                class_exists($class) || interface_exists($class) || trait_exists($class),
                "{$class} could not be autoloaded"
            );
        }
    }
}
