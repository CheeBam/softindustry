<?php

namespace App\Http\Controllers\Api\V1;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Constants;
use DB;
use Storage;
use Illuminate\Support\Facades\File;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $amount = !$request->filled("per_page")
            ? Constants::TABLE_ELEMENTS_AMOUNT
            : $request->input("per_page");

        $sort = explode("|",!$request->filled("sort")
            ? "created_at|desc"
            : $request->input("sort"));

        return response()->json(
            Employee::withCount("projects")
                ->where(function ($query) use ($request) {
                    if ($request->filled("search")) {
                        $query->orWhere("name", "like", "%" . $request->input("search") . "%");
                    }
                })
                ->orderBy($sort[0], $sort[1])
                ->paginate($amount)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required',
            'sociability' => 'required',
            'engineering' => 'required',
            'time_management' => 'required',
            'languages' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation error',
                    'error' => $validator->errors(),
                ],
            422);
        }

        $employee = new Employee();
        $employee->name = $request->input('name');
        $employee->image = $request->input('image');
        $employee->sociability = $request->input('sociability');
        $employee->engineering = $request->input('engineering');
        $employee->time_management = $request->input('time_management');
        $employee->languages = $request->input('languages');
        $employee->save();

        $projects = $request->input('project');
        if ($request->filled("project") && count($projects) > 0) {
            $ids = isset($projects['id']) ? $projects['id'] : array_column($projects, 'id');
            $employee->projects()->attach($ids);
        }

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Upload image to the server
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $path = $request->file('image')->storeAs('public/images',
            uniqid() . '.' . $request->file('image')->getClientOriginalExtension());

        return response()->json(Storage::url($path), 200);
    }

    /**
     * Returns average characteristics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAverages()
    {
        $averages = DB::table('employees')
            ->select(
                DB::raw(
                    'avg(sociability) sociability,
                     avg(engineering) engineering,
                     avg(time_management) timeManagement,
                     avg(languages) languages'
                ))
            ->first();

        return response()->json($averages, 200);
    }
}
