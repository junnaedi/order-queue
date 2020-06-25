<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Table;

class TableController extends Controller
{
    public function index() {
        return view('waiter.table.list-table');
    }

    public function loadData() {
        $table = Table::all();

        if ($table) {
            $response = [
                'status' => 200,
                'data' => $table,
            ];
        } else {
            $response = [
                'status' => 500,
                'message' => 'internal server error!',
            ];
        }

        return response()->json($response);
    }

    public function insert(Request $request) {
        // validate the request
        $validate = Validator::make($request->all(), [
            'tableName' => 'required',
        ]);
        // if validate fails
        if ($validate->fails()) {
            return response()->json(['errors'=>$validate->errors()->all()]);
        } else {
            // handle request
            $insert = Table::insert([
                'tableName' => $request->input('tableName'),
            ]);

            if ($insert) {
                $data = Table::latest('id')->first();

                $response = [
                    'status' => 200,
                    'data'   => $data
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'internal server error!'
                ];
            }
        }

        return response()->json($response);
    }
}
