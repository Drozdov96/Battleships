<?php

class DatabaseHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        //$this->assertSame(\app\controllers\DatabaseHelper::getPlayerForId(999), null);

        $this->assertSame(\app\controllers\DatabaseHelper::getPlayerForId(999), false);
    }
}