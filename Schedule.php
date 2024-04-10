<?php

namespace Biohazard;

use Illuminate\Console\Scheduling\Schedule as ScheduleBase;

class Schedule extends ScheduleBase {

    public function commandsCallback(array $commands, callable $callback) {
        foreach ($commands as $command) {
            $event = $this->command($command);
            
            $callback($event);
        }

        return $this;
    }

    public function commands(...$commands) {
        return groupChains(...$commands)
            ->wrap(fn ($command) => $this->command($command));
    }

    public function jobs(...$jobs) {
        return groupChains(...$jobs)
            ->wrap(fn ($job) => $this->job($job));
    }
}
