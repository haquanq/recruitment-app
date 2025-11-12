<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("interview_type", function (Blueprint $table) {
            $table->bigInteger("id")->generatedAs()->always();
            $table->string("name", 100);
            $table->string("description", 300);
            $table->timestamps();


            $table->unique(columns: ["name"], name: "uq_interview_type__name");
        });

        DB::statement(
            "ALTER TABLE public.interview_type ADD CONSTRAINT pk_interview_type PRIMARY KEY (id)",
        );
    }

    public function down(): void
    {
        Schema::dropIfExists("interview_type");
    }
};
