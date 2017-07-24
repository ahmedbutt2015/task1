<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Exception;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthenticationController extends Controller
{

    public function login(Request $request)
    {

        $password = $request->input('password');
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validator->passes()) {

            $role_id = 2;
            if ($request->has('admin')) {
                $role_id = 1;
            }
            if (Auth::attempt(['username' => $request->username, 'password' => $password, 'role_id' => $role_id])) {
                return redirect('/');
            } else {
                session()->flash('status', 'Incorrect Credentials!');
                return redirect()->back();
            }
        } else {
            return redirect()->back()
                ->withErrors($validator->errors());
        }
    }

    public function register(Request $req)
    {
        $username = $req->input('username');
        $validator = Validator::make($req->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'name' => 'required',
        ]);
        $password = bcrypt($req->input('password'));
        if ($validator->passes()) {
            if ($req->hasFile('image')) {
                if ($user = User::create([
                    'username' => $username,
                    'password' => $password,
                    'name' => $req->name,
                    'role_id' => 2,
                ])
                ) {
                    $id = str_random(15);
                    $file_name = $id . '.' . $req->file('image')->getClientOriginalExtension();
                    Storage::disk('images')->put(
                        $file_name,
                        File::get($req->file('image'))
                    );
                    $user->image = $file_name;
                    $user->save();
                } else {
                    session()->flash('status', 'Something Went Wrong! Try Again!');
                }
            } else {
                session()->flash('status', 'Image Not Found!');
            }
            return redirect('/profile');
        } else {
            return redirect('/profile')->withErrors($validator->errors());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function delete($id)
    {
        $res = User::find($id);
        if ($res != null) {
            $res->delete();

        } else {
            return response()->json([
                "error" => true,
                "message" => 'User Not Found'
            ]);
        }
        return response()->json([
            "error" => false
        ]);
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);

        try {
            $user->update($request->except(['image', 'pass']));
        } catch (QueryException $e) {
            session()->flash('exception', 'This username has been taken !');
            return redirect()->back();
        }
        if ($request->has('pass')) {
            $user->password = bcrypt($request->pass);
            $user->save();
        }
        if ($request->hasFile('image')) {
            $id = str_random(15);
            $file_name = $id . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('images')->put(
                $file_name,
                File::get($request->file('image'))
            );
            $user->image = $file_name;
            $user->save();
        }
        return redirect()->back();
    }


}
