# Lock Screen for Laravel Nova

<p align="center">

<img src="https://github.com/lahirulhr/nova-lockscreen/blob/29d54861af1a3dabde1d59bab75a7562615f38a8/cover.png" />

</p>

The lock screen is a simple security feature that works as locking overlay over the NOVA dashboard. If the user is idle for given timeout, the lockscreen will be activated automatically. Then the user needs to enter login password again to continue their session.

### View

<p align="center">

<img src="https://github.com/lahirulhr/nova-lock-screen/blob/3c84ee30a83159fca5271fd93c20174ed7b7b072/sample.png" />

</p>




### How to use

1. Run composer ``` composer require lahirulhr/nova-lock-screen ``` to install the package

2. Publish config (Optional) `` php artisan vendor:publish --tag="nova-lock-screen.config" ``

3. Use ``LockScreen`` trait in User model

```php

use Lahirulhr\NovaLockScreen;


class User extends Model {

  use LockScreen;
  
  // ... 

}


```

4. Register the Tool in Nova service provider


``` php

use Lahirulhr\NovaLockScreen\NovaLockScreen;

public function tools()
    {
        return [
            // ... ,
            new NovaLockScreen,
        ];
    }

```

5. Register middleware in `` nova.php ``

``` php

'middleware' => [
      // ... ,
      \Lahirulhr\NovaLockScreen\Http\Middleware\LockScreen::class,
],

```

6. Done


### Config

``` php

<?php

// config for Nova Lock Screen

return [
    // master lock
    'enabled' => true,

    // auth guard for lock screen
    'guard' => 'web',

    // if user has been inactive for this long time,  the app will be locked 
    'lock_timeout' => 15, // second

    // default background image for lock screen
    'background_image' => 'https://magnificentsrilanka.com/wp-content/uploads/2022/01/sigiriya-from-pidurangala-1.jpg',

    // these urls are not locked by lock screen
    'excluded_urls' => [
        //
    ],

    // set custom url for lock screen
        'lock_url' => 'nova-lock-screen',
    
    ];

```


### Set custom background image per user

you can override default background image by overriding `` getLockScreenImage()`` method in User model

``` php
public function getLockScreenImage():String
{
    return 'url\to\image.jpg';
}
```

### Enable/Disable lock screen per user

use ``` lockScreenEnabled() ``` method to override default lock status settings

```php
public function lockScreenEnabled():bool
{
    return false;
}

```

### Set locking timeout per user

use ``` lockScreenTimeout() ``` method to override default lock status settings

```php
public function lockScreenTimeout():int
{
    return 60*10; // seconds
}

```


### Customizing the lock screen

The lock screen page is built with Blade views. You can copy them into your resource directory by running `` php artisan vendor:publish --tag="nova-lock-screen.views" `` command
then customize them as you want.


## Credits

- [Lahiru Tharaka](https://github.com/lahirulhr)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
