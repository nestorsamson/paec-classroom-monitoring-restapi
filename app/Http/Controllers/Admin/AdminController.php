<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = \DB::table('users')
            ->join('pending_request', 'users.id', '=', 'pending_request.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

        return response()->json([
            'pendingUsers' => $users,

        ]);
    }


    public function filterByRole(string $roleId)
    {

        $users = \App\Models\User::with('userProfile')
            ->with('roles')
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->whereIn('id', function ($query) use ($roleId) {
                $query->select('user_id')
                    ->from('role_user')
                    ->where('role_id', $roleId); // Replace $teacherRoleId with the actual ID of the "teacher" role
            })
            ->distinct()
            ->paginate(5);



        return response()->json([
            'users' => $users

        ]);


    }

    public function getSettings()
    {

        $settings = \DB::table('settings')->get();
        $schoolYearId = $settings[0]->school_year_id;
        $schoolYear = \App\Models\SchoolYear::find($schoolYearId);

        if ($schoolYear) {
            // School year found
            $settings[0]->school_year = $schoolYear->school_year;
            // Do something with the school year value
        } else {
           $settings[0]->school_year = "N/A";
        }

        return response()->json([
            'settings' => $settings,
            'rooms' => \App\Models\Room::all()
        ]);

    }

   

}