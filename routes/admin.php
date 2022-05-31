<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VueController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccelometerController;
use App\Http\Controllers\Admin\StabilometryController;
use App\Http\Controllers\Admin\StimulationController;
use App\Models\Role;


Route::get('/app/{any}', [VueController::class, 'render'])
    ->where('any', '.*')
    ->name('admin.vue');

//#####################  Logout  ##########################
Route::get('/logout',
    [LoginController::class,"logout"])
    ->name('admin.logout');

//#####################  Auth User  ##########################
Route::get('/auth/user', [
    UserController::class, 'showAuthUser'
])->name('show_auth_user');


//#####################  SELECTS  ##########################
Route::get('/select/roles', function () {
    return Role::getAll();
})->name('select_role');

Route::get('/select/inv_type', function () {
    return \App\Models\InvType::getAll();
})->name('select_inv_type');

Route::get('/select/stimulation_type', function () {
    return \App\Models\StimulationType::getAll();
})->name('select_stimulation_type');

Route::get('/select/signs_type', function () {
    return \App\Models\SignsType::getAll();
})->name('select_signs_type');


//#####################  USER  ##########################
Route::get('admin/app/users/index-content', [UserController::class, 'indexContent'])
    ->name('admin_user_index_content');

Route::get('admin/app/users/active-user/{userId}', [UserController::class, 'active'])
    ->name('admin_user_active');

Route::post('admin/app/users/create',
    [UserController::class, 'create'])
    ->name('admin_user_create');

Route::post('admin/app/users/update/{userId}',
    [UserController::class, 'upsert'])
    ->name('admin_user_update');

//#####################  Accelometer  ##########################
Route::get('admin/app/accelometer/index-content',
    [AccelometerController::class, 'indexContent'])
    ->name('admin_accelometer_index_content');

Route::get('admin/app/accelometer/active-user/{investigationId}',
    [AccelometerController::class, 'active'])
    ->name('admin_accelometer_active');

Route::post('admin/app/accelometer/create',
    [AccelometerController::class, 'create'])
    ->name('admin_accelometer_create');

Route::post('admin/app/accelometer/update/{investigationId}',
    [AccelometerController::class, 'upsert'])
    ->name('admin_accelometer_update');


//#####################  Stimulation  ##########################
Route::get('admin/app/stimulation/index-content',
    [StimulationController::class, 'indexContent'])
    ->name('admin_stimulation_index_content');

Route::get('admin/app/stimulation/active-user/{investigationId}',
    [StimulationController::class, 'active'])
    ->name('admin_stimulation_active');

Route::post('admin/app/stimulation/create',
    [StimulationController::class, 'create'])
    ->name('admin_stimulation_create');

Route::post('admin/app/stimulation/update/{investigationId}',
    [StimulationController::class, 'upsert'])
    ->name('admin_stimulation_update');

//#####################  Stabilometry  ##########################
Route::get('admin/app/stabilometry/index-content',
    [StabilometryController::class, 'indexContent'])
    ->name('admin_stabilometry_index_content');

Route::get('admin/app/stabilometry/active-user/{investigationId}',
    [StabilometryController::class, 'active'])
    ->name('admin_stabilometry_active');

Route::post('admin/app/stabilometry/create',
    [StabilometryController::class, 'create'])
    ->name('admin_stabilometry_create');

Route::post('admin/app/stabilometry/update/{investigationId}',
    [StabilometryController::class, 'upsert'])
    ->name('admin_stabilometry_update');
