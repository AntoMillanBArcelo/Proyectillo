window.addEventListener("load", function() {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var preguntas;
    var preguntaActualIndex = 0;
    document.getElementById("anterior").addEventListener("click", mostrarPreguntaAnterior);
    document.getElementById("siguiente").addEventListener("click", mostrarSiguientePregunta);

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() {
        fetch("../plantilla/pregunta.html")
            .then(x => x.text())
            .then(y => {
                var contenedor = document.createElement("div");
                contenedor.innerHTML = y;
                var pregunta = contenedor.firstChild;

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
        var preguntasHTML = divExamen.getElementsByClassName("pregunta");
        for (var i = 0; i < preguntasHTML.length; i++) {
            preguntasHTML[i].style.display = i === preguntaActualIndex ? "block" : "none";
        }
    }
});
