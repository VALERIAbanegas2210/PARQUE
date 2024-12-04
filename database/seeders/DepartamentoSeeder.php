<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Departamento::create([
            'nombre'=>'SANTA CRUZ'
        ]);
        Departamento::create([
            'nombre'=>'COCHABAMBA'
        ]);
        Departamento::create([
            'nombre'=>'POTOSI'
        ]);
        Departamento::create([
            'nombre'=>'ORURO'
        ]);
        Departamento::create([
            'nombre'=>'BENI'
        ]);
        Departamento::create([
            'nombre'=>'PANDO'
        ]);
        Departamento::create([
            'nombre'=>'LA PAZ'
        ]);
        Departamento::create([
            'nombre'=>'CHUQUISACA'
        ]);
        Departamento::create([
            'nombre'=>'TARIJA'
        ]);
    }
}
