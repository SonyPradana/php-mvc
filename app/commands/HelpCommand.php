<?php

use System\Apps\Command;

class HelpCommand extends Command
{
  public function println()
  {
    $this->prints([
      "Welcome to php-mvc CLI",

      "\n\nUsage:",
      "\n\t" . $this->textGreen("php") . " CLI [flag]\n",
      "\t" . $this->textGreen("php") . " CLI [option] " . $this->textDim("[argument]") . "\n",

      "\nAvilable flag:",
      "\n\t" . $this->textDim("--help") . "\t\t\tget all help command",
      "\n\t" . $this->textDim("--list") . "\t\t\tget list of commands registered (class & function)",
      "\n\t" . $this->textDim("--version") . "\t\tget version php-mvc cli",

      "\n\nAvilabe option:",
      "\n\t" . $this->textGreen("make") . ":controller [controller_name]\t\tgenerate new controller and view",
      "\n\t" . $this->textGreen("make") . ":view [view_name]\t\t\t\tgenerate new view",
      "\n\t" . $this->textGreen("make") . ":service [services_name]\t\t\tgenerate new service",
      "\n\t" . $this->textGreen("make") . ":model [model_name] " . $this->textDim("[argument]") . "\t\tgenerate new model",
      "\n\t" . $this->textGreen("make") . ":models [models_name] " . $this->textDim("[argument]") . "\t\tgenerate new models",
      "\n\t" . $this->textGreen("serve") . " [port_number] " . "\t\t\t\tserve server with port number (default 8080)",

      "\n\nAvilable argument:",
      "\n\t" . $this->textDim("--table-name=[table_name]") . "\tget table column when creating model/models",

    ]);
  }

  public function versionCek()
  {
    $stringfromfile = file('.git/HEAD', FILE_USE_INCLUDE_PATH);

    $firstLine = $stringfromfile[0]; //get the string from the array

    $explodedstring = explode("/", $firstLine, 3); //seperate out by the "/" in the string

    $branchname = $explodedstring[2]; //get the one that is always the branch name

    echo $this->textGreen('apps ') . "version " . $branchname;
    echo $this->textGreen("cli ") . "version " . $_ENV['APP_CLI_VERSION'];
  }

  public function commandList()
  {
    echo "List of all command registered:";
    $this->print_n(2);

    foreach (COMMAND_CONFIG as $commands) {
      // get command
      if (is_array($commands['cmd'])) {
        echo $this->textBlue(implode(", ", $commands['cmd']));
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

}
