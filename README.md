# Lock Screen for Laravel Nova

<p align="center">

<img src="https://github.com/lahirulhr/nova-lockscreen/blob/29d54861af1a3dabde1d59bab75a7562615f38a8/cover.png" />

</p>


### How to use

1. Run composer ``` composer require lahirulhr/nova-lock-screen ``` to install the package

2. Publish config & views `` php artisan vendor:publish --tag="nova-lock-screen" ``

3. Use ``LockScreen`` trait in User model

```php

use Lahirulhr\NovaLockScreen;


class User extends Model {

  use LockScreen;
  
  // ... 

}


```

4. Register Tool in Nova service provider


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

    // these urls does not locked by lock screen
    'excluded_urls' => [
        //
    ]

];

```


### Set custom background image per user

you can overide default background image by overiding `` getLockScreenImage()`` method in User model

``` php
public function getLockScreenImage():String
{
    return 'url\to\image.jpg';
}
```

### Enable/Disable lock screen per user

use ``` lockScreenEnabled() ``` method to overide default lock status settings

```php
public function lockScreenEnabled():bool
{
    return false;
}

```

### Customizing the lock screen

lock screen page is built with blade views. you can copy them into your resource directory by run `` php artisan vendor:publish --tag="nova-lock-screen" `` command
then customize them as your needs.


## Credits

- [Lahiru Tharaka](https://github.com/lahirulhr)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
