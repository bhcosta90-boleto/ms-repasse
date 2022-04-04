<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

final class SynchronizeTable
{
    public static function sincronizar(string $table, $key, $value, $data)
    {
        return DB::table($table)->updateOrInsert([
            $key => $value
        ], $data);
    }
}
