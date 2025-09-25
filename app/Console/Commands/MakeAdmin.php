<?php

   namespace App\Console\Commands;

   use App\Models\User;
   use Illuminate\Console\Command;

   class MakeAdmin extends Command
   {
       protected $signature = 'make:admin {email}';
       protected $description = 'Donne le rôle d\'administrateur à un utilisateur existant via son email';

       public function handle()
       {
           $email = $this->argument('email');
           $user = User::where('email', $email)->first();

           if (!$user) {
               $this->error("Aucun utilisateur trouvé avec l'email : $email");
               return 1;
           }

           $user->update(['role' => 'admin']);
           $this->info("L'utilisateur $email est maintenant un administrateur.");
           return 0;
       }
   }