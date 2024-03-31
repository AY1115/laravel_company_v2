<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２
use App\Http\Requests\DetailRequest; //請求先住所のバリデーション
use App\Http\Requests\CompanyDetailRequest; //会社・請求先住所のバリデーション
use Illuminate\Support\Facades\DB; //トランザクションは、DBファサードが提供する機能なので、まずはDBファサードを有効にする

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
        //会社の請求先情報を取得
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
    public function store(DetailRequest $request, string $id)
    {
        //会社の請求先情報を登録
        $validatedDetail = $request->validated();
        $this->company->findOrFail($id)->deteil()->create($validatedDetail); 
        return redirect()->route("company.index");    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //対象のレコード（詳細情報、請求先情報）を取得　　※詳細ボタン
        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;
        return view("company.detail", ["company" => $companies, "deteil" => $deteils]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //更新の際にレコード（詳細情報、請求先情報）を取得　　※編集ボタン

        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;
        return view("company.edit", ["company" => $companies, "deteil" => $deteils]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyDetailRequest $request, string $id)
    {
        //会社情報と請求先情報を同時に更新
        $validation = $request->validated();

        DB::transaction(function() use ($id, $validation) {
            $this->company->findOrFail($id)->update($validation);
            $this->company->findOrFail($id)->deteil->update($validation);
        });

        return redirect()->route("company.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //会社情報と詳細情報を同時に削除

        DB::transaction(function() use ($id) {
            $this->company->findOrFail($id)->deteil->delete();
            $this->company->findOrFail($id)->delete();
        });

        return redirect()->route("company.index");
    }
}
