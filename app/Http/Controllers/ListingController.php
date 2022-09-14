<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show All Listing 
    public function index()
    {
        return view('listings.index', [
            // 'heading' => 'Latest Listings',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    // Show Single Listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing //Listing::find($id)
        ]);
    }

    // Show Create Form
    public function create()
    {
        return view('listings.create');
    }

    // Store Listing Data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // if ($request->hasFile('logo')) {
        //     $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        // }

        // $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }
}
