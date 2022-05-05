<?php


use Finbox\Sdk\Hash\Hash;
use PHPUnit\Framework\TestCase;


class RequestTest extends TestCase
{
    public function testSuccessHash() {
        $request = new Finbox\Sdk\Request\Request(
            'test://test.domain',
            'access_token',
            'secret_token'
        );

        $command = new \Finbox\Sdk\Commands\ClientCreateCommand(
            \Finbox\Sdk\Types\ClientType::INDIVIDUAL,
            [
                'name' => 'Test',
            ],
            '+7 (900) 000-00-00'
        );

        $curlMock = $this->createMock(Finbox\Sdk\Request\CurlRequest::class);
        $curlMock->expects($this->once())
            ->method('execute')
            ->willReturn('{ "id": "1234" }');

        $curlMock->expects($this->exactly(5))
            ->method('setOption')
            ->withConsecutive(
                [CURLOPT_URL, 'test://test.domain' . $command->getApiMethod()],
                [CURLOPT_CUSTOMREQUEST, $command->getHttpMethod()],
                [CURLOPT_RETURNTRANSFER, TRUE],
                [CURLOPT_HTTPHEADER, ],
                [CURLOPT_POSTFIELDS, json_encode($command->to_array())]
            );

        $reflectionClass = new \ReflectionClass($request);
        $property = $reflectionClass->getProperty('curl');
        $property->setAccessible(true);
        $property->setValue($request, $curlMock);

        $res = $request->make($command);

        $this->assertInstanceOf(\Finbox\Sdk\Hash\RequestResult::class, $res);
        $this->assertTrue($res->success);
    }
}
