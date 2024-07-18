<?php

namespace detit\Polipeople\Commands;

use Illuminate\Console\Command;

class PolipeopleCommand extends Command
{
    public $signature = 'polipeople';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
