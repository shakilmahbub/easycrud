<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiographiesController;
use App\Http\Controllers\TestBiographiesController;
use App\Http\Controllers\TestForm3sController;
use App\Http\Controllers\TestForm4sController;
use App\admin\Http\Controllers\admin\admin\Biographyoo9sController;
use App\admin\Http\Controllers\admin\admin\Biography09sController;
use App\admin\Http\Controllers\admin\admin\BiographyudatesController;
use App\Http\Controllers\Biographyudate1sController;
use App\Http\Controllers\Biographyudate2sController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'biographies',
], function () {
    Route::get('/', [BiographiesController::class, 'index'])
         ->name('biographies.biography.index');
    Route::get('/create', [BiographiesController::class, 'create'])
         ->name('biographies.biography.create');
    Route::get('/show/{biography}',[BiographiesController::class, 'show'])
         ->name('biographies.biography.show');
    Route::get('/{biography}/edit',[BiographiesController::class, 'edit'])
         ->name('biographies.biography.edit');
    Route::post('/', [BiographiesController::class, 'store'])
         ->name('biographies.biography.store');
    Route::put('biography/{biography}', [BiographiesController::class, 'update'])
         ->name('biographies.biography.update');
    Route::delete('/biography/{biography}',[BiographiesController::class, 'destroy'])
         ->name('biographies.biography.destroy');
});

Route::group([
    'prefix' => 'test_biographies',
], function () {
    Route::get('/', [TestBiographiesController::class, 'index'])
         ->name('test_biographies.test_biography.index');
    Route::get('/create', [TestBiographiesController::class, 'create'])
         ->name('test_biographies.test_biography.create');
    Route::get('/show/{testBiography}',[TestBiographiesController::class, 'show'])
         ->name('test_biographies.test_biography.show')->where('id', '[0-9]+');
    Route::get('/{testBiography}/edit',[TestBiographiesController::class, 'edit'])
         ->name('test_biographies.test_biography.edit')->where('id', '[0-9]+');
    Route::post('/', [TestBiographiesController::class, 'store'])
         ->name('test_biographies.test_biography.store');
    Route::put('test_biography/{testBiography}', [TestBiographiesController::class, 'update'])
         ->name('test_biographies.test_biography.update')->where('id', '[0-9]+');
    Route::delete('/test_biography/{testBiography}',[TestBiographiesController::class, 'destroy'])
         ->name('test_biographies.test_biography.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'test_form3s',
], function () {
    Route::get('/', [TestForm3sController::class, 'index'])
         ->name('test_form3s.test_form3.index');
    Route::get('/create', [TestForm3sController::class, 'create'])
         ->name('test_form3s.test_form3.create');
    Route::get('/show/{testForm3}',[TestForm3sController::class, 'show'])
         ->name('test_form3s.test_form3.show');
    Route::get('/{testForm3}/edit',[TestForm3sController::class, 'edit'])
         ->name('test_form3s.test_form3.edit');
    Route::post('/', [TestForm3sController::class, 'store'])
         ->name('test_form3s.test_form3.store');
    Route::put('test_form3/{testForm3}', [TestForm3sController::class, 'update'])
         ->name('test_form3s.test_form3.update');
    Route::delete('/test_form3/{testForm3}',[TestForm3sController::class, 'destroy'])
         ->name('test_form3s.test_form3.destroy');
});

Route::group([
    'prefix' => 'test_form4s',
], function () {
    Route::get('/', [TestForm4sController::class, 'index'])
         ->name('test_form4s.test_form4.index');
    Route::get('/create', [TestForm4sController::class, 'create'])
         ->name('test_form4s.test_form4.create');
    Route::get('/show/{testForm4}',[TestForm4sController::class, 'show'])
         ->name('test_form4s.test_form4.show')->where('id', '[0-9]+');
    Route::get('/{testForm4}/edit',[TestForm4sController::class, 'edit'])
         ->name('test_form4s.test_form4.edit')->where('id', '[0-9]+');
    Route::post('/', [TestForm4sController::class, 'store'])
         ->name('test_form4s.test_form4.store');
    Route::put('test_form4/{testForm4}', [TestForm4sController::class, 'update'])
         ->name('test_form4s.test_form4.update')->where('id', '[0-9]+');
    Route::delete('/test_form4/{testForm4}',[TestForm4sController::class, 'destroy'])
         ->name('test_form4s.test_form4.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'biographyoo9s',
], function () {
    Route::get('/', [admin\Biographyoo9sController::class, 'index'])
         ->name('biographyoo9s.biographyoo9.index');
    Route::get('/create', [admin\Biographyoo9sController::class, 'create'])
         ->name('biographyoo9s.biographyoo9.create');
    Route::get('/show/{biographyoo9}',[admin\Biographyoo9sController::class, 'show'])
         ->name('biographyoo9s.biographyoo9.show');
    Route::get('/{biographyoo9}/edit',[admin\Biographyoo9sController::class, 'edit'])
         ->name('biographyoo9s.biographyoo9.edit');
    Route::post('/', [admin\Biographyoo9sController::class, 'store'])
         ->name('biographyoo9s.biographyoo9.store');
    Route::put('biographyoo9/{biographyoo9}', [admin\Biographyoo9sController::class, 'update'])
         ->name('biographyoo9s.biographyoo9.update');
    Route::delete('/biographyoo9/{biographyoo9}',[admin\Biographyoo9sController::class, 'destroy'])
         ->name('biographyoo9s.biographyoo9.destroy');
});

Route::group([
    'prefix' => 'biography09s',
], function () {
    Route::get('/', [admin\Biography09sController::class, 'index'])
         ->name('biography09s.biography09.index');
    Route::get('/create', [admin\Biography09sController::class, 'create'])
         ->name('biography09s.biography09.create');
    Route::get('/show/{biography09}',[admin\Biography09sController::class, 'show'])
         ->name('biography09s.biography09.show')->where('id', '[0-9]+');
    Route::get('/{biography09}/edit',[admin\Biography09sController::class, 'edit'])
         ->name('biography09s.biography09.edit')->where('id', '[0-9]+');
    Route::post('/', [admin\Biography09sController::class, 'store'])
         ->name('biography09s.biography09.store');
    Route::put('biography09/{biography09}', [admin\Biography09sController::class, 'update'])
         ->name('biography09s.biography09.update')->where('id', '[0-9]+');
    Route::delete('/biography09/{biography09}',[admin\Biography09sController::class, 'destroy'])
         ->name('biography09s.biography09.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'biographyudates',
], function () {
    Route::get('/', [admin\BiographyudatesController::class, 'index'])
         ->name('biographyudates.biographyudate.index');
    Route::get('/create', [admin\BiographyudatesController::class, 'create'])
         ->name('biographyudates.biographyudate.create');
    Route::get('/show/{biographyudate}',[admin\BiographyudatesController::class, 'show'])
         ->name('biographyudates.biographyudate.show')->where('id', '[0-9]+');
    Route::get('/{biographyudate}/edit',[admin\BiographyudatesController::class, 'edit'])
         ->name('biographyudates.biographyudate.edit')->where('id', '[0-9]+');
    Route::post('/', [admin\BiographyudatesController::class, 'store'])
         ->name('biographyudates.biographyudate.store');
    Route::put('biographyudate/{biographyudate}', [admin\BiographyudatesController::class, 'update'])
         ->name('biographyudates.biographyudate.update')->where('id', '[0-9]+');
    Route::delete('/biographyudate/{biographyudate}',[admin\BiographyudatesController::class, 'destroy'])
         ->name('biographyudates.biographyudate.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'biographyudate1s',
], function () {
    Route::get('/', [Biographyudate1sController::class, 'index'])
         ->name('biographyudate1s.biographyudate1.index');
    Route::get('/create', [Biographyudate1sController::class, 'create'])
         ->name('biographyudate1s.biographyudate1.create');
    Route::get('/show/{biographyudate1}',[Biographyudate1sController::class, 'show'])
         ->name('biographyudate1s.biographyudate1.show')->where('id', '[0-9]+');
    Route::get('/{biographyudate1}/edit',[Biographyudate1sController::class, 'edit'])
         ->name('biographyudate1s.biographyudate1.edit')->where('id', '[0-9]+');
    Route::post('/', [Biographyudate1sController::class, 'store'])
         ->name('biographyudate1s.biographyudate1.store');
    Route::put('biographyudate1/{biographyudate1}', [Biographyudate1sController::class, 'update'])
         ->name('biographyudate1s.biographyudate1.update')->where('id', '[0-9]+');
    Route::delete('/biographyudate1/{biographyudate1}',[Biographyudate1sController::class, 'destroy'])
         ->name('biographyudate1s.biographyudate1.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'biographyudate2s',
], function () {
    Route::get('/', [Biographyudate2sController::class, 'index'])
         ->name('biographyudate2s.biographyudate2.index');
    Route::get('/create', [Biographyudate2sController::class, 'create'])
         ->name('biographyudate2s.biographyudate2.create');
    Route::get('/show/{biographyudate2}',[Biographyudate2sController::class, 'show'])
         ->name('biographyudate2s.biographyudate2.show')->where('id', '[0-9]+');
    Route::get('/{biographyudate2}/edit',[Biographyudate2sController::class, 'edit'])
         ->name('biographyudate2s.biographyudate2.edit')->where('id', '[0-9]+');
    Route::post('/', [Biographyudate2sController::class, 'store'])
         ->name('biographyudate2s.biographyudate2.store');
    Route::put('biographyudate2/{biographyudate2}', [Biographyudate2sController::class, 'update'])
         ->name('biographyudate2s.biographyudate2.update')->where('id', '[0-9]+');
    Route::delete('/biographyudate2/{biographyudate2}',[Biographyudate2sController::class, 'destroy'])
         ->name('biographyudate2s.biographyudate2.destroy')->where('id', '[0-9]+');
});
