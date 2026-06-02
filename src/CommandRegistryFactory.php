<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\SniccoBetterCliCommands;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Snicco\Component\BetterWPCLI\Command;
use Snicco\Component\BetterWPCLI\CommandLoader\ArrayCommandLoader;

use function array_filter;
use function array_values;
use function is_a;
use function is_string;
use function sprintf;

final class CommandRegistryFactory
{
    public function __invoke(ContainerInterface $container): CommandRegistry
    {
        $config = Config::fromContainer($container);
        $commands = array_values(array_filter(
            $config->array('snicco_better_cli_commands.commands'),
            static fn(mixed $command): bool => is_string($command) && is_a($command, Command::class, true),
        ));
        $instantiate = static function (string $commandClass) use ($container): Command {
            $command = $container->get($commandClass);
            if (!$command instanceof Command) {
                throw new RuntimeException(sprintf('Command "%s" must resolve to a %s.', $commandClass, Command::class));
            }

            return $command;
        };
        $commandLoader = new ArrayCommandLoader($commands, $instantiate);

        return new CommandRegistry(
            $commandLoader,
            $config->string('snicco_better_cli_commands.namespace')
        );
    }
}
