let municipios;
let busqueda=document.getElementById("busqueda");


async function cargarMunicipios(str){    
    if(str==null){
        str="municipios";
    }
    if(str.value.trim().length === 0 ){
        str="municipios";
    }
      await fetch('servidorMunicipios.php?q=' + str).then(function (response) {
        return response.json(); // Este response.json() que devolvemos...
    }) .then((data) => {
              municipios = data;              
          })
          .catch((error) => {
            console.error("Error en la solicitud:", error);
          });
      }


window.addEventListener("DOMContentLoaded",async ()=>{
    cargarMunicipios(busqueda);
})