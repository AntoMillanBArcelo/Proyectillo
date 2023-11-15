document.addEventListener("DOMContentLoaded", function () {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var preguntas;
    var preguntaActual = 0;

    if (btnComenzar) {
        btnComenzar.addEventListener("click", function () {
            btnComenzar.style.display = "none";
            fetch("plantilla/pregunta.html")
                .then(x => x.text())
                .then(plantilla => {
                    fetch("js/pregunta.json")
                        .then(x => x.json())
                        .then(data => {
                            preguntas = data.preguntas;
                            mostrarPregunta(plantilla, preguntaActual);
                        });
                });
        });
    } else {
        console.error("El botón 'comenzar' no se encontró en el DOM.");
    }

    function mostrarPregunta(plantilla, indice) {
        divExamen.innerHTML = ""; // Limpiar el contenido existente

        var pregunta = preguntas[indice];

        var preguntaHTML = document.createElement("div");
        preguntaHTML.innerHTML = plantilla
            .replace("{0}", pregunta.opciones[0].opcion1)
            .replace("{1}", pregunta.opciones[0].opcion2)
            .replace("{2}", pregunta.opciones[0].opcion3)
            .replace("{3}", pregunta.enunciado)
            .replace("{4}", pregunta.url);

        // Añade la imagen si la pregunta tiene un recurso de tipo "imagen"
        if (pregunta.recurso && pregunta.tipoRecurso === "imagen") {
            preguntaHTML.querySelector('img').setAttribute('src', pregunta.url);
        }

        divExamen.appendChild(preguntaHTML);

        // Añadir evento clic al botón de borrar si existe
        var btnBorrar = document.getElementById('borrar');
        if (btnBorrar) {
            btnBorrar.addEventListener('click', function () {
                // Encontrar la opción marcada y desmarcarla
                var opciones = document.querySelectorAll('input[name="opciones"]');
                opciones.forEach(function (opcion) {
                    if (opcion.checked) {
                        opcion.checked = false;
                    }
                });
            });
        }

        // Añadir evento clic al botón de siguiente
        var btnSiguiente = document.getElementById("siguiente");

        btnSiguiente.addEventListener('click', function () {
            if (preguntaActual < preguntas.length - 1) {
                preguntaActual++;
                mostrarPregunta(plantilla, preguntaActual);
            } else {
                // Has llegado al final del examen, puedes realizar alguna acción aquí
                console.log('Fin del examen');
            }
        });

        var btnAnterior = document.getElementById("anterior");

        btnAnterior.addEventListener('click', function () {
            if (preguntaActual > 0) {
                preguntaActual--;
                mostrarPregunta(plantilla, preguntaActual);
            } else {
                // Has llegado al inicio del examen
                console.log('Inicio del examen');
            }
        });
        
        
    }
});
