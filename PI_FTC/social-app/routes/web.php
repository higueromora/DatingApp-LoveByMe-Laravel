<?php

use App\Http\Controllers\LikeMatchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// use App\Image;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {

//     $images = Image::all();
//     foreach($images as $image){
//         echo $image->image_path."<br/>";
//         echo $image->description."<br/>";
//         // echo $image->user->name.' '.$image->user->surname;
//         echo $image->User->name.' '.$image->User->surname.'<br/>';

//         if(count($image->comments) >= 1){
//             echo '<strong>Comentario</strong>';
//             foreach($image->comments as $comment){
//                 echo $comment->user->name.' '.$comment->User->surname.':'.$comment->content.'<br/>';
//             }
//         }
        
//         echo 'LIKES: '.count($image->likes);
//         echo "<hr/>";
//     }

//     die();
//     return view('welcome');
// });



//GENERALES
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//USUARIOS
Route::get('/configuration', 'App\Http\Controllers\UserController@config')->name('config');
Route::post('/user/update', 'App\Http\Controllers\UserController@update')->name('user.update');
Route::post('/user/update-password', 'App\Http\Controllers\UserController@updatePassword')->name('user.updatePassword');

Route::get('/user/avatar/{filename}', 'App\Http\Controllers\UserController@getImage')->name('user.avatar');
Route::get('/perfil/{id}', 'App\Http\Controllers\UserController@profile')->name('profile');
Route::get('/gente/{search?}', 'App\Http\Controllers\UserController@index')->name('user.index');
Route::post('/user/{id}/updateProfileDescription', [UserController::class, 'updateProfileDescription'])->name('user.updateProfileDescription');

//Borrado de datos
Route::post('/user/delete', 'App\Http\Controllers\UserController@delete')->name('user.delete')->middleware('auth');
Route::post('/user/{id}/delete', 'App\Http\Controllers\UserController@deleteProfile')->name('user.deleteProfile')->middleware('auth');
Route::post('/image/delete/admin/{id}', 'App\Http\Controllers\ImageController@deleteAdmin')->name('image.delete.admin')->middleware('auth');
Route::post('/comment/delete/admin/{id}', 'App\Http\Controllers\CommentController@deleteAdmin')->name('comment.delete.admin')->middleware('auth');


//IMAGEN
Route::get('/subir-imagen', 'App\Http\Controllers\ImageController@create')->name('image.create');
Route::post('/image/save', 'App\Http\Controllers\ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'App\Http\Controllers\ImageController@getImage')->name('image.file');
Route::get('/imagen/delete/{id}', 'App\Http\Controllers\ImageController@delete')->name('image.delete');
Route::get('/imagen/editar/{id}', 'App\Http\Controllers\ImageController@edit')->name('image.edit');
Route::post('/image/update', 'App\Http\Controllers\ImageController@update')->name('image.update');
Route::get('/imagen/{id}', 'App\Http\Controllers\ImageController@detail')->name('image.detail');

//COMENTARIOS
Route::post('/comment/save', 'App\Http\Controllers\CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'App\Http\Controllers\CommentController@delete')->name('comment.delete');

//LIKES
Route::get('/like/{image_id}', 'App\Http\Controllers\LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'App\Http\Controllers\LikeController@dislike')->name('like.delete');
Route::get('/likes', 'App\Http\Controllers\LikeController@index')->name('like.index');

//Matches
Route::get('/likematch/{id}', [LikeMatchController::class, 'likematch']);
Route::get('/dislikematch/{id}', [LikeMatchController::class, 'dislikematch']);
Route::get('/matches/{search?}', 'App\Http\Controllers\UserMatchController@indexmatch')->name('matches.indexmatch');
// Route::get('/chatmatches}', 'App\Http\Controllers\UserMatchController@chatmatches')->name('chat.matches');
Route::get('/match/{search?}', 'App\Http\Controllers\UserMatchController@indexmatch')->name('user.match.index');

//Messages chat
Route::get('/chatmatches/{userId}', 'App\Http\Controllers\MessageController@chatmatches')->name('chat.matches');
Route::post('/messages/send', 'App\Http\Controllers\MessageController@sendMessage')->name('messages.send');
Route::post('/messages/update-read-at', 'App\Http\Controllers\MessageController@updateReadAt')->name('messages.update_read_at');


// Ver mensajes pendientes
Route::get('/check-unread-messages', [MessageController::class, 'checkUnreadMessages']);


// Bloquear usuarios
Route::post('/block/{id}', 'App\Http\Controllers\BlockUserController@block')->name('user.block');
Route::post('/unblock/{id}', 'App\Http\Controllers\BlockUserController@unblock')->name('user.unblock');
Route::get('/blocked-users', 'App\Http\Controllers\BlockUserController@index')->name('user.blocked');
