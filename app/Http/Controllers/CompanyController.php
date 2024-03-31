<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２
use App\Http\Requests\CompanyRequest; //バリデーション一覧
use App\Http\Requests\CompanyDetailRequest; //会社・請求先住所のバリデーション
use Illuminate\Support\Facades\DB; //トランザクションは、DBファサードが提供する機能なので、まずはDBファサードを有効にする

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
        //会社情報と請求先情報を同時に取得することができる
            //※allは論理削除されていないすべてのレコードを取得
        $deteils = $this->deteil->all();
        $companies = $this->company->all(); //追記　MODEL(company.php)で作成した変数の情報をすべて取得
        return view("company.index", ["hensu" => $companies, "deteil" => $deteils]); //$companies の値をビューの変数  'hensu' という名前で渡すもの
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //情報登録ページに移動
        return view("company.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyDetailRequest $request)
    {
        //会社情報と請求先情報を同時に登録できる
        $validation = $request->validated();

        DB::transaction(function() use ($validation) {
            $params = $this->company->create($validation);
            $params->deteil()->create($validation); //deteil()は新しい Deteil モデルを保存してリレーションを確立する
        });
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
        //会社情報を取得
            //findOrFailは対象〈１つ〉のレコードを取得
        $companies = $this->company->findOrFail($id);
        return view("company.edit", ["hensu" => $companies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, string $id)
    {
        //会社情報の更新
        $validated = $request->validated();
        $this->company->findOrFail($id)->update($validated);
        return redirect()->route("company.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //会社情報のみ削除
        $this->company->findOrFail($id)->delete();
        return redirect()->route("company.index");
    }
}
