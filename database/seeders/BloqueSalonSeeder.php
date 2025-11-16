<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloqueSalonSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creando estructura de bloques y salones...');

        // Definición de bloques
        $bloques = [
            ['nombre' => 'Bloque A', 'codigo' => 'A', 'pisos' => 3, 'descripcion' => 'Edificio principal'],
            ['nombre' => 'Bloque B', 'codigo' => 'B', 'pisos' => 2, 'descripcion' => 'Edificio secundario'],
            ['nombre' => 'Bloque C', 'codigo' => 'C', 'pisos' => 4, 'descripcion' => 'Edificio nuevo'],
        ];

        foreach ($bloques as $bloqueData) {
            $bloque = DB::table('bloques')->insertGetId([
                'nombre' => $bloqueData['nombre'],
                'codigo' => $bloqueData['codigo'],
                'pisos' => $bloqueData['pisos'],
                'descripcion' => $bloqueData['descripcion'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Creado: {$bloqueData['nombre']}");

            // Crear salones para cada piso
            $this->crearSalones($bloque, $bloqueData['codigo'], $bloqueData['pisos']);
        }

        $this->command->info("✅ Estructura de bloques y salones creada exitosamente!");
    }

    private function crearSalones(int $bloqueId, string $codigoBloque, int $pisos): void
    {
        $salonesPorPiso = [
            'A' => 10, // 10 salones por piso en Bloque A
            'B' => 4,  // 4 salones por piso en Bloque B
            'C' => 8,  // 8 salones por piso en Bloque C
        ];

        $cantidadSalones = $salonesPorPiso[$codigoBloque] ?? 5;

        for ($piso = 1; $piso <= $pisos; $piso++) {
            for ($salon = 1; $salon <= $cantidadSalones; $salon++) {
                $codigo = sprintf('%s%d%02d', $codigoBloque, $piso, $salon);

                DB::table('salones')->insert([
                    'bloque_id' => $bloqueId,
                    'codigo' => $codigo,
                    'piso' => $piso,
                    'capacidad' => rand(25, 40),
                    'tipo' => $this->determinarTipo($salon),
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function determinarTipo(int $numeroSalon): string
    {
        if ($numeroSalon <= 2) return 'laboratorio';
        if ($numeroSalon == 10) return 'auditorio';
        return 'aula';
    }
}
