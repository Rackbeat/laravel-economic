<?php


namespace LasseRafn\Economic\Models;


use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class JournalVouchers extends Model
{
    protected $entity = 'journals/:journalNumber/vouchers';

    public $journalNumber;
    public $entries;
    public $name;

    public function __construct(Request $request, $data)
    {
        if ($data){
            $this->entity = str_replace(':journalNumber', $data[0]->journal->journalNumber, $this->entity);
        }

        parent::__construct($request, $data);
    }
}