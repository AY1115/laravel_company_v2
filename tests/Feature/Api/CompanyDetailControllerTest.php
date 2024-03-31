<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Deteil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
    }

    /**
     * @test
     */

     public function 会社の請求先情報を登録() {

        $companydata = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);

        $detaildata = [
            "B_Name" => "テスト：請求先会社名",
            "B_Address" => "テスト：請求先住所",
            "B_Tel" => "テスト：請求先電話番号",
            "B_Dapart" => "テスト：請求先電話番号",
            "B_AddName" => "テスト：請求先名前"
        ];
        
        $res = $this->postJson(route('api.detail.create', $companydata->id), $detaildata);
        $res->assertOk();

        $details = Deteil::all(); 
        $this->assertCount(1, $details);
        $detail = $details->first();

        $this->assertEquals($detaildata['B_Name'], $detail->B_Name);
        $this->assertEquals($detaildata['B_Address'], $detail->B_Address);
        $this->assertEquals($detaildata['B_Tel'], $detail->B_Tel);
        $this->assertEquals($detaildata['B_Dapart'], $detail->B_Dapart);
        $this->assertEquals($detaildata['B_AddName'], $detail->B_AddName);

     }


      /**
      * @test
      */
  
      public function 会社の請求先情報を登録が失敗() {
        //バリデーションエラーにより失敗
        $companydata = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);

        $detaildata = [
            "B_Name" => null,
            "B_Address" => "テスト：請求先住所",
            "B_Tel" => "テスト：請求先電話番号",
            "B_Dapart" => "テスト：請求先電話番号",
            "B_AddName" => "テスト：請求先名前"
        ];
        
        $res = $this->postJson(route('api.detail.create', $companydata->id), $detaildata);
        $res->assertStatus(422);

        $companies = Company::all(); 
        $this->assertCount(1, $companies);

        $details = Deteil::all(); 
        $this->assertCount(0, $details);

     }


     /**
     * @test
     */

    public function 会社の請求先情報だけを取得() {
        $companydata = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);

        $detaildata = Deteil::factory()->create([
            "company_id" => $companydata->id,
            "B_Name" => "テスト：請求先会社名",
            "B_Address" => "テスト：請求先住所",
            "B_Tel" => "テスト：請求先電話番号",
            "B_Dapart" => "テスト：請求先電話番号",
            "B_AddName" => "テスト：請求先名前"
        ]);

        $res = $this->getJson(route('api.detail.show', $companydata->id));
        $res->assertOk();
        $data = $res->json();

        $this->assertSame($detaildata->B_Name, $data["B_Name"]);
        
    }


    /**
     * @test
     */

     public function 会社の請求先情報の取得が失敗() {
        //対象のIDの請求先情報のレコードが存在しない
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

        $res = $this->getJson(route('api.detail.show', $companydata->id + 1));
        $res->assertStatus(404);
     }


     /**
      * @test
      */

      public function 会社の請求先情報を更新() {
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
            "B_Name" => "更新：会社名",
            "B_Address" => "更新：住所",
            "B_Tel" => "更新：電話番号",
            "B_Dapart" => "更新：電話番号",
            "B_AddName" => "更新：名前"
        ];

        $res = $this->putJson(route('api.detail.update', $companydata->id), $updatedata);
        $res->assertOk();

        $details = Deteil::all(); 
        $this->assertCount(1, $details);
        $detail = $details->first();
        $this->assertEquals($updatedata['B_Name'], $detail->B_Name);                
      }


      /**
       * @test
       */

       public function 会社の請求先情報の更新が失敗() {
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
            "B_Name" => null,
            "B_Address" => "更新：住所",
            "B_Tel" => "更新：電話番号",
            "B_Dapart" => "更新：電話番号",
            "B_AddName" => "更新：名前"
        ];
        $res = $this->putJson(route('api.detail.update', $companydata->id), $updatedata);
        $res->assertStatus(422);
                
       }


       /**
        * @test
        */

        public function 会社情報と請求先情報の論理削除() {
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

            $res = $this->deleteJson(route('api.company.delete', $companydata->id));
            $res->assertOk();
            $this->assertCount(0, Company::all());
            $this->assertCount(0, Deteil::all());
        }


        /**
         * @test
         */

         public function 会社情報と請求先情報の論理削除が失敗() {
            //対象のレコードのIDが存在しないためエラー
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

            $res = $this->deleteJson(route('api.company.delete', $companydata->id + 1));
            $res->assertStatus(404);

            $this->assertCount(1, Company::all());
            $this->assertCount(1, Deteil::all());
         }


         /**
         * @test
         */

        public function 会社の請求先情報だけを論理削除() {
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

            $res = $this->deleteJson(route('api.detail.delete', $companydata->id));
            $res->assertOk();

            $this->assertCount(1, Company::all());
            $this->assertCount(0, Deteil::all());
        }


        /**
         * @test
         */

         public function 会社の請求先情報だけを論理削除が失敗() {
            //対象のレコードのIDが存在しないためエラー
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

            $res = $this->deleteJson(route('api.detail.delete', $companydata->id + 1));
            $res->assertStatus(404);

            $this->assertCount(1, Company::all());
            $this->assertCount(1, Deteil::all());
         }


         /**
          * @test
          */

          public function 会社情報と請求先情報を同時に取得() {

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

            $res = $this->getJson(route('api.company.showWith', $companydata->id));
            $res->assertOk();

            $companies = Company::all(); 
            $this->assertCount(1, $companies);
            $company = $companies->first();
            $this->assertEquals($companydata['Com_Name'], $company->Com_Name); 

            $details = Deteil::all(); 
            $this->assertCount(1, $details);
            $detail = $details->first();
            $this->assertEquals($detaildata['B_Name'], $detail->B_Name);  
          }


          /**
           * @test
           */

           public function 会社情報と請求先情報を同時に取得が失敗() {
            //対象のレコードのIDが存在しないためエラー

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

            $res = $this->getJson(route('api.company.showWith', $companydata->id + 1));
            $res->assertStatus(404);
        }



}
