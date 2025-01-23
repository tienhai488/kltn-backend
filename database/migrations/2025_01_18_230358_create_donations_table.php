<?php

use App\Enum\AnonymousStatus;
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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('amount', 16, 4)->nullable();
            $table->tinyInteger('is_anonymous')->default(AnonymousStatus::OFF);
            $table->string('note')->nullable();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('class')->nullable();
            $table->string('student_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};