<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manager', function (Blueprint $table) {
            $table->comment('管理員');
            $table->id();
            $table->string('name', 64)->comment('名稱');
            $table->string('account', 64)->unique('uniq_account')->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->boolean('enabled')->default(false)->comment('啟用');
            $table->timestamp('last_login_at')->nullable()->comment('上次登入時間');
            $table->string('last_login_ip', 48)->nullable()->comment('上次登入IP');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager');
    }
};
