<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create-token {nim_user?}';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $nim = $this->argument('nim_user');
        if(is_null($nim))
            $nim = $this->ask('NIM User ');

        $user = User::query()
            ->where('nim',$nim)
            ->first();
        if(is_null($user)){
            $this->error('User tidak ditemukan !');
        }else{
            $token = $user->createToken($nim)->plainTextToken;
            $this->info('token : '.$token);
        }

    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat Token User';
}
