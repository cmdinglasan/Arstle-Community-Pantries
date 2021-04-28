<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Pantry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            $pantries = Pantry::with(['contacts', 'accounts'])->where('region', $region->region)
                ->orderBy('city', 'ASC')
                ->orderBy('name', 'ASC')
                ->get();
            foreach($pantries as $pantry) {
                $pantryList->push($pantry);
            }
            $pantryCollect->push(['region' => $region->region, 'places' => $pantryList]);
        }
        return Inertia::render('Pantries/Index')->with('pantries', $pantryCollect);
    }
    /**
     * Display all listing of the resource via API call.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function api(Request $request)
    {
        $pantries = Pantry::with(['contacts', 'accounts']);

//        $pantries->where('region', $request->input('region'));
//
//        return $pantries->get();

        $query = $request->all();

        if($request->has('region')) {
            $pantries->where('region', $request->input('region'));
        }

        if($request->has('city')) {
            $pantries->where('city', $request->input('city'));
        }

        if($request->has('order')) {
            if($request->input('order') == 'asc' || $request->input('order') == 'desc') {
                if($request->has('sortBy')) {
                    $pantries->orderBy($request->input('sortBy'), Str::upper($request->input('order')) ?? 'ASC');
                } else {
                    $pantries->orderBy('name', Str::upper($request->input('order')) ?? 'ASC');
                }
            } else {
                return response()->json(['message' => "Order direction must be 'asc' or 'desc' (lowercase only)", 'order' => $request->input['order'], 'requests' => $query]);
            }
        }

        if(count($pantries->get()) > 0) {
            return response()->json($pantries->get()->makeHidden(['id','contributor_id', 'verifier_id']));
        } else {
            return response()->json(['message' => 'No results based on query', 'requests' => $query]);
        }


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
        $validated = $request->validate([
            'name' => 'required|unique:pantries',
            'address' => 'nullable',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'region' => 'required',
            'source' => 'required',
            'contact.person' => 'required',
            'contact.number' => 'nullable',
            'accounts.facebook' => 'nullable',
            'accounts.twitter' => 'nullable',
            'accounts.instagram' => 'nullable',
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
        $pantry->contributor_id = Auth::id();
        $pantry->save();

        if($pantry) {
            $message = 'Successfully added ' . $pantry->name;
            return redirect()->route('pantries.index')->with('message', $message);
        } else {
            $message = 'Error adding ' . $pantry->name;
            return redirect()->back()->with('message', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Pantry $pantry
     * @param Request $request
     * @return \Inertia\Response
     */
    public function show(Pantry $pantry, Request $request)
    {
        $pantry = Pantry::with('contacts','accounts')->findOrFail($request->id);

        return Inertia::render('Pantries/Show')->with('pantry', $pantry);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Pantry $pantry
     * @param Request $request
     * @return \Inertia\Response
     */
    public function edit(Pantry $pantry, Request $request)
    {
        $current = Pantry::with('contacts', 'accounts')->findOrFail($request->id);

        return Inertia::render('Pantries/Edit')->with('pantry', $current);
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
        $pantry = Pantry::with('contacts', 'accounts')->findOrFail($request->id);

        $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'region' => 'required',
            'source' => 'required',
            'contacts.person' => 'nullable',
            'contacts.number' => 'nullable',
            'featured_image_local' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_url' => 'nullable',
        ]);

        $featuredImage = null;
        $imageName = null;

        if($request->featured_image_local) {
            $imageName = time().'.'.$request->featured_image_local->getClientOriginalName();
            if($imageName != $pantry->featured_image_local) {
                $featuredImage = $request->file('featured_image_local')->storeAs('images', $imageName, 'public');
            } else {
                $featuredImage = $pantry->featured_image_local;
            }
        }

//        return $imageName;

        $contact = Contact::findOrFail($pantry->contact_id);
        $contact->name = $request->contacts[0]['name'];
        $contact->contact_num = $request->contacts[0]['contact_num'];
        $contact->save();

        $account = Account::findOrFail($pantry->account_id);
        $account->facebook = $request->accounts[0]['facebook'];
        $account->twitter = $request->accounts[0]['twitter'];
        $account->instagram = $request->accounts[0]['instagram'];
        $account->save();

        $pantry->name = $request->name;
        $pantry->address = $request->address;
        $pantry->barangay = $request->barangay;
        $pantry->city = $request->city;
        $pantry->province = $request->province;
        $pantry->region = $request->region;
        $pantry->contact_id = $contact->id;
        $pantry->account_id = $account->id;
        $pantry->source = $request->source;
        $pantry->featured_image_local = $featuredImage;
        $pantry->featured_image_url = $request->featured_image_url;
        $pantry->save();

        if($pantry) {
            return ['message' => 'Item updated successfully', 'code' => 200];
        };
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
