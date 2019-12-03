<?php

namespace Laravuetest\Http\Controllers;

use Laravuetest\Tareas;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    
    public function index()
    {
        $tareas = Tareas::where("estado","!=","0")->get();
        return $tareas;
        //Esta función nos devolvera todas las tareas que tenemos en nuestra BD
    }


    public function store(Request $request)
    {
        
        $tarea = new Tareas();
        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->estado = "1";

        $tarea->save();

        return $tarea;
        //Esta función guardará las tareas que enviaremos mediante vuejs
    }

    public function update(Request $request, Tareas $tareas)
    {
        $tarea = Tareas::findOrFail($request->id);

        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->estado = "1";

        $tarea->save();

        return $tarea;
        //Esta función actualizará la tarea que hayamos seleccionado
    }

    public function destroy($id)
    {
        $tarea = Tareas::findOrFail($id);

        $tarea->estado = "0";

        $tarea->save();

        return $tarea;
        //Esta función eliminará(cambia de estado) la tarea que hayamos seleccionado
    }
}
