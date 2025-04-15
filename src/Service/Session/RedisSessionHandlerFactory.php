<?php

namespace App\Service\Session;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

readonly class RedisSessionHandlerFactory
{
    public function create(
        #[\SensitiveParameter] string $dsn,
        string                        $prefix = 'sf_s',
        ?int                          $ttl = null,
    ): RedisSessionHandler
    {
        $cluster = RedisAdapter::createConnection($dsn);

        return new RedisSessionHandler($cluster, [
            'ttl' => $ttl,
            'prefix' => $prefix,
        ]);
    }
}
