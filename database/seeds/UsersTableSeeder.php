<?php

namespace Cat\Database\Seeds;

use Cat\Models\Agente;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getUsuariosAndPasswords() as $user) {
            \Illuminate\Foundation\Auth\User::create($user);
        }
            \Illuminate\Foundation\Auth\User::create([
                    'name'           => 'developer',
                    'cuit'           => '1234567',
                    'email'          => 'admin@remain-it.com',
                    'password'       => bcrypt('remain14159'),
                    'remember_token' => str_random(10),
            ]);
        
    }
    
    public function getUsuariosAndPasswords()
    {
        
        $candidates = [
            ['Maria Victoria Angles', 'vicu2009@gmail.com', '27307629491'],
            ['Ada Elizabeth Vergara', 'adaevergara@gmail.com', '27268551609'],
            ['Sabrina Marcela Bares', 'sabrinabares@hotmail.com', '27310000464'],
            ['Romina Paola Almeira', 'romialme@hotmail.com', '27296595433'],
            ['Paola Eugenia Zambaglione', 'zambaglionep@gmail.com', '27296981597'],
            ['Matias andres moreno', 'mati_9_more@hotmail.com', '20300514910'],
            ['Valeria Andrea Nizza', 'valerianizza@hotmail.com', '27254359152'],
            ['Nicolás del Campo', 'nicolas.delcampo@hotmail.com', '20352289516'],
            ['Denisse Yasmin Gianvittorio', 'denissegianvittorio@hotmail.com.ar', '27372040454'],
            ['Karina Andrea Scozziero', 'kscozziero@outlook.es', '27202001985'],
            ['Olga Cordero', 'olgacordero1960@hotmail.com', '27142928251'],
            ['Alejandro Agustin Mercante', 'ale_mercante@hotmail.com', '20294713639'],
            ['ESTELA FURFARO', 'efurfaro@buenosaires.gob.ar', '27261646809'],
            ['LUCIA VANESA D´ELIA', 'fiamma_delia@hotmail.com', '27235079793'],
            ['Cinthia Soledad Moran', 'cymups06@hotmail.com', '27295307795'],
            ['Kolator Milagros Sofía', 'm.kolator@hotmail.com.ar', '27399194828'],
            ['Sabrina Alejandra Garcia', 'sabrinagarcia_728@hotmail.com', '27297354715'],
            ['Alejandra Graciela Narvarte', 'alenarvarte@yahoo.com.ar', '27270004747'],
            ['Maria Nieves Arizio', 'mnarizio@hotmail.com', '27206956904'],
            ['liliana elizabeth goitia', 'lilianagoitia@yahoo.com.ar', '27293325087'],
            ['Luis Angel Martinez', 'luisangelmar@gmail.com', '20221859953'],
            ['Nancy Romero', 'nanjunr@hotmail.com', '23292477554'],
            ['Dell Arciprette Constanza', 'constanzaestela@hotmail.com', '27241668954'],
            ['Mayra Saguatti', 'mayri89@hotmail.com', '27345545269'],
            ['TOMASI, CRISTIAN HERNAN', 'ch_tomasi@hotmail.com ', '23258954629'],
            ['Julio Tevez', 'jtevez@buenosaires.gob.ar', '20281044762'],
            ['Moretto Sebastian', 'morettosebastian@hotmail.com ', '20251349690'],
            ['Julieta Krawinkel', 'julicurti92@hotmail.com ', '27370355989'],
            ['Gerbasi Veronica', 'veronicagerbasi@hotmail.com ', '27185649062'],
            ['Gianvittorio Romina', 'rodriguez_rojana@hotmail.com ', '27286306913'],
            ['Hubacek Andrea', 'hubacekk@gmail.com ', '23367243384'],
            ['Celestino Veronica', 'veronicaicelestino@gmail.com', '20382548745'],
        ];
        
        foreach ($candidates as $newOne) {
            $pass    = explode('@', $newOne[1]);
            $users[] = [
                'name'           => ucwords($newOne[0]),
                'cuit'           => $newOne[2],
                'email'          => $newOne[1],
                'password'       => bcrypt($pass[0] . '1234'),
                'remember_token' => str_random(10),
            
            ];
        }
        
        return $users;
    }
}
