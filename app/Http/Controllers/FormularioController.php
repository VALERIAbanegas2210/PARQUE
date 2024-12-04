<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Reserva;
use App\Models\usuario;
use App\Models\comunidad;
use App\Models\Formulario;
use App\Models\Departamento;
use App\Models\Guardaparque;
use App\Models\tipo_entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
        // Método para mostrar todos los formularios pendientes
        public function mostrarFormulariosPendientes()
        {
            // Obtener todos los formularios con estado 'PENDIENTE'
            $formularios = Formulario::where('estado', 'PENDIENTE')->paginate(10);
          //  dd($formulariosPendientes);
            // Retornar la vista con los formularios pendientes
            
            return view('administracion.FormulariosPendientes.indexFormulariosPendientes', compact('formularios'));
        }
    
        // Método para mostrar todos los formularios pagados
        public function mostrarFormulariosPagados()
        {
            // Obtener todos los formularios con estado 'PAGADO'
            $formularios = Formulario::where('estado', 'PAGADO')->paginate(10);
    
            // Retornar la vista con los formularios pagados
            return view('administracion.FormulariosPagados.indexFormulariosPagados', compact('formularios'));
        }

        //para usuario
        public function mostrarActividadEnCurso(){

            // Obtener todos los formularios con estado 'PAGADO' y con carnet ci
            $usuario=usuario::findOrFail(Auth::id());

            $formularios = Formulario::where('estadoUsuario', 'PENDIENTE')->where('ci',$usuario->ci)->where('estado','PAGADO')->paginate(10);
            
            // Retornar la vista con los formularios pagados
            return view('usuarios.ActividadUsuario.actividadActiva', compact('formularios'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos=Departamento::all();
        $comunidades=comunidad::all();
        $tipoEntradas=tipo_entrada::all();

        return view('usuarios.FormularioReserva.FormularioReservax',compact('departamentos','comunidades','tipoEntradas'));

    }
    //vista pal admin
    public function adminCreate(){
        $departamentos=Departamento::all();
        $comunidades=comunidad::all();
        $tipoEntradas=tipo_entrada::all();
        $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
        
        return view('administracion.FormularioReserva.FormularioReservax',compact('departamentos','comunidades','tipoEntradas','layout'));
    }
    //para mostrar ir a una vista de resumen
    public function showResumen(Request $request)
    {   
      //  dd($request->all());
        if($request->isMethod('post')){
            // Obtener todos los datos del formulario
            $formDataFront = $request->input('formData');
            //dd($formDataFront[0]['ci']);
            //dd($request->all());
            // Inicializar un array vacío para los datos validados
    
            $formData = [];//lista con los datos validados
            $montoTotal=0;
            $montoRelativo=0;
            $huboCambios=false;
            
            // Recorrer cada formulario (en caso de múltiples reservas)
            foreach ($formDataFront as $index => $form) {
                // Inicializar un array para guardar los campos del formulario actual
                //$formData = [];
                $listaAuxiliarEntrante=[];
    
                //verifico si los campos que si o si son necesarios independientemente del tipo de entrada
                if(!empty($form['tipo_entrada'])&&!empty($form['comunidad'])&&!empty($form['ruta_turistica'])){ 
    
                     // Obtener la hora actual en formato H:i:s
                    $horaActual = date('H:i:s');
    
                    // Concatenar la fecha y la hora
                    $fechaCompleta = ($form['fecha_reserva'] . ' ' . $horaActual);
                    

                    $fechaActual=date('Y-m-d');//fecha actual


                    // Convertir la cadena a un objeto DateTime
                   // $fechaConHora = new DateTime($fechaCompleta);
    
                    //para agregar atributos a un objeto en php es así
                    $listaAuxiliarEntrante['tipo_entrada']=$form['tipo_entrada'];
                    $listaAuxiliarEntrante['comunidad']=$form['comunidad'];
                    $listaAuxiliarEntrante['ruta_turistica']=$form['ruta_turistica'];
                    $listaAuxiliarEntrante['nombre_comunidad']=$form['nombre_comunidad'];
                    $listaAuxiliarEntrante['nombre_ruta_turistica']=$form['nombre_ruta_turistica'];

                    
                    //$listaAuxiliarEntrante['fecha_reserva']=$fechaCompleta;
                    if(!empty($form['nombre'])&&!empty($form['tiempoEstadia'])){//si no esta vacio los campos que aplica para todos
                        
                        
                        //$listaAuxiliarEntrante['edad']=$form['edad'];
                        $listaAuxiliarEntrante['nombre']=$form['nombre'];
                        $listaAuxiliarEntrante['tiempoEstadia']=$form['tiempoEstadia'];
                        
                        //dd(new DateTime($form['fecha_reserva'])>=new DateTime($fechaActual));

                        $idTipoEntrada=$form['tipo_entrada'];
                        $edadLimite=100;
                        if($idTipoEntrada==='1'||$idTipoEntrada==='4'){
                            $edadLimite=18;
                        }
                        if((int)$form['edad']>0&&(int)$form['edad']<=$edadLimite){
                            $listaAuxiliarEntrante['edad']=$form['edad'];
                        }else{
                            $huboCambios=true;
                        }

                        if(new DateTime($form['fecha_reserva'])>=new DateTime($fechaActual)){
                            $listaAuxiliarEntrante['fecha_reserva']=$fechaCompleta;
                        }else{
                            $huboCambios=true;
                        }
                        if($idTipoEntrada){//si existe id de tipo de entrada
                            /*if((float)$form['edad']<18){
                                $montoTotal+=10;
                                $montoRelativo=10;
                            }else{*/
                            $montoTotal+=(float)$form['precioEntrada'];
                            $montoRelativo=(float)$form['precioEntrada'];
                            $listaAuxiliarEntrante['montoRelativo']=$montoRelativo;
                            switch ($idTipoEntrada) {
                                case '1'://estudiante
                                    # code...
                                    if(!empty($form['ci_estudiante'])&&!empty($form['unidad_educativa'])&&!empty($form['departamento'])){
                                    //    $listaAuxiliarEntrante['rude']=$form['rude'];
                                        $listaAuxiliarEntrante['ci']=$form['ci_estudiante'];
                                        $listaAuxiliarEntrante['unidad_educativa']=$form['unidad_educativa'];
                                        $listaAuxiliarEntrante['departamento']=$form['departamento'];
                                        $listaAuxiliarEntrante['nombre_departamento']=$form['nombre_departamento'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                    break;
                                case '2'://extranjero
                                    # code...
                                    if(!empty($form['pasaporte'])&&!empty($form['nacionalidad']) ){
                                        $listaAuxiliarEntrante['pasaporte']=$form['pasaporte'];
                                        $listaAuxiliarEntrante['nacionalidad']=$form['nacionalidad'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                    break;
                                case '3'://nacional
                                        # code...
                                        if(!empty($form['departamento'])&&!empty($form['ci'])){
                                           // dd($form['ci']);
                                            $listaAuxiliarEntrante['ci']=$form['ci'];
                                           // $listaAuxiliarEntrante['nacionaldad']=$form['nacionalidad'];
                                            $listaAuxiliarEntrante['departamento']=$form['departamento'];
                                            $listaAuxiliarEntrante['nombre_departamento']=$form['nombre_departamento'];
                                        }else{
                                            $huboCambios=true;
                                        }
                                    break;
                                case '4'://extranjero-menor
                                        # code...
                                    if(!empty($form['pasaporte'])&&!empty($form['nacionalidad']) ){    
                                        $listaAuxiliarEntrante['pasaporte']=$form['pasaporte'];
                                        $listaAuxiliarEntrante['nacionalidad']=$form['nacionalidad'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                break;    
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }else{
                        $huboCambios=true;
                    }
                }else{
                    $huboCambios=true;
                }
    
                // Solo agregar el formulario si tiene datos válidos
                if (!empty($listaAuxiliarEntrante)) {
                    //como lista.add en javagod
                    $formData[] = $listaAuxiliarEntrante;
                }
            }
            //$formData['montoTotal']=$montoTotalAPagar;
            //dd($formData);
            // Retornar la vista con los datos validados
            //dd($formData);
            $esActualizacion=false;
            return view('usuarios.FormularioReserva.Resumen', compact('formData','montoTotal','huboCambios','esActualizacion'));
        }

        if($request->isMethod('get')){
             // Manejo de recarga (GET): Recuperar datos filtrados desde sessionStorage
             $esActualizacion=true;

            return view('usuarios.FormularioReserva.Resumen', [
                'formData' => [], // No se enviarán datos iniciales
                'montoTotal' => 0,
                //'layout' => usuario::getLayout(Auth::id()),
                'huboCambios' => null,
                'esActualizacion'=>$esActualizacion
            ]);
        }
    }

    //para ver el resumen siendo admin
    public function showAdminResumen(Request $request){
        //dd($request->all());
        // Obtener todos los datos del formulario
        if($request->isMethod('post')){

            $formDataFront = $request->input('formData');
            $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde        
            //dd($formDataFront[0]['ci']);
            //dd($request->all());
            // Inicializar un array vacío para los datos validados
    
            $formData = [];//lista con los datos validados
            //$errores=[];
            $montoTotal=0;
            $huboCambios=false;
            $montoRelativo=0;
            
            // Recorrer cada formulario (en caso de múltiples reservas)
            foreach ($formDataFront as $index => $form) {
                // Inicializar un array para guardar los campos del formulario actual
                //$formData = [];
                $listaAuxiliarEntrante=[];
    
                //verifico si los campos que si o si son necesarios independientemente del tipo de entrada
                if(!empty($form['tipo_entrada'])&&!empty($form['comunidad'])&&!empty($form['ruta_turistica'])&&!empty($form['tipoPago'])){ 
                    //para agregar atributos a un objeto en php es así
                    $listaAuxiliarEntrante['tipo_entrada']=$form['tipo_entrada'];
                    $listaAuxiliarEntrante['comunidad']=$form['comunidad'];
                    $listaAuxiliarEntrante['ruta_turistica']=$form['ruta_turistica'];
                    $listaAuxiliarEntrante['nombre_comunidad']=$form['nombre_comunidad'];
                    $listaAuxiliarEntrante['nombre_ruta_turistica']=$form['nombre_ruta_turistica'];
    
                    // Obtener la hora actual en formato H:i:s
                    $horaActual = date('H:i:s');
    
                    // Concatenar la fecha y la hora
                    $fechaCompleta = $form['fecha_reserva'] . ' ' . $horaActual;
    
                    //$listaAuxiliarEntrante['fecha_reserva']=$fechaCompleta;
                    if(!empty($form['nombre'])&&!empty($form['tiempoEstadia'])){//si no esta vacio los campos que aplica para todos


                        $listaAuxiliarEntrante['nombre']=$form['nombre'];
                        $listaAuxiliarEntrante['tiempoEstadia']=$form['tiempoEstadia'];
                        $tipoePago=$form['tipoPago'];
                        $listaAuxiliarEntrante['tipoPago']=$tipoePago;//puede ser qr,efectivo,mixto
                        if($tipoePago=="Mixto"){
                            if((float)$form['montoQR']>=0&&(float)$form['montoEfectivo']>=0){
                                if((float)$form['montoQR']+(float)$form['montoEfectivo']===(float)$form['precioEntrada']){
                                    $listaAuxiliarEntrante['montoQR']=$form['montoQR'];
                                    $listaAuxiliarEntrante['montoEfectivo']=$form['montoEfectivo'];
                                }else{
                                    $huboCambios=true;
                                }
                            }else{
                                $huboCambios=true;
                            }
                        }

                        $fechaActual=date('Y-m-d');//fecha actual
                        
                        if(new DateTime($form['fecha_reserva'])>=new DateTime($fechaActual)){
                            $listaAuxiliarEntrante['fecha_reserva']=$fechaCompleta;
                        }else{
                            $huboCambios=true;
                        }

                        $idTipoEntrada=$form['tipo_entrada'];

                        $edadLimite=100;
                        if($idTipoEntrada==='1'||$idTipoEntrada==='4'){
                            $edadLimite=18;
                        }
                        if((int)$form['edad']>0&&(int)$form['edad']<=$edadLimite){
                            $listaAuxiliarEntrante['edad']=$form['edad'];
                        }else{
                            $huboCambios=true;
                        }

                        if($idTipoEntrada){//si existe id de tipo de entrada
                            /*if((float)$form['edad']<18){
                                $montoTotal+=10;
                                $montoRelativo=10;
                            }else{*/
                            $montoTotal+=(float)$form['precioEntrada'];
                            $montoRelativo=(float)$form['precioEntrada'];
                            $listaAuxiliarEntrante['montoRelativo']=$montoRelativo;
                            switch ($idTipoEntrada) {
                                case '1'://estudiante
                                    # code...
                                    if(!empty($form['ci_estudiante'])&&!empty($form['unidad_educativa'])&&!empty($form['departamento'])){
                                    //    $listaAuxiliarEntrante['rude']=$form['rude'];
                                        $listaAuxiliarEntrante['ci']=$form['ci_estudiante'];
                                        $listaAuxiliarEntrante['unidad_educativa']=$form['unidad_educativa'];
                                        $listaAuxiliarEntrante['departamento']=$form['departamento'];
                                        $listaAuxiliarEntrante['nombre_departamento']=$form['nombre_departamento'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                    break;
                                case '2'://extranjero
                                    # code...
                                    if(!empty($form['pasaporte'])&&!empty($form['nacionalidad']) ){
                                        $listaAuxiliarEntrante['pasaporte']=$form['pasaporte'];
                                        $listaAuxiliarEntrante['nacionalidad']=$form['nacionalidad'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                    break;
                                case '3'://nacional
                                        # code...
                                        if(!empty($form['departamento'])&&!empty($form['ci'])){
                                           // dd($form['ci']);
                                            $listaAuxiliarEntrante['ci']=$form['ci'];
                                           // $listaAuxiliarEntrante['nacionaldad']=$form['nacionalidad'];
                                            $listaAuxiliarEntrante['departamento']=$form['departamento'];
                                            $listaAuxiliarEntrante['nombre_departamento']=$form['nombre_departamento'];
                                        }else{
                                            $huboCambios=true;
                                        }
                                    break;
                                case '4'://extranjero-menor
                                        # code...
                                    if(!empty($form['pasaporte'])&&!empty($form['nacionalidad']) ){    
                                        $listaAuxiliarEntrante['pasaporte']=$form['pasaporte'];
                                        $listaAuxiliarEntrante['nacionalidad']=$form['nacionalidad'];
                                    }else{
                                        $huboCambios=true;
                                    }
                                break;    
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }else{
                        $huboCambios=true;    
                    }
                }else{
                    $huboCambios=true;
                }
    
                // Solo agregar el formulario si tiene datos válidos
                if (!empty($listaAuxiliarEntrante)) {
                    //como lista.add en javagod
                    $formData[] = $listaAuxiliarEntrante;
                }
            }
            //$formData['montoTotal']=$montoTotalAPagar;
           //dd($huboCambios);
            // Retornar la vista con los datos validados
            $esActualizacion=false;
          //  dd($formData);
            return view('administracion.FormularioReserva.Resumen', compact('formData','montoTotal','layout','huboCambios','esActualizacion'));
        }
        if($request->isMethod('get')){
            $esActualizacion=true;

            return view('administracion.FormularioReserva.Resumen', [
                'formData' => [], // No se enviarán datos iniciales
                'montoTotal' => 0,
                'layout' => usuario::getLayout(Auth::id()),
              //  'huboCambios' => false,
              'huboCambios' => null,
                'esActualizacion'=>$esActualizacion
            ]);
        }

        
         
    }

    /**
     * Store a newly created resource in storage.
     * para guardar la reserva
     */
    public function store(Request $request)
    {
      //  dd($request->all());
     /*   $datos=json_decode($request->input('formData'),true);//pasarlo de json a formato array
        //Auth::id(), // ID del usuario autenticado, para acceder al id del usuario logeado

        //creo un objeto Reserva
        try{

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
                        'fechaReserva' => now(),
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
        }catch(Exception $e){
            //return redirect()->route('layouts.template');//en el caso de fallo
            dd($e);
        }
        //en el caso de exito
        return redirect()->route('layouts.template');*/
    }

    /**
     * Display the specified resource.
     * mostrarme el formulario,recibe el parametro formulario
     */
    public function show(Formulario $formulario)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idReserva,$idForm)
    {

        $reserva = Reserva::with('formularios.departamento', 'formularios.rutaTuristica', 'formularios.comunidad', 'formularios.tipoEntrada')
        ->findOrFail($idReserva);
        $formulario = $reserva->formularios->where('id', $idForm)->first();
        //dd(json_encode($formulario,JSON_PRETTY_PRINT));
        $departamentos=Departamento::all();
        $comunidades=comunidad::all();
        $tipoEntradas=tipo_entrada::all();
        //dd(json_encode($formulario,JSON_PRETTY_PRINT));
        
        //$layout = Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('admin') ? 'layouts.admin_template' : 'layouts.template';
        //return view('mi_vista', compact('layout'));

        return view('usuarios.Reservas.edicionReserva',compact('departamentos','comunidades','tipoEntradas','formulario'));
    }

    public function adminEdit($idReserva,$idForm)
    {

        $reserva = Reserva::with('formularios.departamento', 'formularios.rutaTuristica', 'formularios.comunidad', 'formularios.tipoEntrada')
        ->findOrFail($idReserva);
        $formulario = $reserva->formularios->where('id', $idForm)->first();
        //dd(json_encode($formulario,JSON_PRETTY_PRINT));
        $departamentos=Departamento::all();
        $comunidades=comunidad::all();
        $tipoEntradas=tipo_entrada::all();
        $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
        //dd(json_encode($formulario,JSON_PRETTY_PRINT));
        //$layout = Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('admin') ? 'layouts.admin_template' : 'layouts.template';
        //return view('mi_vista', compact('layout'));

        return view('administracion.AdminReservas.edicionReserva',compact('departamentos','comunidades','tipoEntradas','formulario','layout'));
    }

    /**
     * Update the specified resource in storage.
     * actualizar un objeto formulario
     * update usuario
     */
    public function update($idReserva,$idForm,Request $request)
    {
      //   dd($request->all());
                    // Validaciones del request
            try {
                //code...
                $request->validate([
                    'tipo_entrada' => 'required|exists:tipo_entradas,id', 
                    'comunidad' => 'required|exists:comunidads,id',
                    'ruta_turistica' => 'required|exists:ruta_turisticas,id',
                    
                    'nombre' => 'required|regex:/^[\pL\s]+$/u|max:255',
                    'ci' => 'nullable|regex:/^\d+$/|max:255', // Solo números
                    'edad' => 'required|numeric|min:1|max:100', 
                    'tiempoEstadia' => 'required|numeric|min:1',
                    'nacionalidad' => 'nullable|string|max:100',
                    'pasaporte' => 'nullable|regex:/^[a-zA-Z0-9]+$/|max:50', // Alfanumérico
                ]);
            } catch (Exception $th) {
                return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');   
            }

            $valorTipoEntrada=$request->tipo_entrada;
            $bool=FormularioController::validacionUpdateAdmin($idForm,$valorTipoEntrada,$request);
         //   dd($request->all());
            if($bool){

                // Buscar el formulario por su ID
                $formulario = Formulario::findOrFail($idForm);
                //si cambio el tipo de entrada cambia el estado a pendiente
                if($formulario->tipo_entrada_id!=(int)$request->tipo_entrada){
                    $formulario->estado="PENDIENTE";
                    $formulario->bandera=true;
                }
    
                // Asignación masiva de los campos comunes
                try {
                    // Obtener la hora actual en formato H:i:s
                    $horaActual = date('H:i:s');
    
                    // Concatenar la fecha y la hora
                    $fechaCompleta = new DateTime($request->fecha_reserva . ' ' . $horaActual);
                    
                    $formulario->fill([
                        'nombre' => $request->nombre,
                        'edad' => $request->edad,
                        'tiempoEstadia' => $request->tiempoEstadia,
                        'tipo_entrada_id' => $request->tipo_entrada,
                        'comunidad_id' => $request->comunidad,
                        'ruta_turistica_id' => $request->ruta_turistica,
                        'fechaReserva' => $fechaCompleta,
                    ]);
                    
    
    
                    // Aplicar campos condicionales según el tipo de entrada
                    switch ($request->tipo_entrada) {
                        case '1': // Estudiante
                        case '3': // Nacional
                            $formulario->ci = $request->ci;
                            $formulario->departamento_id = $request->departamento;
                            break;
                        
                        case '2': // Extranjero
                        case '4': // Extranjero-Menor
                            $formulario->pasaporte = $request->pasaporte;
                            $formulario->nacionalidad = $request->nacionalidad;
                            break;
                    }
                    
                    // Guardar los cambios o ya con esto lo actualizas
                    $formulario->save();
                } catch (Exception $th) {
                    echo($th);
                    //throw $th;
                }
                //return redirect()->route('usuario.show.detalle',['id'=>$idReserva])->with('success','Formulario Actualizado con Exito');
                return redirect()->back()->with('success', 'La Actualizacion se realizó correctamente.')->with('source','edicionFormulario');
            }else{
                return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');
            }

    }


    public static function validacionUpdate($idTipoEntrada,Request $request):bool{
        /*if($idTipoEntrada==='1'||$idTipoEntrada==='3'){//nacional o estudiante, no importa nacionalidad ni pasaporte
            if($request->tipo_entrada!==null&& $request->departamento!==null
            &&$request->comunidad!==null&&$request->ruta_turistica!==null&&$request->nombre!==null
            &&$request->ci!==null&&$request->tiempoEstadia!==null&&$request->fecha_reserva!==null){
                $esValidaLaFecha=FormularioController::esValidaLaFecha($request->fecha_reserva);
                //$esEdadValida=true;
                if($idTipoEntrada==='1'){//entonces es estudiante 
                    $esEdadValida=(int)$request->edad<=18&&$request->edad>0;
                }else{  
                    $esEdadValida=(int)$request->edad<=100&&$request->edad>0;
                }
                return $esValidaLaFecha&&$esEdadValida;
            }
        }
        return false;*/
         // Validar campos requeridos básicos
         if($idTipoEntrada=='1'||$idTipoEntrada=='3'){//nacional o estudiante
             if (!self::camposRequeridosPresentes($request)) {
                 return false;
             }
         }else{//nacional o extranjero
            if(!self::camposRequeridosPresentesParaExtranjeros($request)){
                return false;
            }
         }

        // Validar fecha
        if (!self::esValidaLaFecha($request->fecha_reserva)) {
            return false;
        }

        // Validar edad según el tipo de entrada
        if ($idTipoEntrada == '1' || $idTipoEntrada=='4') { // Estudiante
            return self::esEdadValida((int)$request->edad, 0, 18);
        }else if ($idTipoEntrada == '3' || $idTipoEntrada=='2') { // Nacional
            return self::esEdadValida((int)$request->edad, 0, 100);
        }

        return false; // Otros casos no válidos
    }

    public static function validacionUpdateAdmin($idForm,$idTipoEntrada,Request $request):bool{
        /*if($idTipoEntrada==='1'||$idTipoEntrada==='3'){//nacional o estudiante, no importa nacionalidad ni pasaporte
            if($request->tipo_entrada!==null&& $request->departamento!==null
            &&$request->comunidad!==null&&$request->ruta_turistica!==null&&$request->nombre!==null
            &&$request->ci!==null&&$request->tiempoEstadia!==null&&$request->fecha_reserva!==null){
                $esValidaLaFecha=FormularioController::esValidaLaFecha($request->fecha_reserva);
                //$esEdadValida=true;
                if($idTipoEntrada==='1'){//entonces es estudiante 
                    $esEdadValida=(int)$request->edad<=18&&$request->edad>0;
                }else{  
                    $esEdadValida=(int)$request->edad<=100&&$request->edad>0;
                }
                return $esValidaLaFecha&&$esEdadValida;
            }
        }
        return false;*/
         // Validar campos requeridos básicos
         if($idTipoEntrada=='1'||$idTipoEntrada=='3'){//nacional o estudiante
             if (!self::camposRequeridosPresentes($request)) {
                 return false;
             }
         }else{//nacional o extranjero
            if(!self::camposRequeridosPresentesParaExtranjeros($request)){
                return false;
            }
         }

        // Validar fecha
        $formularioActual=Formulario::findOrFail($idForm);
        //dd(Carbon::parse($formularioActual->fechaReserva)->format('Y-m-d')===($request->fecha_reserva));
        
         //si a actualizar es diferente al que esta en la base de datos y es ademas una fecha valida >= hoy
        if (Carbon::parse($formularioActual->fechaReserva)->format('Y-m-d')!==($request->fecha_reserva)
            &&!self::esValidaLaFecha($request->fecha_reserva)){
                return false;
            }
        

        // Validar edad según el tipo de entrada
        if ($idTipoEntrada == '1' || $idTipoEntrada=='4') { // Estudiante
            return self::esEdadValida((int)$request->edad, 0, 18);
        }else if ($idTipoEntrada == '3' || $idTipoEntrada=='2') { // Nacional
            return self::esEdadValida((int)$request->edad, 0, 100);
        }

        return false; // Otros casos no válidos
    }

    public static function esValidaLaFecha(string $date): bool
    {
        $today = date('Y-m-d'); // Obtiene la fecha actual en formato "YYYY-MM-DD".
        return $date >= $today;
    }


    private static function camposRequeridosPresentesParaExtranjeros(Request $request): bool
    {
        $campos = [
            'tipo_entrada',
            'comunidad',
            'ruta_turistica',
            'nombre',
            'pasaporte',
            'tiempoEstadia',
            'fecha_reserva',
            'nacionalidad'
        ];

        foreach ($campos as $campo) {
            if (empty($request->$campo)) {
                return false;
            }
        }

        return true;
    }
    private static function camposRequeridosPresentes(Request $request): bool
    {
        $campos = [
            'tipo_entrada',
            'departamento',
            'comunidad',
            'ruta_turistica',
            'nombre',
            'ci',
            'tiempoEstadia',
            'fecha_reserva'
        ];

        foreach ($campos as $campo) {
            if (empty($request->$campo)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valida si una edad está dentro de un rango específico.
     */
    private static function esEdadValida(int $edad, int $min, int $max): bool
    {
        return $edad >= $min && $edad <= $max;
    }
    /**
     * Update the specified resource in storage.
     * actualizar un objeto formulario
     */
    public function updateAdmin($idReserva,$idForm,Request $request)
    {
      //  dd($request->all(),$idForm,$idReserva);
                    // Validaciones del request
            /*$request->validate([
                'tipo_entrada' => 'required|exists:tipo_entradas,id', 
                'comunidad' => 'required|exists:comunidads,id',
                'ruta_turistica' => 'required|exists:ruta_turisticas,id',
                'nombre' => 'required|string|max:255',
                'ci' => 'nullable|string|max:255',
                'edad' => 'required|numeric|min:1|max:120',
                'tiempoEstadia' => 'required|numeric|min:1',
                'nacionalidad' => 'nullable|string|max:100',
                'pasaporte' => 'nullable|string|max:50',
            ]);
            // Obtener la hora actual en formato H:i:s
            $horaActual = date('H:i:s');

            // Concatenar la fecha y la hora
            $fechaCompleta = new DateTime($request->fecha_reserva . ' ' . $horaActual);
            // Buscar el formulario por su ID
            $formulario = Formulario::findOrFail($idForm);
            //dd($formulario->tipo_entrada_id,(int)$request->tipo_entrada);
            if($formulario->tipo_entrada_id!=(int)$request->tipo_entrada  ){
                $formulario->estado="PENDIENTE";
                $formulario->bandera=true;
            }
            // Asignación masiva de los campos comunes
            try {
                

                $formulario->fill([
                    'nombre' => $request->nombre,
                    'edad' => $request->edad,
                    'tiempoEstadia' => $request->tiempoEstadia,
                    'tipo_entrada_id' => $request->tipo_entrada,
                    'comunidad_id' => $request->comunidad,
                    'ruta_turistica_id' => $request->ruta_turistica,
                    'fechaReserva' => $fechaCompleta,
                ]);
    
                // Aplicar campos condicionales según el tipo de entrada
                switch ($request->tipo_entrada) {
                    case '1': // Estudiante
                    case '3': // Nacional
                        $formulario->ci = $request->ci;
                        $formulario->departamento_id = $request->departamento;
                        break;
                    
                    case '2': // Extranjero
                    case '4': // Extranjero-Menor
                        $formulario->pasaporte = $request->pasaporte;
                        $formulario->nacionalidad = $request->nacionalidad;
                        break;
                }
    
                // Guardar los cambios o ya con esto lo actualizas
                $formulario->save();
            } catch (Exception $th) {
                echo($th);
                //throw $th;
            }
            return redirect()->back()->with('success','Formulario Actualizado con Exito');
            //return redirect()->back()->with('success', 'La operación se realizó correctamente.');
            //redirect(url()->previous());*/
            //   dd($request->all());
                    // Validaciones del request
                    try {
                        //code...
                        $request->validate([
                            'tipo_entrada' => 'required|exists:tipo_entradas,id', 
                            'comunidad' => 'required|exists:comunidads,id',
                            'ruta_turistica' => 'required|exists:ruta_turisticas,id',
                            
                            'nombre' => 'required|regex:/^[\pL\s]+$/u|max:255',
                            'ci' => 'nullable|regex:/^\d+$/|max:255', // Solo números
                            'edad' => 'required|numeric|min:1|max:100', 
                            'tiempoEstadia' => 'required|numeric|min:1',
                            'nacionalidad' => 'nullable|string|max:100',
                            'pasaporte' => 'nullable|regex:/^[a-zA-Z0-9]+$/|max:50', // Alfanumérico
                        ]);
                    } catch (Exception $th) {
                        return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');   
                    }
        
                    $valorTipoEntrada=$request->tipo_entrada;
                    $bool=FormularioController::validacionUpdateAdmin($idForm,$valorTipoEntrada,$request);
                 //   dd($request->all());
                    if($bool){
        
                        // Buscar el formulario por su ID
                        $formulario = Formulario::findOrFail($idForm);
                        //si cambio el tipo de entrada cambia el estado a pendiente
                        if($formulario->tipo_entrada_id!=(int)$request->tipo_entrada){
                            $formulario->estado="PENDIENTE";
                            $formulario->bandera=true;
                        }
            
                        // Asignación masiva de los campos comunes
                        try {
                            // Obtener la hora actual en formato H:i:s
                            $horaActual = date('H:i:s');
            
                            // Concatenar la fecha y la hora
                            $fechaCompleta = new DateTime($request->fecha_reserva . ' ' . $horaActual);
                            
                            $formulario->fill([
                                'nombre' => $request->nombre,
                                'edad' => $request->edad,
                                'tiempoEstadia' => $request->tiempoEstadia,
                                'tipo_entrada_id' => $request->tipo_entrada,
                                'comunidad_id' => $request->comunidad,
                                'ruta_turistica_id' => $request->ruta_turistica,
                                'fechaReserva' => $fechaCompleta,
                            ]);
                            
            
            
                            // Aplicar campos condicionales según el tipo de entrada
                            switch ($request->tipo_entrada) {
                                case '1': // Estudiante
                                case '3': // Nacional
                                    $formulario->ci = $request->ci;
                                    $formulario->departamento_id = $request->departamento;
                                    break;
                                
                                case '2': // Extranjero
                                case '4': // Extranjero-Menor
                                    $formulario->pasaporte = $request->pasaporte;
                                    $formulario->nacionalidad = $request->nacionalidad;
                                    break;
                            }
                            
                            // Guardar los cambios o ya con esto lo actualizas
                            $formulario->save();
                        } catch (Exception $th) {
                            echo($th);
                            //throw $th;
                        }
                        //return redirect()->route('usuario.show.detalle',['id'=>$idReserva])->with('success','Formulario Actualizado con Exito');
                        return redirect()->back()->with('success', 'La Actualizacion se realizó correctamente.')->with('source','edicionFormulario');
                    }else{
                        return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');
                    }


            /*try {
                //code...
                $request->validate([
                    'tipo_entrada' => 'required|exists:tipo_entradas,id', 
                    'comunidad' => 'required|exists:comunidads,id',
                    'ruta_turistica' => 'required|exists:ruta_turisticas,id',
                    
                    'nombre' => 'required|regex:/^[\pL\s]+$/u|max:255',
                    'ci' => 'nullable|regex:/^\d+$/|max:255', // Solo números
                    'edad' => 'required|numeric|min:1|max:100', 
                    'tiempoEstadia' => 'required|numeric|min:1',
                    'nacionalidad' => 'nullable|string|max:100',
                    'pasaporte' => 'nullable|regex:/^[a-zA-Z0-9]+$/|max:50', // Alfanumérico
                ]);
            } catch (Exception $th) {
                return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');   
            }

            $valorTipoEntrada=$request->tipo_entrada;
            $bool=FormularioController::validacionUpdate($valorTipoEntrada,$request);
         //   dd($request->all());
            if($bool){

                // Buscar el formulario por su ID
                $formulario = Formulario::findOrFail($idForm);
                //si cambio el tipo de entrada cambia el estado a pendiente
                if($formulario->tipo_entrada_id!=(int)$request->tipo_entrada){
                    $formulario->estado="PENDIENTE";
                    $formulario->bandera=true;
                }
    
                // Asignación masiva de los campos comunes
                try {
                    // Obtener la hora actual en formato H:i:s
                    $horaActual = date('H:i:s');
    
                    // Concatenar la fecha y la hora
                    $fechaCompleta = new DateTime($request->fecha_reserva . ' ' . $horaActual);
                    
                    $formulario->fill([
                        'nombre' => $request->nombre,
                        'edad' => $request->edad,
                        'tiempoEstadia' => $request->tiempoEstadia,
                        'tipo_entrada_id' => $request->tipo_entrada,
                        'comunidad_id' => $request->comunidad,
                        'ruta_turistica_id' => $request->ruta_turistica,
                        'fechaReserva' => $fechaCompleta,
                    ]);
                    
    
    
                    // Aplicar campos condicionales según el tipo de entrada
                    switch ($request->tipo_entrada) {
                        case '1': // Estudiante
                        case '3': // Nacional
                            $formulario->ci = $request->ci;
                            $formulario->departamento_id = $request->departamento;
                            break;
                        
                        case '2': // Extranjero
                        case '4': // Extranjero-Menor
                            $formulario->pasaporte = $request->pasaporte;
                            $formulario->nacionalidad = $request->nacionalidad;
                            break;
                    }
                    
                    // Guardar los cambios o ya con esto lo actualizas
                    $formulario->save();
                } catch (Exception $th) {
                    echo($th);
                    //throw $th;
                }
                //return redirect()->route('usuario.show.detalle',['id'=>$idReserva])->with('success','Formulario Actualizado con Exito');
                return redirect()->back()->with('success', 'La Actualizacion se realizó correctamente.')->with('source','edicionFormulario');
            }else{
                return redirect()->back()->with('error', 'Hubo un error al actualizar los datos, verifique los datos nuevamente por favor.')->with('source','edicionFormulario');
            }*/


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $formulario=Formulario::findOrFail($id);
        $formulario->delete();
        return redirect()->back()->with('success','borrado con exito');
    }

    /*funcion para ver los roles de un usuario */
    public function k(){
        //$usuario = Auth::guard('usuarios')->user();
        $roles = usuario::findOrFail(Auth::id())->getRoleNames()->first();
        dd($roles); // Debería imprimir los roles asignados al usuario

        
    }


    public function mostrarFormulariosPendientesPorComunidad(){
        $guardaparque = Guardaparque::find(Auth::id()); // Obtener el guardaparque por su ID

        //para obtener los id de las comunidades donde esta a cargo el guardaparque
        $idComunidadesDelGuardaparque=$guardaparque->supervisas->pluck('comunidad_id');
        // ahora la consulta sql para obtener los formularios que coincidan con las comunidades del guardaparque 
        $formularios=Formulario::whereIn('comunidad_id',$idComunidadesDelGuardaparque)->where('estado','PENDIENTE')->paginate(10);

        $estado="PENDIENTES";
        return view('usuarios.FormulariosDiarios.formulariosPendientesPorComunidad',compact('formularios','estado'));
    }


    public function mostrarFormulariosPagadosPorComunidad(){
        $guardaparque = Guardaparque::find(Auth::id()); // Obtener el guardaparque por su ID

        //para obtener los id de las comunidades donde esta a cargo el guardaparque
        $idComunidadesDelGuardaparque=$guardaparque->supervisas->pluck('comunidad_id');
        
        // ahora la consulta sql para obtener los formularios que coincidan con las comunidades del guardaparque 
        $formularios=Formulario::whereIn('comunidad_id',$idComunidadesDelGuardaparque)->where('estado','PAGADO')->paginate(10);
        $estado="PAGADO";
        return view('usuarios.FormulariosDiarios.formulariosPendientesPorComunidad',compact('formularios','estado'));
    }


    //logica de graficas


    public function obtenerVentasGenerica(Request $request){
        
        /*$filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];
    
        // Usar Query Builder
        $formulariosVendidos = DB::table('formularios')
            ->where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->count();
    
        return response()->json(['totalVentas' => $formulariosVendidos]);*/
        $filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];
    
        // Consulta con Eloquent
        $formulariosVendidos = Formulario::where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->count();
    
        return response()->json(['totalVentas' => $formulariosVendidos]);
    }

    public function obtenerGananciasGenerica(Request $request){
        
        
        $filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];
    
        // Consulta con Eloquent
        $totalGanancias = Formulario::where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->with('tipoEntrada')
            ->get()
            ->sum(function ($formulario){
                return $formulario->tipoEntrada->precio;
            });
    
        return response()->json(['totalGanancias' => $totalGanancias]);
    }

    public function obtenerCantidadModalidadesPago(Request $request){
        //return response()->json(['sexo'=>$request->filtro]);
        $filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];

        $cantidadMixto=$this->obtenerPagosMixtos($fechaInicio,$fechaFin);
        
        $cantidadQR=$this->obtenerPagosPorModalidad("QR",$fechaInicio,$fechaFin)-$cantidadMixto;
        
        $cantidadEfectivo=$this->obtenerPagosPorModalidad("EFECTIVO",$fechaInicio,$fechaFin)-$cantidadMixto;
        
        //return response()->json(['sexo'=>$cantidadMixto]);

        return response()->json(['cantidadQR'=>$cantidadQR,'cantidadEfectivo'=>$cantidadEfectivo,'cantidadMixto'=>$cantidadMixto]);
        
    }
    public function obtenerPagosPorModalidad($modalidad,$fechaInicio,$fechaFin){
        return Formulario::where('estado','PAGADO')->whereBetween('fechaIngreso',[$fechaInicio,$fechaFin])
        ->whereHas('pagos',function($query) use ($modalidad){
            $query->where('nombre',$modalidad);
        })->count();
        /*return Formulario::where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->whereHas('pagos', function ($query) use ($modalidad) {
                $query->select('formulario_id')
                    ->groupBy('formulario_id')
                    ->where('nombre',$modalidad)
                    ->havingRaw('COUNT(*) = 1');
            })
            ->count();*/
    }
    public function obtenerPagosMixtos($fechaInicio, $fechaFin)
    {
        return Formulario::where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->whereHas('pagos', function ($query) {
                $query->select('formulario_id')
                    ->groupBy('formulario_id')
                    ->havingRaw('COUNT(*) = 2');
            })
            ->count();
    }

    public function obtenerVisitantesDeComunidades(Request $request){
        $filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];
         // Obtener datos agrupados por comunidad
      /*      $visitantesPorComunidad = Formulario::where('estado', 'PAGADO')
            ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
            ->with('comunidads') // Relación con la comunidad
            ->selectRaw('comunidad_id, COUNT(*) as nro_visitantes')
            ->groupBy('comunidad_id')
            ->get();

        // Añadir información de las comunidades
        $resultados = $visitantesPorComunidad->map(function ($item) {
            return [
                'id' => $item->comunidad->id ?? null,
                'nombre' => $item->comunidad->nombre ?? 'Sin nombre',
                'zona' => $item->comunidad->zona ?? 'Sin zona',
                'nro_visitantes' => $item->nro_visitantes,
            ];
        });*/
         // Consulta con left join para incluir todas las comunidades
        $visitantesPorComunidad = Comunidad::leftJoin('formularios', function ($join) use ($fechaInicio, $fechaFin) {
            $join->on('comunidads.id', '=', 'formularios.comunidad_id')
                ->where('formularios.estado', 'PAGADO')
                ->whereBetween('formularios.fechaIngreso', [$fechaInicio, $fechaFin]);
        })
            ->selectRaw('comunidads.id, comunidads.nombre, comunidads.zona, COUNT(formularios.id) as nro_visitantes')
            ->groupBy('comunidads.id', 'comunidads.nombre', 'comunidads.zona')
            ->get();

        
        return response()->json($visitantesPorComunidad);
        

    }
    public function obtenerVentasGraficasGenericas(Request $request){
        $filtro = $request->input('filtro'); // "hoy", "mes", "año"
        $hoy = now('America/La_Paz');
    
        // Mapear los rangos de tiempo
        $rangos = [
            'hoy' => [$hoy->copy()->startOfDay(), $hoy->copy()->endOfDay()],
            'mes' => [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()],
            'año' => [$hoy->copy()->startOfYear(), $hoy->copy()->endOfYear()],
        ];
    
        if (!array_key_exists($filtro, $rangos)) {
            return response()->json(['error' => 'Filtro no válido'], 400);
        }
    
        [$fechaInicio, $fechaFin] = $rangos[$filtro];

        // Agrupar según el filtro
        $ventas = Formulario::where('estado', 'PAGADO')
        ->whereBetween('fechaIngreso', [$fechaInicio, $fechaFin])
        ->selectRaw(
            $filtro === 'hoy' ? 'HOUR(fechaIngreso) as label, COUNT(*) as total' :
            ($filtro === 'mes' ? 'DAY(fechaIngreso) as label, COUNT(*) as total' :
            'MONTH(fechaIngreso) as label, COUNT(*) as total')
        )
        ->groupBy('label')
        ->orderBy('label')
        ->get();


        // Formatear los datos para la gráfica
        $labels = $ventas->pluck('label')->map(function ($label) use ($filtro) {
            if ($filtro === 'hoy') {
                return $label . ':00'; // Horas (ejemplo: "13:00")
            } elseif ($filtro === 'mes') {
              //  $dias=[1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado',7=>'Domingo'];
                
                //return $dias[$label]??'dia ' . $label; // Días (ejemplo: "Día 5")
                return 'Día ' . $label; // Días (ejemplo: "Día 5")
            } else {
                // Convertir números de meses a nombres
                $meses = [
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ];
                return $meses[$label] ?? 'Mes ' . $label; // Meses (ejemplo: "Enero")
            }
        });
        $data = $ventas->pluck('total');

        return response()->json(['labels' => $labels, 'data' => $data]);

    }
    public function getBladePractica(){
        return view('administracion.practica-Si1.practica');
    }
}
