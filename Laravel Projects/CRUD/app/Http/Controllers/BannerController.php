<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banner\store;
use App\Http\Requests\Banner\update;
use App\Models\Banner;
use App\Models\BannerType;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//use phpDocumentor\Reflection\Type;

class BannerController extends Controller
{
    /**
     * display all banners
     */
    public function index()
    {
        $banner['banners'] = Banner::orderBy('id', 'desc')->paginate(5);
        return view('Banner.index', $banner);
    }

    /***
     * show a from to create a new banner
     */
    public function create()
    {
        $data['types'] = BannerType::orderBy('id', 'desc')->get();


        return view('Banner.create', $data);

    }

    /***
     * Store a newly created banner in storage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(store $request)
    {
//        $request->validate([
//
//        ]);
        $image_name = time() . '.' . $request->image->extension();
        $request->image->move(public_path('BannerImages'), $image_name);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->body = $request->body;
        $banner->image = $image_name;
        $banner->type_id = $request->type_id;

        try {
            $banner->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_banner')->with('error', 'your data has not been created successfully');
        }
        return redirect()->route('index_banner')->with('success', 'New banner has been created successfully');
    }

    /***
     * show a form to edit a specified banner
     */
    public function edit(int $id)
    {
        $banner = Banner::query()->findOrFail($id);
        $data = BannerType::orderBy('id', 'desc')->paginate(5);

        return view('Banner.edit', compact('banner','data'));
    }

    /****
     * update a specified banner in storage
     */
    public function update(update $request, $id)
    {

        $banner = Banner::query()->findOrFail($id);
        /***
         * check if image file has been changed or not
         */
        if ($request->image != null) {

            if (file_exists("BannerImages/" . $banner->image)) {
                unlink("BannerImages/" . $banner->image);
            }
            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('BannerImages'), $image_name);
            $banner->image = $image_name;
        }
        /***
         * check if type id has been changed or not
         */
        if ($request->type_id != null) {
            $banner->type_id = $request->type_id;
        }

        $banner->title = $request->title;
        $banner->body = $request->body;


        try {
            $banner->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_banner')->with('error', 'your data has not been updated successfully');
        }
        return redirect()->route('index_banner')->with('success', 'your data has been updated successfully');
    }

    /***
     * remove the specified banner type from storage
     */
    public function destroy(int $id)
    {
        $banner = Banner::query()->findOrFail($id);
        try {
            $banner->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('index_banner')->with('error', 'your datahas not been deleted successfully');
        }
        return redirect()->route('index_banner')->with('success', 'Your data has been deleted successfully');
    }
}
