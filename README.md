# Laravel prometheus metrics

## Installation

Require this package with composer using the following command:

```bash
composer require shureban/laravel-prometheus
```

Add the following class to the `providers` array in `config/app.php`:
```php
Shureban\LaravelPrometheus\PrometheusServiceProvider::class,
```

You can also publish the config file to change implementations (ie. interface to specific class).
```shell
php artisan vendor:publish --provider="Shureban\LaravelPrometheus\PrometheusServiceProvider"
```

Update `.env` config, change REDIS_CLIENT from redis to predis:
```text
REDIS_CLIENT=predis
```

## Usages

Create folder, where you will contain your custom metrics classes (for example `app/Components/Prometheus`). Realise constructor with metric static params.

```php
namespace App\Components\Prometheus;

use Shureban\LaravelPrometheus\Counter;
use Shureban\LaravelPrometheus\Attributes\Name;
use Shureban\LaravelPrometheus\Attributes\Labels;

class AuthCounter extends Counter
{
    public function __construct()
    {
        $name   = new Name('auth');
        $labels = new Labels(['event']);
        $help   = 'Counter of auth events';

        parent::__construct($name, $labels, $help);
    }
}
```

Using DI (or not), increase the metric value.

```php
use App\Components\Prometheus\AuthCounter;

class RegisterController extends Controller
{
    public function __invoke(..., AuthCounter $counter): Response
    {
        // Registration new user logic
    
        $counter->withLabelsValues(['registration'])->inc();
    }
}
```

Or, if you have static list of events, you may realize following flow:

```php
namespace App\Components\Prometheus\Counters;

use Shureban\LaravelPrometheus\Counter;
use Shureban\LaravelPrometheus\Attributes\Name;
use Shureban\LaravelPrometheus\Attributes\Labels;

class AuthCounter extends Counter
{
    public function __construct()
    {
        $name   = new Name('auth');
        $labels = new Labels(['event']);
        $help   = 'Counter of auth events';

        parent::__construct($name, $labels, $help);
    }
    
    public function registration(): void 
    {
        $this->withLabelsValues(['registration'])->inc();
    }
}
```

This way helps you encapsulate logic with labels, and the code seems pretty

```php
use App\Components\Prometheus\AuthCounter;

class RegisterController extends Controller
{
    public function __invoke(..., AuthCounter $counter): Response
    {
        // Registration new user logic
    
        $counter->registration();
    }
}
```
