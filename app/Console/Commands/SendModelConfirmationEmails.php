<?php

namespace App\Console\Commands;

use App\Mail\ModelsConfirmationMail;
use App\Models\RegisteredModels;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendModelConfirmationEmails extends Command
{
    protected $signature = 'models:send-confirmations';

    protected $description = 'Wysyła emaile potwierdzające rejestrację modeli z confirm=0 i oznacza je jako potwierdzone';

    /**
     * Ile kont (nie modeli) obsłużyć na jedno uruchomienie - zabezpieczenie
     * przed limitami wysyłki na współdzielonym SMTP przy dużych partiach.
     */
    private const ACCOUNTS_PER_RUN = 20;

    public function handle(): int
    {
        $ownerIds = RegisteredModels::where('confirm', 0)->distinct()->pluck('users_id');

        if ($ownerIds->isEmpty()) {
            return self::SUCCESS;
        }

        $accountIds = User::whereIn('id', $ownerIds)
            ->get(['id', 'idopiekuna'])
            ->map(fn ($owner) => $owner->idopiekuna ?? $owner->id)
            ->unique()
            ->take(self::ACCOUNTS_PER_RUN);

        $accounts = User::whereIn('id', $accountIds)
            ->whereNull('idopiekuna')
            ->where('status', '!=', 2)
            ->get();

        foreach ($accounts as $account) {
            $ownModels = RegisteredModels::where('users_id', $account->id)
                ->where('confirm', 0)
                ->get();

            $modelIdsToConfirm = $ownModels->pluck('id')->all();
            $learnerSections = [];

            $learners = User::where('idopiekuna', $account->id)->get();
            foreach ($learners as $learner) {
                $learnerModels = RegisteredModels::where('users_id', $learner->id)
                    ->where('confirm', 0)
                    ->get();

                if ($learnerModels->isEmpty()) {
                    continue;
                }

                $learnerSections[] = [
                    'name' => trim($learner->imie . ' ' . $learner->nazwisko),
                    'models' => $learnerModels->map(fn ($m) => $this->formatModel($m))->all(),
                ];

                $modelIdsToConfirm = array_merge($modelIdsToConfirm, $learnerModels->pluck('id')->all());
            }

            if (empty($modelIdsToConfirm)) {
                continue;
            }

            try {
                Mail::to($account->email)->send(new ModelsConfirmationMail(
                    $ownModels->map(fn ($m) => $this->formatModel($m))->all(),
                    $learnerSections,
                ));

                RegisteredModels::whereIn('id', $modelIdsToConfirm)->update(['confirm' => 1]);

                $this->info("Wysłano potwierdzenie do {$account->email} (" . count($modelIdsToConfirm) . " modeli)");
            } catch (Throwable $e) {
                Log::error("Nie udało się wysłać potwierdzenia modeli do {$account->email}: {$e->getMessage()}");
                $this->error("Błąd wysyłki do {$account->email}: {$e->getMessage()}");
            }
        }

        return self::SUCCESS;
    }

    private function formatModel(RegisteredModels $model): string
    {
        return $model->producent
            ? "{$model->nazwa} ({$model->producent})"
            : $model->nazwa;
    }
}
