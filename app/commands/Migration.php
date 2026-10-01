<?php
/**
 * Command: Migration
 *
 * Auto-discovered by the LavaLust CLI.
 * No registration needed — just drop this file in app/commands/.
 */
class Migration
{
    /**
     * The CLI command name.
     * Usage: php lava migration
     */
    public static $command = 'migration';

    /** Short description shown in php lava help */
    public static $description = 'Run database migrations';

    /**
     * Argument/flag descriptions shown in help.
     *
     * Example:
     *   public static $arguments = [
     *       'name'        => 'A positional argument',
     *       '[--flag=<v>]' => 'An optional flag',
     *   ];
     */
    public static $arguments = [
        '[action]' => 'Action: run, create-migration, rollback, rollback-all, refresh, status',
        '[name]'   => 'Migration class name for create-migration',
    ];

    /**
     * Command entry point.
     *
     * @param string|null $input   First positional argument (php lava migration <input>)
     * @param array       $flags   Associative array of --flag=value pairs
     */
    public function handle($input = null, array $flags = [])
    {
        $action = $input ?? 'run';
        $route_map = [
            'run'              => 'migrate',
            'create-migration' => 'create-migration',
            'rollback'         => 'rollback',
            'rollback-all'     => 'rollback-all',
            'refresh'          => 'refresh',
            'status'           => 'status',
        ];

        if (!isset($route_map[$action])) {
            echo danger("Unknown migration action: \"{$action}\"");
            echo "Available actions: " . implode(', ', array_keys($route_map)) . PHP_EOL;
            exit(1);
        }

        if ($action === 'create-migration') {
            global $argv;
            $name = $flags['name'] ?? ($argv[3] ?? null);

            if (!$name) {
                echo danger('Migration name is required.');
                echo "Example: php lava migration create-migration create_products_table" . PHP_EOL;
                exit(1);
            }

            $route = 'create-migration/' . $name;
        } else {
            $route = $route_map[$action];
        }

        $index = PUBLIC_DIR . 'index.php';
        if (!file_exists($index)) {
            echo danger("index.php not found at: {$index}");
            exit(1);
        }

        $command = sprintf(
            'php %s %s',
            escapeshellarg($index),
            escapeshellarg($route)
        );
        passthru($command);
    }
}