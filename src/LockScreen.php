<?php

namespace Lahirulhr\NovaLockScreen;

trait LockScreen
{
    public function getLockScreenImage(): string
    {
        return config('nova-lock-screen.background_image');
    }

    public function lockScreenEnabled(): bool
    {
        return config('nova-lock-screen.enabled');
    }

    public function getLockScreenTimeout(): int
    {
        return config('nova-lock-screen.lock_timeout');
    }
}
