<?php

// config for Nova Lock Screen

return [
    // master lock
    'enabled' => true,

    // auth guard for lock screen
    'guard' => 'web',

    // if user has been inactive for this long time,  the app will be locked
    'lock_timeout' => 60 * 15, // second

    // default background image for lock screen
    'background_image' => 'https://magnificentsrilanka.com/wp-content/uploads/2022/01/sigiriya-from-pidurangala-1.jpg',

    // these urls does not locked by lock screen
    'excluded_urls' => [
        //
    ],

    // set custom url for lock screen
    'lock_url' => 'nova-lock-screen',

];
