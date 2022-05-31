<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->role();
        $this->invType();
        $this->stimulationType();
        $this->signsType();
        $this->user();
    }

    public function role()
    {
        \DB::table('roles')->insert([
            [
                'name' => "Administrador",
            ],
            [
                'name' => "Alumno",
            ],

        ]);
    }
    public function invType()
    {
        \DB::table('inv_type')->insert([
            [
                'name' => "Acelerometria",
            ],
            [
                'name' => "Estimulacion",
            ],
            [
                'name' => "Estabilometria",
            ],
        ]);
    }
    public function stimulationType()
    {
        \DB::table('stimulation_type')->insert([
            [
                'name' => "Bipolar-Unilateral-Diagonal-Bilateral",
            ],
            [
                'name' => "Monopolar-Unilateral-Diagonal-Bilateral",
            ],

        ]);
    }

    public function signsType()
    {
        \DB::table('signs_type')->insert([
            [
                'name' => "Biopac MP150",
            ],
            [
                'name' => "Wii balance board",
            ],
            [
                'name' => "Delsys",
            ],

        ]);
    }

    public function user()
    {
        \DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@investigaciones.com',
                'password' => bcrypt('prueba123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'fk_id_role' => 1,
            ],
        ]);
    }
}
