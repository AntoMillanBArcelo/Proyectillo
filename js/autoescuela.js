document.addEventListener("DOMContentLoaded", function () {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var divPaginacion = document.getElementById("paginacion");
    var preguntas;
    var preguntaActualIndex = 0;
    var preguntaTemplate;

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() {
        fetch("plantilla/pregunta.html")
            .then(x => x.text())
            .then(y => {
                var contenedor = document.createElement("div");
                contenedor.innerHTML = y;
                preguntaTemplate = contenedor.firstChild;

                fetch("js/pregunta.json")
                    .then(x => x.json())
                    .then(y => {
                        preguntas = y.preguntas;
                        mostrarPregunta();
                        mostrarPaginacion();
                    })
                    .catch(error => console.error('Error al cargar preguntas:', error));
            });
    }

    function mostrarPaginacion() {
        for (var i = 0; i < preguntas.length; i++) {
            var numeroPregunta = i + 1;
            var botonPagina = document.createElement("button");
            botonPagina.textContent = numeroPregunta;
            botonPagina.addEventListener("click", function (index) {
                return function () {
                    preguntaActualIndex = index;
                    mostrarPregunta();
                };
            }(i));
            divPaginacion.appendChild(botonPagina);
        }
    }

    function mostrarSiguientePregunta() {
        if (preguntaActualIndex < preguntas.length - 1) {
            preguntaActualIndex++;
            mostrarPregunta();
        }
    }

    function mostrarPreguntaAnterior() {
        if (preguntaActualIndex > 0) {
            preguntaActualIndex--;
            mostrarPregunta();
        }
    }

    function mostrarPregunta() {
        // Elimina cualquier pregunta anterior mostrada
        while (divExamen.firstChild) {
            divExamen.removeChild(divExamen.firstChild);
        }

        // Clona la plantilla de pregunta para mostrarla
        var preguntaClonada = divExamen.appendChild(document.importNode(preguntaTemplate, true));

        // Obtén los datos de la pregunta actual
        var preguntaActual = preguntas[preguntaActualIndex];

        // Llena la pregunta con los datos
        var enunciadoElement = preguntaClonada.querySelector('.enunciado');
        var opcionesElements = preguntaClonada.querySelectorAll('form input[type="radio"] + label');
        var fotoElement = preguntaClonada.querySelector('.url');

        enunciadoElement.textContent = preguntaActual.enunciado;

        opcionesElements.forEach(function(opcion, index) {
            var opcionData = preguntaActual.opciones[index];
            opcion.textContent = opcionData;
        });

        // Muestra la foto de la pregunta con manejo de errores
        fotoElement.onload = function() {
            // La imagen se cargó correctamente
        };
        fotoElement.onerror = function() {
            console.error('Error al cargar la imagen:', preguntaActual.url);
        };
        
        fotoElement.onerror = function() {
            console.error('Error al cargar la imagen:', preguntaActual.url);
        };
        fotoElement.src = preguntaActual.url;
        fotoElement.alt = "Foto de la pregunta";

        // Agrega eventos a los botones de Anterior y Siguiente
        var btnAnterior = preguntaClonada.querySelector("#anterior");
        var btnSiguiente = preguntaClonada.querySelector("#siguiente");

        btnAnterior.addEventListener("click", mostrarPreguntaAnterior);

        if (preguntaActualIndex < preguntas.length - 1) {
            // Si no es la última pregunta, agrega el evento al botón "Siguiente"
            btnSiguiente.addEventListener("click", mostrarSiguientePregunta);
        } else {
            // Si es la última pregunta, agrega un botón "Enviar" con el evento correspondiente
            var btnEnviar = document.createElement("button");
            btnEnviar.textContent = "Enviar";
            btnEnviar.id = "enviar";
            preguntaClonada.querySelector("main").appendChild(btnEnviar);

            btnEnviar.addEventListener("click", function() {
                // Realiza la lógica de envío o muestra el mensaje "Fin"
                alert("Fin");
            });
        }

        // Agrega evento al botón "Borrar" para desmarcar la opción seleccionada
        var btnBorrar = preguntaClonada.querySelector(".borrar");
        btnBorrar.addEventListener("click", function() {
            // Desmarca la opción seleccionada
            var opcionesRadio = preguntaClonada.querySelectorAll('form input[type="radio"]');
            opcionesRadio.forEach(function(opcion) {
                opcion.checked = false;
            });
        });
    }
});
