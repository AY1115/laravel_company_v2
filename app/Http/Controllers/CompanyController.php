<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２

class CompanyController extends Controller
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
        //allは論理削除されていないすべてのレコードを取得
        $deteils = $this->deteil->all();
        $companies = $this->company->all(); //追記　MODEL(company.php)で作成した変数の情報をすべて取得
        return view("company.index", ["hensu" => $companies, "deteil" => $deteils]); //$companies の値をビューの変数  'hensu' という名前で渡すもの
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("company.create");
    }

    /**
     * Store a newly created resource in storage.
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

        //詳細情報のバリデーション
        $validatedDetail = $request->validate([ 
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"],
        ]);
        $detail = new Deteil($validatedDetail);
        $this->company->deteil()->save($detail); //deteil()は新しい Deteil モデルを保存してリレーションを確立する


        return redirect()->route("company.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //findOrFailは対象〈１つ〉のレコードを取得
        $companies = $this->company->findOrFail($id);
        return view("company.edit", ["hensu" => $companies]);
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
        return redirect()->route("company.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->company->findOrFail($id)->delete();
        return redirect()->route("company.index");
    }
}
