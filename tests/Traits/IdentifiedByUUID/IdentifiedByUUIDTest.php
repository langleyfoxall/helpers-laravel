<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 28/06/2019
 * Time: 10:19
 */
namespace LangleyFoxall\Traits\IdentifiedByUUID;

use LangleyFoxall\Traits\IdentifiedByUUID\Models\Demo;
use Orchestra\Testbench\TestCase;

class IdentifiedByUUIDTest extends TestCase
{

    /**
     * Setup the test
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }

    /**
     * Check that saving a model correctly saves a UUID
     * @return void
     */
    public function testSaveStoresUUID()
    {
        $demo = Demo::create(['text' => 'hello world']);
        $this->assertRegExp('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $demo->uuid);
    }

    /**
     * Check that updating the model does not change the UUID
     */
    public function testUpdateDoesNotChangeUUID()
    {
        $demo = Demo::create(['text' => 'hello world']);
        $uuid = $demo->uuid;

        $demo->update(['text' => 'updated text']);

        $this->assertTrue($demo->uuid === $uuid);
    }
}