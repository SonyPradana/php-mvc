<?php

use System\Apps\Command;

class HelpCommand extends Command
{
  public function println()
  {
    echo "Welcome to php-mvc CLI";

    echo "\n\nUsage:";
    echo "\n\t" . $this->textGreen("php") . " CLI [flag]\n";
    echo "\t" . $this->textGreen("php") . " CLI [option] " . $this->textDim("[argument]") . "\n";

    echo "\nAvilable flag:";
    echo "\n\t" . $this->textDim("--help") . "\t\t\tget all help command";
    echo "\n\t" . $this->textDim("--version") . "\t\tget version php-mvc CLI";

    echo "\n\nAvilabe option:";
    echo "\n\t" . $this->textGreen("make") . ":controller [controller_name]\t\tgenerate new controller and view";
    echo "\n\t" . $this->textGreen("make") . ":view [view_name]\t\t\t\tgenerate new view";
    echo "\n\t" . $this->textGreen("make") . ":service [services_name]\t\t\tgenerate new service";
    echo "\n\t" . $this->textGreen("make") . ":model [model_name] " . $this->textDim("[argument]") . "\t\tgenerate new model";
    echo "\n\t" . $this->textGreen("make") . ":models [models_name] " . $this->textDim("[argument]") . "\t\tgenerate new models";
    echo "\n\t" . $this->textGreen("serve ") . "[port_number] " . "\t\t\t\tserve server with port number (default 8080)";

    echo "\n\nAvilable argument:";
    echo "\n\t" . $this->textDim("--table-name=[table_name]") . "\tget table column when creating model/models";

  }

  public function versionCek()
  {
    echo 'cli vervion ' . $_ENV['APP_CLI_VERSION'];
  }


}
