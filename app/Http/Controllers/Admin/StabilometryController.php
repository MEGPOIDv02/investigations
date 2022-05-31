<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investigation;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StabilometryController extends Controller
{
    public function indexContent(Request $request)
    {
        $page = $request->get('page', 0);
        $size = $request->get('size', 15);
        $skip = $page * $size;

        $filterName = $request->get('filter-name', null);
        $filterEmail = $request->get('filter-email', null);
        $filterRole = $request->get('filter-role_name', null);

        $query = Investigation::query()
            ->where('fk_id_inv_type', Investigation::STABILOMETRY)
            ->with(['inv_type','signs_type','stimulation_type'])
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

    public function active($investigationId)
    {
        try {
            Investigation::destroy($investigationId);
            return response()->json([
                'success' => true,
                'message' => 'Investigación Borrada correctamente'
            ]);
        }catch (\Throwable $exception){
            return response()->json([
                'success' => false,
                'message' => 'Error al Borrar Investigación'
            ]);
        }
    }

    public function upsert(Request $request, $investigationId)
    {
        try {
            DB::beginTransaction();
            $investigation = Investigation::find($investigationId);

            $investigation->name = $request->name;
            $investigation->effects = $request->effects;
            $investigation->duration = $request->duration;
            $investigation->frecuenty = $request->frecuenty;
            $investigation->intensity = $request->intensity;
            $investigation->time = $request->time;
            $investigation->colocation = $request->colocation;
            $investigation->concent = $request->concent;
            if($request->hasFile('documentTxt'))
            {
                $txt = $request->file('documentTxt');
                $url_document = UploadFiles::storeFile($txt,$investigation->id, 'investigations_txt');
                $investigation->document = $url_document;

            }
            $investigation->fk_id_inv_type = Investigation::STABILOMETRY;
            $investigation->fk_id_inv_stimulation_type = $request->fk_id_stimulation_type;
            $investigation->fk_id_inv_sign_type = $request->fk_id_signs_type;

            $investigation->saveOrFail();
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
            $investigation = new Investigation;

            $investigation->name = $request->name;
            $investigation->effects = $request->effects;
            $investigation->duration = $request->duration;
            $investigation->frecuenty = $request->frecuenty;
            $investigation->intensity = $request->intensity;
            $investigation->time = $request->time;
            $investigation->colocation = $request->colocation;
            if($request->concent==true)
            {
                $investigation->concent = true;
            }
            if($request->hasFile('documentTxt'))
            {
                $txt = $request->file('documentTxt');
                $url_document = UploadFiles::storeFile($txt,$investigation->id, 'investigations_txt');
                $investigation->document = $url_document;

            }
            $investigation->fk_id_inv_type = Investigation::STABILOMETRY;
            $investigation->fk_id_inv_stimulation_type = $request->fk_id_stimulation_type;
            $investigation->fk_id_inv_sign_type = $request->fk_id_signs_type;

            $investigation->saveOrFail();
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
}
