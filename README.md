# Laravel schedule calling multiple commands
```bash
composer require biohazard/laravel-schedule
```


App\Console\Kernel.php
```php
<?php

...
use Biohazard\Kernel as ConsoleKernel;
...

class Kernel extends ConsoleKernel
{
	...

    protected function schedule(Schedule $schedule): void
    {
        $schedule->commands(
            'command1',
            'command2',
            'command3',
        )->name('Name')
            ->storeOutput()
            ->onSuccess(function (Stringable $output) {
                echo 'Schedule task output success '. $output;
            })->onFailure(function (Stringable $output) {
                echo 'Schedule task output failured '. $output;
            })
            ->dailyAt('20:00')
            ->run();

        $schedule->jobs(
            new Job1,
            new Job2,
            new Job3,
        )->name('Name')
            ->dailyAt('21:00')
            ->run();
    }

 	...
}

```