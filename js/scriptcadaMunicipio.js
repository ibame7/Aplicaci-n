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

            console.log(resultadoObtenido.Instalaciones);
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
        });
}


document.addEventListener("DOMContentLoaded",async()=>{
    buscarMunicipio();
})