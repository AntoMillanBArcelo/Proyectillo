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
                    pregAux.getElementsByClassName("id")[0].innerHTML=y.preguntas[i].id;
                    pregAux.getElementsByClassName("categoria")[0].innerHTML=y.preguntas[i].categoria;
                    pregAux.getElementsByClassName("dificultad")[0].innerHTML=y.preguntas[i].dificultad;
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
