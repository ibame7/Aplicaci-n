let resultadoObtenido;
async function buscarMunicipio() {
    let resultados=document.getElementById("resultados");
    let municipio= localStorage.getItem("municipio").toLowerCase();
    municipio=municipio.charAt(0).toUpperCase() + municipio.slice(1);
    await fetch("servidor/servidorcadaMunicipio.php?municipio=" + municipio)
        .then(function (response) {
          return response.json(); 
        })
        .then((data) => {
          resultadoObtenido = data;
          if (resultadoObtenido.error) {
            let div=document.createElement("div");
            div.classList.add("divError");
            div.textContent=resultadoObtenido.error;
            resultados.appendChild(div);

            console.log(resultadoObtenido.error);

          } else if(resultadoObtenido.Instalaciones){
            pintarInstalaciones(resultadoObtenido);
            console.log(resultadoObtenido);
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
        });
}

async function pintarInstalaciones(instalaciones){
  let divResultados= document.getElementById("resultados");
  divResultados.innerHTML="";

  let divInstalaciones= document.createElement("div");
  divInstalaciones.id="divInstalaciones";

  let h1= document.createElement("h1");
  h1.textContent=instalaciones.pueblo;

  divResultados.appendChild(h1);

  instalaciones.Instalaciones.forEach(instalacion => {
    console.log(instalacion);

    let divInstalacion= document.createElement("div");
    divInstalacion.classList.add("divInstalacion");

    let h3=document.createElement("h3");
    h3.textContent=instalacion.nombre;

    let p=document.createElement("p");
    p.textContent=instalacion.precio+" €/hora";

    divInstalacion.addEventListener("click",async()=>{
      reservar();
    })

    divInstalacion.appendChild(h3)
    divInstalacion.appendChild(p)
    divInstalaciones.appendChild(divInstalacion);
    divResultados.appendChild(divInstalaciones);

    switch(instalacion.deporte) {
      case "Futbol":
        divInstalacion.id="divFutbol";
        break;
      case "Futbol Sala":
        divInstalacion.id="divFutSal";
        break;
      case "Baloncesto":
        divInstalacion.id="divBaloncesto";
        break;
        case "Tenis":
          divInstalacion.id="divTenis";
          break;
        case "Padel":
          divInstalacion.id="divPadel";
          break;
        case "Balonmano":
          divInstalacion.id="divBalonmano";
          break;
      }
      
      
  });
 
}


document.addEventListener("DOMContentLoaded",async()=>{
    buscarMunicipio();
});

