<?php


namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Project extends Model
{
    protected $entity = 'projects';
    protected $primaryKey = 'number';
    protected $puttable = [
        'name',
        'number',
    ];

    public $number;
    public $name;
    public $self;

}