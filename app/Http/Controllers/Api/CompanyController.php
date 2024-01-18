<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２

class CompanyController extends Controller
{
    //

    private Company $company;
    private Deteil $deteil; //追記２

    public function __construct(Company $company, Deteil $deteil) {
        $this->company = $company;
        $this->deteil = $deteil;

    }
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        //
        //会社情報のバリデーション
        $validated = $request->validate([
            "Com_Name" => ["required", "string", "max:255"],
            "Address" => ["required", "string", "max:255"],
            "Tel" => ["required", "string", "max:255"],
            "Name" => ["required", "string", "max:255"]
        ]);
        $this->company->fill($validated)->save();


        return ["message" => "ok"];
    }

    public function show(int $id) {
        $company = $this->company->findOrFail($id);
        return $company;
    }

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
        return ["message" => "ok"];
    }

    public function destroy(string $id)
    {
        //
        $this->company->findOrFail($id)->deteil->delete();
        $this->company->findOrFail($id)->delete();
        return ["message" => "ok"];
    }

    public function showWith(int $id) {
        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;
        return [$companies, $deteils];

    }

    public function extra1(Request $request) {
        //会社情報のバリデーション
        $validated = $request->validate([
            "Com_Name" => ["required", "string", "max:255"],
            "Address" => ["required", "string", "max:255"],
            "Tel" => ["required", "string", "max:255"],
            "Name" => ["required", "string", "max:255"]
        ]);
        $this->company->fill($validated)->save();

        //詳細情報のバリデーション
        $validatedDetail = $request->validate([ 
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"],
        ]);
        $detail = new Deteil($validatedDetail);
        $this->company->deteil()->save($detail);
        return ["message" => "ok"];
    }

    public function extra2(Request $request, string $id) {
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
        $this->company->findOrFail($id)->deteil->update($validatedDetail);

        return ["message" => "ok"];
    }
}
