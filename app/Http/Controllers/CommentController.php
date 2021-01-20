<?php

namespace App\Http\Controllers;

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

    	$image_id = $request->input('image_id');
    	$content = $request->input('content');


    }
}
