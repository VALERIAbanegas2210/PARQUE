<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Entrada;
use App\Models\tipo_entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use Maatwebsite\Excel\Facades\Excel;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    public function generarExcel()
    {
        try {
            // Crear una nueva hoja de cálculo de PhpSpreadsheet
            $spreadsheet = new Spreadsheet();
            $hoja = $spreadsheet->getActiveSheet();

            // Encabezados del archivo Excel
            $encabezados = ['NIT', 'CÓDIGO_AUTORIZACION', 'TIPO_ENTRADA'];
            $hoja->fromArray($encabezados, null, 'A1');

            // Generar 600 entradas ficticias
            $entradasFicticias = [];
            for ($i = 1; $i <= 600; $i++) {
                $nit = Entrada::NIT; // Generar un NIT aleatorio
                $codigoAutorizacion = strtoupper(bin2hex(random_bytes(6))); // Generar un código aleatorio
                $tipoEntrada = ['ESTUDIANTE', 'NACIONAL', 'EXTRANJERO', 'EXTRANJERO-MENOR'][array_rand(['ESTUDIANTE', 'NACIONAL', 'EXTRANJERO', 'EXTRANJERO-MENOR'])];

                $entradasFicticias[] = [$nit, $codigoAutorizacion, $tipoEntrada];
            }

            // Colocar las entradas ficticias en la hoja de cálculo
            $hoja->fromArray($entradasFicticias, null, 'A2');

            // Crear el escritor de Excel para generar el archivo
            $writer = new Xlsx($spreadsheet);
            $nombreArchivo = 'entradas_ficticias.xlsx';

            // Enviar encabezados para la descarga del archivo
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
            header('Cache-Control: max-age=0');

            // Guardar el archivo en la salida
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el archivo Excel: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposDeEntrada=tipo_entrada::all();
        $entradas=Entrada::where('estado','DISPONIBLE')->paginate(10);//para paginarlo
        
        return view('administracion.GeneracionEntrada.indexEntrada',compact('tiposDeEntrada','entradas'));
    }

    public function procesarExcel(Request $request)
    {   
        //dd($request->all());
        // Validar que se haya enviado un archivo Excel
        $request->validate([
            'archivoExcel' => 'required|file|mimes:xlsx,xls',
            
        ]);


        try {
            // Cargar el archivo de Excel desde el componente de html que se llama archivoExcel
            $archivo = $request->file('archivoExcel');
            $spreadsheet = IOFactory::load($archivo->getRealPath());
            $hoja = $spreadsheet->getActiveSheet();

            // Obtener el total de filas en la hoja
            $maxRow = $hoja->getHighestRow();

            DB::beginTransaction();
            // Iterar sobre las filas (desde la fila 2 en adelante para ignorar encabezados)
            for ($fila = 2; $fila <= $maxRow; $fila++) {
                $celdaNIT = $hoja->getCell("A" . $fila)->getValue();
                $celdaCodigo = $hoja->getCell("B" . $fila)->getValue();
                $celdaTipoEntrada = $hoja->getCell("C" . $fila)->getValue();
                $fechaLimiteEmisionEntrada=$hoja->getCell("D" .$fila)->getValue();
                //dd($fechaLimiteEmisionEntrada);
                // Guardar los datos en la base de datos
                $entrada = new Entrada();
                $entrada->nit = $celdaNIT;
                $entrada->codigoAutorizacion = $celdaCodigo;
                $entrada->tipo_entrada_id = tipo_entrada::getIdTipoEntrada($celdaTipoEntrada);
                $entrada->estado="DISPONIBLE";
                $entrada->fechaLimiteEmision=EntradaController::parsearFecha($fechaLimiteEmisionEntrada);
                //$entrada->tipo_entrada_id = $request->tipoEntrada; // Este es el tipo de entrada seleccionado
                //$entrada->save();  // No olvides descomentar esto para guardar los datos
                //dd($entrada,$celdaTipoEntrada);
                $entrada->save();
            }
            DB::commit();
            
            
            return redirect()->back()->with('success', 'Las entradas se generaron con éxito a partir del archivo Excel.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    
    }

    
    //metodo para parsear las fechas a Y-m-d de tal manera que en la BD lo guarde en la forma correcta 
    public static function parsearFecha($fecha){


        // Verificar si la fecha está en formato numeral de Excel
        if (is_numeric($fecha)) {
            try {
                return Carbon::instance(Date::excelToDateTimeObject($fecha))->format('Y-m-d');
            } catch (Exception $e) {
                throw new Exception("Formato numeral de Excel inválido: {$fecha}");
            }
        }
        $formatos=['Y/m/d','d/m/Y'];
        foreach ($formatos as  $formato) {
            try {
                return Carbon::createFromFormat($formato,$fecha)->format('Y-m-d');
            } catch (Exception $th) {
                continue;
            }
        } 
        throw new Exception("error formato no valido: {$fecha}");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Entrada $entrada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrada $entrada)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            //code...
            $request->validate([
                'codigo' => 'required|string|min:10|max:20',
            ]);
            $entrada=Entrada::findOrFail($id);
            $entrada->codigoAutorizacion=strtoupper($request->codigo);
            $entrada->save();
            return redirect()->back()->with('success','entrada Actualizada con exito');
        } catch (Exception $th) {
            return redirect()->back()->with('error','Hubo un error al actualizar la Entrada! '. $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //dd($id);
        try {
            //code...
            $entradaAEliminar=Entrada::findOrFail($id);
            $entradaAEliminar->delete();
            return redirect()->back()->with('success','Entrada Eliminada con exito!');
        } catch (Exception $th) {
            return redirect()->back()->with('error','Hubo un error al eliminar la Entrada!'. $th->getMessage());
        }
    }
}
