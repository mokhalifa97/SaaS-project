<?php
namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantDatabaseService
{
    public function createDatabase($tenant)
    {
        $database = str_replace(' ', '', $tenant->name);
        DB::statement('CREATE DATABASE ' . $database);
    }

    public function connectToDb($tenant){
        $database = str_replace(' ', '', $tenant->name);
        Config::set('database.connections.tenant.database', $database);
        DB::purge('tenant');
        DB::reconnect('tenant');
        Config::set('database.default', 'tenant');
    }

    public function migrateToDb($tenant){
        Artisan::call('migrate', ['--path' => 'database/migrations/tenant']);
    }
}