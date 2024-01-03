<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::with('roles')->get();
        $user = User::with('permissions')->get();
        // dd($userEdit->name);
        $permissions = Permission::all();
        return view('users.index', compact('user', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->permission);
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));
            $user->givePermissionTo($request->permission);
            return redirect()->route('users')->with('success', 'Berhasil tambah data user');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', $th->getMessage());
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userEdit = User::with('permissions')->find($id);
        return response()->json($userEdit);
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
        // dd($request->all());
        if ($request->password) {
            # code...
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['email', 'max:255', 'unique:users,email,' . $id],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['email', 'max:255', 'unique:users,email,' . $id],
            ]);
        }

        try {
            $user = User::findOrFail($id);
            if ($request->password) {
                # code...
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
            // dd($user->getPermissionNames());
            $userPermissions = $user->getPermissionNames();
            if (!empty($userPermissions)) {
                # code...
                foreach ($userPermissions as $key => $value) {
                    // dd($value);
                    $user->revokePermissionTo($value);
                }
            }
            // dd($request);
            $user->givePermissionTo($request->permissions);
            return redirect()->route('users')->with('success', 'Berhasil ubah data user');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $userPermissions = $user->getPermissionNames();
            if (!empty($userPermissions)) {
                # code...
                foreach ($userPermissions as $key => $value) {
                    // dd($value);
                    $user->revokePermissionTo($value);
                }
            }
            $user->delete();
            return redirect()->route('users')->with('success', 'Berhasil hapus data user');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', $th->getMessage());
        }
    }
}
