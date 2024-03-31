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
<div class="border-solid border-b-2 border-gry-500 p-2 mb-2">
  <div class="flex justify-between">
    <h2 class="text-base mb-4">更新</h2>
    <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
      <a href="{{ route('company.index') }}">戻る</a>
    </button>
  </div>
  <form method="POST" action="{{ route('deteil.update', [$company->id]) }}">
    @csrf
    @method('PUT')
    <div class="mb-4">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        社名/かな  
    </label>
    <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        type="text" name="Com_Name" placeholder="新規のTodo" value="{{ $company->Com_Name }}">
    </div>
    <div class="mb-4">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        住所
    </label>
    <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        type="text"name="Address" placeholder="新規のTodo" value="{{ $company->Address }}">
    </div>
    <div class="mb-4">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        電話番号
    </label>
    <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        type="text"name="Tel" placeholder="新規のTodo" value="{{ $company->Tel }}">
    </div>
    <div class="mb-4">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        代表者名/かな
    </label>
    <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        type="text"name="Name" placeholder="新規のTodo" value="{{ $company->Name }}">
    </div>

    <div>請求者情報</div>           
                
      <div class="mb-4">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
          請求先名称/かな
      </label>
      <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text" name="B_Name" value="{{ $deteil->B_Name }}" placeholder="情報を入力して下さい"/>
      </div>
      <div class="mb-4">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
          住所  
      </label>
          <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text" name="B_Address" value="{{ $deteil->B_Address }}" placeholder="情報を入力して下さい"/>
      </div>
      <div class="mb-4">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
          電話番号
      </label>
      <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text" name="B_Tel" value="{{ $deteil->B_Tel }}" placeholder="情報を入力して下さい"/>
      </div>
      <div class="mb-4">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
          請求先部署  
      </label>
      <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text" name="B_Dapart" value="{{ $deteil->B_Dapart }}" placeholder="情報を入力して下さい"/>
      </div>
      <div class="mb-4">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
          請求先宛名/かな  
      </label>
      <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text" name="B_AddName" value="{{ $deteil->B_AddName }}" placeholder="情報を入力して下さい"/>
      </div>


    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
      登録
    </button>
  </form>
</div>
</body>
</html>