<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewComposerServiceProvider extends ServiceProvider
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
        View::composer(['users.create', 'users.edit'], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });

        View::composer(['employees.create', 'employees.edit','attendances.index'], function ($view) {
            return $view->with(
                'departments',
                \App\Models\Department::select('id', 'department_name')->get()
            );
        });

        View::composer(['employees.create', 'employees.edit'], function ($view) {
            return $view->with(
                'gpslocations',
                \App\Models\Gpslocation::select('id', 'gpc_location_name')->get()
            );
        });


        View::composer(['earnings.create', 'earnings.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'employee_id')->get()
            );
        });

        View::composer(['deductions.create', 'deductions.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'employee_id')->get()
            );
        });

        View::composer(['monthlies.create', 'monthlies.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'bpjs_health_no')->get()
            );
        });

        View::composer(['news.create', 'news.edit'], function ($view) {
            return $view->with(
                'categorynews',
                \App\Models\Categorynews::select('id', 'category_name')->get()
            );
        });

        View::composer(['news.create', 'news.edit'], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });


        View::composer(['attendances.create', 'attendances.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'full_name')->get()
            );
        });

        View::composer(['izinsakits.create', 'izinsakits.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'full_name')->get()
            );
        });


		View::composer(['report-attendances.index'], function ($view) {
            return $view->with(
                'departments',
                \App\Models\Department::select('id', 'department_name')->get()
            );
        });


		View::composer(['attendance-revisions.create', 'attendance-revisions.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'employee_id')->get()
            );
        });

		View::composer(['leave-requests.create', 'leave-requests.edit'], function ($view) {
            return $view->with(
                'employees',
                \App\Models\Employee::select('id', 'employee_id')->get()
            );
        });

		View::composer(['news.create', 'news.edit'], function ($view) {
            return $view->with(
                'categorynews',
                \App\Models\Categorynews::select('id', 'category_name')->get()
            );
        });

		View::composer(['news.create', 'news.edit'], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });


		View::composer(['galeries.create', 'galeries.edit'], function ($view) {
            return $view->with(
                'categoryGaleries',
                \App\Models\CategoryGalery::select('id', 'name_category')->get()
            );
        });

	}
}