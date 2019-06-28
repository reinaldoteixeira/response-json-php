<?php

use \Mockery;
use ResponseJson\ResponseJson;
use PHPUnit\Framework\TestCase;

class ResponseJsonTest extends TestCase
{
    /**
     * @covers \ResponseJson\ResponseJson::response
     */
    public function testResponseError()
    {
        $token = [
            'token' => 'token_application',
            'valid_until' => '2019-06-04 17:17:34',
        ];

        $start = microtime(true);
        $finish = $start - microtime(true);

        $responseJson = Mockery::mock(ResponseJson::class)->makePartial();
        $responseJson->shouldReceive('getConfig')
            ->with('version.info')
            ->andReturn('1.0')
            ->shouldReceive('getProfiler')
            ->with($start)
            ->andReturn($finish);

        $helper = $responseJson->response(
            'requestid',
            $start,
            $token,
            [],
            'An unexpected error occurred, please try again later',
            422
        );

        $response = [
            'code' => 422,
            'data' => [],
            'profiler' => $finish,
            'token' => $token,
            'version' => '1.0',
            'requestId' => 'requestid',
            'message' => 'An unexpected error occurred, please try again later',
        ];

        $this->assertEquals(422, json_decode($helper, true)['code']);
        $this->assertEquals(json_encode($response), $helper);
    }

    /**
     * @covers \ResponseJson\ResponseJson::response
     */
    public function testResponseSucess()
    {
        $token = [
            'token' => 'token_application',
            'valid_until' => '2019-06-04 17:17:34',
        ];

        $start = microtime(true);
        $finish = $start - microtime(true);

        $responseJson = Mockery::mock(ResponseJson::class)->makePartial();
        $responseJson->shouldReceive('getConfig')
            ->with('version.info')
            ->andReturn('1.0')
            ->shouldReceive('getProfiler')
            ->with($start)
            ->andReturn($finish);

        $helper = $responseJson->response(
            'requestid',
            $start,
            $token,
            [
                'id' => 1,
            ],
            '',
            200
        );

        $response = [
            'code' => 200,
            'data' => [
                'id' => 1,
            ],
            'profiler' => $finish,
            'token' => $token,
            'version' => '1.0',
            'requestId' => 'requestid',
        ];

        $this->assertEquals(200, json_decode($helper, true)['code']);
        $this->assertEquals(json_encode($response), $helper);
    }

    /**
     * @covers \ResponseJson\ResponseJson::responseDelete
     */
    public function testResponseDelete()
    {
        $responseJson = new ResponseJson;
        $helper = $responseJson->responseDelete();

        $this->assertEquals(204, json_decode($helper, true)['code']);
        $this->assertEmpty(json_decode($helper, true)['data']);
    }

    /**
     * @covers \ResponseJson\ResponseJson::getProfiler
     */
    public function testGetProfilerWithoutStart()
    {
        $responseJson = new ResponseJson;
        $helper = $responseJson->getProfiler(null);

        $this->assertEquals(0, $helper);
    }

    /**
     * @covers \ResponseJson\ResponseJson::getProfiler
     */
    public function testGetProfiler()
    {
        $responseJson = new ResponseJson;
        $helper = $responseJson->getProfiler(microtime(true));

        $this->assertNotNull($helper);
        $this->assertIsFloat($helper);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
