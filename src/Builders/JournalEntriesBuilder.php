<?php


namespace LasseRafn\Economic\Builders;


use Illuminate\Support\Facades\Log;
use LasseRafn\Economic\Models\JournalEntries;
use LasseRafn\Economic\Utils\Request;

class JournalEntriesBuilder extends Builder
{
    protected $entity = 'journals/:journalNumber/entries';
    protected $model = JournalEntries::class;


    public function __construct(Request $request, $journalNumber)
    {
        $this->entity = str_replace(':journalNumber', $journalNumber, $this->entity);

        parent::__construct($request);
    }
}