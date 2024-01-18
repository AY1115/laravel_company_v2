<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２

class DetailController extends Controller
{

    private Company $company;
    private Deteil $deteil; //追記２

    public function __construct(Company $company, Deteil $deteil) {
        $this->company = $company;
        $this->deteil = $deteil;

    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $deteils = $this->deteil->all();
        return view("company.detail", ['deteil' => $deteils]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validatedDetail = $request->validate([ 
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"],
        ]);
        $detail = new Deteil($validatedDetail);
        $this->company->deteil()->save($detail); 


        return redirect()->route("company.index");    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;
        return view("company.detail", ["company" => $companies, "deteil" => $deteils]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;
        return view("company.edit", ["hensu" => $companies, "hensu1" => $deteils]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            "Com_Name" => ["required", "string", "max:255"],
            "Address" => ["required", "string", "max:255"],
            "Tel" => ["required", "string", "max:255"],
            "Name" => ["required", "string", "max:255"]
        ]);
        $this->company->findOrFail($id)->update($validated);

        $validatedDetail = $request->validate([ 
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"],
        ]);
        $this->company->findOrFail($id)->deteil->update($validatedDetail); //deteilは既存の Deteil モデルを更新する
        
        return redirect()->route("company.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->company->findOrFail($id)->deteil->delete();
        $this->company->findOrFail($id)->delete();

        return redirect()->route("company.index");
    }
}
