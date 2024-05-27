let resultadoObtenido;
async function buscarMunicipio() {
  let resultados = document.getElementById("resultados");
  let municipio = localStorage.getItem("municipio").toLowerCase();
  municipio = municipio.charAt(0).toUpperCase() + municipio.slice(1);
  await fetch("servidor/servidorcadaMunicipio.php?municipio=" + municipio)
    .then(function (response) {
      return response.json();
    })
    .then((data) => {
      resultadoObtenido = data;
      if (resultadoObtenido.error) {
        let div = document.createElement("div");
        div.classList.add("divError");
        div.textContent = resultadoObtenido.error;
        resultados.appendChild(div);

        console.log(resultadoObtenido.error);
      } else if (resultadoObtenido.Instalaciones) {
        pintarInstalaciones(resultadoObtenido);
        console.log(resultadoObtenido);
      }
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

function mostrarModal(button, instalacion) {
  document.getElementById("reservationModal").style.display = "flex";

  button.addEventListener("click", function () {});

  document
    .getElementById("closeModalBtn")
    .addEventListener("click", function () {
      document.getElementById("reservationModal").style.display = "none";
    });

  window.addEventListener("click", function (event) {
    const modal = document.getElementById("reservationModal");
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  document
    .getElementById("reservationForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      reservar(instalacion);
    });
}
async function reservar(instalacion) {
  let divError=document.getElementById("error");
  let ok = true;

  // Obtener la fecha y hora actual
  let fechaActual = new Date();
  let horaActual = fechaActual.getHours();

  // Obtener los valores seleccionados por el usuario
  let fechaSeleccionada = document.getElementById("date").value;
  let horaSeleccionada = document.getElementById("time").value;

  // Convertir la fecha y hora seleccionadas por el usuario en un objeto Date
  let fechaSeleccionadaObj = new Date(fechaSeleccionada);
  let horaSeleccionadaSplit = horaSeleccionada.split(":");
  let horaSeleccionadaNum = parseInt(horaSeleccionadaSplit[0]);

  // Verificar si la fecha seleccionada es igual o posterior a la fecha actual
  if (fechaSeleccionadaObj < fechaActual) {
    if (horaSeleccionadaNum <= horaActual) {
      ok = false;
    }
  } else if (
    fechaSeleccionadaObj.getTime() === fechaActual.getTime() &&
    horaSeleccionadaNum <= horaActual
  ) {
    // Si la fecha seleccionada es hoy, verificar que la hora seleccionada sea posterior a la hora actual
    ok = false;
  } else {
    ok = true;
  }

  if (ok) {
    // Formatear la fecha y hora en el formato adecuado para enviar a la base de datos (YYYY-MM-DD HH:MM:SS)
    let fechaHoraFormateada =
      fechaSeleccionada + " " + horaSeleccionada + ":00";

    

    // Convertir la fecha de inicio a un objeto Date
    let fechaInicio = new Date(fechaHoraFormateada);

    // Sumar una hora a la fecha de inicio
    fechaInicio.setHours(fechaInicio.getHours() + 1);

    // Formatear la fecha de finalización
    let fecha_finish =
      fechaInicio.getFullYear() +
      "-" +
      ("0" + (fechaInicio.getMonth() + 1)).slice(-2) +
      "-" +
      ("0" + fechaInicio.getDate()).slice(-2) +
      " " +
      ("0" + fechaInicio.getHours()).slice(-2) +
      ":" +
      ("0" + fechaInicio.getMinutes()).slice(-2) +
      ":" +
      ("0" + fechaInicio.getSeconds()).slice(-2);


    // Realizar la solicitud Fetch
    try {
      let url =
        "http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorcadaMunicipio.php";
      let fecha_start = fechaHoraFormateada;
      let importe = instalacion.precio;
      let pista = instalacion.id;

      let datos = {
        fecha_start: fecha_start,
        fecha_finish: fecha_finish,
        importe: importe,
        pista: pista,
      };

      let options = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(datos),
      };

      let response = await fetch(url, options);
      let data = await response.json();

      if (data.error) {
        divError.innerHTML=data.error;
      } else if (data.mensaje) {
        divError.innerHTML="";
        alert(data.mensaje);
        window.location.href="index.php";
      }else if (data.permiso) {
        alert(data.permiso);
        window.location.href="acceso.php";
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  } else {
    console.log(
      "La reserva no es válida. Por favor, selecciona una fecha y hora adecuadas."
    );
  }
}



async function pintarInstalaciones(instalaciones) {
  let divResultados = document.getElementById("resultados");
  divResultados.innerHTML = "";

  let divInstalaciones = document.createElement("div");
  divInstalaciones.id = "divInstalaciones";

  let h1 = document.createElement("h1");
  h1.textContent = instalaciones.pueblo;

  divResultados.appendChild(h1);

  instalaciones.Instalaciones.forEach((instalacion) => {
    console.log(instalacion);

    let divInstalacion = document.createElement("div");
    divInstalacion.classList.add("divInstalacion");

    let h3 = document.createElement("h3");
    h3.textContent = instalacion.nombre;

    let p = document.createElement("p");
    p.textContent = instalacion.precio + " €/hora";

    divInstalacion.addEventListener("click", async () => {
      mostrarModal(this, instalacion);
    });

    divInstalacion.appendChild(h3);
    divInstalacion.appendChild(p);
    divInstalaciones.appendChild(divInstalacion);
    divResultados.appendChild(divInstalaciones);

    switch (instalacion.deporte) {
      case "Futbol":
        divInstalacion.id = "divFutbol";
        break;
      case "Futbol Sala":
        divInstalacion.id = "divFutSal";
        break;
      case "Baloncesto":
        divInstalacion.id = "divBaloncesto";
        break;
      case "Tenis":
        divInstalacion.id = "divTenis";
        break;
      case "Padel":
        divInstalacion.id = "divPadel";
        break;
      case "Balonmano":
        divInstalacion.id = "divBalonmano";
        break;
    }

    if (instalacion.activo == 0) {
      divInstalacion.classList.add("disabled");
    }
  });
}

document.addEventListener("DOMContentLoaded", async () => {
  buscarMunicipio();
});
