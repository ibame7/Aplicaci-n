let municipios;
let busqueda = document.getElementById("busqueda");
let resultados = document.getElementById("resultados");

async function cargarMunicipios(str) {
  if (str === null) {
    str = "municipios";
  } else {
    if (str.length === 0) {
      str = "municipios";
    }
  }
  await fetch("servidorMunicipios.php?municipio=" + str)
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

function pintar(municipios) {
  resultados.innerHTML = "";
  municipios.forEach((municipio) => {
    let divMunicipio = document.createElement("div");
    divMunicipio.classList.add("divMunicipio");
    let titulo = document.createElement("h2");
    titulo.textContent = municipio.pueblo;
    divMunicipio.appendChild(titulo);
    resultados.appendChild(divMunicipio);
    divMunicipio.addEventListener("click", () => {
      cargarMunicipios(municipio.pueblo);
    });
  });
}

window.addEventListener("DOMContentLoaded", async () => {
  cargarMunicipios(busqueda);
});
