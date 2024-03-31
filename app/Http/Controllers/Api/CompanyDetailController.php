<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; //追記
use App\Models\Deteil; //追記２
use App\Http\Requests\DetailRequest; //請求先住所のバリデーション
use App\Http\Requests\CompanyDetailRequest; //会社・請求先住所のバリデーション
use Illuminate\Support\Facades\DB; //トランザクションは、DBファサードが提供する機能なので、まずはDBファサードを有効にする

class CompanyDetailController extends Controller
{

    private Company $company;
    private Deteil $deteil; //追記２

    public function __construct(Company $company, Deteil $deteil) {
        $this->company = $company;
        $this->deteil = $deteil;
    }

    public function store(DetailRequest $request, int $id)
    {
        //会社の請求先情報を登録することができる
        $validatedDetail = $request->validated();
        $this->company->findOrFail($id)->deteil()->create($validatedDetail); 

        return ["message" => "ok"];
    }

    public function show(string $id)
    {
        //会社の請求先情報だけを取得することができる
        $detail = $this->company->findOrFail($id)->deteil;
            //$detail = $this->deteil->all();　　※削除処理がされていない全ての請求先情報の取得の場合

        return $detail;
    }

    public function update(DetailRequest $request, string $id)
    {
        //会社の請求先情報を更新することができる
        $validation = $request->validated();
        $this->company->findOrFail($id)->deteil->update($validation);

        return ["message" => "ok"];
    }

    public function destroy(string $id)
    {
        //会社の請求先情報だけを論理削除することができる
        $this->company->findOrFail($id)->deteil->delete();

        return ["message" => "ok"];
    }




}


