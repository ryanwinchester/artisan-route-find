# artisan route:find

I've come across working on some apps that have probably 100+ routes and it can become a pain finding things you are looking for.

`artisan route:list` + `grep` is fine, mostly, but I ended up making a bash function to do it, as well as trimming extra whitespace from the results. Then I thought *"Hey, it would be nice if there was something built in to the framework."* Something like `artisan route:find`

So, here it is, a proof-of-concept kind of thing.

## Install and Set-up

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
