<?php

namespace App\Providers;

use App\Models\Pago;
use App\Models\usuario;
use App\Models\Supervisa;
use App\Models\Formulario;
use App\Models\Guardaparque;
use App\Observers\PagoObserver;
use App\Observers\UsuarioObserver;
use Illuminate\Support\Facades\URL;
use App\Observers\SupervisaObserver;
use App\Observers\FormularioObserver;
use App\Observers\GuardaparqueObserver;
use Illuminate\Support\ServiceProvider;
use App\Listeners\CreateUsuarioForGuardaparque;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        usuario::observe(UsuarioObserver::class);
        //Guardaparque::observe(GuardaparqueObserver::class);
        Formulario::observe(FormularioObserver::class);
        Supervisa::observe(SupervisaObserver::class);
        Pago::observe(PagoObserver::class);

        //ngrok
        /*if (app()->environment('local')) {
            URL::forceScheme('https');
        }*/
    }
}