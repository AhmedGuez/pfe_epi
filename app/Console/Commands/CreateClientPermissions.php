<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateClientPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:create-client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create permissions for client users to view and print their own commandes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating client permissions...');

        // Create permissions
        $permissions = [
            'view commande',
            'view commande article',
            'view any commande',
            'view-own-commandes', // Keep existing for backward compatibility
            'print-own-commandes', // Keep existing for backward compatibility
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            $this->info("✅ Permission '{$permission}' created/verified");
        }

        // Get or create client role
        $clientRole = Role::where('name', 'client')->first();
        if (!$clientRole) {
            $clientRole = Role::create(['name' => 'client', 'guard_name' => 'web']);
            $this->info('✅ Client role created');
        } else {
            $this->info('✅ Client role already exists');
        }

        // Assign permissions to client role
        foreach ($permissions as $permission) {
            $permissionModel = Permission::where('name', $permission)->where('guard_name', 'web')->first();
            if ($permissionModel) {
                $clientRole->givePermissionTo($permissionModel);
            }
        }

        $this->info('✅ Client permissions assigned successfully!');
        $this->info('Client users can now:');
        $this->info('- View commande');
        $this->info('- View commande article');
        $this->info('- View any commande');
        $this->info('- View their own commandes (legacy)');
        $this->info('- Print their own commandes (legacy)');
        $this->info('- Cannot edit or delete commandes');
    }
} 