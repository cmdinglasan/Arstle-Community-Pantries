<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Pantry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ListPantries extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $regions = DB::table('pantries')
            ->select('region')
            ->groupBy('region')
            ->get();

        $pantryCollect = collect();

        foreach($regions as $region) {
            $pantryList = collect();
            $pantries = Pantry::with(['contacts', 'accounts'])->where('region', $region->region)->get();
            foreach($pantries as $pantry) {
                $pantryList->push($pantry);
            }
            $pantryCollect->push(['region' => $region->region, 'places' => $pantryList]);
        }

        return response()->json($pantryCollect);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Pantries/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        if($request) {
//            return response()->json($request);
//        }

//        $contact = Contact::create(
//            Request::validate([
//                'name' => $request->contact['person'],
//                'contact_num' => $request->contact['number'],
//            ])
//        );
//
//        $account = Account::create(
//            Request::validate([
//                'facebook' => $request->accounts['facebook'],
//                'twitter' => $request->accounts['twitter'],
//                'instagram' => $request->accounts['instagram'],
//            ])
//        );
//
//        $pantry = Pantry::create(
//            Request::validate([
//                'name' => $request->name,
//                'address' => $request->address,
//                'barangay' => $request->barangay,
//                'city' => $request->city,
//                'province' => $request->province,
//                'region' => $request->region,
//                'contacts_id' => $contact->id,
//                'accounts_id' => $account->id,
//                'source' => $request->source,
//            ])
//        );

        $validated = $request->validate([
            'name' => 'required|unique:pantries',
            'address' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'region' => 'required',
            'source' => 'required',
            'contact.person' => 'required',
            'contact.number' => 'required',
            'accounts.facebook' => 'required',
            'accounts.twitter' => 'required',
            'accounts.instagram' => 'required',
        ]);

        $contact = new Contact();
        $contact->name = $request->contact['person'];
        $contact->contact_num = $request->contact['number'];
        $contact->save();

        $account = new Account();
        $account->facebook = $request->accounts['facebook'];
        $account->twitter = $request->accounts['twitter'];
        $account->instagram = $request->accounts['instagram'];
        $account->save();

        $pantry = new Pantry();
        $pantry->name = $request->name;
        $pantry->address = $request->address;
        $pantry->barangay = $request->barangay;
        $pantry->city = $request->city;
        $pantry->province = $request->province;
        $pantry->region = $request->region;
        $pantry->contact_id = $contact->id;
        $pantry->account_id = $account->id;
        $pantry->source = $request->source;
        $pantry->save();

        if($pantry) {
            $message = 'Successfully added ' . $pantry->name;

            return redirect()->route('pantries.show')->with('message', $message);
        } else {
            $message = 'Error adding ' . $pantry->name;
            return redirect()->back()->with('message', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pantry  $pantry
     * @return \Illuminate\Http\Response
     */
    public function show(Pantry $pantry)
    {
        $regions = DB::table('pantries')
        ->select('region')
        ->groupBy('region')
        ->get();

        $pantryCollect = collect();

        foreach($regions as $region) {
            $pantryList = collect();
            $pantries = Pantry::with(['contacts', 'accounts'])->where('region', $region->region)->get();
            foreach($pantries as $pantry) {
                $pantryList->push($pantry);
            }
            $pantryCollect->push(['region' => $region->region, 'places' => $pantryList]);
        }
        return Inertia::render('Pantries/Show')->with('pantries', $pantryCollect);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pantry  $pantry
     * @return \Illuminate\Http\Response
     */
    public function edit(Pantry $pantry)
    {
        return Inertia::render('Pantries/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pantry  $pantry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pantry $pantry)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pantry  $pantry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pantry $pantry)
    {
        //
    }
}
