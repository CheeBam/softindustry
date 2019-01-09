<?php

namespace App\Http\Controllers\Api\V1;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Project::all(), 200);
    }
}
