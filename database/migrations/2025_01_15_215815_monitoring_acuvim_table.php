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
        // Schema::create('monitoring_acuvim', function (Blueprint $table) {
        //     $table->id('id_acuvim');
        //     $table->string('gateway_name')->nullable();
        //     $table->string('gateway_model')->nullable();
        //     $table->string('gateway_serial')->nullable();
        //     $table->string('device_name')->nullable();
        //     $table->string('device_model')->nullable();
        //     $table->string('device_serial')->nullable();
        //     $table->string('device_online')->nullable();
        //     $table->string('Timestamp')->nullable();
        //     $table->float('Freq_Hz')->nullable();
        //     $table->float('V1')->nullable();
        //     $table->float('V2')->nullable();
        //     $table->float('V3')->nullable();
        //     $table->float('Vnavg_V')->nullable();
        //     $table->float('V12')->nullable();
        //     $table->float('V23')->nullable();
        //     $table->float('V31')->nullable();
        //     $table->float('VIavg_V')->nullable();
        //     $table->float('I1')->nullable();
        //     $table->float('I2')->nullable();
        //     $table->float('I3')->nullable();
        //     $table->float('Iavg_A')->nullable();
        //     $table->float('In')->nullable();
        //     $table->float('P1')->nullable();
        //     $table->float('P2')->nullable();
        //     $table->float('P3')->nullable();
        //     $table->float('Psum_kW')->nullable();
        //     $table->float('Q1')->nullable();
        //     $table->float('Q2')->nullable();
        //     $table->float('Q3')->nullable();
        //     $table->float('Qsum_kvar')->nullable();
        //     $table->float('S1')->nullable();
        //     $table->float('S2')->nullable();
        //     $table->float('S3')->nullable();
        //     $table->float('Ssum_kVA')->nullable();
        //     $table->float('PF1')->nullable();
        //     $table->float('PF2')->nullable();
        //     $table->float('PF3')->nullable();
        //     $table->float('PF')->nullable();
        //     $table->float('Unbl_V')->nullable();
        //     $table->float('Unbl_I')->nullable();
        //     $table->float('LCavg')->nullable();
        //     $table->float('DMD_P_kW')->nullable();
        //     $table->float('DMD_Q_kvar')->nullable();
        //     $table->float('DMD_S_kVA')->nullable();
        //     $table->float('EP_IMP_kWh')->nullable();
        //     $table->float('EP_EXP_kWh')->nullable();
        //     $table->float('EQ_IMP_kvarh')->nullable();
        //     $table->float('EQ_EXP_kvarh')->nullable();
        //     $table->float('EP_TOTAL_kWh')->nullable();
        //     $table->float('EP_NET_kWh')->nullable();
        //     $table->float('EQ_TOTAL_kvarh')->nullable();
        //     $table->float('EQ_NET_kvarh')->nullable();
        //     $table->float('ES_kVAh')->nullable();
        //     $table->float('THD_Va')->nullable();
        //     $table->float('THD_Vb')->nullable();
        //     $table->float('THD_Vc')->nullable();
        //     $table->float('THD_Vavg')->nullable();
        //     $table->float('THD_Ia')->nullable();
        //     $table->float('THD_Ib')->nullable();
        //     $table->float('THD_Ic')->nullable();
        //     $table->float('THD_Iavg')->nullable();
        //     $table->float('Ang_Vb')->nullable();
        //     $table->float('Ang_Vc')->nullable();
        //     $table->float('Ang_Ia')->nullable();
        //     $table->float('Ang_Ib')->nullable();
        //     $table->float('Ang_Ic')->nullable();
        //     $table->float('DMD_I1_A')->nullable();
        //     $table->float('DMD_I2_A')->nullable();
        //     $table->float('DMD_I3_A')->nullable();
        //     $table->float('EPa_IMP_kWh')->nullable();
        //     $table->float('EPa_EXP_kWh')->nullable();
        //     $table->float('EPb_IMP_kWh')->nullable();
        //     $table->float('EPb_EXP_kWh')->nullable();
        //     $table->float('EPc_IMP_kWh')->nullable();
        //     $table->float('EPc_EXP_kWh')->nullable();
        //     $table->float('EQa_IMP_kvarh')->nullable();
        //     $table->float('EQa_EXP_kvarh')->nullable();
        //     $table->float('EQb_IMP_kvarh')->nullable();
        //     $table->float('EQb_EXP_kvarh')->nullable();
        //     $table->float('EQc_IMP_kvarh')->nullable();
        //     $table->float('EQc_EXP_kvarh')->nullable();
        //     $table->float('ESa_kVAh')->nullable();
        //     $table->float('ESb_kVAh')->nullable();
        //     $table->float('ESc_kVAh')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('monitoring_acuvim', function (Blueprint $table) {
            $table->id('id_acuvim');

            // Gateway & Device Info
            $table->string('gateway_name')->nullable();
            $table->string('gateway_model')->nullable();
            $table->string('gateway_serial')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_serial')->nullable();
            $table->boolean('device_online')->nullable();
            $table->timestamp('Timestamp')->nullable();

            // Basic Electrical
            $table->float('Freq_Hz')->nullable();
            $table->float('V1')->nullable();
            $table->float('V2')->nullable();
            $table->float('V3')->nullable();
            $table->float('Vnavg_V')->nullable();
            $table->float('V12')->nullable();
            $table->float('V23')->nullable();
            $table->float('V31')->nullable();
            $table->float('Vlavg_V')->nullable();
            $table->float('I1')->nullable();
            $table->float('I2')->nullable();
            $table->float('I3')->nullable();
            $table->float('Iavg_A')->nullable();
            $table->float('In')->nullable();

            // Power
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
            $table->string('LoadType')->nullable();

            // Energy kWh (Active)
            $table->float('EPa_IMP_kWh')->nullable();
            $table->float('EPb_IMP_kWh')->nullable();
            $table->float('EPc_IMP_kWh')->nullable();
            $table->float('EP_IMP_kWh')->nullable();
            $table->float('EPa_EXP_kWh')->nullable();
            $table->float('EPb_EXP_kWh')->nullable();
            $table->float('EPc_EXP_kWh')->nullable();
            $table->float('EP_EXP_kWh')->nullable();
            $table->float('EP_TOTAL_kWh')->nullable();
            $table->float('EP_NET_kWh')->nullable();

            // Energy kvarh (Reactive)
            $table->float('EQa_IMP_kvarh')->nullable();
            $table->float('EQb_IMP_kvarh')->nullable();
            $table->float('EQc_IMP_kvarh')->nullable();
            $table->float('EQ_IMP_kvarh')->nullable();
            $table->float('EQa_EXP_kvarh')->nullable();
            $table->float('EQb_EXP_kvarh')->nullable();
            $table->float('EQc_EXP_kvarh')->nullable();
            $table->float('EQ_EXP_kvarh')->nullable();
            $table->float('EQ_TOTAL_kvarh')->nullable();
            $table->float('EQ_NET_kvarh')->nullable();

            // Apparent Energy
            $table->float('ESa_kVAh')->nullable();
            $table->float('ESb_kVAh')->nullable();
            $table->float('ESc_kVAh')->nullable();
            $table->float('ES_kVAh')->nullable();

            // Demand
            $table->float('DMD_P_kW')->nullable();
            $table->float('DMD_Q_kvar')->nullable();
            $table->float('DMD_S_kVA')->nullable();
            $table->float('DMD_I1_A')->nullable();
            $table->float('DMD_I2_A')->nullable();
            $table->float('DMD_I3_A')->nullable();

            // Unbalance
            $table->float('Unbl_V')->nullable();
            $table->float('Unbl_I')->nullable();

            // Harmonic Summary (no per-order harmonics)
            $table->float('THD_Va')->nullable();
            $table->float('THD_Vb')->nullable();
            $table->float('THD_Vc')->nullable();
            $table->float('THD_Vavg')->nullable();
            $table->float('THD_Ia')->nullable();
            $table->float('THD_Ib')->nullable();
            $table->float('THD_Ic')->nullable();
            $table->float('THD_Iavg')->nullable();
            $table->float('OTHD_Va')->nullable();
            $table->float('OTHD_Vb')->nullable();
            $table->float('OTHD_Vc')->nullable();
            $table->float('ETHD_Va')->nullable();
            $table->float('ETHD_Vb')->nullable();
            $table->float('ETHD_Vc')->nullable();
            $table->float('THFF_Va')->nullable();
            $table->float('THFF_Vb')->nullable();
            $table->float('THFF_Vc')->nullable();
            $table->float('CF_Va')->nullable();
            $table->float('CF_Vb')->nullable();
            $table->float('CF_Vc')->nullable();
            $table->float('OTHD_Ia')->nullable();
            $table->float('OTHD_Ib')->nullable();
            $table->float('OTHD_Ic')->nullable();
            $table->float('ETHD_Ia')->nullable();
            $table->float('ETHD_Ib')->nullable();
            $table->float('ETHD_Ic')->nullable();
            $table->float('KF_Ia')->nullable();
            $table->float('KF_Ib')->nullable();
            $table->float('KF_Ic')->nullable();

            // Angles
            $table->float('Ang_Vb')->nullable();
            $table->float('Ang_Vc')->nullable();
            $table->float('Ang_Ia')->nullable();
            $table->float('Ang_Ib')->nullable();
            $table->float('Ang_Ic')->nullable();

            // Sequence Components
            $table->float('SEQ_POS_REAL_Va')->nullable();
            $table->float('SEQ_NEG_REAL_Va')->nullable();
            $table->float('SEQ_ZERO_REAL_Va')->nullable();
            $table->float('SEQ_POS_REAL_Ia')->nullable();
            $table->float('SEQ_NEG_REAL_Ia')->nullable();
            $table->float('SEQ_ZERO_REAL_Ia')->nullable();
            $table->float('SEQ_POS_IMG_Va')->nullable();
            $table->float('SEQ_NEG_IMG_Va')->nullable();
            $table->float('SEQ_ZERO_IMG_Va')->nullable();
            $table->float('SEQ_POS_IMG_Ia')->nullable();
            $table->float('SEQ_NEG_IMG_Ia')->nullable();
            $table->float('SEQ_ZERO_IMG_Ia')->nullable();

            // Digital Inputs (DI)
            $table->integer('DI11')->nullable();
            $table->integer('DI12')->nullable();
            $table->integer('DI13')->nullable();
            $table->integer('DI14')->nullable();
            $table->integer('DI15')->nullable();
            $table->integer('DI16')->nullable();

            // Analog Inputs (AI)
            $table->float('AI1')->nullable();
            $table->float('AI2')->nullable();
            $table->float('AI3')->nullable();
            $table->float('AI4')->nullable();

            // IO11 module
            $table->integer('IO11_DI1')->nullable();
            $table->integer('IO11_DI2')->nullable();
            $table->integer('IO11_DI3')->nullable();
            $table->integer('IO11_DI4')->nullable();
            $table->integer('IO11_DI5')->nullable();
            $table->integer('IO11_DI6')->nullable();

            // IO21 module
            $table->integer('IO21_DI1')->nullable();
            $table->integer('IO21_DI2')->nullable();
            $table->integer('IO21_DI3')->nullable();
            $table->integer('IO21_DI4')->nullable();
            $table->float('IO21_AO1')->nullable();
            $table->float('IO21_AO2')->nullable();

            // IO31 module
            $table->integer('IO31_DI1')->nullable();
            $table->integer('IO31_DI2')->nullable();
            $table->integer('IO31_DI3')->nullable();
            $table->integer('IO31_DI4')->nullable();
            $table->float('IO31_AI1')->nullable();
            $table->float('IO31_AI2')->nullable();

            // IO12 module
            $table->integer('IO12_DI1')->nullable();
            $table->integer('IO12_DI2')->nullable();
            $table->integer('IO12_DI3')->nullable();
            $table->integer('IO12_DI4')->nullable();
            $table->integer('IO12_DI5')->nullable();
            $table->integer('IO12_DI6')->nullable();

            // IO22 module
            $table->integer('IO22_DI1')->nullable();
            $table->integer('IO22_DI2')->nullable();
            $table->integer('IO22_DI3')->nullable();
            $table->integer('IO22_DI4')->nullable();
            $table->float('IO22_AO1')->nullable();
            $table->float('IO22_AO2')->nullable();

            // IO32 module
            $table->integer('IO32_DI1')->nullable();
            $table->integer('IO32_DI2')->nullable();
            $table->integer('IO32_DI3')->nullable();
            $table->integer('IO32_DI4')->nullable();
            $table->float('IO32_AI1')->nullable();
            $table->float('IO32_AI2')->nullable();

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
