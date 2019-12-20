<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            
            $api=new ApiController();
            $api->getInplay();
            DB::table('test')->insert(['index'=>'2']);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
    protected function load($paths)
    {
        $paths = array_unique(is_array($paths) ? $paths : (array) $paths);
        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });
        if (empty($paths)) {
            return;
        }
        $namespace = $this->app->getNamespace();
        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );
            if (is_subclass_of($command, Command::class) &&
                ! (new ReflectionClass($command))->isAbstract()) {
                Artisan::starting(function ($artisan) use ($command) {
                    $artisan->resolve($command);
                });
            }
        }
    }
}
