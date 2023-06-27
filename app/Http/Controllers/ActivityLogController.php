<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Http\Requests\StoreActivityLogRequest;
use App\Http\Requests\UpdateActivityLogRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getUserActivityLog(ActivityLog $activityLog)
    {
        $authenticatedUser = Auth::user();

        $authType = get_class($authenticatedUser);

        $userActivities = ActivityLog::where("user_id", "=", $authenticatedUser->id)
            ->where("user_type", "=", "$authType")->get();


        return response()->json(['success' => "success", 'data' => $userActivities], 200);

    }
    public function getAllActivityLog(ActivityLog $activityLog)
    {


        $authenticatedUser = Auth::user();

        $userActivities = ActivityLog::with("user")->with("data")->get();

        return response()->json(['success' => "success", 'data' => $userActivities], 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityLogRequest $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        //
    }
}