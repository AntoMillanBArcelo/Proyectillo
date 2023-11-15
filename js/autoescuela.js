document.addEventListener("DOMContentLoaded", function() {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var preguntas;
    var preguntaActualIndex = 0;

    if (btnComenzar) {
        btnComenzar.addEventListener("click", comenzar);
    } else {
        console.error("El botón 'comenzar' no se encontró en el DOM.");
    }

    function comenzar() {
        fetch("plantilla/pregunta.html")
            .then(x => x.text())
            .then(y => {
                var contenedor = document.createElement("div");
                contenedor.innerHTML = y;
                var pregunta = contenedor.querySelector(".pregunta"); 

                fetch("js/pregunta.json")
                    .then(x => x.json())
                    .then(y => {
                        preguntas = y;  
                        mostrarPregunta();

                        var btnSiguiente = document.getElementById("siguiente");
                        var btnAnterior = document.getElementById("anterior");

                        if (btnSiguiente && btnAnterior) {
                            btnSiguiente.addEventListener("click", mostrarSiguientePregunta);
                            btnAnterior.addEventListener("click", mostrarPreguntaAnterior);
                        } else {
                            console.error("Los botones 'siguiente' o 'anterior' no se encontraron en el DOM.");
                        }
                    });
            });
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
