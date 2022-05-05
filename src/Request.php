<?php

namespace Finbox\Sdk\Request;

use Exception;
use Finbox\Sdk\Commands\Command;
use Finbox\Sdk\Hash\Hash;
use Finbox\Sdk\Hash\RequestResult;
use Finbox\Sdk\Types\HttpMethod;


class Request
{
    private $url;
    private $secret;
    private $token;
    private $curl;

    public function __construct(string $url, string $token, string $secret)
    {
        $this->url = $url;
        $this->secret = $secret;
        $this->token = $token;
        $this->curl = new CurlRequest();
    }

    protected function request(string $url, string $method, array $postData, string $hash)
    {
        $this->curl->setOption(CURLOPT_URL, $url);
        $this->curl->setOption(CURLOPT_CUSTOMREQUEST, $method);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, TRUE);
        $this->curl->setOption(CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
            'x-secure: ' . $hash,
        ]);

        if ($method == HttpMethod::POST) {
            $this->curl->setOption(CURLOPT_POSTFIELDS, json_encode($postData));
        }

        $response = $this->curl->execute();

        if ($response === FALSE) {
            return null;
        }

        $this->curl->close();

        return $response;
    }

    private function buildApiUrl(Command $command): string
    {
        return $this->url . $command->getApiMethod();
    }

    public function make(Command $command): RequestResult
    {
        $hash = Hash::hash($command->to_array(), $this->secret);

        $response = $this->request(
            $this->buildApiUrl($command),
            $command->getHttpMethod(),
            $command->to_array(),
            $hash
        );

        if (is_null($response)) {
            return new RequestResult(false, 'Request error');
        }

        try {
            $responseData = json_decode($response, TRUE);
        } catch (Exception $e) {
            return new RequestResult(false, $e->getMessage());
        }

        if (is_null($responseData)) {
            return new RequestResult(false, 'JSON parse error');
        }

        if (key_exists('statusCode', $responseData)) {
            if ($responseData['statusCode'] !== 200 && $responseData['statusCode'] !== 201) {
                return new RequestResult(
                    false,
                    $responseData['errorMessage'],
                    $responseData['errorCode'],
                    $responseData['data'],
                    null);
            }
        }

        return new RequestResult(true, null, null, null, $responseData);
    }
}
