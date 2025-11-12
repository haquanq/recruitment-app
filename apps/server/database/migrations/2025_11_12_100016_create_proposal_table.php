<?php

use App\Enums\ProposalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Pest\Laravel\castAsJson;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("proposal", function (Blueprint $table) {
            $table->bigInteger("id")->generatedAs()->always();
            $table->string("title", 200);
            $table->string("description", 500);
            $table->integer("hire_goal");
            $table->integer("hired_count")->nullable();
            $table->integer("min_salary");
            $table->integer("max_salary");
            $table->timestamps();

            $table
                ->enum("status", ProposalStatus::cases())
                ->default(ProposalStatus::DRAFT);

            $table
                ->foreignId("user_id")
                ->constrained(table: "user", indexName: "fk_proposal__user");
            $table
                ->foreignId("contract_type_id")
                ->constrained(
                    table: "contract_type",
                    indexName: "fk_proposal__contract_type",
                );
            $table
                ->foreignId("education_level_id")
                ->constrained(
                    table: "education_level",
                    indexName: "fk_proposal__education_level",
                );
            $table
                ->foreignId("experience_level_id")
                ->constrained(
                    table: "experience_level",
                    indexName: "fk_proposal__experience_level",
                );
            $table
                ->foreignId("position_id")
                ->constrained(
                    table: "position",
                    indexName: "fk_proposal__position",
                );

            $table->unique(columns: ["title"], name: "uq_proposal__title");
        });

        DB::statement(
            "ALTER TABLE public.proposal ADD CONSTRAINT pk_proposal PRIMARY KEY (id)",
        );
    }

    public function down(): void
    {
        Schema::dropIfExists("proposal");
    }
};
