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
     * @return JsonObject $response
     */
    public function response(
        string $requestId,
        float $start,
        $token,
        $data = [],
        string $message = ''
    ) {
        $profiler = $this->getProfiler($start);

        $response = [
            'data' => $data,
            'profiler' => $profiler,
            'token' => $token,
            'requestId' => $requestId,
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return $response;
    }

    /**
     * Prepare 204 delete response
     * @return Response $response
     */
    public function responseDelete()
    {
        $response = [
            'data' => [],
        ];
        return $response;
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
}
