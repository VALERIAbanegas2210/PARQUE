<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\BitacoraGuardaparqueController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\GuardaparqueController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RutaTuristicaController;
use App\Http\Controllers\SupervisaController;
use App\Http\Controllers\TipoEntradaController;
use App\Models\comunidad;
use App\Models\Entrada;
use App\Models\Formulario;
use App\Models\Guardaparque;
use App\Models\Horario;
use App\Models\Supervisa;
use App\Models\tipo_entrada;


// Ruta para la página de inicio
Route::get('/', function () {
    return redirect()->route('user.usuariotemplate');
});

// Rutas de usuario
Route::prefix('user')->group(function () {
    Route::get('/usuariotemplate', function () {
        return view('usuarioTemplate.index');
    })->name('user.usuariotemplate');

    Route::middleware(['auth:usuarios'])->group(function () {
        // Ruta para la vista del perfil del usuario
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('usuarios.perfil');
        Route::delete('/delete-profile-image', [UsuarioController::class, 'deleteProfileImage'])->name('deleteProfileImage');
        Route::put('/update-profile', [UsuarioController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        //aca se dispara para acutualizar a un usuario
        Route::put('/usuarios/admin/{id}', [UsuarioController::class, 'updateAdmin'])->name('usuarios.admin.update');
        // Rutas para las comunidades
        // Ruta para acceder a la comunidad
        Route::get('/comunidad/villa_amboro/{id}', [ComunidadController::class, 'show_villa_amoboro'])->name('comunidad.show_villa_amoboro');
        Route::get('/comunidad/jardin_de_las_delicias/{id}', [ComunidadController::class, 'show_jardin_de_las_delicias'])->name('comunidad.show_jardin_de_las_delicias');
        Route::get('/comunidad/la_chonta/{id}', [ComunidadController::class, 'show_la_chonta'])->name('comunidad.show_la_chonta');
        Route::get('/comunidad/mataracu/{id}', [ComunidadController::class, 'show_mataracu'])->name('comunidad.show_mataracu');
        Route::get('/comunidad/oriente/{id}', [ComunidadController::class, 'show_oriente'])->name('comunidad.show_oriente');

        //comentarios
        Route::post('/comunidad/mataracu/comentar',[ComentarioController::class,'store'])->name('comentarios.store');
        Route::put('/comunidad/mataracu/actualizar/{id}',[ComentarioController::class,'update'])->name('comentarios.update');
        Route::delete('/comunidad/mataracu/comentar/eliminar/{id}',[ComentarioController::class,'destroy'])->name('comentarios.destroy');

        //para vista guardaparque
        Route::get('/guardaparque/horarioAsignado/{id}',[GuardaparqueController::class,'showModificado'])->name('usuarios.guardaparque.verHorario');

        //para hacer la reserva
        Route::get('/formulario/crear',[FormularioController::class,'create'])->name('usuario.formulario.create');

        Route::match(['get','post'],'/formulario/resumen',[FormularioController::class,'showResumen'])->name('usuario.formulario.resumen');
        //con esto guardo reservas
        Route::post('/formulario/enviarReservas',[ReservaController::class,'store'])->name('usuario.formularios.guardarReservas');

        //mostrar las reservas pendientes del usuario especifico el id esta dentro del controlador
        Route::get('/usuario-reservas',[ReservaController::class,'userShowReservas'])->name('usuario.show.reserva');

        //para mostrar el detalle o formularios hechos en una reserva
        Route::get('/usuario-reservas-edit/{id}',[ReservaController::class,'userEditReserva'])->name('usuario.show.detalle');

        //para eliminar una reserva
        Route::delete('/reservas/eliminar/{id}',[ReservaController::class,'destroy'])->name('usuario.delete.reserva');
        
        //al editar una reserva es editar un formulario //solo es vista
        Route::get('/reservas/{idReserva}/formulario/{idForm}',[FormularioController::class,'edit'])->name('usuario.editar.formulario');
        //para eliminar un objeto formulario
        Route::delete('/reservas/formulario/eliminar/{id}',[FormularioController::class,'destroy'])->name('usuario.eliminar.formulario');
        //para actualizar el formulario
        Route::put('/reservas/{idReserva}/formulario/{idForm}/actualizar',[FormularioController::class,'update'])->name('usuario.update.formulario');
        
        //prueba par guardaparque
        Route::get('/pruebilla',[FormularioController::class,'k'])->name('usuarios.k');

        //creo que estos son pa admin xd

        //ruta para desplegar los formularios pendientes por comunidad
        Route::get('/reservas/formularios-pendientes-comunidad',[FormularioController::class,'mostrarFormulariosPendientesPorComunidad'])->name('usuario.formulariosPendientes.comunidad');

        //ruta para desplegar los formularios pagados por comunidad
        Route::get('/reservas/formularios-pagados-comunidad',[FormularioController::class,'mostrarFormulariosPagadosPorComunidad'])->name('usuario.formulariosPagados.comunidad');



        //ruta para mostrar las reservas pagadas donde vera el detalle pero no podra editar
        Route::get('/reservas/misReservasPagadas',[ReservaController::class,'mostrarReservasPagadasDelUsuario'])->name('usuario.reservasPagadas');

        Route::get('/mis-reservas-pagadas-show/{id}',[ReservaController::class,'userEditReservaPagadas'])->name('usuario.show.detalle.pagado');

        //ruta para mostrar los formularios donde incluyeron a esta persona
        Route::get('/actividadEnCurso',[FormularioController::class,'mostrarActividadEnCurso'])->name('usuario.actividadEnCurso');

        //ruta para agregar la imagen,el id comentario viene implicito
        Route::post('/comentarios/imagenes/agregar', [ImagenController::class, 'store'])->name('comentarios.imagenes.agregar');
        //ruta para eliminar la imagen
        Route::delete('/comentarios/imagenes/eliminar/{id}', [ImagenController::class, 'destroy'])->name('comentarios.imagenes.eliminar');

        Route::get('/usuario', function () {
            return view('usuarios.comunidad.villa_amboro');
        })->name('comunidades.villa_amboro');
        // Ruta para layouts de usuario
        Route::get('/layouts', function () {
            return view('layouts.template');
        })->name('layouts.template');

    });
});

// Rutas de administración
//prefix<=>RequestMapping()
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdministradorController::class, 'login'])->name('administracion.login');
    Route::get('/verification', [AuthController::class, 'showVerificationForm'])->name('verification.form');
    Route::get('/registro', [AdministradorController::class, 'registro'])->name('administracion.registro');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Rutas de roles
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.Roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.Roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('admin.Roles.store');
    Route::get('/roles/edit/{role}', [RoleController::class, 'edit'])->name('admin.Roles.edit');
    Route::post('/roles/update/{role}', [RoleController::class, 'update'])->name('admin.Roles.update');
    Route::delete('/roles/delete/{role}', [RoleController::class, 'destroy'])->name('admin.Roles.delete');
    Route::get('/usuarios/tipo_entrada', [TipoEntradaController::class, 'usuariosIndex'])->name('usuarios.tipo_entrada');

    Route::get('/layouts', function () {
        return view('layouts.admin_template');
    })->name('layouts.admin_template');

    //para guardaparques 
    //formulario para crear guardaparques
    Route::get('/guardaparque/crearGuardaParque',[GuardaparqueController::class,'create'])->name('admin.guardaparque.create');
    //para almacenar el guardaparques
    Route::post('/guardaparque/store',[GuardaparqueController::class,'store'])->name('admin.guardaparque.store');
    //para obtener todos los guardaparques
    Route::get('/guardaparques',[GuardaparqueController::class,'index'])->name('admin.guardaparque.index');
    //para eliminar un guardaparque
    Route::delete('guardaparque/delete/{guardaparque}',[GuardaparqueController::class,'destroy'])->name('admin.guardaparque.delete');
    //para editar el guardaparque
    Route::get('/guardaparque/edit/{guardaparque}',[GuardaparqueController::class,'edit'])->name('admin.guardaparque.edit');

    Route::patch('/guardaparque/update/{id}',[GuardaparqueController::class,'update'])->name('admin.guardaparque.update');

    //para eliminar un supervisa
    Route::delete('/guardaparque/supervisa/delete/{id}',[SupervisaController::class,'destroy']);
    //para eliminar un horario
    Route::delete('/guardaparque/horario/delete/{id}',[HorarioController::class,'destroy']);
    //para actualizar un horario
    Route::patch('/guardaparque/horario/update/{id}', [HorarioController::class, 'update'])->name('admin.guardaparque.horario.update');
    //para obtener un horario dado el id
    Route::get('/guardaparque/horario/get/{id}',[HorarioController::class,'get']);

    //para crear un supervisa
    Route::post('/guardaparque/supervisa/store',[SupervisaController::class,'store'])->name('admin.guardaparque.supervisa.create');

    //para eliminar el supervisa
    Route::delete('/guardaparque/supervisa/delete/{id}',[SupervisaController::class,'destroy']);

    Route::get('/guardarparque/bitacora/{id}',[BitacoraGuardaparqueController::class,'show'])->name('admin.guardaparque.bitacoraGuarda');
    Route::get('/guardaparque/bitacoras',[BitacoraGuardaparqueController::class,'index'])->name('admin.guardparque.bitacorasGuardaparques');

    //TRABAJO VALERIA
    
    Route::get('/rutas/index', [RutaTuristicaController::class,'adminIndex'])->name('admin.rutas.index');

    Route::get('/rutas/{id}', [RutaTuristicaController::class,'show'])->name('rutas.show');
    
    Route::post('/rutas/store', [RutaTuristicaController::class,'store'])->name('admin.rutas.store');
    // Ruta para el usuario - Vista solo para ver las rutas sin opciones de modificación
    //Route::get('/user/rutas', [RutaTuristicaController::class, 'userIndex'])->name('user.rutas.index');
    Route::put('/rutas/{id}', [RutaTuristicaController::class,'update'])->name('admin.rutas.update');
    Route::delete('/rutas/{id}', [RutaTuristicaController::class,'destroy'])->name('admin.rutas.destroy');


    //ruta para obtener las rutas turisticas de una determinada comunidad
    Route::get('/comunidad/ruta/{id}',[ComunidadController::class,'mostrarRutasDeComunidad'])->name('route.mostrarRutasDeComunidades');
    /*

        Route::get('/rutas/{id}', [RutaController::class, 'show'])->name('rutas.show');
        Route::get('/administradores/rutas', [RutaController::class, 'adminIndex'])->name('admin.rutas.index');
        // Ruta para almacenar una nueva ruta (administrador)
        Route::post('/administradores/rutas', [RutaController::class, 'store'])->name('admin.rutas.store');
        // Ruta para el usuario - Vista solo para ver las rutas sin opciones de modificación
        Route::get('/user/rutas', [RutaController::class, 'userIndex'])->name('user.rutas.index');
        Route::put('/administradores/rutas/{id}', [RutaController::class, 'update'])->name('admin.rutas.update');
        Route::delete('/administradores/rutas/{id}', [RutaController::class, 'destroy'])->name('admin.rutas.destroy');

     */

    
    //para crear un supervisa o asignacion de horario
  //  Route::put('/guardaparque/supervisa/edit',[Supervisa::class,'edit'])->name('admin.guardaparque.supervisa.update');
    //para actualizar un supervisa 
    //Route::get('/guardaparque/{guardaparque}/supervisa/crearAsignacion',[Supervisa::class,'create'])->name('admin.guardaparque.supervisa.create');

    /* 
    //para hacer la reserva
        Route::get('/formulario/crear',[FormularioController::class,'create'])->name('usuario.formulario.create');

        
        
        
        //para eliminar una reserva
        Route::delete('/reservas/eliminar/{id}',[ReservaController::class,'destroy'])->name('usuario.delete.reserva');
        
        //para eliminar un objeto formulario
        Route::delete('/reservas/formulario/eliminar/{id}',[FormularioController::class,'destroy'])->name('usuario.eliminar.formulario');
        //para actualizar el formulario
        Route::put('/reservas/{idReserva}/formulario/{idForm}/actualizar',[FormularioController::class,'update'])->name('usuario.update.formulario');
        */
        //formularios de reservas
        Route::get('/formulario/crear',[FormularioController::class,'adminCreate'])->name('admin.formulario.create')->middleware(['auth:usuarios']);
        //front de resumen de reserva hecha
        //
        Route::match(['get','post'],'/formulario/resumen',[FormularioController::class,'showAdminResumen'])->name('admin.formulario.resumen')->middleware(['auth:usuarios']);
        //con esto guardo reservas
        Route::post('/formulario/enviarReservas',[ReservaController::class,'adminStore'])->name('admin.formularios.guardarReservas')->middleware(['auth:usuarios']);
        //mostrar las reservas pendientes del usuario especifico el id esta dentro del controlador
        Route::get('/reservas/pendientes',[ReservaController::class,'adminShowReservasPendientes'])->name('admin.show.reserva.pendiente')->middleware(['auth:usuarios']);
        //para mostrar las reservas pagadas del admin,generalmente esta se va usar
        Route::get('/reservas/pagadas',[ReservaController::class,'adminShowReservasPagadas'])->name('admin.show.reserva.pagada')->middleware(['auth:usuarios']);

        //para mostrar el detalle o formularios hechos en una reserva
        Route::get('/admin-reservas-edit/{id}',[ReservaController::class,'adminEditReserva'])->name('admin.show.detalle')->middleware(['auth:usuarios']);

        //al editar una reserva es editar un formulario //solo es vista
        Route::get('/reservas/{idReserva}/formulario/{idForm}',[FormularioController::class,'adminEdit'])->name('admin.editar.formulario')->middleware(['auth:usuarios']);;
        
        //para actualizar el formulario
        Route::put('/reservas/{idReserva}/formulario/{idForm}/actualizar',[FormularioController::class,'updateAdmin'])->name('admin.update.formulario')->middleware(['auth:usuarios']);;

        //para mostrar el pago realizado por un formulario
        //pasandole el id del formulario
        Route::get('/reservas/pagos/{id}',[PagoController::class,'edit'])->name('admin.editar.pagos.formulario')->middleware(['auth:usuarios']);;

        //aun no funcionan

        // Ruta para editar los pagos del usuario
        Route::get('/pagos/{idFormulario}', [PagoController::class, 'edit'])->name('admin.editar.pagos.formulario')->middleware(['auth:usuarios']);;

        // Ruta para actualizar un pago específico
        Route::put('/pagos/{idPago}', [PagoController::class, 'update'])->name('admin.actualizar.pago')->middleware(['auth:usuarios']);;

        // Ruta para eliminar un pago específico
        Route::delete('/pagos/{idPago}', [PagoController::class, 'destroy'])->name('admin.eliminar.pago')->middleware(['auth:usuarios']);;

        // Ruta para agregar un nuevo pago al formulario
        Route::post('/pagos/{idFormulario}/add', [PagoController::class, 'store'])->name('admin.agregar.pago')->middleware(['auth:usuarios']);;

        //ruta para mostrar la lista de los usuarios que tienen formularios por pagar
        Route::get('/formulariosPorPagar',[FormularioController::class,'mostrarFormulariosPendientes'])->name('admin.verFormularios.pendientes');
        //ruta para mostrar la lista de formularios pagados
        Route::get('/formulariosPagados',[FormularioController::class,'mostrarFormulariosPagados'])->name('admin.verFormularios.pagados');

        Route::get('/entradas/generarEntradas',[EntradaController::class,'create'])->name('admin.entradas.generarEntradasExcel');

        Route::post('/entradas/procesarExcel',[EntradaController::class,'procesarExcel'])->name('admin.procesar.excel');

        Route::post('/sexo/generar600',[EntradaController::class,'generarExcel'])->name('admin.generar.entradas.ficticias');

        //para las editar entradas generadas
        Route::put('/entradaGenerada/editar/{id}',[EntradaController::class,'update'])->name('admin.editar.entradaGenerada');
        //para eliminar de las entradas generadas
        Route::delete('/entradaGenerada/eliminar/{id}',[EntradaController::class,'destroy'])->name('admin.eliminar.entradaGenerada');


        //logica para graficas
//        Route::get('/api/ventas', [TuControlador::class, 'obtenerVentasPorFiltro']);

        Route::get('/graficas/generarNroVentas',[FormularioController::class,'obtenerVentasGenerica'])->name('ventas.filtrar');
        Route::get('/graficas/generarGanancias',[FormularioController::class,'obtenerGananciasGenerica'])->name('ganancias.filtrar');
        Route::get('/graficas/generarTortas',[FormularioController::class,'obtenerCantidadModalidadesPago'])->name('tortas.filtrar');
        Route::get('/graficas/generarVisitantesPorComunidad',[FormularioController::class,'obtenerVisitantesDeComunidades'])->name('comunidades.visitantes.filtrar');
        Route::get('/graficas/generarVentasGraficada',[FormularioController::class,'obtenerVentasGraficasGenericas'])->name('ventas.grafica.filtrar');

        Route::get('/dashboard',[usuarioController::class,'getDashBoard'])->name('admin.dashboard');
// jorge estuvo aqui :v
});
// Rutas de administración
//administradores/store
Route::prefix('administradores')->group(function () {
    // Rutas para gestionar el perfil del administrador
    Route::get('/', [AdministradorController::class, 'index'])->name('admin.index'); // Ver perfil
    Route::get('/create', [AdministradorController::class, 'create'])->name('admin.create'); // Crear perfil
    Route::post('/store', [AdministradorController::class, 'store'])->name('admin.store'); // Guardar perfil
    Route::get('/edit/{id}', [AdministradorController::class, 'edit'])->name('admin.edit'); // Editar perfil
    Route::put('/update/{id}', [AdministradorController::class, 'update'])->name('admin.update'); // Actualizar perfil
    Route::post('/upload-image', [AdministradorController::class, 'uploadImage'])->name('admin.perfil.uploadImage'); // Subir imagen de perfil
    Route::delete('/delete-profile-image', [AdministradorController::class, 'deleteProfileImage'])->name('deleteProfileImage');

    Route::get('/tipo_entrada', [TipoEntradaController::class, 'index'])->name('admin.tipo_entrada.index');
    

    Route::get('/tipo_entrada/create', [TipoEntradaController::class, 'create'])->name('admin.tipo_entrada.create');
    Route::post('/tipo_entrada/store', [TipoEntradaController::class, 'store'])->name('admin.tipo_entrada.store');

    Route::get('/tipo_entrada/{tipo_entrada}/edit', [TipoEntradaController::class, 'edit'])->name('admin.tipo_entrada.edit');
    Route::put('/tipo_entrada/{tipo_entrada}', [TipoEntradaController::class, 'update'])->name('admin.tipo_entrada.update');
    Route::delete('/tipo_entrada/{tipo_entrada}', [TipoEntradaController::class, 'destroy'])->name('admin.tipo_entrada.destroy');

    Route::get('/comunidades', [ComunidadController::class, 'index'])->name('admin.comunidades.index'); // Ver perfil
    Route::post('/comunidades/store', [ComunidadController::class, 'store'])->name('admin.comunidades.store');
    Route::get('/comunidades/edit/{comunidad}', [ComunidadController::class, 'edit'])->name('admin.comunidades.edit');
    Route::put('/comunidades/update/{comunidad}', [ComunidadController::class, 'update'])->name('admin.comunidades.update');


                                                                                //show_villa_amoboro_admin                                    
        Route::get('/comunidad/villa_amboro/{id}', [ComunidadController::class, 'show_villa_amoboro_admin'])->name('administracion.comunidad.show_villa_amoboro');
        Route::get('/comunidad/jardin_de_las_delicias/{id}', [ComunidadController::class, 'show_jardin_de_las_delicias_admin'])->name('administracion.comunidad.show_jardin_de_las_delicias');
        Route::get('/comunidad/la_chonta/{id}', [ComunidadController::class, 'show_la_chonta_admin'])->name('administracion.comunidad.show_la_chonta');
        Route::get('/comunidad/mataracu/{id}', [ComunidadController::class, 'show_mataracu_admin'])->name('administracion.comunidad.show_mataracu');
        Route::get('/comunidad/oriente/{id}', [ComunidadController::class, 'show_oriente_admin'])->name('administracion.comunidad.show_oriente');

        Route::post('/comunidad/mataracu/comentar',[ComentarioController::class,'store'])->name('admin.comentarios.store');
        Route::put('/comunidad/mataracu/actualizar/{id}',[ComentarioController::class,'update'])->name('admin.comentarios.update');
        Route::delete('/comunidad/mataracu/comentar/eliminar/{id}',[ComentarioController::class,'destroy'])->name('admin.comentarios.destroy');
        Route::put('/comunidad/mataracu/actualizar-admin/{id}', [ComentarioController::class, 'updateForAdmin'])->name('admin.comentarios.update');
        Route::delete('/comunidad/mataracu/comentar/eliminar-admin/{id}', [ComentarioController::class, 'destroyForAdmin'])->name('admin.comentarios.destroy');
        



    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    // Route::delete('/destroy/{id}', [AdministradorController::class, 'destroy'])->name('admin.destroy'); // Eliminar perfil
    Route::put('/update-profile', [AdministradorController::class, 'updateProfile'])->name('updateProfile'); // Eliminar perfil
    // Otras rutas...

    
});


// Habilitar rutas de autenticación y verificación de correo
Auth::routes(['verify' => true]);

Route::middleware(['web'])->group(function () {
    // Rutas de autenticación
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
});

// Rutas de verificación
Route::get('/verificacion/{email}', [AuthController::class, 'showVerificationForm'])->name('verification.page');
Route::post('/verificar', [AuthController::class, 'verifyCode'])->name('verification.submit');
Route::get('/verification-success', function () {
    return view('emails.verification-success');
})->name('verification.success');




