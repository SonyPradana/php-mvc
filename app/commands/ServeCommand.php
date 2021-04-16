<?php

use System\Apps\Command;

class ServeCommand extends Command
{
  public function Serve()
  {
    $port = $this->OPTION[0] ?? '8080';
    $port = $port == '' ? '8080' :$port;
    $localIP = getHostByName(getHostName());

    $this->prints([
      "Server runing add:",
      "\n- Local:\t" .   $this->textBlue("http://localhost:$port"),
      "\n- Network:\t" . $this->textBlue("http://$localIP:$port"),

      $this->textYellow("\n\nctrl+c to stop server"),
      $this->textBlue("\n\nINFO"),
      " server runing...\n",
    ]);

    shell_exec("php -S 127.0.0.1:$port -t public/");
  }
}