<?php

namespace Olssonm\Ampersand\Tests;

use Olssonm\Ampersand\AmpersandServiceProvider;
use \Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Sheets\SheetsServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            AmpersandServiceProvider::class,
            SheetsServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app) {}

    public function tearDown(): void
    {
        // Unset config
        $file = base_path() . '/config/ampersand.php';
        if(file_exists($file)) {
            unlink($file);
        }

        parent::tearDown();
    }
}
