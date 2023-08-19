<?php
namespace Lahirulhr\NovaLockScreen;

 trait LockScreen{
    public function getLockScreenImage():String
    {
        return config('nova-lock-screen.background_image');
    }

    public function lockScreenEnabled():bool
    {
        return config('nova-lock-screen.enabled');
    }
 }
