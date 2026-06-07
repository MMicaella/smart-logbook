<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Borrow;

use App\Notifications\SystemNotification;

class CheckOverdueBorrows extends Command
{
    protected $signature = 'borrows:overdue';

    protected $description = 'Check overdue borrows';

    public function handle()
    {
        $borrows = Borrow::where(
                'status',
                'approved'
            )
            ->where(
                'expires_at',
                '<',
                now()
            )
            ->get();

        foreach ($borrows as $borrow) {

            $borrow->status = 'overdue';

            $borrow->save();

            /*
            |--------------------------------------------------------------------------
            | NOTIFY USER
            |--------------------------------------------------------------------------
            */

            $borrow->user->notify(

                new SystemNotification(

                    'Your borrow is now overdue.',

                    '/my-borrows'

                )

            );
        }

        $this->info(
            'Overdue borrows checked.'
        );
    }
}