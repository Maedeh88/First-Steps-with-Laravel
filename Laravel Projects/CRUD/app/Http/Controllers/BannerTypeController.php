<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerType\store;
use App\Http\Requests\BannerType\update;
use App\Models\BannerType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerTypeController extends Controller
{
    /**
     * display all banner types
     */
    public function index()
    {
        $data['banner_types'] = BannerType::orderBy('id', 'desc')->paginate(5);

        return view('BannerType.index', $data);
    }

    /***
     * show a from to create a new banner type
     */
    public function create()
    {
        return view('BannerType.create');
    }

    /***
     * Store a newly created banner type in storage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(store $request)
    {

        $banner_type = new BannerType();
        $banner_type->name = $request->name;
        try {
            $banner_type->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_banner_type')->with('error', 'your data has not been created successfully');
        }
        return redirect()->route('index_banner_type')->with('success', 'New banner type has been created successfully');
    }

    /***
     * show a form to edit a specified banner type
     */
    public function edit(int $id)
    {
        $banner_type = BannerType::query()->findOrFail($id);
        return view('BannerType.edit', compact('banner_type'));
    }

    /****
     * update a specified banner type in storage
     */
    public function update(update $request, $id)
    {
        $banner_type = BannerType::find($id);
        $banner_type->name = $request->name;
        try {
            $banner_type->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_banner_type')->with('error', 'your data has not been updated successfully');
        }
        return redirect()->route('index_banner_type')->with('success', 'your data has been updated successfully');
    }

    /***
     * remove the specified banner type from storage
     */
    public function destroy(int $id)
    {
        $banner_type = BannerType::query()->findOrFail($id);
        try {
            $banner_type->delete();
        }catch (Exception|QueryException $e){
            Log::error($e->getMessage());
            return redirect()->route('index_banner_type')->with('error', 'your data has not been deleted successfully');
        }
        return redirect()->route('index_banner_type')->with('success', 'Your data has been deleted successfully');
    }
}
