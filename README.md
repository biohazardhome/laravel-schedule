# Laravel schedule calling multiple commands

App\Console\Kernel.php
```
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
            ->dailyAt('21:09')
            ->run();
    }

 	...
}

```