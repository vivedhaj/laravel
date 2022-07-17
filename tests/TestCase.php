<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    /**
     * setup
     *
     * @return void
     */
    public function setUp():void {
        parent::setUp();
        $this->seed();
        $this->get('api/load-quotes');
    }
}
