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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string ('nom');
            $table->string ('prenom');
            $table->string ('matricule_solde')->unique();
            $table->string('lieu_affectation');
            $table->string('type_agent')->default('titulaire'); // titulaire, contractuel
            $table->integer('nombre_enfants')->default(0);
            $table->date('date_prise_service');
            $table->integer('jours_conges_dus')->default(0);
            $table->integer('jours_reportes')->default(0); // max 72 jours
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
