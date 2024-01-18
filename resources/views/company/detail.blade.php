<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--cssファイルはpublicディレクトリ以下に置く→assetはpublic以下のファイルを読み込む-->
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>


<body>
    <div class="mt-20 mb-10 flex ">
        <h1 class="colum">COMPANYユーザー情報</h1>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          <a href="{{ route('company.index'); }}">戻る</a>
        </button>
      </div>
      <div>

        <h2 class="colum">会社情報</h2>
            <div class="yoko">
                <div>ID :</div>
                <div class="border_box">{{ $company->id }}</div>
            </div>

            <div class="yoko">
                <div>社名/かな :</div>
                <div class="border_box">{{ $company->Com_Name }}</div>
            </div>

            <div class="yoko">
                <div>住所 :</div>
                <div class="border_box">{{ $company->Address }}</div>
            </div>

            <div class="yoko">
                <div>電話番号 :</div>
                <div class="border_box">{{ $company->Tel }}</div>
            </div>

            <div class="yoko">
                <div>代表者名/かな :</div>
                <div class="border_box">{{ $company->Name }}</div>
            </div>

        <h2 class="colum">請求先情報</h2>
            <div class="yoko">
                <div>請求先名称/かな :</div>
                <div class="border_box">{{ $deteil->B_Name }}</div>
            </div>

            <div class="yoko">
                <div>請求先住所 :</div>
                <div class="border_box">{{ $deteil->B_Address }}</div>
            </div>

            <div class="yoko">
                <div>電話番号 :</div>
                <div class="border_box">{{ $deteil->B_Tel }}</div>
            </div>

            <div class="yoko">
                <div>請求先部署 :</div>
                <div class="border_box">{{ $deteil->B_Dapart }}</div>
            </div>

            <div class="yoko">
                <div>請求先宛名/かな :</div>
                <div class="border_box">{{ $deteil->B_AddName }}</div>
            </div>

    </div>
    
</body>
</html>