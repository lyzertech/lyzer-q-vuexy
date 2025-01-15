<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('monitoring_acuvim', function (Blueprint $table) {
            $table->id('id_acuvim');
            $table->timestamp('Time')->nullable();
            $table->float('Freq_Hz')->nullable();
            $table->float('V1')->nullable();
            $table->float('V2')->nullable();
            $table->float('V3')->nullable();
            $table->float('Vnavg_')->nullable();
            $table->float('V')->nullable();
            $table->float('V12')->nullable();
            $table->float('V23')->nullable();
            $table->float('V31')->nullable();
            $table->float('VIavg_V')->nullable();
            $table->float('I1')->nullable();
            $table->float('I2')->nullable();
            $table->float('I3')->nullable();
            $table->float('Iavg_A')->nullable();
            $table->float('P1')->nullable();
            $table->float('P2')->nullable();
            $table->float('P3')->nullable();
            $table->float('Psum_kW')->nullable();
            $table->float('Q1')->nullable();
            $table->float('Q2')->nullable();
            $table->float('Q3')->nullable();
            $table->float('Qsum_kvar')->nullable();
            $table->float('S1')->nullable();
            $table->float('S2')->nullable();
            $table->float('S3')->nullable();
            $table->float('Ssum_kVA')->nullable();
            $table->float('PF1')->nullable();
            $table->float('PF2')->nullable();
            $table->float('PF3')->nullable();
            $table->float('PF')->nullable();
            $table->float('Unbl_V')->nullable();
            $table->float('Unbl_I')->nullable();
            $table->float('LCavg')->nullable();
            $table->float('DMD_P_kW')->nullable();
            $table->float('DMD_Q_kvar')->nullable();
            $table->float('DMD_S_kVA')->nullable();
            $table->float('EP_IMP_kWh')->nullable();
            $table->float('EP_EXP_kWh')->nullable();
            $table->float('EQ_IMP_kvarh')->nullable();
            $table->float('EQ_EXP_kvarh')->nullable();
            $table->float('EP_TOTAL_kWh')->nullable();
            $table->float('EP_NET_kWh')->nullable();
            $table->float('EQ_TOTAL_kvarh')->nullable();
            $table->float('EQ_NET_kvarh')->nullable();
            $table->float('ES_kVAh')->nullable();
            $table->float('THD_Va')->nullable();
            $table->float('THD_Vb')->nullable();
            $table->float('THD_Vc')->nullable();
            $table->float('THD_Vavg')->nullable();
            $table->float('THD_Ia')->nullable();
            $table->float('THD_Ib')->nullable();
            $table->float('THD_Ic')->nullable();
            $table->float('THD_Iavg')->nullable();
            $table->float('Ang_Vb')->nullable();
            $table->float('Ang_Vc')->nullable();
            $table->float('Ang_Ia')->nullable();
            $table->float('Ang_Ib')->nullable();
            $table->float('Ang_Ic')->nullable();
            $table->float('DMD_I1_A')->nullable();
            $table->float('DMD_I2_A')->nullable();
            $table->float('DMD_I3_A')->nullable();
            $table->float('EPa_IMP_kWh')->nullable();
            $table->float('EPa_EXP_kWh')->nullable();
            $table->float('EPb_IMP_kWh')->nullable();
            $table->float('EPb_EXP_kWh')->nullable();
            $table->float('EPc_IMP_kWh')->nullable();
            $table->float('EPc_EXP_kWh')->nullable();
            $table->float('EQa_IMP_kvarh')->nullable();
            $table->float('EQa_EXP_kvarh')->nullable();
            $table->float('EQb_IMP_kvarh')->nullable();
            $table->float('EQb_EXP_kvarh')->nullable();
            $table->float('EQc_IMP_kvarh')->nullable();
            $table->float('EQc_EXP_kvarh')->nullable();
            $table->float('ESa_kVAh')->nullable();
            $table->float('ESb_kVAh')->nullable();
            $table->float('ESc_kVAh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_acuvim');
    }
};
