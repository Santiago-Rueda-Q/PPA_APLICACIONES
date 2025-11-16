<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaIncidenteSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creando categorías de incidentes...');

        $categorias = [
            [
                'nombre' => 'Acceso al Salón',
                'slug' => 'acceso-salon',
                'descripcion' => 'Solicitudes de apertura o cierre de salones',
                'color' => '#2563eb',
            ],
            [
                'nombre' => 'Mantenimiento',
                'slug' => 'mantenimiento',
                'descripcion' => 'Reparaciones y mantenimiento de infraestructura',
                'color' => '#f59e0b',
            ],
            [
                'nombre' => 'Limpieza',
                'slug' => 'limpieza',
                'descripcion' => 'Servicios de limpieza y aseo',
                'color' => '#10b981',
            ],
            [
                'nombre' => 'Equipos y Tecnología',
                'slug' => 'equipos-tecnologia',
                'descripcion' => 'Problemas con proyectores, computadores, etc.',
                'color' => '#8b5cf6',
            ],
            [
                'nombre' => 'Servicios Básicos',
                'slug' => 'servicios-basicos',
                'descripcion' => 'Agua, luz, internet, climatización',
                'color' => '#dc2626',
            ],
            [
                'nombre' => 'Mobiliario',
                'slug' => 'mobiliario',
                'descripcion' => 'Sillas, mesas, tableros, etc.',
                'color' => '#0891b2',
            ],
            [
                'nombre' => 'Seguridad',
                'slug' => 'seguridad',
                'descripcion' => 'Problemas de seguridad física o acceso',
                'color' => '#e11d48',
            ],
            [
                'nombre' => 'Otro',
                'slug' => 'otro',
                'descripcion' => 'Otros tipos de incidentes',
                'color' => '#6b7280',
            ],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias_incidentes')->insert([
                'nombre' => $categoria['nombre'],
                'slug' => $categoria['slug'],
                'descripcion' => $categoria['descripcion'],
                'color' => $categoria['color'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Categoría: {$categoria['nombre']}");
        }

        $this->command->info("✅ Categorías de incidentes creadas exitosamente!");
    }
}
