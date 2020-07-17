<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function($user) {
            return $user->is_admin;
        });

        // abbility da netko moze updatati, deletati post | closure(prvi parametar=> USER, u nasem slucaju $post)
        // Gate::define('update-post', function($user, $post) {
        //     return $user->id === $post->user_id;
        // });


        // Gate::define('delete-post', function($user, $post) {
        //     return $user->id === $post->user_id;
        // });


        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        // primjer: comments.create, comments.update etc.
        // sve metode u policy klasi (create,view,update,delete) default
        // Gate::resource('posts', 'App\Policies\BlogPostPolicy');


        // koristimo before kako bi provjerio prije ostalih gateova, i ako je true onda uopce ne pokrene ostale gateove!
        // useful kad imamo admina koji moze sve raditi, brisati, updatati ...
        Gate::before(function ($user, $ability) {
            // ako maknemo delete-post onda ne mozemo obrisati postove!!
            if($user->is_admin && in_array($ability, ['update', /*'delete-post'*/])) {
                return true;
            }
        });

        // result ce biti pasani od strane laravela
        // result ce vratitit true ili false ako idovi ne mecaju kod provjere u gateu
        // Gate::after(function ($user, $ability, $result) {
        //     // ako maknemo delete-post onda ne mozemo obrisati postove!!
        //     if($user->is_admin) {
        //         return true;
        //     }
        // });
    }
}
