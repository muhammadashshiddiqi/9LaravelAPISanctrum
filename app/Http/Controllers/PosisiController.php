<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PosisiController extends Controller
{
    public function get_list(){
        $all = Posisi::select('user_id', 'position', 'status')->get();

        if ($all->isEmpty()) {

            $rest = [
                'message' => 'Data tidak berhasil ditemukan.',
                'data' => $all,
                'status' => 'error'
            ];

            return response()->json($rest, 201);

        } else {

            $rest = [
                'message' => 'Data berhasil ditemukan.',
                'data' => $all,
                'status' => 'success'
            ];

            return response()->json($rest, 200);
        }
    }
    
    public function store(Request $request){
        $field = $request->validate([
            'user_id' => 'required|numeric|exists:users,id|unique:posisis',
            'status' => 'required|in:Active,Inactive',
            'position' => 'required',
        ]);

        $data = Posisi::create([
            'user_id' => $field['user_id'],
            'status' => $field['status'],
            'position' => $field['position']
        ]);

        $rest = [
            'message' => 'Data berhasil di tambah.',
            'data' => $data,
            'status' => 'success'
        ];

        return response()->json($rest, 201);
    }

    public function show($id){
        $data = Posisi::select('user_id', 'position', 'status')->where('user_id', $id)->get();

        if($data->isEmpty()){

            $rest = [
                'message' => 'Data tidak berhasil ditemukan.',
                'data' => $data,
                'status' => 'error'
            ];

            return response()->json($rest, 201);

        }else{
            $rest = [
                'message' => 'Data berhasil ditemukan.',
                'data' => $data,
                'status' => 'success'
            ];

            return response()->json($rest, 200);
        }
    }

    public function update(Request $request, $id)
    {
        $ids = Posisi::find($id);
        if($ids){
            $field = $request->validate([
                'status' => 'required|in:Active,Inactive',
                'position' => 'required',
            ]);

            DB::table('posisis')->where('user_id', $id)
                                ->update(['status' => $field['status'], 'position' => $field['position'] ]);

            $rest = [
                'message' => 'Data berhasil diupdate.',
                'data' => $field,
                'status' => 'success'
            ];

            return response()->json($rest, 201);

        }else{

            $rest = [
                'message' => 'Data tidak berhasil ditemukan.',
                'data' => $request->all(),
                'status' => 'error'
            ];

            return response()->json($rest, 201);
        }
    }

    public function destroy($id)
    {
        $ids = Posisi::find($id);
        if ($ids) {
            $ids->delete();

            $rest = [
                'message' => 'Data berhasil didelete.',
                'status' => 'success'
            ];

            return response()->json($rest, 200);

        } else {

            $rest = [
                'message' => 'Data tidak berhasil ditemukan.',
                'status' => 'success'
            ];

            return response()->json($rest, 201);
        }
    }
}
