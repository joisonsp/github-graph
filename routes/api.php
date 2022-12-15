<?php


use Illuminate\Support\Facades\Route;
use App\Models\Github;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/commit/cadastro', function (Request $request) {
    $commit = new Github();
    $commit->login = $request->login;
    $commit->comments_url = $request->comments_url;
    $commit->date = $request->date;
    $commit->save();

    return $commit;
});
