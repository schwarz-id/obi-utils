<?php

namespace SchwarzID\ObiUtils\Commands;

use Illuminate\Console\Command;

class ObiUtilsCommand extends Command
{
    public $signature = 'obi-utils';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
