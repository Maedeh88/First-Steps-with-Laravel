<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function getById(int $id)
    {
        return Currency::where('id' . $id)->get();
    }

    public function paginate(int $id)
    {
        // TODO: Implement paginate() method.
        return Currency::orderBy('id', 'desc')->paginate($id);

    }
}
