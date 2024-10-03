<?php

namespace Andi\GraphQL\Spiral\Controller;

use GraphQL\Server\StandardServer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class GraphQLController
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly StandardServer $server,
    ) {
    }

    public function graphql(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();
        $stream = $this->streamFactory->createStream();

        $response = $this->server->processPsrRequest($request, $response, $stream);
        assert($response instanceof ResponseInterface);

        return $response;
    }
}
