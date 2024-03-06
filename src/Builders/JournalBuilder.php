<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Journal;

class JournalBuilder extends Builder
{
    protected $entity = 'journals';
    protected $model = Journal::class;
}
