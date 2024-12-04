<?php

namespace Database\Seeders;

use App\Models\comunidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComunidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        comunidad::create([
            'nombre' => 'Mataracu',
            'descripcion' => 'ESTA ES LA PAGINA DE MATARACU',
            'zona' => 'OESTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'La chonta',
            'descripcion' => 'ESTA ES LA PAGINA DE LA CHONTA',
            'zona' => 'NORTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'Oriente',
            'descripcion' => 'ESTA ES LA PAGINA DE ORIENTE',
            'zona' => 'SUR',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'Ichilo colorado',
            'descripcion' => 'ESTA ES LA PAGINA DE ICHILO COLORADO',
            'zona' => 'OESTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'Villa Amboro',
            'descripcion' => 'ESTA ES LA PAGINA DE VILLA AMBORO',
            'zona' => 'NORTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'La yunga',
            'descripcion' => 'ESTA ES LA PAGINA DE LOS YUNGA',
            'zona' => 'ESTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
        comunidad::create([
            'nombre' => 'Jardín de las delicias',
            'descripcion' => 'Jardín de las Delicias del Amboró es uno de los destinos turísticos más impresionantes de Bolivia. Ubicado en el municipio de El Torno, departamento de Santa Cruz, este lugar ofrece una experiencia única para los amantes de la naturaleza y las actividades al aire libre.',
            'zona' => 'ESTE',
            'disponibilidad'=>'DISPONIBLE'
        ]);
    }
}