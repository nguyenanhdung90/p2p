<?php

namespace App\Providers;

use App\P2p\Ads\InitiateAd;
use App\P2p\Ads\InitiateAdInterface;
use App\P2p\Ads\P2pAd;
use App\P2p\Ads\P2pAdInterface;
use App\P2p\Appeal\InitiateAppeal;
use App\P2p\Appeal\InitiateAppealInterface;
use App\P2p\BankTransferDetails\BankTransferDetail;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\PairCoinFiat\PairCoinFiat;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use App\P2p\Transactions\ConfirmTransfer;
use App\P2p\Transactions\ConfirmTransferInterface;
use App\P2p\Transactions\InitiateTransaction;
use App\P2p\Transactions\InitiateTransactionInterface;
use App\P2p\Transactions\P2pTransactionInterface;
use App\P2p\Transactions\P2pTransaction;
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
            P2pTransactionInterface::class => P2pTransaction::class,
            ConfirmTransferInterface::class => ConfirmTransfer::class,
            InitiateTransactionInterface::class => InitiateTransaction::class,
            InitiateAdInterface::class => InitiateAd::class,
            InitiateAppealInterface::class => InitiateAppeal::class,
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
