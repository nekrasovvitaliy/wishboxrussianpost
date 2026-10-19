<?php

declare(strict_types=1);

namespace WishboxRussianPost\Config;

use WishboxRussianPost\Exception\ConfigurationException;

final readonly class RussianPostConfig
{
    public function __construct(
        public string $accessToken,
        public string $userAuthorization,
        public string $baseUrl,
        public string $userAgent,
    ) {
        if ($accessToken === '') {
            throw new ConfigurationException('Russian Post access_token must not be empty.');
        }

        if ($userAuthorization === '') {
            throw new ConfigurationException('Russian Post user_authorization must not be empty.');
        }

        if ($baseUrl === '') {
            throw new ConfigurationException('Russian Post base_url must not be empty.');
        }
    }

    /**
     * @param array{
     *     access_token?: string,
     *     user_authorization?: string,
     *     base_url?: string,
     *     user_agent?: string
     * } $config
     */
    public static function fromArray(array $config, string $defaultBaseUrl): self
    {
        return new self(
            accessToken: self::withoutPrefix((string) ($config['access_token'] ?? ''), 'AccessToken'),
            userAuthorization: self::withoutPrefix(
                (string) ($config['user_authorization'] ?? ''),
                'Basic',
            ),
            baseUrl: rtrim((string) ($config['base_url'] ?? $defaultBaseUrl), '/'),
            userAgent: (string) ($config['user_agent'] ?? 'wishbox-russian-post-client/0.1'),
        );
    }

    private static function withoutPrefix(string $value, string $prefix): string
    {
        $value = trim($value);

        if (str_starts_with(strtolower($value), strtolower($prefix) . ' ')) {
            return trim(substr($value, strlen($prefix) + 1));
        }

        return $value;
    }
}
