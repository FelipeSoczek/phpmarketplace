<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() //REGISTRA QUALQUER SERVIÇO DENTRO DA APLICAÇÃO
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() //INICIALIZA QQER SERVIÇO DA APLICAÇÃO/GLOBALMENTE
    {
        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Marketplace")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Marketplace")->setRelease("1.0.0");
    }
}
