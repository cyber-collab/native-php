<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;

/**
* Simple in-memory cache implementation.
*/
class CacheStored implements CacheItemInterface
{
    protected string $key;
    public function __construct(string $key, ?string $cacheExpire = null, ?string $cacheLimiter = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            if ($cacheLimiter !== null) {
                session_cache_limiter($cacheLimiter);
            }

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire);
            }

            session_start();
        }
        $this->key = $key;
    }
    public function get(): mixed
    {
        if ($this->isHit()) {
            return $_SESSION[$this->key];
        }

        return null;
    }

    public function set($value): static
    {
        $_SESSION[$this->key] = $value;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function isHit(): bool
    {
        return array_key_exists($this->key, $_SESSION);
    }

    public function expiresAt(?\DateTimeInterface $expiration): static
    {
        return $this;
    }

    public function expiresAfter(\DateInterval|int|null $time): static
    {
        return $this;
    }
}
