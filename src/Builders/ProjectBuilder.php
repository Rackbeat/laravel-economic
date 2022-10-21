<?php


namespace LasseRafn\Economic\Builders;


use LasseRafn\Economic\Models\Project;

class ProjectBuilder extends NewRestBuilder
{
    protected $entity = 'projects';
    protected $model = Project::class;

}