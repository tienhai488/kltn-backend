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
        Schema::create('organization_account_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('birth')->nullable();
            $table->string('website')->nullable();
            $table->string('field')->nullable();
            $table->string('address')->nullable();
            $table->string('username')->nullable();
            $table->text('information')->nullable();
            $table->string('representative_name')->nullable();
            $table->string('representative_phone_number')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('status')->default(AccountRequestStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_account_requests');
    }
};
