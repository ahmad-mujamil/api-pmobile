<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create-user {--token}';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $nim = $this->ask('nim ');
        $nama = $this->ask('nama ');
        $password = $this->ask('Password ');
        $alamat = $this->ask('Alamat ');
        $tgl_lahir = $this->ask('Tanggal Lahir (yyyy-mm-dd) ');
        $jurusan = $this->ask('Jurusan ');
        $email = $this->ask('Email ');
        $user = User::query()
            ->where('nim',$nim)
            ->first();

        if(!is_null($user)){
            $this->error('user sudah terdaftar !');
        }else{
            $user = User::query()->create([
                    "nim" => $nim,
                    "nama" => $nama,
                    "password" => bcrypt($password),
                    "alamat" => $alamat,
                    "tgl_lahir" => $tgl_lahir,
                    "jurusan" => $jurusan,
                    "email" => $email
                ]);

            if($this->option('token')){
                $token = $user->createToken($nim)->plainTextToken;
                $this->info('token : '.$token);
            }else{
                $this->info('User Created successfully');
            }

        }

    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User';
}
