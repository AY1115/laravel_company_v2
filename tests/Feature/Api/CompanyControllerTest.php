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

    public function Company新規作成() {
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

     public function Company新規作成が失敗() {
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

     public function Company情報の取得() {
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

     public function Company情報の取得が失敗() {
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

      public function Company情報の更新() {
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

       public function Company情報の更新が失敗() {
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

     public function detail新規作成() {

        $companydata = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);

        $detaildata = [
            "B_Name" => "テスト：会社名",
            "B_Address" => "テスト：住所",
            "B_Tel" => "テスト：電話番号",
            "B_Dapart" => "テスト：電話番号",
            "B_AddName" => "テスト：名前"
        ];
        
        $res = $this->postJson(route('api.detail.create', $companydata->id), $detaildata);
        $res->assertOk();
     }

     /**
      * @test
      */
     
     public function detail新規作成が失敗() {
        $companydata = Company::factory()->create([
            "Com_Name" => "テスト：会社名",
            "Address" => "テスト：住所",
            "Tel" => "テスト：電話番号",
            "Name" => "テスト：名前"
        ]);

        $detaildata = [
            "B_Name" => 123,
            "B_Address" => "テスト：住所",
            "B_Tel" => "テスト：電話番号",
            "B_Dapart" => "テスト：電話番号",
            "B_AddName" => "テスト：名前"
        ];
        
        $res = $this->postJson(route('api.detail.create', $companydata->id), $detaildata);
        $res->assertStatus(422);
     }

    /**
     * @test
     */

    public function detail情報のみを取得() {
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

        $res = $this->getJson(route('api.detail.show', $companydata->id));
        $res->assertOk();
        $data = $res->json();

        $this->assertSame($detaildata->B_Name, $data["B_Name"]);
        
    }

    /**
     * @test
     */

     public function detail情報の取得失敗() {
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

      public function detail情報の更新() {
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
        $this->assertDatabaseHas("deteils", $updatedata);
                
      }

      /**
       * @test
       */

       public function detail情報の更新が失敗() {
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
            "B_Name" => 123,
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

        public function Companyとdetailの論理削除() {
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

         public function Companyとdetailの削除が失敗() {
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
         }

        /**
         * @test
         */

        public function detailの論理削除() {
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

         public function detailの論理削除が失敗() {
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
         }

         /**
          * @test
          */

          public function Companyとdetailの情報取得() {

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

            $show1 = [
                "Com_Name" => "テスト：会社名",
                "Address" => "テスト：住所",
                "Tel" => "テスト：電話番号",
                "Name" => "テスト：名前"
            ];
            $show2 = [
                "B_Name" => "テスト：会社名",
                "B_Address" => "テスト：住所",
                "B_Tel" => "テスト：電話番号",
                "B_Dapart" => "テスト：電話番号",
                "B_AddName" => "テスト：名前"
            ];
            $res = $this->getJson(route('api.company.showWith', $companydata->id));
            $res->assertOk();

            $this->assertDatabaseHas("companies", $show1);
            $this->assertDatabaseHas("deteils", $show2);
          }


          /**
           * @test
           */

           public function Companyとdetailの情報取得が失敗() {

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

            /**
             * @test
             */

             public function エクストラ課題同時登録() {
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

              public function エクストラ課題同時登録が失敗() {
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

              public function エクストラ課題同時更新() {
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

               public function エクストラ課題同時更新が失敗() {
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

                $res = $this->putJson(route('api.company.update.extra1', $companydata->id + 1), $updatedata);
                $res->assertStatus(404);
            
              }

}
