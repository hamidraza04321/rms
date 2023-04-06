<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data) {
            $response = collect([ 'status' => true ])->merge($data);
            return Response::json($response);
        });

        Response::macro('errors', function ($errors) {
            return Response::json([
                'status' => false,
                'errors' => $errors
            ]);
        });

        Response::macro('successMessage', function ($message) {
            return Response::json([
                'status'  => true,
                'message' => $message
            ]);
        });

        Response::macro('errorMessage', function ($message) {
            return Response::json([
                'status'  => false,
                'message' => $message
            ]);
        });
    }
}
