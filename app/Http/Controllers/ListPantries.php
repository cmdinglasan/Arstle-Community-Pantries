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
use Symfony\Component\Console\Input\Input;

class ListPantries extends Controller
{

    public $regions = [
        'National Capital Region',
        'Cordillera Administrative Region',
        'Region 1: Ilocos Region',
        'Region 2: Cagayan Valley',
        'Region 3: Central Luzon',
        'Region 4A: CALABARZON',
        'Region 4B: MIMAROPA / Southwestern Tagalog',
        'Region 5: Bicol Region',
        'Region 6: Western Visayas',
        'Region 7: Central Visayas',
        'Region 8: Eastern Visayas',
        'Region 9: Zamboanga Peninsula',
        'Region 10: Northern Mindanao',
        'Region 11: Davao Region',
        'Region 12: SOCCSKARGEN',
        'Region 13: Caraga Region',
        'Bangsamoro Autonomous Region in Muslim Mindanao'
    ];

    public $provinces = [
        'Abra',
        'Agusan del Norte',
        'Agusan del Sur',
        'Aklan',
        'Albay',
        'Antique',
        'Apayao',
        'Basilan',
        'Bataan',
        'Batanes',
        'Batangas',
        'Benguet',
        'Biliran',
        'Bohol',
        'Bukidnon',
        'Bulacan',
        'Cagayan',
        'Camarines Norte',
        'Camarines Sur',
        'Camiguin',
        'Capiz',
        'Catanduanes',
        'Cavite',
        'Cebu',
        'Cotabato',
        'Davao de Oro',
        'Davao del Norte',
        'Davao del Sur',
        'Davao Occidental',
        'Dinagat Islands',
        'Eastern Samar',
        'Guimaras',
        'Ifugao',
        'Ilocos Norte',
        'Ilocos Sur',
        'Iloilo',
        'Isabela',
        'Kalinga',
        'La Union',
        'Laguna',
        'Lanao del Norte',
        'Lanao del Sur',
        'Leyte',
        'Maguindanao',
        'Marinduque',
        'Masbate',
        'Misamis Occidental',
        'Misamis Oriental',
        'Mountain Province',
        'NCR, 2nd District',
        'NCR, 3rd District',
        'NCR, 4th District',
        'NCR, Manila',
        'Negros Occidental',
        'Negros Oriental',
        'Northern Samar',
        'Nueva Ecija',
        'Nueva Vizcaya',
        'Occidental Mindoro',
        'Palawan',
        'Pampanga',
        'Pangasinan',
        'Quezon Province',
        'Quirino',
        'Rizal',
        'Romblon',
        'Samar',
        'Saranggani',
        'Siquijor',
        'South Cotabato',
        'Southern Leyte',
        'Sultan Kudarat',
        'Sulu',
        'Surigao del Norte',
        'Surigao del Sur',
        'Tarlac',
        'Tawi-tawi',
        'Zambales',
        'Zamboanga del Norte',
        'Zamboanga del Sur',
        'Zamboanga Sibugay',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
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
        return Inertia::render('Pantries/Index')->with([
            'pantries' => $pantryCollect,
            'provinces' => $this->provinces,
        ]);
    }
    /**
     * Display all listing of the resource via API call.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function api(Request $request)
    {
        $pantries = collect();

        $query = $request->all();

        $searchTerm = $request->input('query');

        if($request->has('coordsOnly')) {
            if($request->input('coordsOnly') == true) {
                $pantries = Pantry::select(['name','latitude','longitude'])->orderBy('name');
            }
        } else {
            $pantries = Pantry::with(['contacts', 'accounts']);

            if(!$query) {
                $pantries->orderBy('name', 'ASC');
            }

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
        }

        if($request->has('search')) {
            $pantries = Pantry::with(['contacts', 'accounts'])
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like','%' . $request->search . '%')
                ->orWhere('region', 'like','%' . $request->search . '%')
                ->orWhere('address', 'like','%' . $request->search . '%')
                ->orWhere('barangay', 'like','%' . $request->search . '%')
                ->orWhere('province', 'like','%' . $request->search . '%')
                ->orderBy('name', 'asc');
        }

        if(count($pantries->get()) > 0) {
            return response()->json($pantries->get()->makeHidden(['id','contributor_id', 'verifier_id', 'contact_id', 'account_id']));
        } else {
            return response()->json(['message' => 'No results based on query', 'requests' => $query]);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Pantries/Create')->with([
            'regions' => $this->regions,
            'provinces' => $this->provinces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $regions = $this->regions;

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
            'featured_image_local' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_url' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
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
        $pantry->province = $this->provinces[$request->province];
        $pantry->region = $this->regions[$request->region];
        $pantry->contact_id = $contact->id;
        $pantry->account_id = $account->id;
        $pantry->source = $request->source;
        $pantry->contributor_id = Auth::id();
        $pantry->featured_image_local = $featuredImage;
        $pantry->featured_image_url = $request->featured_image_url;
        $pantry->longitude = $request->longitude;
        $pantry->latitude = $request->latitude;
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

        foreach($this->regions as $key => $region) {
            if($current->region == $region) {
                $current->region = $key;
            }
        }

        foreach($this->provinces as $key => $province) {
            if($current->province == $province) {
                $current->province = $key;
            }
        }

        return Inertia::render('Pantries/Edit')->with([
            'pantry' => $current,
            'provinces' => $this->provinces,
            'regions' => $this->regions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pantry $pantry
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
            'latitude' => 'nullable',
            'longitude' => 'nullable',
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
        $pantry->province = $this->provinces[$request->province];
        $pantry->region = $this->regions[$request->region];
        $pantry->contact_id = $contact->id;
        $pantry->account_id = $account->id;
        $pantry->source = $request->source;
        $pantry->featured_image_local = $featuredImage;
        $pantry->featured_image_url = $request->featured_image_url;
        $pantry->longitude = $request->longitude;
        $pantry->latitude = $request->latitude;
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
