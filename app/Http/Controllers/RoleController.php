<?php

    

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use DB;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

    

class RoleController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

     public function __construct()
     {
         $this->middleware(function ($request, $next) {
             // Check if the user has 'Admin' role, then bypass specific permission checks
             if (auth()->user() && auth()->user()->hasRole('Admin')) {
                 return $next($request);
             }
     
             // Otherwise, apply regular permission checks
             $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
             $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
             $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
             $this->middleware('permission:role-delete', ['only' => ['destroy']]);
     
             return $next($request);
         });
     }
     

    

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request): View

    {

        $roles = Role::orderBy('id','DESC')->paginate(5);

        return view('roles.index',compact('roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);

    }

    

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

     public function create(): View
     {
         $permission = Permission::get();
         return view('roles.create', compact('permission'));
     }
     
    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

     public function store(Request $request): RedirectResponse
     {
         // Validate the incoming request
         $this->validate($request, [
             'name' => 'required|unique:roles,name',
             'permission' => 'required|array', // Ensure permission is an array
             'permission.*' => 'exists:permissions,id', // Validate each permission ID exists
         ]);
     
         // Create the new role
         $role = Role::create(['name' => $request->input('name')]);
     
         // Retrieve permission names based on the IDs provided in the request
         $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
     
         // Sync the permissions with the role using permission names
         $role->syncPermissions($permissions);
     
         // Redirect back with a success message
         return redirect()->route('roles.index')
                          ->with('success', 'Role created successfully');
     }
     

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id): View

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();

    

        return view('roles.show',compact('role','rolePermissions'));

    }

    

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id): View

    {

        $role = Role::find($id);

        $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)

            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')

            ->all();

    

        return view('roles.edit',compact('role','permission','rolePermissions'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

     public function update(Request $request, $id): RedirectResponse
     {
         $this->validate($request, [
             'name' => 'required',
             'permission' => 'required|array', // Ensure permission is an array
             'permission.*' => 'exists:permissions,id', // Validate each permission ID exists
         ]);
     
         $role = Role::findOrFail($id);
         $role->name = $request->input('name');
         $role->save();
     
         // Retrieve permission names based on the IDs provided in the request
         $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
     
         // Sync the permissions with the role using permission names
         $role->syncPermissions($permissions);
     
         return redirect()->route('roles.index')
                          ->with('success', 'Role updated successfully');
     }
     

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id): RedirectResponse

    {

        DB::table("roles")->where('id',$id)->delete();

        return redirect()->route('roles.index')

                        ->with('success','Role deleted successfully');

    }

}