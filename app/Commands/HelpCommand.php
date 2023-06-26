<?php

namespace App\Commands;

use App\Karnels\ConsoleKernel;
use System\Console\Command;
use System\Console\Style\Style;
use System\Console\Traits\PrintHelpTrait;
use System\Text\Str;

use function System\Console\info;
use function System\Console\style;
use function System\Console\warn;

class HelpCommand extends Command
{
    use PrintHelpTrait;

    public static array $command = [
      [
        'cmd'       => ['-h', '--help'],
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'main',
      ], [
        'cmd'       => '--list',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'commandList',
      ], [
        'cmd'       => 'help',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'commandhelp',
      ],
    ];

    public function printHelp()
    {
        return [
            'commands'  => [
                'help' => 'Get help for avilable command',
            ],
            'options'   => [],
            'relation'  => [
                'help' => ['[command_name]'],
            ],
        ];
    }

    private $banner =
'   _____ ____ _ _   __ ____ _ ____   ____   ____ _
  / ___// __ `/| | / // __ `// __ \ / __ \ / __ `/
 (__  )/ /_/ / | |/ // /_/ // / / // / / // /_/ /
/____/ \__,_/  |___/ \__,_//_/ /_//_/ /_/ \__,_/  ';

    /**
     * Use for print --help.
     */
    public function main()
    {
        $has_visited      = [];
        $this->print_help = [
          'margin-left'         => 8,
          'column-1-min-lenght' => 16,
        ];

        foreach (ConsoleKernel::$command as $commands) {
            if (!in_array($commands['class'], $has_visited)) {
                $class_name    = $commands['class'];
                $has_visited[] = $class_name;

                if (class_exists($class_name)) {
                    $class = new $class_name([]);

                    if (!method_exists($class, 'printHelp')) {
                        continue;
                    }

                    $res = app()->call([$class, 'printHelp']) ?? [];

                    if (isset($res['commands']) && $res['commands'] != null) {
                        foreach ($res['commands'] as $command => $desc) {
                            $this->command_describes[$command] = $desc;
                        }
                    }

                    if (isset($res['options']) && $res['options'] != null) {
                        foreach ($res['options'] as $option => $desc) {
                            $this->option_describes[$option] = $desc;
                        }
                    }

                    if (isset($res['relation']) && $res['relation'] != null) {
                        foreach ($res['relation'] as $option => $desc) {
                            $this->command_relation[$option] = $desc;
                        }
                    }
                }
            }
        }

        $printer = new Style();
        $printer->push($this->banner)->textGreen();
        $printer
            ->new_lines(2)
            ->push('Usage:')
            ->new_lines(2)->tabs()
            ->push('php')->textGreen()
            ->push(' cli [flag]')
            ->new_lines()->tabs()
            ->push('php')->textGreen()
            ->push(' cli [command] ')
            ->push('[option]')->textDim()
            ->new_lines(2)

            ->push('Avilable flag:')
            ->new_lines(2)->tabs()
            ->push('--help')->textDim()
            ->tabs(3)
            ->push('Get all help commands')
            ->new_lines()->tabs()
            ->push('--list')->textDim()
            ->tabs(3)
            ->push('Get list of commands registered (class & function)')
            ->new_lines(2)
        ;

        $printer->push('Avilabe command:')->new_lines(2);
        $printer = $this->printCommands($printer)->new_lines();

        $printer->push('Avilabe options:')->new_lines();
        $printer = $this->printOptions($printer);

        $printer->out();
    }

    public function commandList()
    {
        style('List of all command registered:')->out();

        foreach (ConsoleKernel::$command as $commands) {
            // get command
            if (is_array($commands['cmd'])) {
                style(implode(', ', $commands['cmd']))->textBlue()->out();
            } else {
                style($commands['cmd'])->textBlue()->out();
            }

            style("\t")
              ->push($commands['class'])->textGreen()
              ->push("\t")->push($commands['fn'])->textDim()
              ->out();
        }
    }

    public function commandHelp()
    {
        if (!isset($this->OPTION[0])) {
            style('')
                 ->tap(info('To see help command, place provide command_name'))
                ->textYellow()
                ->push('php cli help <command_nama>')->textDim()
                ->new_lines()
                ->push('              ^^^^^^^^^^^^')->textRed()
                ->out()
            ;

            return;
        }

        $className = $this->OPTION[0];
        if (Str::contains(':', $className)) {
            $className = explode(':', $className);
            $className = $className[0];
        }

        $className .= 'Command';
        $className = ucfirst($className);
        $className = 'App\\Commands\\' . $className;

        if (class_exists($className)) {
            $class = new $className([]);

            $res = app()->call([$class, 'printHelp']) ?? [];

            if (isset($res['commands']) && $res['commands'] != null) {
                $this->command_describes = $res['commands'];
            }

            if (isset($res['options']) && $res['options'] != null) {
                $this->option_describes = $res['options'];
            }

            if (isset($res['relation']) && $res['relation'] != null) {
                $this->command_relation = $res['relation'];
            }

            style('Avilabe command:')->new_lines()->out();
            $this->printCommands(new Style())->out();

            style('Avilable options:')->new_lines()->out();
            $this->printOptions(new Style())->out();

            return;
        }

        warn("Help for `{$this->OPTION[0]}` command not found")->out(false);
    }
}
