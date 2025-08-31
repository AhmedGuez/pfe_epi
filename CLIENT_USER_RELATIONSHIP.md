# Client-User Relationship System

This document explains the client-user relationship system that allows users to connect to the application and manage client data.

## Overview

The system creates a many-to-many relationship between clients and users, allowing:
- Multiple users to access a single client
- Multiple clients to be managed by a single user
- Role-based access control (owner, manager, viewer)
- Primary user designation for each client
- **Automatic user creation** when creating a client with "client" role assignment
- **Client-specific permissions** for viewing and printing their own commandes

## Key Features

### Automatic User Creation
When creating a new client:
1. A user account is automatically created using the client's email
2. The user is assigned the "client" role by default
3. The user is set as the primary user for the client
4. A password is required during client creation
5. **Client-specific permissions are automatically assigned**

### Role-Based Access Control
- **Client Role**: Default role for client users with restricted permissions
- **Owner**: Full access to client data
- **Manager**: Manage client operations  
- **Viewer**: Read-only access

### Client Permissions
Client users automatically receive these permissions:
- **view-own-commandes**: Can view only their own commandes
- **print-own-commandes**: Can print only their own commandes
- **Cannot create, edit, or delete commandes**
- **Cannot access other clients' data**

## Database Structure

### Tables Created

1. **client_user** (Pivot Table)
   - `id` - Primary key
   - `client_id` - Foreign key to clients table
   - `user_id` - Foreign key to users table
   - `role` - Enum: 'owner', 'manager', 'viewer'
   - `is_primary` - Boolean: indicates if this is the primary user
   - `created_at`, `updated_at` - Timestamps

2. **clients** table updated
   - `user_id` - Foreign key to users table (nullable) - for primary user relationship

## Filament Integration

### ClientResource Form
The client creation form now includes:
- **Password field**: Required for creating the associated user account
- **Automatic user creation**: Creates user with client's email and name
- **Role assignment**: Automatically assigns "client" role
- **Relationship setup**: Creates the client-user relationship

### Form Steps
1. **Step 1**: Basic client information (nom, prenom, nom_entreprise, matricule_fiscale)
2. **Step 2**: Contact information (email, telephone, adresse, commentaire)
3. **Step 3**: User password and settings (password, air, tva)

### Table Display
- Shows client information
- Displays associated user name
- Shows user role badges
- Filter to show clients with/without users

## Models

### User Model
```php
// Get all clients for a user
$user->clients;

// Get primary client for a user
$user->primaryClient;

// Check if user has access to a specific client
$user->hasClientAccess($clientId, $role);

// Get user's role for a specific client
$user->getClientRole($clientId);
```

### Client Model
```php
// Get all users for a client
$client->users;

// Get primary user for a client
$client->primaryUser;

// Get users with specific role
$client->usersWithRole('owner');

// Check if a user has access to this client
$client->hasUserAccess($userId, $role);
```

## Usage Examples

### Creating a Client (Automatic User Creation)
```php
// When creating a client through Filament, a user is automatically created:
// 1. User account created with client's email
// 2. Password hashed and stored
// 3. "client" role assigned
// 4. User set as primary for the client
// 5. Client-user relationship established
```

### Manual User Creation
```php
// Create user manually
$user = User::create([
    'name' => 'Client Name',
    'email' => 'client@example.com',
    'password' => Hash::make('password'),
]);

// Assign client role
$user->assignRole('client');

// Attach to client
$client->users()->attach($user->id, [
    'role' => 'owner',
    'is_primary' => true,
]);
```

### Checking Access
```php
// Check if user can access a client
if ($user->hasClientAccess($clientId)) {
    // User has access
}

// Check specific role
if ($user->hasClientAccess($clientId, 'owner')) {
    // User is owner
}
```

## API Endpoints

### Client-User Management Routes
```php
// Attach user to client
POST /client-users/{client}/attach

// Detach user from client
DELETE /client-users/{client}/detach

// Update user role
PUT /client-users/{client}/update-role

// Get all users for a client
GET /client-users/{client}/users

// Get all clients for current user
GET /client-users/my-clients

// Set primary user
PUT /client-users/{client}/set-primary
```

## Commands

### Create Client Role
```bash
php artisan role:create-client
```
Ensures the "client" role exists in the database.

## Testing

Run the seeder to test the functionality:
```bash
php artisan db:seed --class=ClientUserSeeder
```

This will create:
- A test client: client@example.com
- A test user with "client" role
- A relationship with 'owner' role and primary status
- Password: password123

## Security Features

1. **Role-based Access Control**: Users can have different roles (client, owner, manager, viewer)
2. **Primary User Designation**: Each client can have one primary user
3. **Admin Override**: Admin users bypass access restrictions
4. **Middleware Protection**: Routes can be protected with access middleware
5. **Password Security**: Passwords are properly hashed and stored

## Workflow

### Creating a New Client
1. Fill in client information in Filament form
2. Provide password for the associated user account
3. System automatically:
   - Creates user account with client's email
   - Assigns "client" role
   - Sets user as primary for the client
   - Establishes client-user relationship
4. Success notification shown

### Editing a Client
1. Update client information
2. Optionally update password (leave empty to keep current)
3. System updates user password if provided
4. Success notification shown

## Future Enhancements

1. **Email Notifications**: Send welcome email to new client users
2. **Password Reset**: Allow clients to reset their passwords
3. **Bulk Operations**: Create multiple clients with users at once
4. **Audit Trail**: Track all client-user relationship changes
5. **Advanced Permissions**: More granular permissions based on roles 

## CommandeResource Restrictions

### Client Access Control
The CommandeResource has been modified to restrict client access:

1. **Query Filtering**: Client users only see commandes related to their associated clients
2. **Action Restrictions**: 
   - ✅ Can view commandes (read-only)
   - ✅ Can print commandes (new print functionality)
   - ❌ Cannot create new commandes
   - ❌ Cannot edit existing commandes
   - ❌ Cannot delete commandes

### Print Functionality
- **Print Action**: Added to CommandeResource table with printer icon
- **Print Controller**: `CommandePrintController` with access control
- **Print View**: Professional print-friendly template
- **Access Control**: Only allows printing own commandes for client users

### CommandeResource Modifications
```php
// Query filtering for client users
public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    
    if (auth()->user()->hasRole('client')) {
        $user = auth()->user();
        $clientIds = $user->clients()->pluck('clients.id');
        $query->whereIn('client_id', $clientIds);
    }
    
    return $query;
}

// Action restrictions
public static function canCreate(): bool
{
    return auth()->user()->hasRole(['Super Admin', 'admin']);
}

public static function canEdit(Commande $record): bool
{
    return auth()->user()->hasRole(['Super Admin', 'admin']);
}

public static function canDelete(Commande $record): bool
{
    return auth()->user()->hasRole(['Super Admin', 'admin']);
}
``` 