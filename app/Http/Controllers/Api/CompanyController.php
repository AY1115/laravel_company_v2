<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(CompanyRequest $request) {
        //会社情報の登録をすることができる
        $validation = $request->validated();
        $this->company->create($validation);

        return ["message" => "ok"];
    }

    public function show(int $id) {
        //会社情報の詳細を取得することができる
        $company = $this->company->findOrFail($id);
            //$companies = $this->company->all(); 　※削除処理がされていない全ての会社情報の取得の場合

        return $company;
    }

    public function update(CompanyRequest $request, string $id)
    {
        //会社情報の更新をすることができる
        $validated = $request->validated();
        $this->company->findOrFail($id)->update($validated);

        return ["message" => "ok"];
    }

    public function destroy(string $id)
    {
        //会社情報を論理削除することができる
            //その際必ず請求先情報も論理削除してください
        DB::transaction(function() use ($id) {
            $this->company->findOrFail($id)->deteil->delete();
            $this->company->findOrFail($id)->delete();
        });

        return ["message" => "ok"];
    }

    public function ShowWith(int $id) 
    {
        //会社情報と請求先情報を同時に取得することができる
        $companies = $this->company->findOrFail($id);
        $deteils = $companies->deteil;

        return [$companies, $deteils];
    }

    public function extra1(CompanyDetailRequest $request) 
    {
        //会社情報と請求先情報を同時に登録できる
        $validation = $request->validated();
        DB::transaction(function() use ($validation) {
            $params = $this->company->create($validation);
            $params->deteil()->create($validation);
        });

        return ["message" => "ok"];
    }

    public function extra2(CompanyDetailRequest $request, string $id) 
    {
        //会社情報と請求先情報を同時に更新できる
        $validation = $request->validated();
        DB::transaction(function() use ($id, $validation) {
            $this->company->findOrFail($id)->update($validation);
            $this->company->findOrFail($id)->deteil->update($validation);
        });

        return ["message" => "ok"];
    }
}
