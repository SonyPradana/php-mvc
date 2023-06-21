<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Traits\CommandTrait;
use System\Support\Facades\DB;

use function DI\env;
use function System\Console\fail;
use function System\Console\info;
use function System\Console\ok;
use function System\Console\warn;

class MakeCommand extends Command
{
    use CommandTrait;
    public static array $command = [
        [
            'cmd'       => 'make:controller',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_controller',
        ], [
            'cmd'       => 'make:view',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_view',
        ], [
            'cmd'       => 'make:services',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_services',
        ], [
            'cmd'       => 'make:model',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_model',
        ], [
            'cmd'       => 'make:models',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_models',
        ], [
            'cmd'       => 'make:command',
            'mode'      => 'full',
            'class'     => MakeCommand::class,
            'fn'        => 'make_command',
        ],
    ];

    public function printHelp()
    {
        return [
            'commands'  => [
                'make:controller' => 'Generate new controller',
                'make:view'       => 'Generate new view',
                'make:service'    => 'Generate new service',
                'make:model'      => 'Generate new model',
                'make:command'    => 'Generate new command',
            ],
            'options'   => [
                '--table-name' => 'Set table column when creating model/models.',
            ],
            'relation'  => [
                'make:controller' => ['[controller_name]'],
                'make:view'       => ['[view_name]'],
                'make:service'    => ['[service_name]'],
                'make:model'      => ['[model_name]', '--table-name'],
                'make:command'    => ['[command_name]'],
            ],
        ];
    }

    public function make_controller(): int
    {
        info('Making controller file...')->out(false);

        $success = $this->makeTemplate($this->OPTION[0], [
            'template_location' => commands_path() . 'stubs/controller',
            'save_location'     => controllers_path(),
            'pattern'           => '__controller__',
            'surfix'            => 'Controller.php',
        ]);

        if ($success) {
            ok('Finish created controller')->out();

            return 0;
        }

        fail('Failed Create controller')->out();

        return 1;
    }

    public function make_view(): int
    {
        info('Making view file...')->out(false);

        $success = $this->makeTemplate($this->OPTION[0], [
            'template_location' => commands_path() . 'stubs/view',
            'save_location'     => view_path(),
            'pattern'           => '__view__',
            'surfix'            => '.template.php',
        ]);

        if ($success) {
            ok('Finish created view file')->out();

            return 0;
        }

        fail('Failed Create view file')->out();

        return 1;
    }

    public function make_services(): int
    {
        info('Making service file...')->out(false);

        $success = $this->makeTemplate($this->OPTION[0], [
            'template_location' => commands_path() . 'stubs/service',
            'save_location'     => services_path(),
            'pattern'           => '__service__',
            'surfix'            => 'Service.php',
        ]);

        if ($success) {
            ok('Finish created services file')->out();

            return 0;
        }

        fail('Failed Create services file')->out();

        return 1;
    }

    public function make_model(): int
    {
        info('Making model file...')->out(false);

        $success = $this->makeTemplate($this->OPTION[0], [
            'template_location' => commands_path() . 'stubs/model',
            'save_location'     => model_path(),
            'pattern'           => '__model__',
            'surfix'            => '.php',
        ], $this->OPTION[0] . '/');

        if ($this->option('table-name', false)) {
            $table_name = $this->option('table-name');
            // $this->FillModelDatabase(
            //     model_path() . $this->OPTION[0] . '/' . $this->OPTION[0] . '.php',
            //     $table_name
            // );
        }

        if ($success) {
            ok('Finish created model file')->out();

            return 0;
        }

        fail('Failed Create model file')->out();

        return 1;
    }

    public function make_models(): int
    {
        info('Making models file...')->out(false);

        $name = $this->OPTION[0];

        $success = $this->makeTemplate($name, [
            'template_location' => commands_path() . 'stubs/models',
            'save_location'     => model_path(),
            'pattern'           => '__models__',
            'surfix'            => 's.php',
        ], $name . '/');

        if ($this->option('table-name', false)) {
            $table_name = $this->option('table-name');
            $this->FillModelsDatabase(
                model_path() . ucfirst($name) . '/' . $name . 's.php',
                $table_name
            );
        }

        if ($success) {
            ok('Finish created models file')->out();

            return 0;
        }

        fail('Failed Create model file')->out();

        return 1;
    }

    /**
     * Replece template to new class/resoure.
     *
     * @param string $argument    Name of Class/file
     * @param array  $make_option Configuration to replace template
     * @param string $folder      Create folder for save location
     *
     * @return bool True if templete success copie
     */
    private function makeTemplate(string $argument, array $make_option, string $folder = ''): bool
    {
        $folder = ucfirst($folder);
        if (file_exists($file_name = $make_option['save_location'] . $folder . $argument . $make_option['surfix'])) {
            warn('File already exist')->out(false);

            return false;
        }

        if ('' !== $folder && !is_dir($make_option['save_location'] . $folder)) {
            mkdir($make_option['save_location'] . $folder);
        }

        $get_template = file_get_contents($make_option['template_location']);
        $get_template = str_replace('@' . $make_option['pattern'], ucfirst($argument), $get_template);
        $get_template = str_replace($make_option['pattern'], $argument, $get_template);
        $get_template = preg_replace('/^.+\n/', '', $get_template);
        $isCopied     = file_put_contents($file_name, $get_template);

        return $isCopied === false ? false : true;
    }

    public function make_command()
    {
        info('Making command file...')->out(false);
        $name    = $this->OPTION[0];
        $success = $this->makeTemplate($name, [
            'template_location' => commands_path() . 'stubs/command',
            'save_location'     => commands_path(),
            'pattern'           => '__command__',
            'surfix'            => 'Command.php',
        ]);

        if ($success) {
            $geContent = file_get_contents(config_path() . 'command.config.php');
            $geContent = str_replace(
                '// more command here',
                "// {$name} \n\t" . 'App\\Commands\\' . $name . 'Command::$' . "command\n\t// more command here",
                $geContent
            );

            file_put_contents(config_path() . 'command.config.php', $geContent);

            ok('Finish created command file')->out();

            return 0;
        }

        fail("\nFailed Create command file")->out();

        return 1;
    }

    /**
     * Fill template with property
     * base on databe table.
     *
     * @param string $model_location File location (model)
     * @param string $table_name     Tabel name to sync with model
     *
     * @return bool True if templete success copie
     */
    private function FillModelDatabase(string $model_location, string $table_name): bool
    {
        $table_column = DB::table('INFORMATION_SCHEMA')
            ->select()
            ->equal('TABLE_SCHEMA', env('DB_NAME'))
            ->equal('TABLE_NAME', $table_name)
            ->all() ?? [];

        $column_template = '';
        $getter_template = '';
        $setter_template = '';

        foreach ($table_column as $column) {
            if ($column['COLUMN_NAME'] != 'id') {
                $column_template .= "'" . $column['COLUMN_NAME'] . "' => null,\n\t\t\t";
                $getter_template .= $this->TemplateGetterModel($column['COLUMN_NAME']);
                $setter_template .= $this->TemplateSetterModel($column['COLUMN_NAME']);
            }
        }

        $getContent = file_get_contents($model_location);
        // replece table name
        $getContent = str_replace('__table__', $table_name, $getContent);
        // replace teble column
        $getContent = str_replace('__column__', $column_template, $getContent);
        // replece getter and setter
        $getContent = str_replace('__getter__', $getter_template, $getContent);
        $getContent = str_replace('__setter__', $setter_template, $getContent);

        $isCopied   = file_put_contents($model_location, $getContent);

        return $isCopied === false ? false : true;
    }

    /**
     * Fill template with property
     * base on databe table.
     *
     * @param string $model_location File location (models)
     * @param string $table_name     Tabel name to sync with models
     *
     * @return bool True if templete success copie
     */
    private function FillModelsDatabase(string $model_location, string $table_name)
    {
        info($model_location)->out();
        info($table_name)->out();
        $getContent = file_get_contents($model_location);
        $getContent = str_replace('__table__', $table_name, $getContent);
        $isCopied   = file_put_contents($model_location, $getContent);

        return $isCopied === false ? false : true;
    }

    // helper

    /**
     * Helper for make model.
     */
    private function TemplateGetterModel(string $column_name): string
    {
        return
      "\n\tpublic function $column_name()" .
      "\n\t" . '{' .
      "\n\t\t" . 'return $' . "this->COLUMNS['$column_name'];" .
      "\n\t" . '}' .
      "\n";
    }

    /**
     * Helper for make model.
     */
    private function TemplateSetterModel(string $column_name): string
    {
        $functionName = ucfirst($column_name);

        return
      "\n\tpublic function set$functionName(int " . '$val)' .
      "\n\t" . '{' .
      "\n\t\t" . '$' . "this->COLUMNS['$column_name'] = " . '$val;' .
      "\n\t\t" . 'return $this;' .
      "\n\t" . '}' .
      "\n";
    }
}
