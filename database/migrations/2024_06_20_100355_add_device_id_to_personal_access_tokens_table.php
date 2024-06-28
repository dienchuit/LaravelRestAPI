<?php

use App\Models\Device;
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
        Schema::table('user_access_tokens', function (Blueprint $table) {
            $table->foreignIdFor(Device::class, 'device_id')->constrained('devices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_access_tokens', function (Blueprint $table) {
            $table->dropForeign('user_access_tokens_device_id_foreign');
        });
    }
};
