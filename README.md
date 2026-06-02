# kaiseki/wp-snicco-better-cli-commands

Register `snicco/better-wp-cli` commands with WP-CLI from a `kaiseki/config` container.

A single `kaiseki/wp-hook` `HookProviderInterface` (`CommandRegistry`) that, on the `cli_init`
action, builds a `snicco/better-wp-cli` `WPCLIApplication` from a configured list of command classes
and registers them with WP-CLI. Command classes are resolved lazily from the PSR-11 container, so each
command's own dependencies are wired by the container.

## Installation

```bash
composer require kaiseki/wp-snicco-better-cli-commands
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator. It registers the
`CommandRegistry` hook provider and a `CommandRegistryFactory`, and seeds the
`snicco_better_cli_commands` config with an empty command list and the `kaiseki` namespace.

Configure your commands and (optionally) the WP-CLI namespace, then activate the provider via
`kaiseki/wp-hook`:

```php
use Kaiseki\WordPress\SniccoBetterCliCommands\CommandRegistry;
use My\App\Cli\GreetCommand;   // extends Snicco\Component\BetterWPCLI\Command

return [
    'snicco_better_cli_commands' => [
        'commands'  => [
            GreetCommand::class,   // list of Snicco BetterWPCLI Command class-strings
        ],
        'namespace' => 'my-app',   // WP-CLI namespace; defaults to 'kaiseki'
    ],
    'hook' => [
        'provider' => [
            CommandRegistry::class,
        ],
    ],
];
```

Each command class must extend `Snicco\Component\BetterWPCLI\Command` and be resolvable from the
container. Non-string entries, and strings that are not `Command` subclasses, are ignored.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE.md).
