<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\SniccoBetterCliCommands;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'snicco_better_cli_commands' => [
                'commands' => [],
                'namespace' => 'kaiseki',
            ],
            'hook' => [
                'provider' => [
                    CommandRegistry::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    CommandRegistry::class => CommandRegistryFactory::class,
                ],
            ],
        ];
    }
}
