<?php

use System\Apps\Command;

class ServeCommand extends Command
{
  public function Serve()
  {
    $port = $this->OPTION[0] ?? '8080';
    $port = $port == '' ? '8080' :$port;
    $localIP = getHostByName(getHostName());

    echo "Server runing add:";
    echo "\n- Local:\t" .   $this->textBlue("http://localhost:$port");
    echo "\n- Network:\t" . $this->textBlue("http://$localIP:$port");

    echo $this->textBlue("\n\nINFO");
    echo " server runing...\n";

    shell_exec("php -S 127.0.0.1:$port -t public/");
  }
}
