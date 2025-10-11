<?php

declare(strict_types=1);

namespace App\Providers;

use App\Commands\Cron\Log;
use System\Cron\Schedule;
use System\Integrate\ServiceProvider;
use System\Security\Hashing\Argon2IdHasher;
use System\Security\Hashing\ArgonHasher;
use System\Security\Hashing\BcryptHasher;
use System\Security\Hashing\DefaultHasher;
use System\Security\Hashing\HashManager;
use System\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // error handle
        $this->registerErrorHandle();

        // register schedule to containel
        $this->app->set('cron.log', fn (): Log => new Log());
        $this->app->set('schedule', fn (): Schedule => new Schedule(now()->timestamp, $this->app['cron.log']));

        // hash
        $this->registerHash();
    }

    private function registerErrorHandle(): void
    {
        if ($this->app->isDebugMode() && class_exists(\Whoops\Run::class)) {
            $this->app->set('error.handle', fn () => new \Whoops\Run());
            $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
            $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());
        }
    }

    private function registerHash(): void
    {
        $this->app->set('hash.bcrypt', function (): BcryptHasher {
            return (new BcryptHasher())
                ->setRounds(
                    Config::get('BCRYPT_ROUNDS', 12)
                );
        });
        $this->app->set('hash.argon', value: function (): ArgonHasher {
            return (new ArgonHasher())
                ->setMemory(1024)
                ->setTime(2)
                ->setThreads(2);
        });
        $this->app->set('hash.argon2id', fn (): Argon2IdHasher => new Argon2IdHasher());
        $this->app->set('hash.default', fn (): DefaultHasher => new DefaultHasher());

        $this->app->set('hash', function (): HashManager {
            $hash = new HashManager();
            $hash->setDefaultDriver($this->app['hash.bcrypt']);
            $hash->setDriver('bcrypt', $this->app['hash.bcrypt']);
            $hash->setDriver('argon', $this->app['hash.argon']);
            $hash->setDriver('argon2id', $this->app['hash.argon2id']);
            $hash->setDriver('default', $this->app['hash.default']);

            return $hash;
        });
    }
}
