<template>
    <div class="container">
        <div class="row">

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="text-bold">Crear nueva tarea</h4>
                        <!--vue-circle
                        ref="myUniqueID"
                        :progress="progreso"
                        :size="100"
                        :reverse="false"
                        line-cap="round"
                        :fill="bajo"
                        empty-fill="rgba(0, 0, 0, .1)"
                        :animation-start-value="0.0"
                        :start-angle="0"
                        insert-mode="append"
                        :thickness="5"
                        :show-percent="true"
                        @vue-circle-progress="progress"
                        @vue-circle-end="progress_end">
                        <p>Progreso</p>
                    </vue-circle-->
                    <!--progress-bar
                        :options="options"
                        :value="progress"
                    /-->
                    <!--input type="text" v-model="progress"-->

                   
                    </div>

                    <div class="panel-body">
                        <form>
                           <div class="form-group">
                               <label for="nombre">Nombre</label>
                               <input type="text" v-model="dataTarea.nombre" 
                                        class="form-control" id="nombre" 
                                        placeholder="Ingresar nombre de la tarea" autocomplete="off"
                                >
                           </div>
                           <div class="form-group">
                               <label for="descripcion">Descripcion</label>
                               <textarea class="form-control" name="descripcion"
                                         v-model="dataTarea.descripcion"
                                         id="descripcion" rows="3" 
                                         placeholder="Ingresar descripción de la tarea">
                               </textarea>
                           </div>

                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                <button v-if="modoEdit == false" @click="createTarea()" type="button" class="btn btn-sm btn-success">Registrar</button>
                                <button v-if="modoEdit == true" @click="updateTarea()" type="button" class="btn btn-sm btn-warning">Actualizar</button>
                                <button type="button" @click="cancelarFormTarea()" class="btn btn-sm btn-default">Cancelar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-8">

                <ul class="list-group">
                    <li class="list-group-item border-0 mb-3 shadow-sm" v-for="tarea in tareas" :key="tarea.id">
                        <h4 class="text-bold"> {{tarea.nombre}}</h4>
                        <p class="text-muted">{{tarea.descripcion}}</p>
                        <button @click="getDatosTarea(tarea)" type="button" class="btn btn-sm btn-warning">Editar</button>
                        <button @click="deleteTarea(tarea.id)"  type="button" class="btn btn-sm btn-danger">Eliminar</button>
                    </li>
                    <!--li class="list-group-item border-0 mb-3 shadow-sm">
                        No se registraron proyectos
                    </li--->
                </ul>

            </div>
        </div>
    </div>
</template>

<script>
import VueCircle from 'vue2-circle-progress'
  export default {
    components: {
      VueCircle
    },

        mounted() {
            let app = this;
            app.getTareas();
           
        },

        data: function(){

            return{

                tareas:[],
                progress: 12,
                dataTarea:{},
                modoEdit: false,
                bajo : { color: "red" },
                medio : { color: "yellow" },
                alto : { color: "green" },
                progreso: 50,
                options: {
                    text: {
                        color: '#FFFFFF',
                        shadowEnable: true,
                        shadowColor: '#000000',
                        fontSize: 14,
                        fontFamily: 'Helvetica',
                        dynamicPosition: false,
                        hideText: false
                    },
                    progress: {
                        color: '#2dbd2d',
                        backgroundColor: '#C0C0C0'
                    },
                    layout: {
                        height: 35,
                        width: 140,
                        verticalTextAlign: 61,
                        horizontalTextAlign: 43,
                        zeroOffset: 0,
                        strokeWidth: 30,
                        progressPadding: 0,
                        type: 'line'
                    }
                    }

            }

        },

        methods:{

            progress(event,progress,stepValue){
                console.log(stepValue);
            },
            progress_end(event){
                console.log("Circle progress end");
            },

            getTareas: function(){
                let app = this;
                axios.get('/tareas')
                    .then(function(resp){
                        app.tareas = resp.data;
                    })
                    .catch(function(resp){
                        console.log(resp);
                    })
            },

            createTarea: function(){
                let app = this;
                let nuevaTarea = app.dataTarea;
                axios.post('/tareas/guardar', nuevaTarea)
                    .then(function(resp){
                        app.dataTarea = {};
                        app.getTareas();
                        console.log('tarea creada');

                        app.$fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Tarea registrada',
                                showConfirmButton: false,
                                timer: 1500
                        })
                    })
                    .catch(function(resp){
                        console.log('Error al crear tarea');
                    })
            },

            getDatosTarea: function(tarea){
                let app = this;
                app.modoEdit = true;
                app.dataTarea = tarea;
                console.log(tarea);
            },

            updateTarea: function(){
                let app = this;
                let editaTarea = app.dataTarea;
                axios.put('/tareas/actualizar', editaTarea)
                    .then(function(resp){
                        app.modoEdit = false;
                        app.dataTarea = {};
                        app.getTareas();
                        console.log('tarea actualizada');

                        app.$fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Tarea actualizada',
                                showConfirmButton: false,
                                timer: 1500
                        })
                    })
                    .catch(function(resp){
                        console.log('Error al actualizar tarea');
                    })

            },

            deleteTarea: function(id){
                let app = this;

                app.$fire({
                    title: '¿Seguro de eliminar la tarea?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                    }).then((result) => {
                    if (result.value) {

                        axios.post('/tareas/borrar/'+id)
                        .then(function(resp){
                            console.log('tarea eliminada');
                            app.getTareas();

                            app.$fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Tarea eliminada',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        })
                        .catch(function(resp){
                            console.log('Error al eliminar la tarea');
                        })
                        
                    }
                })

                

             
            },

            cancelarFormTarea: function(accion){

                let app = this;
                app.modoEdit = false;
                app.dataTarea = {};

            },


        }
    }
</script>
<style>
    .cursor-link{
        cursor: pointer;
    }
</style>