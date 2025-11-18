<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $school_students = [
            ["nis"=>"20251101","name"=>"Alya Putri","gender"=>"Female","class"=>5,"birthdate"=>"2013-04-12","parent_name"=>"Siti Rahma","contact_number"=>"081234567890","address"=>"Jl. Melati Raya No.12, Jakarta","status"=>"Active"],
            ["nis"=>"20251102","name"=>"Bagas Pratama","gender"=>"Male","class"=>6,"birthdate"=>"2012-11-03","parent_name"=>"Budi Santoso","contact_number"=>"081298765432","address"=>"Jl. Anggrek No.5, Depok","status"=>"Active"],
            ["nis"=>"20251103","name"=>"Citra Ayu","gender"=>"Female","class"=>4,"birthdate"=>"2014-06-20","parent_name"=>"Nur Aisyah","contact_number"=>"082112345678","address"=>"Jl. Dahlia No.33, Bekasi","status"=>"Transferred"],
            ["nis"=>"20251104","name"=>"Davin Putra","gender"=>"Male","class"=>6,"birthdate"=>"2012-09-18","parent_name"=>"Hendra Putra","contact_number"=>"081345678912","address"=>"Jl. Kenanga No.22, Tangerang","status"=>"Active"],
            ["nis"=>"20251105","name"=>"Eka Wulandari","gender"=>"Female","class"=>6,"birthdate"=>"2012-02-07","parent_name"=>"Lina Wulandari","contact_number"=>"082134567891","address"=>"Jl. Cemara No.8, Jakarta Barat","status"=>"Graduated"],

            ["nis"=>"20251106","name"=>"Farhan Akbar","gender"=>"Male","class"=>3,"birthdate"=>"2015-03-11","parent_name"=>"M. Akbar","contact_number"=>"081212345001","address"=>"Jl. Pinang No.19, Bogor","status"=>"Active"],
            ["nis"=>"20251107","name"=>"Gita Prameswari","gender"=>"Female","class"=>2,"birthdate"=>"2016-01-29","parent_name"=>"Sri Lestari","contact_number"=>"081227889900","address"=>"Jl. Nangka No.10, Bandung","status"=>"Active"],
            ["nis"=>"20251108","name"=>"Hanif Ramadhan","gender"=>"Male","class"=>1,"birthdate"=>"2017-09-14","parent_name"=>"Rani Ramadhani","contact_number"=>"082145780001","address"=>"Jl. Flamboyan No.7, Tangerang Selatan","status"=>"Active"],
            ["nis"=>"20251109","name"=>"Intan Safira","gender"=>"Female","class"=>4,"birthdate"=>"2014-11-09","parent_name"=>"Sulastri","contact_number"=>"081255661100","address"=>"Jl. Mawar No.2, Bekasi","status"=>"Active"],
            ["nis"=>"20251010","name"=>"Jordi Alexander","gender"=>"Male","class"=>5,"birthdate"=>"2013-05-21","parent_name"=>"Albert Alexander","contact_number"=>"082188990011","address"=>"Jl. Kemuning No.15, Jakarta Timur","status"=>"Active"],

            ["nis"=>"20251011","name"=>"Kayla Meisya","gender"=>"Female","class"=>6,"birthdate"=>"2012-12-02","parent_name"=>"Dewi Kristanti","contact_number"=>"081233445566","address"=>"Jl. Beringin No.4, Bogor","status"=>"Graduated"],
            ["nis"=>"20251012","name"=>"Lukman Fauzi","gender"=>"Male","class"=>3,"birthdate"=>"2015-10-30","parent_name"=>"Fauzi Rahman","contact_number"=>"081299001122","address"=>"Jl. Cendana No.23, Depok","status"=>"Active"],
            ["nis"=>"20251013","name"=>"Melani Cantika","gender"=>"Female","class"=>2,"birthdate"=>"2016-08-19","parent_name"=>"Yuni Puspita","contact_number"=>"082177889922","address"=>"Jl. Sawo No.11, Bandung","status"=>"Active"],
            ["nis"=>"20251014","name"=>"Naufal Rizky","gender"=>"Male","class"=>1,"birthdate"=>"2017-03-07","parent_name"=>"Fajar Prasetyo","contact_number"=>"082199443322","address"=>"Jl. Pahlawan No.6, Jakarta Selatan","status"=>"Active"],
            ["nis"=>"20251015","name"=>"Oriana Rahmi","gender"=>"Female","class"=>4,"birthdate"=>"2014-07-22","parent_name"=>"Rohani","contact_number"=>"081244556677","address"=>"Jl. Merdeka No.8, Tangerang","status"=>"Active"],

            ["nis"=>"20251016","name"=>"Putra Mandala","gender"=>"Male","class"=>5,"birthdate"=>"2013-10-18","parent_name"=>"Syamsul Mandala","contact_number"=>"081377899001","address"=>"Jl. Veteran No.3, Jakarta Barat","status"=>"Active"],
            ["nis"=>"20251017","name"=>"Qiana Ardelia","gender"=>"Female","class"=>3,"birthdate"=>"2015-06-01","parent_name"=>"Marni Ardelia","contact_number"=>"081299774411","address"=>"Jl. Kartini No.9, Bekasi","status"=>"Transferred"],
            ["nis"=>"20251018","name"=>"Rafif Adrian","gender"=>"Male","class"=>2,"birthdate"=>"2016-04-17","parent_name"=>"Deni Adrian","contact_number"=>"082154667788","address"=>"Jl. Cempaka No.14, Bogor","status"=>"Active"],
            ["nis"=>"20251019","name"=>"Salsa Bela","gender"=>"Female","class"=>1,"birthdate"=>"2017-08-25","parent_name"=>"Tina Bela","contact_number"=>"081211778899","address"=>"Jl. Durian No.20, Depok","status"=>"Active"],
            ["nis"=>"20251020","name"=>"Taufik Hidayat","gender"=>"Male","class"=>6,"birthdate"=>"2012-01-12","parent_name"=>"Hidayatullah","contact_number"=>"082166554433","address"=>"Jl. Palem No.16, Jakarta","status"=>"Graduated"],
        ];

        DB::table('school_students')->insert($school_students);
    }
}
