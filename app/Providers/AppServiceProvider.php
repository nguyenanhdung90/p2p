<?php

namespace App\Providers;

use App\P2p\Ads\InitiateAd;
use App\P2p\Ads\InitiateAdInterface;
use App\P2p\Ads\P2pAd;
use App\P2p\Ads\P2pAdInterface;
use App\P2p\Appeals\AddProof;
use App\P2p\Appeals\AddProofInterface;
use App\P2p\Appeals\Appeal;
use App\P2p\Appeals\AppealInterface;
use App\P2p\Appeals\InitiateAppeal;
use App\P2p\Appeals\InitiateAppealInterface;
use App\P2p\Appeals\UpdateStatus;
use App\P2p\Appeals\UpdateStatusInterface;
use App\P2p\BankTransferDetails\AddBankTransferDetail;
use App\P2p\BankTransferDetails\AddBankTransferDetailInterface;
use App\P2p\BankTransferDetails\BankTransferDetail;
use App\P2p\BankTransferDetails\BankTransferDetailInterface;
use App\P2p\BankTransferDetails\UpdateBankTransferDetail;
use App\P2p\BankTransferDetails\UpdateBankTransferDetailInterface;
use App\P2p\ChatP2pTransactions\AddMessage;
use App\P2p\ChatP2pTransactions\AddMessageInterface;
use App\P2p\ChatP2pTransactions\P2pChat;
use App\P2p\ChatP2pTransactions\P2pChatInterface;
use App\P2p\Notifies\MarkingNotifyAsRead;
use App\P2p\Notifies\MarkingNotifyAsReadInterface;
use App\P2p\Notifies\Notify;
use App\P2p\Notifies\NotifyInterface;
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
            NotifyInterface::class => Notify::class,
            MarkingNotifyAsReadInterface::class => MarkingNotifyAsRead::class,
            AddMessageInterface::class => AddMessage::class,
            P2pChatInterface::class => P2pChat::class,
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
