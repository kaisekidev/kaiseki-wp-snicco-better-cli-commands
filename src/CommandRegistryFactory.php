<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\SniccoBetterCliCommands;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;
use Snicco\Component\BetterWPCLI\CommandLoader\ArrayCommandLoader;

final class CommandRegistryFactory
{
    public function __invoke(ContainerInterface $container): CommandRegistry
    {
        $config = Config::fromContainer($container);
        $commands = $config->array('snicco_better_cli_commands.commands');
        // @phpstan-ignore-next-line
        $commandLoader = new ArrayCommandLoader($commands, function (string $commandClass) use ($container) {
            return $container->get($commandClass);
        });

        return new CommandRegistry(
            $commandLoader,
            $config->string('snicco_better_cli_commands.namespace')
        );
    }
}
