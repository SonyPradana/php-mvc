<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Style\Alert;
use System\Console\Traits\PrintHelpTrait;

use function System\Console\style;

class ServeCommand extends Command
{
    use PrintHelpTrait;

    /** @var array */
    public static $command = [
     [
       'cmd'       => 'serve',
       'mode'      => 'full',
       'class'     => ServeCommand::class,
       'fn'        => 'main',
     ],
  ];

    public function printHelp()
    {
        return [
            'commands'  => [
                'serve' => 'serve server with port number (default 8080)',
            ],
            'options'   => [],
            'relation'  => [],
        ];
    }

    public function main(): void
    {
        $port    = $this->OPTION[0] ?? '8080';
        $port    = $port == '' ? '8080' : $port;
        $localIP = gethostbyname(gethostname());

        style('Server runing add:')
            ->new_lines()
            ->push('Local')->tabs()->push("http://localhost:$port")->textBlue()
            ->new_lines()
            ->push('Network')->tabs()->push("http://$localIP:$port")->textBlue()
            ->new_lines(2)
            ->push('ctrl+c to stop server')
            ->new_lines()
            ->tap(Alert::render()->info('server runing...'))
            ->out(false);

        shell_exec("php -S 127.0.0.1:$port -t public/");
    }
}
