<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("interview_evaluation", function (Blueprint $table) {
            $table->bigInteger("id")->generatedAs()->always();
            $table->string("comment", 300);
            $table
                ->foreignId("interview_id")
                ->constrained("interview")
                ->onDelete("cascade");
            $table
                ->foreignId("user_id")
                ->constrained("user")
                ->onDelete("cascade");
            $table->timestamps();

            $table
                ->foreignId("rating_scale_point_id")
                ->constrained("rating_scale_point");

            $table->unique(
                columns: ["interview_id", "user_id"],
                name: "uq_interview_evaluation__per_interview_by_user",
            );
        });

        DB::statement(
            "ALTER TABLE public.interview_evaluation ADD CONSTRAINT pk_interview_evaluation PRIMARY KEY (id)",
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("interview_evaluation");
    }
};
