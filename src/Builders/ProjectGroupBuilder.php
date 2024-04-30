<?php


namespace LasseRafn\Economic\Builders;


use LasseRafn\Economic\Models\ProjectGroup;

class ProjectGroupBuilder extends NewRestBuilder
{
	protected $entity = 'projectgroups';
	protected $model  = ProjectGroup::class;

}