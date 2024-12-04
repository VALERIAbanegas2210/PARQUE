<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\Pago;
use App\Models\Reserva;
use App\Models\usuario;
use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\View\ViewName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //  dd($request->all());
         $datos=json_decode($request->input('formData'),true);//pasarlo de json a formato array
         //Auth::id(), // ID del usuario autenticado, para acceder al id del usuario logeado
 
         //creo un objeto Reserva
         if(count($datos)>0){

             try{
                DB::beginTransaction();
                 $reserva=Reserva::create([
                     'montoTotal'=>$request->input('montoTotal'),
                     'cantidad'=>count($datos),
                     'estado'=>'PENDIENTE',
                     'fechaReserva'=>now(),
                     //'usuario_id' => Auth::id(), // ID del usuario autenticado
                     'usuario_id'=> Auth::id(),
                 ]);
                 //ahora debo crear objetos formularios o detalles maldicion valegod
                 foreach($datos as $formulario){
                      // Validar y obtener los valores, usando null si no están presentes
                     $ci = isset($formulario['ci']) ? $formulario['ci'] : null;
                     $nombre = $formulario['nombre'] ?? null;
                     $edad = isset($formulario['edad']) ? (int) $formulario['edad'] : null;
                     $pasaporte = isset($formulario['pasaporte']) ? $formulario['pasaporte'] : null;
                     $tiempoEstadia = isset($formulario['tiempoEstadia']) ? (int) $formulario['tiempoEstadia'] : null;
                     $nacionalidad = isset($formulario['nacionalidad']) ? $formulario['nacionalidad'] : null;
                     $departamento_id = isset($formulario['departamento']) ? (int) $formulario['departamento'] : null;
                     $ruta_turistica_id = isset($formulario['ruta_turistica']) ? (int) $formulario['ruta_turistica'] : null;
                     $tipo_entrada_id = isset($formulario['tipo_entrada']) ? (int) $formulario['tipo_entrada'] : null;
                     $comunidad_id = isset($formulario['comunidad']) ? (int) $formulario['comunidad'] : null;
                     $fecha=new DateTime($formulario['fecha_reserva']);
    
    
                     //para una validacion mas fuerte seria buscarlos en la bd esos datos,sin embargo ya estan prevalidados
                     //dado que primero se paso de la vista formulario a la vista resumen,entonces digamos que ya estarian cargados
                     // Validar que los campos requeridos tengan valores válidos antes de crear el formulario
                     if ($nombre && $edad && $ruta_turistica_id && $tipo_entrada_id && $comunidad_id) {
                         // Crear el Formulario
                         Formulario::create([
                             'ci' => $ci,
                             'nombre' => $nombre,
                             'edad' => $edad,
                             'pasaporte' => $pasaporte,
                             'tiempoEstadia' => $tiempoEstadia,
                             'fechaIngreso' => null,
                             'fechaSalida' => null,
                             'fechaReserva' => $fecha,
                             'estado' => 'PENDIENTE',
                             'nacionalidad' => $nacionalidad,
                             'estadoUsuario' => 'PENDIENTE',
                             'departamento_id' => $departamento_id,
                             'ruta_turistica_id' => $ruta_turistica_id,
                             'reserva_id' => $reserva->id,
                             'tipo_entrada_id' => $tipo_entrada_id,
                             'comunidad_id' => $comunidad_id,
                             'entrada_id' => null, // Por ahora nulo
                             'guardaparque_id' => null,
                         ]);
                     }
                    
                 }
                 DB::commit();
                 
             }catch(Exception $e){
                 //return redirect()->route('layouts.template');//en el caso de fallo
                 DB::rollBack();
                 //dd($e);
                 return redirect()->route('layouts.template')->with('error', 'Error al guardar la reserva. Intente nuevamente.')->with('source','reserva');
    
             }
             //en el caso de exito
             return redirect()->route('layouts.template')->with('success', 'Reserva realizada correctamente.')->with('source','reserva');
         }
    }

    
    
    public function adminStore(Request $request)
    {
       // dd($request->all());
        $datos = json_decode($request->input('formData'), true); // pasarlo de JSON a formato array
        $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
        try {
            DB::beginTransaction(); // Iniciar transacción

            // Crear objeto Reserva
            $reserva = Reserva::create([
                'montoTotal' => $request->input('montoTotal'),
                'cantidad' => count($datos),
                'estado' => 'PAGADO',
                'fechaReserva' => now(),
                'usuario_id' => Auth::id(), // ID del usuario autenticado
            ]);

            // Crear objetos Formularios (detalles de la reserva)
            foreach ($datos as $formulario) {
                // Validar y obtener los valores, usando null si no están presentes
                $ci = $formulario['ci'] ?? null;
                $nombre = $formulario['nombre'] ?? null;
                $edad = isset($formulario['edad']) ? (int) $formulario['edad'] : null;
                $pasaporte = $formulario['pasaporte'] ?? null;
                $tiempoEstadia = isset($formulario['tiempoEstadia']) ? (int) $formulario['tiempoEstadia'] : null;
                $nacionalidad = $formulario['nacionalidad'] ?? null;
                $departamento_id = isset($formulario['departamento']) ? (int) $formulario['departamento'] : null;
                $ruta_turistica_id = isset($formulario['ruta_turistica']) ? (int) $formulario['ruta_turistica'] : null;
                $tipo_entrada_id = isset($formulario['tipo_entrada']) ? (int) $formulario['tipo_entrada'] : null;
                $comunidad_id = isset($formulario['comunidad']) ? (int) $formulario['comunidad'] : null;
                $tipoPago = $formulario['tipoPago'] ?? null;
                $fecha=new DateTime($formulario['fecha_reserva']);

                // Validar que los campos requeridos tengan valores válidos antes de crear el formulario
                if ($nombre && $edad && $ruta_turistica_id && $tipo_entrada_id && $comunidad_id) {
                    // Crear el Formulario
                    $formularioCreado = Formulario::create([
                        'ci' => $ci,
                        'nombre' => $nombre,
                        'edad' => $edad,
                        'pasaporte' => $pasaporte,
                        'tiempoEstadia' => $tiempoEstadia,
                        'fechaIngreso' => null,
                        'fechaSalida' => null,
                        'fechaReserva' => $fecha,
                        'estado' => 'PENDIENTE',//con el trigger se cambiara
                        'nacionalidad' => $nacionalidad,
                        'estadoUsuario' => 'PENDIENTE',
                        'departamento_id' => $departamento_id,
                        'ruta_turistica_id' => $ruta_turistica_id,
                        'reserva_id' => $reserva->id,
                        'tipo_entrada_id' => $tipo_entrada_id,
                        'comunidad_id' => $comunidad_id,
                        'entrada_id' => null,
                        'guardaparque_id' => null,
                    ]);

                    // Registrar el pago correspondiente según el tipo de pago
                    if ($tipoPago == "Mixto") { // Se registran 2 pagos
                        if((float)$formulario['montoQR']>=0 && (float)$formulario['montoEfectivo']>=0){
                            if((float)$formulario['montoQR']+(float)$formulario['montoEfectivo']==$formularioCreado->tipoEntrada->precio){
                                if((float)$formulario['montoQR']>0){
                                    $pagoBacket=Pago::create([
                                        'formulario_id' => $formularioCreado->id,
                                        'nombre' => "QR",
                                        'monto' => (float)$formulario['montoQR'],
                                    ]);
                                }
                                if((float)$formulario['montoEfectivo']>0){
                                    $pagoBacket=Pago::create([
                                        'formulario_id' => $formularioCreado->id,
                                        'nombre' => "EFECTIVO",
                                        'monto' => (float)$formulario['montoEfectivo'],
                                    ]);
                                }
                                PagoController::agregarIdGuardaparqueAForm($pagoBacket);
                            }
                        }
                    } else if ($tipoPago == "QR") {
                        $pagoBacket=Pago::create([
                            'formulario_id' => $formularioCreado->id,
                            'nombre' => "QR",
                            'monto' => $formularioCreado->tipoEntrada->precio,
                        ]);
                        PagoController::agregarIdGuardaparqueAForm($pagoBacket);
                    } else { // Efectivo
                        $pagoBacket=Pago::create([
                            'formulario_id' => $formularioCreado->id,
                            'nombre' => "EFECTIVO",
                            'monto' => $formularioCreado->tipoEntrada->precio,
                        ]);
                        PagoController::agregarIdGuardaparqueAForm($pagoBacket);
                    }
                }
            }

            DB::commit(); // Confirmar transacción si todo sale bien
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer transacción en caso de error
            dd($e);
            //para verificar si un usuario es admin
            $usuario = usuario::findOrFail(Auth::id());
            if($usuario->hasRole('admin')){
                return redirect()->route('admin.dashboard')->with('error', 'Error al guardar la reserva. Intente nuevamente.')->with('source','reserva');
            }else{
                return redirect()->route($layout)->with('error', 'Error al guardar la reserva. Intente nuevamente.')->with('source','reserva');
            }
        }

        // En caso de éxito
        $usuario = usuario::findOrFail(Auth::id());
        if($usuario->hasRole('admin')){
            return redirect()->route('admin.dashboard')->with('success', 'Reserva guardada con éxito.')->with('source','reserva');
        }else{
            return redirect()->route($layout)->with('success', 'Reserva guardada con éxito.')->with('source','reserva');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $id)
    {
        //
    }
    //para admin
    /*public function showReservas($id){
        $usuario=usuario::find(Auth::id());
        $reservasPendientes=$usuario->reservas()->where('estado','PENDIENTE')->get();//para obtener las reservas pendientes del usuario
        

    }*/
    //para administrador que pasa un id del usuario
    /*public function adminShowReservas($id){
        $usuario=usuario::find($id);
        $reservasPendientes=$usuario->reservas()->where('estado','PENDIENTE')->get();//para obtener las reservas pendientes del usuario

    }*/

    

    //para mostrar las reservas pendientes para el usuario
    public function userShowReservas(){
        $usuario=usuario::find(Auth::id());
        //dd($usuario->reservas());
        $reservasPendientes=$usuario->reservas()->where('estado','PENDIENTE')->paginate(10);//para obtener las reservas pendientes del usuario
        $estado="PENDIENTE";
        //dd($usuario,$reservasPendientes);
        return view('usuarios.Reservas.reservaUsuario',compact('reservasPendientes','estado'));
    }

        //para ver las reservas pendientes del  admin
        public function adminShowReservasPendientes(){
            $usuario=usuario::find(Auth::id());
            //dd(Auth::id());
            $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
            $reservasPendientes=$usuario->reservas()->where('estado','PENDIENTE')->paginate(10);//para obtener las reservas pendientes del usuario
            $estadoReserva="PENDIENTE";
            //dd($usuario,$reservasPendientes);
            return view('administracion.AdminReservas.reservaUsuario',compact('reservasPendientes','estadoReserva','layout'));
        }
        //para ver las reservas en estado pagado del admin
        public function adminShowReservasPagadas(){
            $usuario=usuario::find(Auth::id());
            $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
            $estadoReserva="PAGADO";
            $reservasPendientes=$usuario->reservas()->where('estado','PAGADO')->paginate(10);//para obtener las reservas pagadas del usuario
            //dd($usuario,$reservasPendientes);
            return view('administracion.AdminReservas.reservaUsuario',compact('reservasPendientes','estadoReserva','layout'));
        }


    //id de la reserva
    public function userEditReserva($id){
        /*$reserva=Reserva::find($id);
        $formularios=$reserva->formularios()->get();//detalles */
        $reserva = Reserva::with('formularios.departamento', 'formularios.rutaTuristica', 'formularios.comunidad', 'formularios.tipoEntrada','formularios.reserva')->find($id);
        $formularios = $reserva->formularios;

      //  dd(json_encode($formularios,JSON_PRETTY_PRINT));//para mostrarlo en formato json 
        //dd($formularios[0]->departamento);
        return view('usuarios.Reservas.reservasDelUsuario',compact('formularios'));
    }

    //para ir a la vista de pagados
    public function userEditReservaPagadas($id){
        /*$reserva=Reserva::find($id);
        $formularios=$reserva->formularios()->get();//detalles */
        $reserva = Reserva::with('formularios.departamento', 'formularios.rutaTuristica', 'formularios.comunidad', 'formularios.tipoEntrada','formularios.reserva')->find($id);
        $formularios = $reserva->formularios;

      //  dd(json_encode($formularios,JSON_PRETTY_PRINT));//para mostrarlo en formato json 
        //dd($formularios[0]->departamento);
        return view('usuarios.Reservas.reservaDelUsuarioPagadas',compact('formularios'));
    }

    //para administrador le pasa el id de la reserva
    public function adminEditReserva($id){
        //$reserva=Reserva::find($id);
        //$formularios=$reserva->formularios()->get();//detalles 
        $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
        $reserva = Reserva::with('formularios.departamento', 'formularios.rutaTuristica', 'formularios.comunidad', 'formularios.tipoEntrada','formularios.reserva')->find($id);
        $formularios = $reserva->formularios;

      //  dd(json_encode($formularios,JSON_PRETTY_PRINT));//para mostrarlo en formato json 
        //dd($formularios[0]->departamento);
        return view('administracion.AdminReservas.reservasDelUsuario',compact('formularios','layout'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    public function mostrarReservasPagadasDelUsuario(){
        $usuario=usuario::find(Auth::id());
        //dd($usuario->reservas());
        $reservasPendientes=$usuario->reservas()->where('estado','PAGADO')->paginate(10);//para obtener las reservas pendientes del usuario   
        $estado="PAGADO";
        return view('usuarios.Reservas.reservaUsuario',compact('reservasPendientes','estado'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reserva=Reserva::findOrFail($id);
        $reserva->delete();
        return redirect()->back()->with('success','Reserva eliminada Exitosamente');
    
    }
}
