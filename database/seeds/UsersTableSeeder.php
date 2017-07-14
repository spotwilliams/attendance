<?php

namespace Cat\Database\Seeds;

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
        
        $mails = [
            'vicu2009@gmail.com',
            'adaevergara@gmail.com',
            'sabrinabares@hotmail.com',
            'romialme@hotmail.com',
            'zambaglionep@gmail.com',
            'mati_9_more@hotmail.com',
            'valerianizza@hotmail.com',
            'nicolas.delcampo@hotmail.com',
            'denisse-gianvittorio@hotmail.com.ar',
            'kscozziero@outlook.es',
            'olgacordero1960@hotmail.com',
            'ale_mercante@hotmail.com',
            'efurfaro@buenosaires.gob.ar',
            'fiamma_delia@hotmail.com',
            'cymups06@hotmail.com',
            'm.kolator@hotmail.com.ar',
            'sabrinagarcia_728@hotmail.com',
            'alenarvarte@yahoo.com.ar',
            'mnarizio@hotmail.com',
            'lilianagoitia@yahoo.com.ar',
            'luisangelmar@gmail.com',
            'nanjunr@hotmail.com',
            'constanzaestela@hotmail.com',
            'mayri89@hotmail.com',
            'ch_tomasi@hotmail.com',
            'jtevez@buenosaires.gob.ar',
            'morettosebastian@hotmail.com',
            'julicurti92@hotmail.com',
            'veronicagerbasi@hotmail.com',
            'rodriguez_rojana@hotmail.com',
            'hubacekk@gmail.com',
            'veronicaicelestino@gmail.com',
        ];
        
        foreach ($mails as $mail) {
            $pass    = explode('@', $mail);
            $users[] = [
                'email'          => $mail,
                'password'       => bcrypt($pass[0] . '1234'),
                'remember_token' => str_random(10),
            ];
        }
        
        return $users;
    }
}
