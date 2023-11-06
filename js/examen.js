window.addEventListener("load", function() 
{
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");   

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() 
    {
    // Realiza una solicitud GET al backend para obtener las preguntas desde la base de datos
    fetch("./api/apiExamen.php")
        .then(response => response.json())
        .then(data => {
            var contenedor = document.createElement("div");
            var pregunta = document.querySelector(".pregunta");

            data.preguntas.forEach(function(preguntaData) {
                var pregAux = pregunta.cloneNode(true);

                pregAux.getElementsByClassName("enunciado")[0].innerHTML = preguntaData.enunciado;
                pregAux.getElementsByClassName("url")[0].src = preguntaData.url;
                // Configura las opciones y otros datos de la pregunta

                pregAux.getElementsByClassName("borrar")[0].onclick = function() {
                    var auxPadre = this;
                    while (!auxPadre.classList.contains("pregunta")) {
                        auxPadre = auxPadre.parentNode;
                    }
                    auxPadre.getElementsByClassName("dudosa")[0].checked = false;
                };

                divExamen.appendChild(pregAux);
            });
        });
    }
})