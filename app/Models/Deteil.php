<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //追記
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deteil extends Model
{
    //必要に応じてDeteilのコントローラーファイルに処理を、モデルファイルにＨＴＴＰリソースを記述する
    use HasFactory, SoftDeletes;
    protected $fillable = ["B_Name", "B_Address", "B_Tel", "B_Dapart", "B_AddName"];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
