<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Listing;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(): View
    {
        $listings = Listing::with(['categories', 'sizes', 'colors', 'user.city'])
            ->when(request('title'), function ($query) {    // se nella request (nella querystring) c'è title
                $query->where('title', 'LIKE', '%'.request('title').'%');
            })
            ->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($query2) { // ManyToMany Relationship
                    $query2->where('id', request('category'));
                });
            })
            ->when(request('size'), function ($query) {
                $query->whereHas('sizes', function ($query2) { // ManyToMany Relationship
                    $query2->where('id', request('size'));
                });
            })
            ->when(request('color'), function ($query) {
                $query->whereHas('colors', function ($query2) { // ManyToMany Relationship
                    $query2->where('id', request('color'));
                });
            })
            ->when(request('city'), function ($query) {
                $query->whereHas('user.city', function ($query2) {
                    $query2->where('id', request('city'));
                });
            })
            ->when(request('saved'), function ($query) {
                $query->whereHas('savedUsers', function ($query2) {
                    $query2->where('id', auth()->id());
                });
            })
            ->paginate(5)->withQueryString(); // senza si resettano i search parameter al cambio pagina

        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $cities = City::all();

        return view('listings.index',
            compact('listings', 'categories', 'sizes', 'colors', 'cities'));
    }


    public function create(): View
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('listings.create',
            compact('categories', 'sizes', 'colors'));
    }


    public function store(StoreListingRequest $request): RedirectResponse
    {
        $listing = auth()->user()->listings()->create($request->validated());

        for ($i=1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->attach($request->categories); // scrivo così per "popolare" la relationship
        $listing->sizes()->attach($request->sizes);
        $listing->colors()->attach($request->colors);

        return redirect()->route('listings.index');
    }


    public function show(Listing $listing): Response
    {
        //
    }


    public function edit(Listing $listing): View
    {
        $this->authorize('update', $listing); // per proteggere il link diretto
        $listing->load('categories', 'sizes', 'colors'); // carico le relationship che servono nella view

        $media = $listing->getMedia('listings');
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('listings.edit',
            compact('listing', 'media', 'categories', 'sizes', 'colors'));
    }


    public function update(StoreListingRequest $request, Listing $listing): RedirectResponse
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        for ($i=1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->sync($request->categories); // aggiorno le relationship
        $listing->sizes()->sync($request->sizes);
        $listing->colors()->sync($request->colors);

        return redirect()->route('listings.index');
    }


    public function destroy(Listing $listing): RedirectResponse
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()->route('listings.index');
    }


    public function deletePhoto($listingId, $photoId): RedirectResponse
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($listingId);

        $photo = $listing->getMedia('listings')->where('id', $photoId)->first();

        if ($photo) {
            $photo->delete();
        }

        return redirect()->route('listings.edit', $listingId);
    }
}
