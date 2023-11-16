document.addEventListener("DOMContentLoaded", function () {
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");
    var preguntas;
    var preguntaActual = 0;
    var preguntasPorPagina = 1;

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
                            mostrarPaginacion();
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

            // Inicializar divPaginacion
            var divPaginacion = document.getElementById("paginacion");

            if (divPaginacion) {
                mostrarPaginacion(preguntaActual);
            }
        }

        // Añadir evento clic al botón de siguiente
        var btnSiguiente = document.getElementById("siguiente");

        btnSiguiente.addEventListener('click', function () {
            if (preguntaActual < preguntas.length - 1) {
                preguntaActual++;
                mostrarPregunta(plantilla, preguntaActual);
                mostrarPaginacion(preguntaActual);
            } else {
                // Has llegado al final del examen, puedes realizar alguna acción aquí
                console.log('Fin del examen');
            }
        });

        // Añadir evento clic al botón de anterior
        var btnAnterior = document.getElementById("anterior");

        btnAnterior.addEventListener('click', function () {
            if (preguntaActual > 0) {
                preguntaActual--;
                mostrarPregunta(plantilla, preguntaActual);
                mostrarPaginacion(preguntaActual);
            } else {
                // Has llegado al inicio del examen
                console.log('Inicio del examen');
            }
        });
    }

    function mostrarPaginacion(paginaSeleccionada) {
        var divPaginacion = document.getElementById("paginacion");

        if (divPaginacion) {
            divPaginacion.innerHTML = "";

            // Calcular el número total de páginas
            var totalPaginas = Math.ceil(preguntas.length / preguntasPorPagina);

            for (var i = 1; i <= totalPaginas; i++) {
                var pagina = document.createElement("span");
                pagina.textContent = i;
                pagina.addEventListener('click', function (event) {
                    var paginaSeleccionada = parseInt(event.target.textContent);
                    preguntaActual = (paginaSeleccionada - 1) * preguntasPorPagina;
                    mostrarPregunta(preguntaActual);
                });

                // Marcar la página actual
                if (i === Math.ceil((paginaSeleccionada + 1) / preguntasPorPagina)) {
                    pagina.classList.add("pagina-actual");
                }

                divPaginacion.appendChild(pagina);
            }
        }
    }
});
