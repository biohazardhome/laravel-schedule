<?php

namespace Biohazard;

use Closure;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Console\Scheduling\Event;

class Events {

    use Macroable;

    public array $methods = [];

    public function __construct(public array $events) {

    }

    public function __call(string $method, array $arguments): static {
        $this->methods[$method] = $arguments;

        if (!static::hasMacro($method)) {
            static::macro($method, function($event, $method, ...$arguments) {
                if (method_exists($event, $method)) {
                    $event->{$method}(...$arguments);
                }

                return $this;
            });
        }

        return $this;
    }

    public function run(): void {
        foreach($this->events as $event) {
            foreach ($this->methods as $name => $arguments) {

                $macro = static::$macros[$name];

                if ($macro instanceof Closure) {
                    $macro = $macro->bindTo($this, static::class);
                }

                $macro($event, $name, ...$arguments);
            }
        }
    }
}