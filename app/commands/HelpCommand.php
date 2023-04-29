<?php

use System\Apps\CLI;
use System\Console\Command;

class HelpCommand extends Command
{
    public static array $command = [
    [
      'cmd'       => ['-h', '--help'],
      'mode'      => 'full',
      'class'     => self::class,
      'fn'        => 'println',
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

    public function println()
    {
        $has_visited      = [];
        $help_command     = [];
        $argument_command = [];
        foreach (ConsoleKernel::$command as $commands) {
            if (!in_array($commands['class'], $has_visited)) {
                $class_name    = $commands['class'];
                $has_visited[] = $class_name;

                $class_path = commands_path() . $class_name . '.php';
                if (file_exists($class_path)) {
                    $class = new $class_name([]);
                    $res   = call_user_func_array([$class, 'printHelp'], []) ?? [];
                    if ($res['option'] != null) {
                        $help_command[] = $res['option'];
                    }
                    if ($res['argument'] != null) {
                        $argument_command[] = $res['argument'];
                    }
                }
            }
        }

        $this->prints([
      'Welcome to php-mvc cli',

      "\n\nUsage:",
      "\n\t" . $this->textGreen('php') . " cli [flag]\n",
      "\t" . $this->textGreen('php') . ' cli [option] ' . $this->textDim('[argument]') . "\n",

      "\nAvilable flag:",
      "\n\t" . $this->textDim('--help') . "\t\t\tget all help command",
      "\n\t" . $this->textDim('--list') . "\t\t\tget list of commands registered (class & function)",
      "\n\t" . $this->textDim('--version') . "\t\tget version php-mvc cli",
      "\n",
    ]);

        echo "\nAvilabe option:";

        foreach ($help_command as $help) {
            $this->prints($help);
            echo "\n";
        }

        echo "\nAvilable argument:";

        foreach ($argument_command as $help) {
            $this->prints($help);
            echo "\n";
        }
        echo "\n";
    }

    public function versionCek()
    {
        $stringfromfile = file('.git/HEAD', FILE_USE_INCLUDE_PATH);

        $firstLine = $stringfromfile[0]; // get the string from the array

        $explodedstring = explode('/', $firstLine, 3); // seperate out by the "/" in the string

        $branchname = $explodedstring[2]; // get the one that is always the branch name

        echo $this->textGreen('apps ') . 'version ' . $branchname;
        echo $this->textGreen('cli ') . 'version ' . $_ENV['APP_CLI_VERSION'];
    }

    public function commandList()
    {
        echo 'List of all command registered:';
        $this->print_n(2);

        foreach (CLI::$command as $commands) {
            // get command
            if (is_array($commands['cmd'])) {
                echo $this->textBlue(implode(', ', $commands['cmd']));
            } else {
                echo $this->textBlue($commands['cmd']);
            }

            $this->prints([
        "\t" . $this->textGreen($commands['class']),
        "\t" . $this->textDim($commands['fn']),
        "\n",
      ]);
        }
    }

    public function commandHelp()
    {
        if ($this->OPTION[0] === null) {
            echo $this->textYellow("\nTo see help command, place provide command_name\n\n\t"),
            $this->textDim("php cli help <comman_nama>\n"),
            $this->textRed("\t\t\t^^^^^^^^^^^^^\n\n");

            return;
        }

        $className = $this->OPTION[0];
        if (\System\Text\Str::contains(':', $className)) {
            $className = explode(':', $className);
            $className = $className[0];
        }

        $className .= 'Command';
        $className = ucfirst($className);
        $classPath = commands_path() . $className . '.php';

        if (file_exists($classPath)) {
            require_once $classPath;
            $class = new $className([]);

            $result = call_user_func_array([$class, 'printHelp'], []) ?? '';

            if (is_array($result)) {
                $this->prints(array_merge(
          ['Avilable Option:'],
          $result['option'] ?? $result,
          ["\n\nAvilable Argument:"],
          $result['argument'] ?? [],
          ["\n\n"]
        ));

                return;
            }

            echo $result;

            return;
        }

        echo $this->textRed("\nHelp command not found\n\n");
    }
}
