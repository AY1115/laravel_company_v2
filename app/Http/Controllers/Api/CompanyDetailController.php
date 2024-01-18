<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２

class CompanyDetailController extends Controller
{
    //
    private Company $company;
    private Deteil $deteil; //追記２

    public function __construct(Company $company, Deteil $deteil) {
        $this->company = $company;
        $this->deteil = $deteil;
    }

    public function store(Request $request, int $id)
    {

        //詳細情報のバリデーション
        $validatedDetail = $request->validate([
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"],
        ]);
        $companydata = $this->company->findOrFail($id);

        $detailModel = new Deteil($validatedDetail);

        $companydata->deteil()->save($detailModel);

        return ["message" => "ok"];
    }

    public function show(string $id)
    {
        //
        $companies = $this->company->findOrFail($id);
        $details = $companies->deteil;
        return $details;
    }

    public function update(Request $request, string $id)
    {
        //
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

    public function destroy(string $id)
    {
        //
        $this->company->findOrFail($id)->deteil->delete();
        return ["message" => "ok"];
    }




}


