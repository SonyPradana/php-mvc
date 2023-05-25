<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Style\Style;
use System\Console\Traits\PrintHelpTrait;
use System\Support\Facades\PDO;
use System\Support\Facades\Schema;

use function System\Console\fail;
use function System\Console\info;
use function System\Console\ok;
use function System\Console\option;
use function System\Console\style;
use function System\Console\warn;

class MigrationCommand extends Command
{
    use PrintHelpTrait;

    public static array $command = [
      [
        'cmd'       => 'migrate',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'main',
      ], [
        'cmd'       => 'database:create',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'databaseCreate',
      ], [
        'cmd'       => 'database:drop',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'databaseDrop',
      ], [
        'cmd'       => 'database:show',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'databaseShow',
      ],
    ];

    public function printHelp()
    {
        return [
          'commands'  => [
            'migrate'         => 'Run migration',
            'database:create' => 'Create databese',
            'database:drop'   => 'Drop databese',
            'database:show'   => 'Show databese',
          ],
          'options'   => [
            '--dry-run' => 'Excute migration but olny get query  output.',
            '--force'   => 'Force runing migration/databe query in production',
          ],
          'relation'  => [
            'migrate'          => ['[migration_name]', '--dry-run', '--force'],
            'database:create'  => ['--force'],
            'database:drop'    => ['--force'],
          ],
        ];
    }

    private function DbName(): string
    {
        return app()->get('dsn.sql')['database_name'];
    }

    private function runInDev(): bool
    {
        if (app()->isDev() || $this->force) {
            return true;
        }

        return option(style('Runing migration/datbase in production?')->textRed(), [
            'yes' => fn () => true,
            'no'  => fn () => false,
        ]);
    }

    public function main()
    {
        if (false === $this->runInDev()) {
            return;
        }
        $print   = new Style("\n");
        $dir     = base_path('/database/migration/');
        $migrate = [];
        foreach (new \DirectoryIterator($dir) as $file) {
            if ($file->isDot() | $file->isDir()) {
                continue;
            }

            $vertion           = explode('_', $file->getBasename());
            $group             = end($vertion);
            $migrate[$group][] = $dir . $file->getFilename();
        }

        foreach ($migrate as $key => $val) {
            $schema = require_once end($val);

            if ($this->option('dry-run')) {
                $print->push($schema->__toString())->textDim()->new_lines(2);
                continue;
            }

            $print->push($key)->textDim()->tabs(2);

            try {
                $success = $schema->execute();
            } catch (\Throwable $th) {
                $success = false;
                fail($th->getMessage())->out(false);
            }

            $print->push('done')->textRed();
            if ($success) {
                $print->textGreen();
            }
            $print->new_lines();
        }

        $print->out(false);
    }

    public function databaseCreate(): int
    {
        $db_name = $this->DbName();

        if (!$this->runInDev()) {
            return 2;
        }

        /** @var bool */
        $continue = option(style("Do you want to create database `{$db_name}`?")->textBlue(), [
            'yes' => fn () => true,
            'no'  => fn () => false,
        ]);

        if (false === $continue) {
            return 2;
        }

        info("creating database `{$db_name}`")->out(false);

        $success = Schema::create()->database($db_name)->ifNotExists()->execute();

        if ($success) {
            ok("success create database `{$db_name}`")->out(false);

            return 0;
        }

        fail("cant created database `{$db_name}`")->out(false);

        return 1;
    }

    public function databaseDrop(): int
    {
        if (!$this->runInDev()) {
            return 2;
        }

        $db_name = $this->DbName();

        /** @var bool */
        $continue = option(style("Do you want to drop database `{$db_name}`")->textRed(), [
            'yes' => fn () => true,
            'no'  => fn () => false,
        ]);

        if (false === $continue) {
            return 2;
        }

        info("try to drop database `{$db_name}`")->out(false);

        $success = Schema::drop()->database($db_name)->ifExists(true)->execute();

        if ($success) {
            ok("success drop database `{$db_name}`")->out(false);

            return 0;
        }

        fail("cant drop database `{$db_name}`")->out(false);

        return 1;
    }

    public function databaseShow()
    {
        $db_name = $this->DbName();
        info('showing database')->out(false);

        $tables = PDO::instance()
        ->query('SHOW DATABASES')
            ->query('
                SELECT table_name, create_time
                FROM information_schema.tables
                WHERE table_schema = :db_name')
            ->bind(':db_name', $db_name)
            ->resultset();

        if (0 === count($tables)) {
            warn('table is empty try to run migration')->out();

            return 2;
        }

        foreach ($tables as $table) {
            $name   = $table['table_name'];
            $time   = $table['create_time'];
            $lenght = strlen($name) + strlen($time);

            style($name)->textDim()
                ->repeat('.', 60 - $lenght)->textDim()
                ->push($time)
                ->out();
        }
    }
}
