<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("rating_scale_point", function (Blueprint $table) {
            $table->bigInteger("id")->generatedAs()->always();
            $table->integer("rank");
            $table->string("label", 100);
            $table->string("definition", 300);
            $table->timestamps();

            $table
                ->foreignId("rating_scale_id")
                ->constrained(
                    table: "rating_scale",
                    indexName: "fk_rating_scale_point__rating_scale",
                );

            $table->unique(
                columns: ["rating_scale_id", "label"],
                name: "uq_rating_scale_point__label_per_scale",
            );
        });

        DB::statement(
            "ALTER TABLE public.rating_scale_point ADD CONSTRAINT pk_rating_scale_point PRIMARY KEY (id)",
        );
    }

    public function down(): void
    {
        Schema::dropIfExists("rating_scale_point");
    }
};
