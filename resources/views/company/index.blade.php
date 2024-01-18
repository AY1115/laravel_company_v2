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
        <h1 class="text-base">COMPANY一覧</h1>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          <a href="{{ route('company.create'); }}">新規追加</a>
        </button>
      </div>
      <div>
      <div>会社情報</div>
      <form method="POST">
        <table class="table-auto">
          <thead>
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">作成日時</th>
              <th class="px-4 py-2">更新日時</th>
              <th class="px-4 py-2">社名/かな</th>
              <th class="px-4 py-2">住所</th>
              <th class="px-4 py-2">電話番号</th>
              <th class="px-4 py-2">代表者名/かな</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($hensu as $company): ?>
            <tr>
              <td class="border px-4 py-2">{{ $company->id }}</td>
              <td class="border px-4 py-2">{{ $company->created_at }}</td>
              <td class="border px-4 py-2">{{ $company->updated_at }}</td>
              <td class="border px-4 py-2">{{ $company->Com_Name }}</td>
              <td class="border px-4 py-2">{{ $company->Address }}</td>
              <td class="border px-4 py-2">{{ $company->Tel }}</td>
              <td class="border px-4 py-2">{{ $company->Name }}</td>
              <td class="border px-4 py-2"><a class="bt" href="{{ route('deteil.show', [$company->id]); }}">詳細</a></td>
              <td class="border px-4 py-2"><a class="bt" href="{{ route('deteil.edit', [$company->id]); }}">編集</a></td>
              <form method="POST" action="{{ route('deteil.destroy', [$company->id]); }}">
                @csrf
                @method('DELETE')
                <td class="border px-4 py-2"><button class="bt">削除</button></td>
              </form>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </form>
    </div>
    
</body>
</html>