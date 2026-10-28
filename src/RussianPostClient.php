<?php

declare(strict_types=1);

namespace WishboxRussianPost;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use WishboxRussianPost\Api\CalculatorApi;
use WishboxRussianPost\Api\OrderApi;
use WishboxRussianPost\Config\RussianPostConfig;
use WishboxRussianPost\Exception\HttpException;
use WishboxRussianPost\Exception\TransportException;
use WishboxRussianPost\Exception\UnexpectedResponseException;
use WishboxRussianPost\Response\RawRussianPostResponse;
use WishboxRussianPost\Response\RussianPostResponse;

final class RussianPostClient
{
    public const string BASE_URL = 'https://otpravka-api.pochta.ru';

    private readonly RussianPostConfig $config;
    private ?CalculatorApi $calculatorApi = null;
    private ?OrderApi $orderApi = null;

    /**
     * @param array{
     *     access_token?: string,
     *     user_authorization?: string,
     *     base_url?: string,
     *     user_agent?: string
     * }|RussianPostConfig $config
     */
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        array|RussianPostConfig $config,
    ) {
        $this->config = $config instanceof RussianPostConfig
            ? $config
            : RussianPostConfig::fromArray($config, self::BASE_URL);
    }

    /**
     * @return CalculatorApi
     *
     * @noinspection PhpUnused
     */
    public function calculator(): CalculatorApi
    {
        return $this->calculatorApi ??= new CalculatorApi($this);
    }

    public function orders(): OrderApi
    {
        return $this->orderApi ??= new OrderApi($this);
    }

    /**
     * @param array<string, scalar|list<scalar>> $query
     * @param array<string, mixed>|string|null $body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function request(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
    ): array {
        return $this->requestWithHeaders(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            $authenticated,
        )->data;
    }

    /**
     * @param array<string, scalar|list<scalar>> $query
     * @param array<string, mixed>|string|null $body
     * @param array<string, string> $headers
     */
    public function requestWithHeaders(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
    ): RussianPostResponse {
        $response = $this->sendRawRequest(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            $authenticated,
        );
        $data = $this->decodeJson($response->body);

        if ($response->statusCode >= 400) {
            throw new HttpException(
                $this->extractErrorMessage($data, $response->body, $response->statusCode),
                $response->statusCode,
                $data,
            );
        }

        return new RussianPostResponse($data, $response->headers, $response->statusCode);
    }

    /**
     * @param array<int, callable(RussianPostResponse): mixed|class-string> $responseMap
     * @param array<string, scalar|list<scalar>> $query
     * @param array<string, mixed>|string|null $body
     * @param array<string, string> $headers
     */
    public function requestMapped(
        string $method,
        string $uri,
        array $responseMap,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
    ): mixed {
        $response = $this->requestWithHeaders(
            $method,
            $uri,
            $query,
            $body,
            $headers,
            $authenticated,
        );
        $mapper = $responseMap[$response->statusCode] ?? null;

        if (is_string($mapper) && method_exists($mapper, 'fromArray')) {
            return $mapper::fromArray($response->data);
        }

        if (is_callable($mapper)) {
            return $mapper($response);
        }

        throw new UnexpectedResponseException(sprintf(
            'Unexpected Russian Post response status code %d for %s %s.',
            $response->statusCode,
            strtoupper($method),
            $uri,
        ));
    }

    /**
     * @param array<string, scalar|list<scalar>> $query
     * @param array<string, mixed>|string|null $body
     * @param array<string, string> $headers
     */
    public function sendRawRequest(
        string $method,
        string $uri,
        array $query = [],
        array|string|null $body = null,
        array $headers = [],
        bool $authenticated = true,
        string $accept = 'application/json',
    ): RawRussianPostResponse {
        if ($authenticated) {
            $headers['Authorization'] = 'AccessToken ' . $this->config->accessToken;
            $headers['X-User-Authorization'] = 'Basic ' . $this->config->userAuthorization;
        }

        $payload = is_array($body) ? $this->encodeJson($body) : $body;

        if ($payload !== null && !isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json;charset=UTF-8';
        }

        $request = $this->requestFactory
            ->createRequest(strtoupper($method), $this->buildUrl($uri, $query))
            ->withHeader('Accept', $accept)
            ->withHeader('User-Agent', $this->config->userAgent);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($payload !== null) {
            $request = $request->withBody($this->streamFactory->createStream($payload));
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new TransportException($exception->getMessage(), 0, $exception);
        }

        return new RawRussianPostResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            (string) $response->getBody(),
        );
    }

    /** @param array<string, mixed> $data */
    private function encodeJson(array $data): string
    {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        } catch (JsonException $exception) {
            throw new UnexpectedResponseException('Unable to encode the Russian Post request.', 0, $exception);
        }
    }

    /** @return array<string, mixed> */
    private function decodeJson(string $body): array
    {
        if ($body === '' || $body === 'null') {
            return [];
        }

        try {
            $data = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new UnexpectedResponseException('Unable to decode the Russian Post response.', 0, $exception);
        }

        if (!is_array($data)) {
            throw new UnexpectedResponseException('The Russian Post response must be a JSON object.');
        }

        return $data;
    }

    /**
     * @param array<string, scalar|list<scalar>> $query
     */
    private function buildUrl(string $uri, array $query): string
    {
        $url = $this->config->baseUrl . '/' . ltrim($uri, '/');

        return $query === [] ? $url : $url . '?' . http_build_query($query);
    }

    /** @param array<string, mixed> $data */
    private function extractErrorMessage(array $data, string $body, int $statusCode): string
    {
        foreach (['message', 'error', 'desc', 'description'] as $key) {
            if (is_string($data[$key] ?? null) && $data[$key] !== '') {
                return $data[$key];
            }
        }

        return $body !== ''
            ? 'Russian Post API request failed: ' . $body
            : sprintf('Russian Post API request failed with HTTP status %d.', $statusCode);
    }
}
