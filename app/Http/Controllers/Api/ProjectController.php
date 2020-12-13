<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return response([
            'projects' => ProjectResource::collection($projects),
            'message' => 'Projects retrieved successfully'
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'cost' => 'required'
        ]);

        if($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'message' =>  'Validation Error'
            ],404);
        }

        $project = Project::create($data);

        return response([
            'project' => new ProjectResource($project),
            'message' => 'Project created succesfully'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response([
            'project' => new ProjectResource($project),
            'message' => 'Projec received succesfully'
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->all());

        return response([
            'project' => new ProjectResource($project),
            'message' => 'Project updated succesfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response([
            'message' => 'Deleted succesfully'
        ]);
    }
}
