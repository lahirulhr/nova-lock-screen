<?php
namespace Lahirulhr\NovaLockScreen;

 trait LockAble{
    public function getLockScreenImage():String
    {
        return config('nova-lock-screen.background_image');
    }

    public function lockScreenEnabled():bool
    {
        return config('nova-lock-screen.enabled');
    }
 }
