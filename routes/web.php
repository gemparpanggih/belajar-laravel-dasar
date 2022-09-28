<?php

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\SampleMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\URL;

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

Route::get('/gempar', function () {
    return 'gempar';
});

Route::redirect('gemparpanggih', 'gempar');

Route::view('/hello1', 'hello', ['name' => 'gempar']);

Route::get('/hello2', function () {
    return view('hello', ['name' => 'gempar']);
});

Route::get('/hello-world', function () {
    return view('hello.world');
});

Route::get('/products/{id}', function ($productId) {
    return "Products: " . $productId;
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Products: " . $productId . ", Items: " . $itemId;
})->name('product.item.detail');

Route::get('/category/{category}', function (string $category) {
    return "Category: " . $category;
})->where('category', '[0-9]+')->name('category.detail');;

Route::get('/users/{userId?}', function (string $userId = '404') {
    return "User: " . $userId;
})->name('user.detail');;

Route::get('/produk/{produkId}', function ($produkId) {
    $link = route('product.detail', ['id' => $produkId]);
    return "Link: " . $link;
});

Route::get('/produk-redirect/{produkId}', function ($produkId) {
    return redirect()->route('product.detail', array('id' => $produkId));
});

Route::get('/conflict/{name?}', function (string $name) {
    return "conflict: " . $name;
});

Route::get('/conflict/gempar', function () {
    return "conflict: gempar 2";
});


Route::fallback(function() {
    return '404';
});


Route::controller(HelloController::class)->prefix('/controller/hello')->group(function () {
    Route::get('/request', 'request');
    Route::get('/{name}', 'hello');    
});


Route::controller(InputController::class)->prefix('/input')->group(function () {
    Route::get('/hello','hello');
    Route::post('/hello','hello');
    Route::get('/hello/firstname','helloFirst');
    Route::get('/hello/lastname','helloLast');
    Route::get('/hello/input','helloInput');
    Route::get('/hello/array','arrayInput');
    Route::post('/type','inputType');
    Route::post('/filter/only','filterOnly');
    Route::post('/filter/except','filterExpect');
    Route::post('/filter/merge','filterMerge');
});

Route::post('/file/upload', [FileController::class, 'upload'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('response/hello', [ResponseController::class, 'response']);

Route::get('response/header', [ResponseController::class, 'header']);

Route::controller(ResponseController::class)->prefix('response/type')->group(function () {
    Route::get('/view', 'responseView');
    Route::get('/json', 'responseJson');
    Route::get('/file', 'responseFile');
    Route::get('/download', 'responseDownload');
});

Route::controller(CookieController::class)->prefix('/cookie')->group(function () {
    Route::get('/set', 'createCookie');
    Route::get('/get', 'getCookie');
    Route::get('/clear', 'clearCookie');
});

Route::controller(RedirectController::class)->prefix('/redirect')->group(function () {
    Route::get('/from', 'redirectFrom');
    Route::get('/to', 'redirectTo');
    Route::get('/name', 'redirectName');
    Route::get('/name/{name}', 'redirectHello')->name('redirect-hello');
    Route::get('/action', 'redirectAction');
    Route::get('/away', 'redirectAway');
});

Route::middleware(['sample:GP,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () { return 'OK'; }); 
    Route::get('/group', function () { return 'GROUP'; });
    Route::get('/api-with-param', function () { return 'PARAM'; });
});

Route::get('url/action', function () {

    return URL::action([FormController::class, 'form'], []); 
});

Route::get('/form', [FormController::class, 'form']);

Route::post('/form', [FormController::class, 'submitForm']);

Route::get('url/current', function () {
    return URL::full();
});

Route::get('redirect/name/{name}', [RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');

Route::get('url/named', function () {
    return route('redirect-hello', ['name' => 'gempar']);
});

Route::get('session/create', [SessionController::class, 'createSession']);

Route::get('session/get', [SessionController::class, 'getSession']);

Route::get('error/sample', function () {
    throw new Exception('Sample Error');
});

Route::get('error/manual', function () {
    report(new Exception("Sample Error"));
    return 'OK';
});

Route::get('error/validation', function () {
    throw new ValidationException('Validation Error');
});

Route::get('abort/400', function () {
    abort(400, "Validation Error Message");
});

Route::get('abort/401', function () {
    abort(401);
});

Route::get('abort/500', function () {
    abort(500);
});
