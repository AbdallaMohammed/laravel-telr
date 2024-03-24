<?php

namespace TelrGateway\Tests;

use TelrGateway\TelrManager;

class TestConfig extends AbstractTestCase
{
    /**
     * Set package in test mode.
     *
     * @return void
     */
    public function useTestMode($app)
    {
        $app['config']->set('telr.test_mode', true);
    }

    /**
     * Set package in production mode.
     *
     * @return void
     */
    public function useProductionMode($app)
    {
        $app['config']->set('telr.test_mode', false);
    }

    /**
     * @test
     * @define-env useTestMode
     */
    public function it_can_be_in_test_mode()
    {
        $client = app(TelrManager::class);

        $createRequest = $client->prepareCreateRequest(
            rand(1, 8),
            '5.99',
            'Awesome Description',
        );

        $this->assertTrue($createRequest->toArray()['ivp_test']);
    }

    /**
     * @test
     * @define-env useProductionMode
     */
    public function it_can_be_in_production_mode()
    {
        $client = app(TelrManager::class);

        $createRequest = $client->prepareCreateRequest(
            rand(1, 8),
            '5.99',
            'Awesome Description',
        );

        $this->assertFalse($createRequest->toArray()['ivp_test']);
    }
}