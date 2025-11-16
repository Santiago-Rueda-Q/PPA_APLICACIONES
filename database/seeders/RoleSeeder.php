<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Iniciando creación de roles y permisos...');

        // Limpiar caché de permisos
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('auth.defaults.guard', 'web');

        // ==========================================
        // DEFINICIÓN DE ROLES
        // ==========================================
        $roles = [
            [
                'name' => 'superadmin',
                'description' => 'Administrador del sistema con acceso total',
                'permissions' => [] // Se asignarán todos después
            ],
            [
                'name' => 'admin_infraestructura',
                'description' => 'Administrador de infraestructura',
                'permissions' => [
                    'incidentes.view_all',
                    'incidentes.create',
                    'incidentes.edit_all',
                    'incidentes.delete_all',
                    'incidentes.assign',
                    'incidentes.change_status',
                    'incidentes.view_reports',
                    'usuarios.view',
                    'usuarios.manage',
                    'areas.manage',
                    'categorias.manage',
                    'prioridades.manage',
                ]
            ],
            [
                'name' => 'operativo_servicio',
                'description' => 'Personal operativo que atiende incidentes',
                'permissions' => [
                    'incidentes.view_assigned',
                    'incidentes.edit_assigned',
                    'incidentes.update_status',
                    'incidentes.add_comments',
                    'incidentes.upload_evidence',
                    'incidentes.view_reports',
                ]
            ],
            [
                'name' => 'director_programa',
                'description' => 'Director de programa académico',
                'permissions' => [
                    'incidentes.view_area',
                    'incidentes.create',
                    'incidentes.edit_own',
                    'incidentes.view_reports',
                    'incidentes.approve',
                ]
            ],
            [
                'name' => 'docente_solicitante',
                'description' => 'Docente que reporta incidentes',
                'permissions' => [
                    'incidentes.view_own',
                    'incidentes.create',
                    'incidentes.edit_own',
                    'incidentes.cancel_own',
                    'incidentes.add_comments',
                ]
            ],
        ];

        // ==========================================
        // DEFINICIÓN DE PERMISOS
        // ==========================================
        $this->command->info("\nCreando permisos...");

        $permissions = [
            // Permisos de Incidentes
            ['name' => 'incidentes.view_all', 'description' => 'Ver todos los incidentes'],
            ['name' => 'incidentes.view_assigned', 'description' => 'Ver incidentes asignados'],
            ['name' => 'incidentes.view_area', 'description' => 'Ver incidentes del área'],
            ['name' => 'incidentes.view_own', 'description' => 'Ver incidentes propios'],
            ['name' => 'incidentes.create', 'description' => 'Crear incidentes'],
            ['name' => 'incidentes.edit_all', 'description' => 'Editar todos los incidentes'],
            ['name' => 'incidentes.edit_assigned', 'description' => 'Editar incidentes asignados'],
            ['name' => 'incidentes.edit_own', 'description' => 'Editar incidentes propios'],
            ['name' => 'incidentes.delete_all', 'description' => 'Eliminar incidentes'],
            ['name' => 'incidentes.cancel_own', 'description' => 'Cancelar incidentes propios'],
            ['name' => 'incidentes.assign', 'description' => 'Asignar incidentes'],
            ['name' => 'incidentes.change_status', 'description' => 'Cambiar estado de incidentes'],
            ['name' => 'incidentes.update_status', 'description' => 'Actualizar estado de asignados'],
            ['name' => 'incidentes.add_comments', 'description' => 'Agregar comentarios'],
            ['name' => 'incidentes.upload_evidence', 'description' => 'Subir evidencias'],
            ['name' => 'incidentes.approve', 'description' => 'Aprobar incidentes'],
            ['name' => 'incidentes.view_reports', 'description' => 'Ver reportes'],

            // Permisos de Usuarios
            ['name' => 'usuarios.view', 'description' => 'Ver usuarios'],
            ['name' => 'usuarios.manage', 'description' => 'Gestionar usuarios'],

            // Permisos de Configuración
            ['name' => 'areas.manage', 'description' => 'Gestionar áreas'],
            ['name' => 'categorias.manage', 'description' => 'Gestionar categorías'],
            ['name' => 'prioridades.manage', 'description' => 'Gestionar prioridades'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $guard]
            );
            $this->command->info("  ✓ Permiso: {$permission['name']}");
        }

        // ==========================================
        // CREAR ROLES Y ASIGNAR PERMISOS
        // ==========================================
        $this->command->info("\nCreando roles y asignando permisos...");

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $guard]
            );

            if ($roleData['name'] === 'superadmin') {
                // SuperAdmin tiene todos los permisos
                $role->syncPermissions(Permission::all());
                $this->command->info("  ✓ Rol: {$roleData['name']} (TODOS LOS PERMISOS)");
            } else {
                // Asignar permisos específicos
                $role->syncPermissions($roleData['permissions']);
                $this->command->info("  ✓ Rol: {$roleData['name']} (" . count($roleData['permissions']) . " permisos)");
            }
        }

        // Limpiar caché final
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->command->info("\n✅ Seeder de roles y permisos completado exitosamente!");
    }
}
