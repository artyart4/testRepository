<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       Gate::define('avaliable_message', function (User $user, $id){
           if (Friend::where('user_1',$id)->where('user_2',auth()->id())->where('user_2_accept',1)->orWhere('user_2',$id)->where('user_1',auth()->id())->where('user_2_accept',1)->first()){
               return true;
           }return false;
        });
    }
}
