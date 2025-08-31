<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 管理員
 * @property int $id
 * @property string $name 名稱
 * @property string $account 帳號
 * @property string $password 密碼
 * @property bool $enabled 啟用
 * @property Carbon|null $last_login_at 上次登入時間
 * @property string|null $last_login_ip 上次登入IP
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Manager extends Model
{

    use SoftDeletes;

    protected $table = 'manager';

    protected $hidden = [
        'password',
    ];
}
