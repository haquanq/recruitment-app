<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("user", function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("username");
            $table->string("password");
            $table->timestamps();

            $table->enum("role", UserRole::cases());
            $table
                ->enum("status", UserStatus::cases())
                ->default(UserStatus::ACTIVE);

            $table
                ->foreignId("position_id")
                ->constrained(
                    table: "position",
                    indexName: "fk_user__position",
                );

            $table->primary(columns: ["id"], name: "uq_user");
            $table->unique(columns: ["email"], name: "uq_user__email");
            $table->unique(columns: ["username"], name: "uq_user__username");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("user");
    }
};
