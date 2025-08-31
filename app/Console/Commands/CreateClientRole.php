<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateClientRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:create-client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the client role if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for client role...');

        $clientRole = Role::where('name', 'client')->first();

        if (!$clientRole) {
            $this->info('Creating client role...');
            Role::create(['name' => 'client', 'guard_name' => 'web']);
            $this->info('✅ Client role created successfully!');
        } else {
            $this->info('✅ Client role already exists!');
        }

        $this->info('Client role is ready for use.');
    }
} 