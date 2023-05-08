<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Style\Style;
use System\Console\Traits\PrintHelpTrait;
use System\Support\Facades\Schema;

use function System\Console\fail;
use function System\Console\info;
use function System\Console\ok;

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
        'cmd'       => 'database',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'database',
      ],
    ];

    public function printHelp()
    {
        return [
          'commands'  => [
            'migrate'      => 'Run migration',
            'database'     => 'Create databese',
          ],
          'options'   => [
            '--dry-run' => 'Excute migration but olny get query  output.',
            '--create'  => 'Create datase if not exist',
          ],
          'relation'  => [
            'migrate'  => ['[migration_name]', '--dry-run'],
            'database' => ['--create'],
          ],
        ];
    }

    public function main()
    {
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

    public function database(): void
    {
        if ($this->create) {
            info('creating database')->out(false);

            $success = Schema::create()->database('savanna')->ifNotExists()->execute();

            if ($success) {
                ok('success create database savanna')->out(false);

                return;
            }

            fail('cant create database savanna')->out(false);
        }
    }
}
