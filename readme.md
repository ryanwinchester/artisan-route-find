# artisan route:find

I've come across working on some Laravel-based apps that have probably 100+ routes and it can become a bit annoying to quickly find things you are looking for.

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

## Usage

and now you can do something like:

```
php artisan route:find api/files
```

![](http://s.ryanwinchester.ca/0t0V213Y0B2W/Screen%20Shot%202016-10-07%20at%209.03.55%20PM.png)

and to trim extra whitespace from the results:

```
php artisan route:find api/files --trim
```

![](http://s.ryanwinchester.ca/1B0R2k0r0641/Screen%20Shot%202016-10-08%20at%209.38.50%20AM.png)
