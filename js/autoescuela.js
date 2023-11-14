document.addEventListener("DOMContentLoaded", function() {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var preguntas;
    var preguntaActualIndex = 0;
    var preguntaTemplate;

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() {
        fetch("../plantilla/pregunta.html")
            .then(x => x.text())
            .then(y => {
                var contenedor = document.createElement("div");
                contenedor.innerHTML = y;
                preguntaTemplate = contenedor.firstChild;

                fetch("../js/pregunta.json")
                    .then(x => x.json())
                    .then(y => {
                        preguntas = y.preguntas;
                        cargarPreguntas();
                        mostrarPregunta();
                    });
            });
    }

    function cargarPreguntas() {
        // Puedes realizar alguna lógica aquí para cargar las preguntas en el HTML
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
            var opcionData = preguntaActual.opciones[0]; // Supongo que todas las preguntas tienen el mismo formato para las opciones
            opcion.textContent = opcionData['opcion' + (index + 1)];
        });

        // Muestra la foto de la pregunta
        fotoElement.src = preguntaActual.url;
        fotoElement.alt = "Foto de la pregunta";

        // Agrega eventos a los botones de Anterior y Siguiente
        var btnAnterior = preguntaClonada.querySelector("#anterior");
        var btnSiguiente = preguntaClonada.querySelector("#siguiente");

        btnAnterior.addEventListener("click", mostrarPreguntaAnterior);
        btnSiguiente.addEventListener("click", mostrarSiguientePregunta);
    }
});

