<?php

namespace App\Commands;

use App\Karnels\ConsoleKernel;
use System\Console\Command;
use System\Console\Style\Style;
use System\Console\Traits\PrintHelpTrait;
use System\Text\Str;

use function System\Console\style;

class HelpCommand extends Command
{
    use PrintHelpTrait;

    public static array $command = [
      [
        'cmd'       => ['-h', '--help'],
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'main',
      ],
      [
        'cmd'       => ['-v', '--version'],
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'versionCek',
      ],
      [
        'cmd'       => '--list',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'commandList',
      ],
      [
        'cmd'       => 'help',
        'mode'      => 'full',
        'class'     => self::class,
        'fn'        => 'commandhelp',
      ],
    ];

    /**
     * Use for print --help.
     */
    public function main()
    {
        $has_visited      = [];
        $this->print_help = [
          'margin-left'         => 8,
          'column-1-min-lenght' => 24,
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

                    $res = call_user_func_array([$class, 'printHelp'], []);

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

        style('welcome to cli')->out();

        style("\n\nUsage:")

          ->push("\n\t")
          ->push('php')->textGreen()
          ->push(' cli [flag]')

          ->push("\n\t")
          ->push('php')->textGreen()
          ->push(' cli [command] ')
          ->push('[option]')->textDim()
          ->out()
        ;

        style("\nAvilable flag:")

          ->push("\n\n\t")
          ->push('--help')->textDim()
          ->push("\t\t\t")
          ->push('get all help commands')
          ->push("\n\t")

          ->push('--list')->textDim()
          ->push("\t\t\t")
          ->push('get list of commands registered (class & function)')
          ->push("\n\t")

          ->push('--version')->textDim()
          ->push("\t\t")
          ->push('get version cli')
          ->new_lines()
          ->out()
        ;

        style('Avilabe command:')->new_lines()->out();

        $this->printCommands(new Style())->out();

        style('Avilable options:')->new_lines()->out();

        $this->printOptions(new Style())->out();
    }

    public function versionCek()
    {
        $stringfromfile = file('.git/HEAD', FILE_USE_INCLUDE_PATH);

        $firstLine = $stringfromfile[0]; // get the string from the array

        $explodedstring = explode('/', $firstLine, 3); // seperate out by the "/" in the string

        $branchname = $explodedstring[2]; // get the one that is always the branch name

        style('apps')->textLightGreen()->push(' version ')->push($branchname)->out(false);
        style('cli')->textLightGreen()->push(' version ')->push($_ENV['APP_CLI_VERSION'])->out();
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

    /**
     * Show helper per command.
     * eg: php cli help cron.
     */
    public function commandHelp()
    {
        if (!isset($this->OPTION[0])) {
            style("\nTo see help command, place provide command_name\n\n\t")
                ->new_lines(2)
                ->tabs()
                ->textYellow()
                ->push('php cli help <comman_nama>')
                ->textDim()->new_lines()->tabs()
                ->push('             ^^^^^^^^^^^^^')
                ->textRed()
                ->new_lines()
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

            $res = call_user_func_array([$class, 'printHelp'], []) ?? '';

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

        style("\nHelp command not found\n")->out();
    }
}
