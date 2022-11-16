<?php


namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Project extends Model
{
    protected $entity = 'projects';
    protected $primaryKey = 'number';
    protected $rest_version = '/api/v16.0.0';
    protected $puttable = [
        'name',
        'number',
    ];

    public $number;
    public $name;
    public $self;

}