<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\CommonTrait;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Advert;
use App\Picture;

class AdvertsController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Advert::with('picture')->get();
        return view('admin.adverts.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAd = request()->validate([
            'start_display' => 'bail|required|date',
            'end_display' => 'required|date',
        ]);

        request()->validate(['image' => 'required|image']);

        $ad = Advert::create($validatedAd);
        
        if($file = $request->file('image')){
            $path = request()->file('image')->store('public/upload/images/welcome');
            $picture = new Picture();
            $picture->path = substr($path, 6);

            $ad->picture()->save($picture);
        }
        $this->updateStatisticDate();
        session()->flash('notification_management_admin', 'L\'annonce a bien été enregistrée');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Advert::findOrFail($id);

        return view('admin.adverts.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedAd = request()->validate([
            'start_display' => 'bail|required|date',
            'end_display' => 'required|date',
        ]);
        request()->validate(['image' => 'nullable|image']);

        $ad = Advert::findOrFail($id);
        $ad->update($validatedAd);
        
        if($file = $request->file('image')){
            $previousPicture = $ad->picture->first();
            unlink(storage_path('app/public' . $previousPicture->path));
            $previousPicture->delete();

            $path = request()->file('image')->store('public/upload/images/welcome');
            $picture = new Picture();
            $picture->path = substr($path, 6);

            $ad->picture()->save($picture);
        }
        $this->updateStatisticDate();
        session()->flash('notification_management_admin', 'L\'annonce a bien été mise-à-jour');

        return redirect('/administration/annonces');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Advert::findOrFail($id);

        if($ad->picture->count()){
            unlink(storage_path('app/public' . $ad->picture->first()->path));
            $ad->picture->first()->delete();
        }
        $ad->delete();
        
        $this->updateStatisticDate();
        session()->flash('notification_management_admin', 'L\'annonce a bien été supprimée');
        return redirect('/administration/annonces');
    }
}
