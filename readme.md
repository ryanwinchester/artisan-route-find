# artisan route:find

```
composer require sevenshores/artisan-route-find
```

Register the command by adding it to `app/Console/Kernel`:

```php
protected $commands = [

    \SevenShores\RouteFinder\RouteFindCommand::class,

];
```

and now you can do:

```
php artisan route:find some-route
```

and to trim extra whitespace from the results:

```
php artisan route:find api/posts --trim
```
