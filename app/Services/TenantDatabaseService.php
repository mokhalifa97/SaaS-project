<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class TenantDatabaseService
{
    public function createDatabase($tenant)
    {
        $dbName = str_replace(' ', '', $tenant->name) . '_' . 'DB';
        DB::statement('CREATE DATABASE ' . $dbName);
    }
}