<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Pago;
use App\Models\usuario;
use App\Models\TipoPago;
use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
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
    public function store(Request $request,$idFormulario)
    {
       // dd($request->all(),$idFormulario);
        try {
            DB::beginTransaction(); // Iniciar transacción
            $nombreTipoPago=($request->nombre);
            //dd((float) $request->monto>=0);
            if((float) $request->monto>0){
                $pagoBackend=Pago::create([
                    'nombre'=>$nombreTipoPago,
                    'monto'=>(float)$request->monto,
                    'formulario_id'=>$idFormulario
                ]);
                /*if(Formulario::yaEstanTodosPagados($idFormulario)){
                    $formulario=Formulario::findOrFail($idFormulario);
                    $formulario->guardaparque_id=Auth::id();
                }*/
                //una vez que se dispara el trigger solo queda verificar si cambio el estado de pendiente a pagado,si esta en pagado entonces 
                //solo queda agregar el idguardaparque que lo atendio
                PagoController::agregarIdGuardaparqueAForm($pagoBackend);
                DB::commit();
                return redirect()->back()->with('success','Pago Registrado con Exito!')->with('source','pagosUser');
            }else{
                
                return redirect()->back()->with('error','Hubo un error al registrar el pago')->with('source','pagosUser');//no muestra es super raro
            }
            
            
            //code...
        } catch (Exception $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('error','Hubo un error al registrar el pago')->with('source','pagosUser');
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pago $tipoPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * para mostrar la interfaz de cada pago 
     */
    public function edit($idFormulario)
    {   
        $formulario=Formulario::findOrFail($idFormulario);

        $pagos=$formulario->pagos;
        $layout=usuario::getLayout(Auth::id());    //para saber que layout le corresponde
        $tipoEntrada=$formulario->tipoEntrada;
         // Realiza la suma de todos los montos de los pagos asociados al formulario
        $montoActual = $pagos->sum('monto');
        return view('administracion.AdminReservas.Pagos.pagodelusuario',compact('pagos','layout','tipoEntrada','montoActual'));

    }

    /**
     * Update the specified resource in storage.
     * actualizar el pago
     * recibo el id del pago, y el objeto pago
     */
    public function update($idPago,Request $request)
    {
        //dd($request->all());
        try {
            DB::beginTransaction(); // Iniciar transacción
            $nombreTipoPago=($request->nombre);
            if((float) $request->monto>0){
                $pagoBackend=Pago::findOrFail($idPago);
                $pagoBackend->nombre=$nombreTipoPago;
                $pagoBackend->monto=(float) $request->monto;
                $pagoBackend->save();//se dispara el trigger del udpate

                /*if(Formulario::yaEstanTodosPagados($pagoBackend->formulario->id)){
                    $formulario=$pagoBackend->formulario->id;
                    $formulario->guardaparque_id=Auth::id();
                }*/
                //una vez que se dispara el trigger solo queda verificar si cambio el estado de pendiente a pagado,si esta en pagado entonces 
                //solo queda agregar el idguardaparque que lo atendio
                
                PagoController::agregarIdGuardaparqueAForm($pagoBackend);
                DB::commit();
                return redirect()->back()->with('success','Pago Actualizado con Exito')->with('source','pagosUser');
            }else{
                return redirect()->back()->with('error','Hubo un error al actualizar el pago')->with('source','pagosUser');
            }
            
            
            //code...
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Hubo un error al actualizar el pago')->with('source','pagosUser');
            dd($th);
        }
    }
    public static function agregarIdGuardaparqueAForm($pago):void{
        try {
            //code...
            
            $formulario=$pago->formulario;
            if($formulario->estado=="PAGADO"){
                $formulario->guardaparque_id=Auth::id();
                $formulario->save();
            }
        } catch (Exception $th) {
            dd("error en agregar",$th);
        }
    }
    /**
     * Remove the specified resource from storage.
     * recibe el id del pago
     */
    public function destroy($id)
    {
      //  dd($id);
        $pago=Pago::findOrFail($id);
        //una vez que se dispara el trigger solo queda verificar si cambio el estado de pendiente a pagado,si esta en pagado entonces 
        //solo queda agregar el idguardaparque que lo atendio
        PagoController::agregarIdGuardaparqueAForm($pago);
        $pago->delete();
        return redirect()->back()->with('success','Pago Eliminado con Exito')->with('source','pagosUser');
    }
}
