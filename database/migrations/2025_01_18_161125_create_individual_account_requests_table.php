<?php

use App\Enum\AccountRequestStatus;
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
        Schema::create('individual_account_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('birth')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('club_name')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->text('information')->nullable();
            $table->string('username')->nullable();
            $table->string('status')->default(AccountRequestStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_account_requests');
    }
};
