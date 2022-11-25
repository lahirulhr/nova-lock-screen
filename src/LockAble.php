<?php
namespace Visanduma\NovaLockscreen;

 trait LockAble{
    public function getLockScreenImage():String
    {
        return config('nova-lockscreen.background_image');
    }

    public function lockScreenEnabled():bool
    {
        return true;
    }
 }
