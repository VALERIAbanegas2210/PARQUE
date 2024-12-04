<?php

namespace App\Observers;

use App\Models\Formulario;
use Exception;

class FormularioObserver
{
    /**
     * Handle the Formulario "created" event.
     */
    public function created(Formulario $formulario): void
    {
        //
    }

    /**
     * Handle the Formulario "updated" event.
     * 
     * trigger para actualizar el monto total cada que se modifica una reserva
     * 
     */
    public function updated(Formulario $formulario): void
    {
        try {
            
            $reserva=$formulario->reserva;
            //para calcular el nuevo monto total
            $montoTotal=$reserva->formularios()->join('tipo_entradas','formularios.tipo_entrada_id','=','tipo_entradas.id')
            ->sum('tipo_entradas.precio');
            $reserva->montoTotal=$montoTotal;

            /*if($formulario->tipo_entrada_id!=$formulario->getOriginal('tipo_entrada_id')){
                $formulario->estado="PENDIENTE";
            }*/

            $reserva->cantidad=$reserva->formularios()->count();//para actualizar la cantidad de reservas de un formulario

            //primero una consulta para contar los formularios diferentes de pagado
            //cuenta los diferentes de pagado osea los que estan en pendientes,si es 0 quiere decir que todos estan pagados
            $cantidadDeFormulariosNoPagados=$reserva->formularios()->where('estado','!=','PAGADO')->count();
            if($cantidadDeFormulariosNoPagados==0){
                $reserva->estado="PAGADO";
            }else{
                $reserva->estado="PENDIENTE";//
            }
            $reserva->save();

            //$reserva->save();
                //ya actualizado el monto total

                //ahora requiero que si se actualiza el precio de entrada
            // Busco el tipo de pago antes de hacer el cambio con el getOriginal
            /*$idTipoEntradaAnterior = $formulario->getOriginal('tipo_entrada_id');
            //si el anterior y el actual se mantienen iguales no hagas nada,dejalo como esta
            //pero si son id diferentes entonces quiere decir que hubo un cambio
            if($idTipoEntradaAnterior!=$formulario->tipo_entrada_id){
                $formulario->estado="PENDIENTE";
                // Desactivar temporalmente los eventos de Eloquent para evitar recursión infinita
                //esto evita el abrazo mortal,dado que al hacer save estamos actualizando nuevamente
                Formulario::withoutEvents(function () use ($formulario) {
                    $formulario->save(); // Guardar los cambios en el formulario
                });
            }*/

            //code...
        } catch (Exception $th) {
            dd($th);//mostrar el error
        }
        
    }

    /**
     * Handle the Formulario "deleted" event.
     */
    public function deleted(Formulario $formulario): void
    {
        $reserva=$formulario->reserva;
            //para calcular el nuevo monto total
            $montoTotal=$reserva->formularios()->join('tipo_entradas','formularios.tipo_entrada_id','=','tipo_entradas.id')
            ->sum('tipo_entradas.precio');
            $reserva->montoTotal=$montoTotal;

            $reserva->cantidad=$reserva->formularios()->count();
            //primero una consulta para contar los formularios diferentes de pagado
            //cuenta los diferentes de pagado osea los que estan en pendientes,si es 0 quiere decir que todos estan pagados
            $cantidadDeFormulariosNoPagados=$reserva->formularios()->where('estado','!=','PAGADO')->count();
            if($cantidadDeFormulariosNoPagados==0){
                $reserva->estado="PAGADO";
            }else{
                $reserva->estado="PENDIENTE";//sexo
            }
            $reserva->save();

    }

    /**
     * Handle the Formulario "restored" event.
     */
    public function restored(Formulario $formulario): void
    {
        //
    }

    /**
     * Handle the Formulario "force deleted" event.
     */
    public function forceDeleted(Formulario $formulario): void
    {
        //
    }
}
