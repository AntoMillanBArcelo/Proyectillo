window.addEventListener("load", function() 
{
    var btnComenzar = document.getElementById("comenzar");
    var divExamen = document.getElementById("examen");   

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() 
    {
        fetch("/plantilla/pregunta.html") 
        .then(x=>x.text())
        .then(y=>{
            var contenedor = document.createElement("div");
            contenedor.innerHTML = y;
            var pregunta = contenedor.firstChild;
            fetch("/servidor/pregunta.json")
            .then(x=>x.json())
            .then(y=>{
                for(let i = 0; i< y.preguntas.length; i++)
                {
                    var pregAux = pregunta.cloneNode(true);
                   
                    pregAux.getElementsByClassName("enunciado")[0].innerHTML=y.preguntas[i].enunciado;
                    pregAux.getElementsByClassName("url")[0].src=y.preguntas[i].url;
                    pregAux.querySelector("input#opcion1").value = y.preguntas[i].opciones[0].opcion1;
                    pregAux.querySelector("label[for='opcion1']").innerText = y.preguntas[i].opciones[0].opcion1;
                    
                    pregAux.querySelector("input#opcion2").value = y.preguntas[i].opciones[0].opcion2;
                    pregAux.querySelector("label[for='opcion2']").innerText = y.preguntas[i].opciones[0].opcion2;
                     
                    pregAux.querySelector("input#opcion3").value = y.preguntas[i].opciones[0].opcion3;
                    pregAux.querySelector("label[for='opcion3']").innerText = y.preguntas[i].opciones[0].opcion3;
                    pregAux.getElementsByClassName("borrar")[0].onclick=function()
                    {
                        var auxPadre = this;
                        while (!auxPadre.classList.contains("pregunta")) 
                        {
                            auxPadre=auxPadre.parentNode;    
                        }
                        auxPadre.getElementsByClassName("dudosa")[0].checked=false;
                    }
                    divExamen.appendChild(pregAux)
                }
            })
        })   
    }
})
