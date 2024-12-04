<?php

namespace App\Observers;

use Exception;
use App\Models\Pago;
use App\Models\Entrada;
use App\Models\Formulario;

class PagoObserver
{
    /**
     * Handle the Pago "created" event.
     */
    public function created(Pago $pago): void
    {
        $this->actualizarEstadoFormulario($pago);
    }

    /**
     * Handle the Pago "updated" event.
     */
    public function updated(Pago $pago): void
    {
        //
        $this->actualizarEstadoFormulario($pago);
    }

    /**
     * Handle the Pago "deleted" event.
     */
    public function deleted(Pago $pago): void
    {
        //
        $this->actualizarEstadoFormulario($pago);
    }

    /**
     * Handle the Pago "restored" event.
     */
    public function restored(Pago $pago): void
    {
        //
    }

    /**
     * Handle the Pago "force deleted" event.
     */
    public function forceDeleted(Pago $pago): void
    {
        //
    }

    /**
     * Método para actualizar el estado del formulario.
     */
    private function actualizarEstadoFormulario(Pago $pago): void
    {
        $formulario = $pago->formulario; // Obtener el formulario relacionado con el pago

        // Calcular el total de los pagos realizados para el formulario
        $totalPagos = $formulario->pagos()->sum('monto');

        // Obtener el precio del tipo de entrada asociado al formulario
        $precioEntrada = $formulario->tipoEntrada->precio;
        //$estaPagado=$formulario->estado ==="PAGADO"?true:false;
        // Actualizar el estado del formulario
        if ($totalPagos == $precioEntrada) {//se entiende que aqui esta pagado
            $formulario->estado = 'PAGADO';
            
                //si es nulo la entrada
                if(!$formulario->entrada_id){//asigna una nueva entrada
                    $this->asignarNuevaEntrada($formulario);
                }else{
                    $huboCambios=$formulario->bandera;
                    //si hubo cambios es decir que si el tipo de entrada cambio
                    if($huboCambios){//entonces crea una nueva entrada y la que tiene asignada dejala disponible
                        $this->liberarEntrada($formulario);
                        $this->asignarNuevaEntrada($formulario);
                        $formulario->bandera=false;
                    }

                }
                
                 
            
        } else {
            $formulario->estado = 'PENDIENTE';
        }

        $formulario->save(); // Guardar los cambios en el formulario
    }

    private function liberarEntrada(Formulario $formulario):void{
        $entrada=Entrada::findOrFail($formulario->entrada_id);
                        $entrada->estado="DISPONIBLE";
                        $entrada->save();//guardo la entrada para que nuevamente este disponible
    }
    /**
     * Asignar una nueva entrada al formulario.
     */
    private function asignarNuevaEntrada(Formulario $formulario): void
    {
        $entradaDisponible = Entrada::where('tipo_entrada_id', $formulario->tipo_entrada_id)
            ->where('estado', 'DISPONIBLE')
            ->first();//busco una entrada disponible

        if ($entradaDisponible) {//si existe
            $formulario->entrada_id = $entradaDisponible->id;
            $formulario->fechaIngreso = now(); // Registrar la fecha de ingreso
            $entradaDisponible->estado = 'UTILIZADA';
            $entradaDisponible->save();
        } else {
            throw new Exception('No hay entradas disponibles para este tipo de entrada.');
        }
    }
}
