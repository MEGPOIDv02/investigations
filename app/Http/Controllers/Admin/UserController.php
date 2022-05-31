<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function indexContent(Request $request)
    {
        $page = $request->get('page', 0);
        $size = $request->get('size', 15);
        $skip = $page * $size;

        $filterName = $request->get('filter-name', null);
        $filterEmail = $request->get('filter-email', null);
        $filterRole = $request->get('filter-role_name', null);

        $query = User::query()
            ->with(['role'])
            ->where('id','!=',User::ADMIN)
            ->orderBy('id', 'asc');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        if ($filterEmail !== null) {
            $query->where('email', "like", "%" . $filterEmail . "%");
        }

        if ($filterRole !== null) {
            $query->whereHas('role', function ($q) use ($filterRole) {
                $q->where('name', 'like', "%" . $filterRole . "%");
            });
        }


        $count = $query->count();
        $users = $query
            ->limit($size)
            ->skip($skip)
            ->get();

        return response()->json([
            'page' => $page,
            'size' => $size,
            'count' => $count,
            'data' => $users,
        ]);
    }

    public function active($userId)
    {
        try {
            User::destroy($userId);
            return response()->json([
                'success' => true,
                'message' => 'Usuario Borrado correctamente'
            ]);
        }catch (\Throwable $exception){
            return response()->json([
                'success' => false,
                'message' => 'Error al Borrar usuario'
            ]);
        }
    }

    public function upsert(Request $request, $userId)
    {
        try {
            DB::beginTransaction();
            //Save User
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->fk_id_role = $request->fk_id_role;
            $user->password = bcrypt($request->password);
            $user->saveOrFail();
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'line' => $exception->getLine()
            ]);
        }
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            //Save User
            $user = new User;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->fk_id_role = $request->fk_id_role;
            $user->password = bcrypt($request->password);
            $user->saveOrFail();
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'line' => $exception->getLine()
            ]);
        }
    }
    public function showAuthUser(){
        try{
            $user=User::with('role')->findOrFail(\Auth::user()->id);
            return response()->json([
                'success'=>true,
                'data'=>$user
            ]);
        }catch (\Exception $ex){
            return response()->json([
                'success'=>false,
                'data'=>$ex->getMessage()
            ]);
        }


    }
}
