<?php

namespace App\Providers;

use App\P2p\Ads\P2pAd;
use App\P2p\Ads\P2pAdInterface;
use App\P2p\BankTransferDetails\BankTransferDetail;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\PairCoinFiat\PairCoinFiat;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $appServices = [
            PairCoinFiatInterface::class => PairCoinFiat::class,
            P2pAdInterface::class => P2pAd::class,
            BankTransferDetailInterface::class => BankTransferDetail::class,
        ];
        foreach ($appServices as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
