<?php

namespace App\Commands;

use System\Console\Command;
use System\Console\Traits\CommandTrait;
use System\Router\Router;

class RouteCommand extends Command
{
    use CommandTrait;

    /** @var array */
    public static $command = [
      [
        'cmd'       => 'route:list',
        'mode'      => 'full',
        'class'     => RouteCommand::class,
        'fn'        => 'println',
      ],
    ];

    public function printHelp()
    {
        return [
          'commands'  => [
            'route:list'                  => 'Get route list information',
          ],
          'options'   => [],
          'relation'  => [],
        ];
    }

    public function println()
    {
        require_once base_path('/routes/web.php');
        require_once base_path('/routes/api.php');

        $line_max  = 0;
        $printable = [];
        $all       = ['get', 'head', 'post', 'put', 'patch', 'delete', 'options'];
        foreach (Router::getRoutes() as $key => $route) {
            $methods = [];
            foreach ($route['method'] as $method) {
                $methods[] = $this->coloringMethod($method);
            }
            $method = implode($this->textDim('|'), $methods);
            $method = $all == $route['method']
              ? $this->coloringMethod('ANY')
              : $method;
            $count  = 16 - strlen($method);
            $method = $count > 0
              ? $method . str_repeat(' ', $count)
              : $method;

            $name       = $route['name'];
            $expression = $route['expression'];

            $printable[$key]['method']     = $method;
            $printable[$key]['name']       = $name;
            $printable[$key]['expression'] = $expression;

            $count    = strlen($name);
            $line_max = $count > $line_max ? $count : $line_max;
        }

        $mask = '%-10.100s %.20s' . $this->textDim('%-30.60s %.70s') . $this->newLine();
        foreach ($printable as $line) {
            echo sprintf(
                $mask,
                $line['method'],
                $line['name'],
                str_repeat('.', 40 + ($line_max - strlen($line['name']))),
                $line['expression']
            );
        }
    }

    private function coloringMethod(string $method)
    {
        $method = strtoupper($method);

        if ($method === 'GET') {
            return $this->textBlue($method);
        }

        if ($method === 'POST' || $method === 'PUT') {
            return $this->textYellow($method);
        }

        if ($method === 'DELETE') {
            return $this->textRed($method);
        }

        return $this->textDim($method);
    }
}
