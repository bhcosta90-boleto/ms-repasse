<?php

namespace App\Http\Controllers;

use App\Services\RetornoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetornoController extends Controller
{
    public function __construct(private RetornoService $service)
    {

    }
    public function store(Request $request, string $banco)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $result = $this->service->cadastrarRetorno($data + [
                'banco_id' => $banco,
            ]);

            DB::commit();
            return response()->json($result, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $result = [
                'status' => $e->status,
                'message' => $e->errors(),
            ];

            Log::error($data);

            DB::rollBack();
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];

            Log::error($data);

            DB::rollBack();
        }

        return response()->json($result, 400);
    }
}
