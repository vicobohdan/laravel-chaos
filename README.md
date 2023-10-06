# Installing

You can install using the Composer package manager:

```sh
composer require chaos-ws/laravel-chaos-broadcaster
```

# Configuration

## Add Chaos redis database configuration

Add new `redis` database to `config/database.php`:

```php

	'redis' => [
		'chaos' => [
		    'host' => env('CHAOS_HOST', '127.0.0.1'),
		    'password' => null,
		    'port' => env('CHAOS_PORT', 6379),
		    'database' => 1,
		],

```

## Add Chaos broadcast configuration

You will need to add Chaos broadcast configuration to `config/broadcasting.php` file:

```php

	'chaos' => [
	    'driver' => 'chaos',
	    'connection' => 'chaos',

	    'key' => env('PUSHER_APP_KEY'),
	    'secret' => env('PUSHER_APP_SECRET'),
	    'app_id' => env('PUSHER_APP_ID'),
	    'options' => [
	        'cluster' => env('PUSHER_APP_CLUSTER'),
	        'encrypted' => true,
	        'host' => env('PUSHER_APP_HOST', '127.0.0.1'),
	        'port' => env('PUSHER_APP_PORT', '6001'),
	        'scheme' => 'http'
	    ],
	],

```

## Change broadcast driver

Next, you will need to add & configure Chaos connection `CHAOS_HOST` and `CHAOS_PORT`, then change your broadcast driver to `chaos` in your `.env` file:

```sh

BROADCAST_DRIVER=chaos

CHAOS_HOST=127.0.0.1
CHAOS_PORT=6379

```