<?php

declare(strict_types=1);

use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant;

return [
    'tenant_model' => App\Models\Tenant::class,
    'id_generator' => Stancl\Tenancy\UUIDGenerator::class,

    'domain_model' => Domain::class,

    /**
     * The list of domains hosting your central app.
     */
    'central_domains' => [
        '127.0.0.1',
        'localhost',
        'cip-tools.de',
        'www.cip-tools.de',
    ],

    /**
     * Tenancy bootstrappers.
     */
    'bootstrappers' => [
        Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\QueueTenancyBootstrapper::class,
    ],

    /**
     * Database tenancy config.
     */
    'database' => [
        'central_connection' => env('DB_CONNECTION', 'central'),

        /**
         * UPDATED: Yahan humne 'tenant_sqlite' select kiya hai automation ke liye.
         */
        'template_tenant_connection' => 'tenant_sqlite',

        /**
         * Tenant database names prefix.
         * SQLite file names ke liye ye prefix use hoga (e.g., tenantfoo.sqlite).
         */
        'prefix' => 'tenant',
        'suffix' => '',

        /**
         * Managers config.
         */
        'managers' => [
            /**
             * UPDATED: SQLite Manager ko path bataya hai.
             * Ab ye 'database/tenants' folder me files banayega.
             */
            'sqlite' => [
                'driver' => Stancl\Tenancy\TenantDatabaseManagers\SQLiteDatabaseManager::class,
                'root' => database_path('tenants'), // Files yahan save hongi
            ],

            'mysql' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
            'pgsql' => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLDatabaseManager::class,
        ],
    ],

    /**
     * Cache tenancy config.
     */
    'cache' => [
        'tag_base' => 'tenant',
    ],

    /**
     * Filesystem tenancy config.
     */
    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
        ],
        'root_override' => [
            'local' => '%storage_path%/app/',
            'public' => '%storage_path%/app/public/',
        ],
        'suffix_storage_path' => true,
        'asset_helper_tenancy' => true,
    ],

    /**
     * Redis tenancy config.
     */
    'redis' => [
        'prefix_base' => 'tenant',
        'prefixed_connections' => [],
    ],

    /**
     * Features.
     */
    'features' => [
        // Stancl\Tenancy\Features\UserImpersonation::class,
        // Stancl\Tenancy\Features\TelescopeTags::class,
        // Stancl\Tenancy\Features\UniversalRoutes::class,
        // Stancl\Tenancy\Features\TenantConfig::class,
        // Stancl\Tenancy\Features\CrossDomainRedirect::class,
        // Stancl\Tenancy\Features\ViteBundler::class,
    ],

    'routes' => true,

    'migration_parameters' => [
        '--force' => true,
        '--path' => [database_path('migrations/tenant')],
        '--realpath' => true,
    ],

    'seeder_parameters' => [
        '--class' => 'DatabaseSeeder',
    ],
];
