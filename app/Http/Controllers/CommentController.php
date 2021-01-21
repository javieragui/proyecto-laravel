<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Restringir acceso
    //Para que no entre en configuración del usuario sin estar logeado
    public function __construct() {
        $this->middleware('auth');
    }

    //Función para recoger los datos del comentario de cada foto
    public function store(Request $request) {

    	$validate = $this->validate($request, [
         'image_id' => 'integer|required',
         'content' => 'string|required'
     ]);

        //Recoger datos
        $user = \Auth::User();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asigno los valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la bd
        $comment->save();

        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])->with([
            'message' => 'Has publicado tu comentario correctamente!!'
        ]);

    }

    //Eliminar comentario propio
    public function delete($id){
        //Conseguir datos del usuario logueado
        $user = \Auth::User();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario o de la publicación
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            //Eliminar comentario
            $comment->delete();

            //Redirección
            return redirect()->route('image.detail', ['id' => $comment->image->id])->with([
                'message' => 'Comentario eliminado correctamente!!'
            ]);
        }else{
            //Redirección
            return redirect()->route('image.detail', ['id' => $comment->image->id])->with([
                'message' => 'El comentario no se ha eliminado!!'
            ]);
        }
    }
}
