<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;


trait CustomID
{
    // Generate angka terakhir untuk semua ID, tapi formatnya ditentukan di model masing-masing.
    protected function getLastNumber($prefix = '', $resetYearly = false)
    {
        $query = static::query();

        if ($resetYearly) {
            $query->whereYear('created_at', date('Y'));
        }

        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            $cast = "CAST(REGEXP_REPLACE({$this->getKeyName()}, '[^0-9]', '', 'g') AS INTEGER)";
        } else {
            $cast = "CAST(REGEXP_REPLACE({$this->getKeyName()}, '[^0-9]', '') AS UNSIGNED)";
        }

        return $query->where($this->getKeyName(), 'like', $prefix . '%')
            ->max(DB::raw($cast)) ?? 0;
        }
}
