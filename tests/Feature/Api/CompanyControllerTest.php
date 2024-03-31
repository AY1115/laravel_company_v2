<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Deteil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
    }

    /**
     * @test
     */

    public function 会社情報の登録() {
        $params = [
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ];
        $res = $this->postJson(route('api.company.create'), $params);
        $res->assertOk();
        $companies = Company::all(); 
        
        $this->assertCount(1, $companies);

        $company = $companies->first();

        $this->assertEquals($params['Com_Name'], $company->Com_Name);
        $this->assertEquals($params['Address'], $company->Address);
        $this->assertEquals($params['Tel'], $company->Tel);
        $this->assertEquals($params['Name'], $company->Name);
    }

    /**
     * @test
     */

     public function 会社情報の登録が失敗() {
        //バリデーションエラーにより失敗
        $params = [
            "Com_Name" => null,
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ];
        $res = $this->postJson(route('api.company.create'), $params);
        $res->assertStatus(422);

     }


     /**
      * @test
      */

     public function 会社情報の詳細を取得() {
        
            $params = Company::factory()->create([
                "Com_Name" => "テスト：会社名",
                "Address" => "テスト：住所",
                "Tel" => "テスト：電話番号",
                "Name" => "テスト：名前"
            ]);
            $res = $this->getJson(route('api.company.show', $params->id));
            $res->assertOk();

            $data = $res->json();

            $this->assertSame($params->Com_Name, $data['Com_Name']);
            $this->assertSame($params->Address, $data['Address']);
            $this->assertSame($params->Tel, $data['Tel']);
            $this->assertSame($params->Name, $data['Name']);

     }

     /**
      * @test
      */

     public function 会社情報の詳細存在しない() {
        //対象のIDの会社情報のレコードが存在しない
        $params = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);
        $res = $this->getJson(route('api.company.show', $params->id + 1));
        $res->assertStatus(404);
     }

     /**
      * @test
      */

      public function 会社情報の更新() {
        $params = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);
        $update = [
            "Com_Name" => "更新：会社名",
            "Address" => "更新：住所",
            "Tel" => "更新：電話番号",
            "Name" => "更新：名前"
        ];

        $res = $this->putJson(route('api.company.update', $params->id), $update);
        $res->assertOk();
        $this->assertDatabaseHas("companies", $update);
      }

      /**
       * @test
       */

       public function 会社情報の更新が失敗() {
        //バリデーションエラーにより失敗
        $params = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);
        $update = [
            "Com_Name" => null,
            "Address" => "更新：住所",
            "Tel" => "更新：電話番号",
            "Name" => "更新：名前"
        ];

        $res = $this->putJson(route('api.company.update', $params->id), $update);
        $res->assertStatus(422);

       }


        /**
         * @test
         */

            public function 会社情報と請求先情報を同時に登録() {
            //エクストラ課題
                $companydata = [
                    "Com_Name" => "テスト：会社名",
                    "Address" => "テスト：住所",
                    "Tel" => "テスト：電話番号",
                    "Name" => "テスト：名前",
                    "B_Name" => "テスト：会社名",
                    "B_Address" => "テスト：住所",
                    "B_Tel" => "テスト：電話番号",
                    "B_Dapart" => "テスト：電話番号",
                    "B_AddName" => "テスト：名前"
                ];
                $res = $this->postJson(route('api.company.create.extra1'), $companydata);
                $res->assertOk();
                $companies = Company::all(); 
                $details = Deteil::all(); 
                
                $this->assertCount(1, $companies);
                $this->assertCount(1, $details);

                $company = $companies->first();
                $detail = $details->first();
        
                $this->assertEquals($companydata['Com_Name'], $company->Com_Name);
                $this->assertEquals($companydata['Name'], $company->Name);

                $this->assertEquals($detail->company_id, $company->id);
                $this->assertEquals($companydata['B_Name'], $detail->B_Name);
                $this->assertEquals($companydata['B_AddName'], $detail->B_AddName);
            }


             /**
              * @test
              */

              public function 会社情報と請求先情報を同時に登録が失敗() {
                //エクストラ課題
                //バリデーションエラーにより失敗
                $companydata = [
                    "Com_Name" => null,
                    "Address" => "テスト：住所",
                    "Tel" => "テスト：電話番号",
                    "Name" => "テスト：名前",
                    "B_Name" => "テスト：会社名",
                    "B_Address" => "テスト：住所",
                    "B_Tel" => "テスト：電話番号",
                    "B_Dapart" => "テスト：電話番号",
                    "B_AddName" => "テスト：名前"
                ];
                $res = $this->postJson(route('api.company.create.extra1'), $companydata);
                $res->assertStatus(422);
             }


             /**
              * @test
              */

              public function 会社情報と請求先情報を同時に更新() {
                //エクストラ課題
                $companydata = Company::factory()->create([
                    "Com_Name" => "テスト：会社名",
                    "Address" => "テスト：住所",
                    "Tel" => "テスト：電話番号",
                    "Name" => "テスト：名前"
                ]);
        
                $detaildata = Deteil::factory()->create([
                    "company_id" => $companydata->id,
                    "B_Name" => "テスト：会社名",
                    "B_Address" => "テスト：住所",
                    "B_Tel" => "テスト：電話番号",
                    "B_Dapart" => "テスト：電話番号",
                    "B_AddName" => "テスト：名前"
                ]);

                $updatedata = [
                    "Com_Name" => "更新：会社名",
                    "Address" => "更新：住所",
                    "Tel" => "更新：電話番号",
                    "Name" => "更新：名前",
                    "B_Name" => "更新：会社名",
                    "B_Address" => "更新：住所",
                    "B_Tel" => "更新：電話番号",
                    "B_Dapart" => "更新：電話番号",
                    "B_AddName" => "更新：名前"
                ];

                $res = $this->putJson(route('api.company.update.extra1', $companydata->id), $updatedata);
                $res->assertOk();

                $companies = Company::all(); 
                $details = Deteil::all(); 
                
                $this->assertCount(1, $companies);
                $this->assertCount(1, $details);

                $company = $companies->first();
                $detail = $details->first();

                $this->assertEquals($updatedata["Com_Name"], $company->Com_Name);
                $this->assertEquals($detail->company_id, $company->id);
                $this->assertEquals($updatedata["B_Name"], $detail->B_Name);
            
              }


              /**
               * @test
               */

               public function 会社情報と請求先情報を同時に更新が失敗() {
                //エクストラ課題
                //バリデーションエラーにより失敗

                $companydata = Company::factory()->create([
                    "Com_Name" => "テスト：会社名",
                    "Address" => "テスト：住所",
                    "Tel" => "テスト：電話番号",
                    "Name" => "テスト：名前"
                ]);
        
                $detaildata = Deteil::factory()->create([
                    "company_id" => $companydata->id,
                    "B_Name" => "テスト：会社名",
                    "B_Address" => "テスト：住所",
                    "B_Tel" => "テスト：電話番号",
                    "B_Dapart" => "テスト：電話番号",
                    "B_AddName" => "テスト：名前"
                ]);

                $updatedata = [
                    "Com_Name" => null,
                    "Address" => "更新：住所",
                    "Tel" => "更新：電話番号",
                    "Name" => "更新：名前",
                    "B_Name" => "更新：会社名",
                    "B_Address" => "更新：住所",
                    "B_Tel" => "更新：電話番号",
                    "B_Dapart" => "更新：電話番号",
                    "B_AddName" => "更新：名前"
                ];

                $res = $this->putJson(route('api.company.update.extra1', $companydata->id), $updatedata);
                $res->assertStatus(422);
              }

}
