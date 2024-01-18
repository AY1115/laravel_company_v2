<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //追記
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory, SoftDeletes; //追記　SoftDeletesはデータ削除する際の時間などを追加する

    protected $fillable = ["Com_Name", "Address", "Tel", "Name"]; //追記
    protected $dates = ['created_at', 'updated_at']; // 追記
    public function deteil() {
        return $this->HasOne(Deteil::class, 'company_id');
    }
}
