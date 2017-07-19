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
    }
    
    public function getUsuariosAndPasswords()
    {
        
        $candidates = [
            [
                'vicu2009@gmail.com',
                '27307629491',
            ],
            [
                'adaevergara@gmail.com',
                '27268551609',
            ],
            [
                'sabrinabares@hotmail.com',
                '27310000464',
            ],
            [
                'romialme@hotmail.com',
                '27296595433',
            ],
            [
                'zambaglionep@gmail.com',
                '27296981597',
            ],
            [
                'mati_9_more@hotmail.com',
                '20300514910',
            ],
            [
                'valerianizza@hotmail.com',
                '27254359152',
            ],
            [
                'nicolas.delcampo@hotmail.com',
                '20352289516',
            ],
            [
                'denissegianvittorio@hotmail.com.ar',
                '27372040454',
            ],
            [
                'kscozziero@outlook.es',
                '27202001985',
            ],
            [
                'olgacordero1960@hotmail.com',
                '27142928251',
            ],
            [
                'ale_mercante@hotmail.com',
                '20294713639',
            ],
            [
                'efurfaro@buenosaires.gob.ar',
                '27261646809',
            ],
            [
                'fiamma_delia@hotmail.com',
                '27235079793',
            ],
            [
                'cymups06@hotmail.com',
                '27295307795',
            ],
            [
                'm.kolator@hotmail.com.ar',
                '27399194828',
            ],
            [
                'sabrinagarcia_728@hotmail.com',
                '27297354715',
            ],
            [
                'alenarvarte@yahoo.com.ar',
                '27270004747',
            ],
            [
                'mnarizio@hotmail.com',
                '27206956904',
            ],
            [
                'lilianagoitia@yahoo.com.ar',
                '27293325087',
            ],
            [
                'luisangelmar@gmail.com',
                '20221859953',
            ],
            [
                'nanjunr@hotmail.com',
                '23292477554',
            ],
            [
                'constanzaestela@hotmail.com',
                '27241668954',
            ],
            [
                'mayri89@hotmail.com',
                '27345545269',
            ],
            [
                'ch_tomasi@hotmail.com',
                '23258954629',
            ],
            [
                'jtevez@buenosaires.gob.ar',
                '20281044762',
            ],
            [
                'morettosebastian@hotmail.com',
                '20251349690',
            ],
            [
                'julicurti92@hotmail.com',
                '27370355989',
            ],
            [
                'veronicagerbasi@hotmail.com',
                '27185649062',
            ],
            [
                'rodriguez_rojana@hotmail.com',
                '27286306913',
            ],
            [
                'hubacekk@gmail.com',
                '23367243384',
            ],
            [
                'veronicaicelestino@gmail.com',
                '20382548745',
            ],
        ];
        
        foreach ($candidates as $newOne) {
            $pass    = explode('@', $newOne[0]);
            $agente  = (Agente::where('cuit', '=', $newOne[1])->first());
            $users[] = [
                'email'          => $newOne[0],
                'password'       => bcrypt($pass[0] . '1234'),
                'remember_token' => str_random(10),
                'id_agente'      => ($agente === null ? null : $agente->id),
            
            ];
        }
        
        return $users;
    }
}
