<?php

namespace App\Logic\Manager;

use App\Http\Requests\Currency\store;
use App\Http\Requests\Currency\update;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;

class CurrencyManager
{
    private static $instance;

    public static function getCurrencyManagerInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function all()
    {
        return Currency::all();
    }

    public function getById(int $id)
    {
        return Currency::query()->findOrFail($id);
    }

    public function paginate(int $id)
    {
        // TODO: Implement paginate() method.
        return Currency::orderBy('id', 'desc')->paginate($id);

    }

    public function store(store $request)
    {
        $icon_name = time() . '.' . $request->icon->extension();
        $request->icon->move(public_path('icon'), $icon_name);

        $digital_currency = new Currency();
        $digital_currency->name = $request->name;
        $digital_currency->symbol = $request->symbol;
        $digital_currency->rank = $request->rank;
        $digital_currency->icon = $icon_name;
        $digital_currency->total_volume = $request->total_volume;
        $digital_currency->daily_volume = $request->daily_volume;
        try {
            $digital_currency->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function update(update $request, int $id)
    {
        $currency_manager = new CurrencyManager();
        $currency = $currency_manager->getById($id);
        if ($request->icon != null) {
            if (file_exists("icon/" . $currency->icon)) {
                unlink("icon/" . $currency->icon);
            }
            $icon_name = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('icon'), $icon_name);
            $currency->icon = $icon_name;
        }
        $currency->name = $request->name;
        $currency->rank = $request->rank;
        $currency->symbol = $request->symbol;
        $currency->total_volume = $request->total_volume;
        $currency->daily_volume = $request->daily_volume;
        try {
            $currency->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function destroy(Currency $currency)
    {
        if (file_exists("icon/" . $currency->icon)) {
            unlink("icon/" . $currency->icon);
        }
        try {
            $currency->delete();

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function getBanners(int $id)
    {
        $currency = CurrencyManager::getCurrencyManagerInstance()->getById($id);
        return $currency;
//        $data['banners'] = $currency->banners();
//        return view('crud.get_banners', $data)->with(['id' => $id]);


    }
}

