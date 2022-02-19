<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\attachBanner;
use App\Http\Requests\Currency\store;
use App\Http\Requests\Currency\update;
use App\Logic\Manager\CurrencyManager;
use App\Models\Banner;
use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use mysql_xdevapi\Exception;
use Nette\Utils\Type;


class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['currencies'] = CurrencyManager::getCurrencyManagerInstance()->paginate(8);

        return view('crud.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crud.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(store $request)
    {

        try {
            CurrencyManager::getCurrencyManagerInstance()->store($request);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_currency')->with('error', 'your data has not been created successfully');
        }
        return redirect()->route('index_currency')
            ->with('success', 'Your data has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\company $currency
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {

        $currency = CurrencyManager::getCurrencyManagerInstance()->getById($id);
        return view('crud.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CRUD $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $currency = CurrencyManager::getCurrencyManagerInstance()->getById($id);
        return view('crud.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\crud $currency
     * @return \Illuminate\Http\Response
     */
    public function update(update $request, $id)
    {
        try {
            CurrencyManager::getCurrencyManagerInstance()->update($request, $id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_currency')->with('error', 'your data has not been updated successfully');
        }
        return redirect()->route('index_currency')
            ->with('success', 'Your data Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CRUD $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        try {
            CurrencyManager::getCurrencyManagerInstance()->destroy($currency);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_currency')->with('error', 'your data has not been deleted successfully');
        }
        return redirect()->route('index_currency')->with('success', 'Your data has been deleted successfully');
    }

    /***
     * Show and update banners associated to a specified currency
     */
    public function getBanners(int $id)
    {

//        $currency = Currency::query()->findOrFail($id);
//        $data['banners'] = $currency->banners();
       $currency = CurrencyManager::getCurrencyManagerInstance()->getById($id);
//        $data['banners'] = $currency->banners();
//        dd($data['banners']);

//        return view('crud.get_banners', $data)->with(['id' => $id]);
        return view('crud.get_banners', compact('currency'));
    }

    /***
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * show the form for adding a banner to a specified currency
     */
    public function addBanner(int $id)
    {

        $currency = CurrencyManager::getCurrencyManagerInstance()->getById($id);

        $data['all_banners'] = Banner::orderBy('id', 'desc')->get();

        return view('crud.add_banner', compact('currency'), $data);

    }

    /***
     * @param Request $request
     * @param int $currency_id
     * @return \Illuminate\Http\RedirectResponse
     * store newly added banner to a specified currency
     */
    public function attachBanner(attachBanner $request, int $currency_id)
    {
        $currency = CurrencyManager::getCurrencyManagerInstance()->getById($currency_id);
        try {
            $currency->banners()->syncWithoutDetaching($request->banners);
        } catch (Exception|QueryException $exception) {
            dd($exception->getMessage());
            Log::error($exception->getMessage());
            return redirect()->route('get_banners', $currency_id)->with('error', 'your data has not been updated successfully');
        }
        return redirect()->route('get_banners', $currency_id)->with('success', 'Your data has been updated');
    }

    /***
     * @param int $banner_id
     * @param int $currency_id
     * @return \Illuminate\Http\RedirectResponse
     * delete a certain banner associated with a specified currency
     */
    public function removeBanner(int $currency_id, int $banner_id)
    {
        $currency = CurrencyManager::getCurrencyManagerInstance()->getBuId($currency_id);
        try {
            $currency->banners()->detach($banner_id);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('get_banners')->with('error', 'your data has not been updated successfully');
        }
        return redirect()->route('get_banners', $currency_id)->with('success', 'Your data has been updated');
    }

    /**
     * testing redis for currency caching
     */

    public function test_redis(int $id)
    {
        if (Cache::has('currency_' . $id)) {
            $cached_currency = Cache::get('currency_' . $id);
            if (isset($cached_currency)) {
                $currency = json_decode($cached_currency, FALSE);
                return response()->json([
                    'status_code' => 201,
                    'message' => 'Fetched from redis',
                    'data' => $currency,
                ]);
            }
        } else {
            $currency = Currency::query()->findOrFail($id);
            Cache::put('currency_' . $id, $currency, 60);
            return response()->json([
                'status_code' => 201,
                'message' => 'Fetched from database',
                'data' => $currency,
            ]);
        }
    }


}
