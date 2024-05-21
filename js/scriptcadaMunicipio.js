async function buscarMunicipio() {
    let municipio= localStorage.getItem("municipio").toLowerCase();
    await fetch("servidor/servidorcadaMunicipio.php?municipio=" + municipio)
        .then(function (response) {
          return response.json(); // Este response.json() que devolvemos...
        })
        .then((data) => {
          municipios = data;
          if (municipios.length > 1) {
            pintar(municipios);
          } else {
            localStorage.setItem("municipio", municipios.pueblo);
            window.location.href = "cadaMunicipio.php";
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
        });
}


document.addEventListener("DOMContentLoaded",async()=>{
    buscarMunicipio();
})