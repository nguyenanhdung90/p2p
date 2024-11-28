<?php

namespace App\Providers;

use App\P2p\Ads\InitiateAd;
use App\P2p\Ads\InitiateAdInterface;
use App\P2p\Ads\P2pAd;
use App\P2p\Ads\P2pAdInterface;
use App\P2p\Appeal\AddProof;
use App\P2p\Appeal\AddProofInterface;
use App\P2p\Appeal\Appeal;
use App\P2p\Appeal\AppealInterface;
use App\P2p\Appeal\InitiateAppeal;
use App\P2p\Appeal\InitiateAppealInterface;
use App\P2p\Appeal\UpdateStatus;
use App\P2p\Appeal\UpdateStatusInterface;
use App\P2p\BankTransferDetails\AddBankTransferDetail;
use App\P2p\BankTransferDetails\AddBankTransferDetailInterface;
use App\P2p\BankTransferDetails\BankTransferDetail;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\BankTransferDetails\UpdateBankTransferDetail;
use App\P2p\BankTransferDetails\UpdateBankTransferDetailInterface;
use App\P2p\PairCoinFiat\AddPairCoinFiat;
use App\P2p\PairCoinFiat\AddPairCoinFiatInterface;
use App\P2p\PairCoinFiat\DeletePairCoinFiat;
use App\P2p\PairCoinFiat\DeletePairCoinFiatInterface;
use App\P2p\PairCoinFiat\PairCoinFiat;
use App\P2p\PairCoinFiat\PairCoinFiatInterface;
use App\P2p\Transactions\ConfirmTransfer;
use App\P2p\Transactions\ConfirmTransferInterface;
use App\P2p\Transactions\InitiateTransaction;
use App\P2p\Transactions\InitiateTransactionInterface;
use App\P2p\Transactions\P2pTransactionInterface;
use App\P2p\Transactions\P2pTransaction;
use App\P2p\Transactions\UpdateP2pTransaction;
use App\P2p\Transactions\UpdateP2pTransactionInterface;
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
            AppealInterface::class => Appeal::class,
            AddProofInterface::class => AddProof::class,
            UpdateStatusInterface::class => UpdateStatus::class,
            AddPairCoinFiatInterface::class => AddPairCoinFiat::class,
            DeletePairCoinFiatInterface::class => DeletePairCoinFiat::class,
            AddBankTransferDetailInterface::class => AddBankTransferDetail::class,
            UpdateBankTransferDetailInterface::class => UpdateBankTransferDetail::class,
            UpdateP2pTransactionInterface::class => UpdateP2pTransaction::class,
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
