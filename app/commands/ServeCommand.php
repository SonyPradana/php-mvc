<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Traits\CommandTrait;

use function System\Console\style;

class ServeCommand extends Command
{
    use CommandTrait;

    public static array $command = [
    [
      'cmd'       => 'serve',
      'mode'      => 'full',
      'class'     => ServeCommand::class,
      'fn'        => 'serve',
    ],
  ];

    public function printHelp()
    {
        return [
      'option' => [
        "\n\t" . $this->textGreen('serve') . ' [port_number] ' . "\t\t\t\tserve server with port number (default 8080)",
      ],
      'argument' => [],
    ];
    }

    public function Serve()
    {
        $port    = $this->OPTION[0] ?? '8080';
        $port    = $port == '' ? '8080' : $port;
        $localIP = gethostbyname(gethostname());

        style('')
            ->push('Server runing add:')
            ->new_lines()
            ->push('- Local:')
            ->tabs()
            ->push("http://localhost:$port")->textBlue()
            ->new_lines()
            ->push('- Local:')
            ->tabs()
            ->push("http://$localIP:$port")->textBlue()
            ->new_lines(2)
            ->push('ctrl+c to stop server')->textYellow()
            ->new_lines(2)
            ->push('INFO')
            ->new_lines()
            ->push(' server runing...')
            ->out()
        ;

        shell_exec("php -S 127.0.0.1:$port -t public/");
    }
}
