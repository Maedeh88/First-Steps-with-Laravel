<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\attachBanner;
use App\Http\Requests\Currency\store;
use App\Http\Requests\Currency\update;
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
    private $currency_repository;

    public function __construct(CurrencyRepositoryInterface $currency_repository)
    {
        $this->currency_repository = $currency_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $data['currencies'] = Currency::orderBy('id', 'desc')->paginate(5);
        $data['currencies']=$this->currency_repository->paginate(8);

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
        $currency = Currency::query()->findOrFail($id);
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
        $currency = Currency::query()->findOrFail($id);
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
        $currency = Currency::find($id);
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
        if (file_exists("icon/" . $currency->icon)) {
            unlink("icon/" . $currency->icon);
        }
        try {
            $currency->delete();

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

        $currency = Currency::query()->findOrFail($id);
        $data['banners'] = $currency->banners;

        return view('crud.get_banners', $data)->with(['id' => $id]);
    }

    /***
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * show the form for adding a banner to a specified currency
     */
    public function addBanner(int $id)
    {

        $currency = Currency::query()->findOrFail($id);

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

        $currency = Currency::query()->findOrFail($currency_id);
        try {
            $currency->banners()->syncWithoutDetaching($request->banners);
        } catch (Exception|QueryException $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('get_banners')->with('error', 'your data has not been updated successfully');
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
        $currency = Currency::query()->findOrFail($currency_id);
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
