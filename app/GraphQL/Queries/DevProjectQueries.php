<?php

namespace App\GraphQL\Queries;

use App\Models\DevProject;

class DevProjectQueries
{
    public function listDevProject($_, $args)
    {
        $devProjects = DevProject::all();
        return $devProjects;
    }
}
