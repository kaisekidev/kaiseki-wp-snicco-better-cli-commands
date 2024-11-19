<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\SniccoBetterCliCommands;

use Kaiseki\WordPress\Hook\HookProviderInterface;
use Snicco\Component\BetterWPCLI\Command;
use Snicco\Component\BetterWPCLI\CommandLoader\CommandLoader;
use Snicco\Component\BetterWPCLI\WPCLIApplication;

use function add_action;

final class CommandRegistry implements HookProviderInterface
{
    public function __construct(
        /** @var CommandLoader<Command> */
        private CommandLoader $commandLoader,
        private string $namespace,
    ) {
    }

    public function addHooks(): void
    {
        add_action('cli_init', [$this, 'registerCommands']);
    }

    public function registerCommands(): void
    {
        $application = new WPCLIApplication($this->namespace, $this->commandLoader);
        $application->registerCommands();
    }
}
