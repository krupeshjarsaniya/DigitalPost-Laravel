<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Menu;
use App\Permission;
use View;

class AdminUserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::permission');
    }

    public function changeUserRole(Request $request) {
        $menus = Menu::where('parent_id', 0)->get();
        $permissions = Permission::where('user_role', $request->user_role)->pluck('menu_id')->toArray();
        $form = (string)View::make('user::permissionForm')->with('menus',$menus)->with('permissions',$permissions);
        return response()->json(['status' => true,'form' => $form ]);
    }

    public function updatepermission(Request $request) {
        if(!isset($request->user_role)) {
            return response()->json(['status' => false,'message' => "Select User Role" ]);
        }
        if(!in_array($request->user_role, array(2,3,4))) {
            return response()->json(['status' => false,'message' => "Select Valid User Role" ]);
        }
        if(!isset($request->permissions)) {
            return response()->json(['status' => false,'message' => "Select Atleast 1 Permission" ]);
        }
        $oldPerissions = Permission::where('user_role', $request->user_role)->get();
        foreach ($oldPerissions as $key => $oldPerission) {
            $oldPerission->delete();
        }
        $permissions = $request->permissions;
        foreach ($permissions as $key => $permission) {
            $newPermission = new Permission;
            $newPermission->user_role = $request->user_role;
            $newPermission->menu_id = $permission;
            $newPermission->save();
        }
        return response()->json(['status' => true,'message' => "Permission updated successfully!" ]);

    }
}
