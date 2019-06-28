<?php

namespace ResponseJson;

class ResponseJson
{
    /**
     * Prepare JSON response
     *
     * @param string $requestId
     * @param float $start
     * @param string $token
     * @param array $data
     * @param string $message
     * @param integer $code
     * @return JsonObject $response
     */
    public function response(
        string $requestId,
        float $start,
        $token,
        $data = [],
        string $message = '',
        int $code = 200
    ) {
        $version = $this->getConfig('version.info');
        $profiler = $this->getProfiler($start);

        $response = [
            'code' => $code,
            'data' => $data,
            'profiler' => $profiler,
            'token' => $token,
            'version' => $version,
            'requestId' => $requestId,
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return json_encode($response);
    }

    /**
     * Prepare 204 delete response
     * @return Response $response
     */
    public function responseDelete()
    {
        $response = [
            'code' => 204,
            'data' => [],
        ];
        return json_encode($response);
    }

    /**
     * Get profile count
     * @return void
     */
    public function getProfiler($start)
    {
        if (empty($start)) {
            return 0;
        }
        $finish = microtime(true);
        return ($finish - $start);
    }

     /**
      * @codeCoverageIgnore
      * get and return project config
      * @param string $config
      * @return mixed
      */
    public function getConfig(string $config)
    {
        return config($config);
    }
}
