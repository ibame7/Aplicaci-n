let cambioDatos = document.getElementById("cambioDatos");
let cambioContrasenia = document.getElementById("cambioContrasenia");
let reservasBoton = document.getElementById("reservasBoton");
let reseniasBoton = document.getElementById("reseniasBoton");
let usuario;
let reservas;
let pistas;

function showContent(id) {
  let perfil = document.getElementById("perfil");
  let reservas = document.getElementById("reservas");
  let resenias = document.getElementById("resenias");
  if (id == "perfil") {
    perfil.style.display = "";
    reservas.style.display = "none";
    resenias.style.display = "none";
  } else if (id == "reservas") {
    perfil.style.display = "none";
    reservas.style.display = "";
    resenias.style.display = "none";
  } else if (id == "resenias") {
    perfil.style.display = "none";
    reservas.style.display = "none";
    resenias.style.display = "";
  }
}
async function mostrarDatos() {
  try {
    let respuesta = await fetch("servidor/servidorSacarSesion.php");
    if (!respuesta.ok) {
      throw new Error("Error al obtener la sesión");
    }
    let datos = await respuesta.json();
    usuario = datos.usuario;
    // Haz algo con el usuario obtenido
  } catch (error) {
    console.error("Hubo un error:", error);
  }

  document.getElementById("nombre").value = usuario.nombre;
  document.getElementById("apellido1").value = usuario.apellido1;
  document.getElementById("apellido2").value = usuario.apellido2;
  document.getElementById("email").value = usuario.correo;
  document.getElementById("username").value = usuario.username;
}
function validarEmail(email) {
  const regex = /^[^\s@]+@gmail\.com$|^[^\s@]+@[^\s@]+\.[^\s@]+\.es$/;
  return regex.test(email);
}
async function modificarDatos() {
  error.innerHTML = "";
  let ok = true;
  let url = new URL(
    "http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorCambiarDatos.php"
  );
  let nombre = document.getElementById("nombre");
  let apellido1 = document.getElementById("apellido1");
  let apellido2 = document.getElementById("apellido2");
  let correo = document.getElementById("email");
  let username = document.getElementById("username");
  let inputs = [nombre, apellido1, apellido2, correo, username];

  // Función para validar campos vacíos
  let validarCampo = (campo) => {
    if (campo.value.trim().length === 0) {
      campo.style.border = "2px solid red";
      ok = false;
    } else {
      campo.style.border = "";
    }
  };

  // Validar cada campo
  inputs.forEach((input) => validarCampo(input));

  // Validar el correo
  if (ok && !validarEmail(correo.value)) {
    correo.style.border = "2px solid red";
    ok = false;
  }

  if (ok) {
    let datos;
    if (usuario.correo != correo.value) {
      datos = {
        nombre: nombre.value,
        apellido1: apellido1.value,
        apellido2: apellido2.value,
        correo: correo.value,
        username: username.value,
      };
    } else {
      datos = {
        nombre: nombre.value,
        apellido1: apellido1.value,
        apellido2: apellido2.value,
        username: username.value,
        correoIgual: correo.value,
      };
    }

    let options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    };

    // Realizar la solicitud Fetch
    try {
      let response = await fetch(url, options);
      let data = await response.json();

      if (data.hasOwnProperty("ok")) {
        window.location.reload();
      } else if (data.hasOwnProperty("error")) {
        error.innerHTML = data.error;
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}
async function modificarContrasenia() {
  error2.innerHTML = "";
  let ok = true;
  let url = new URL(
    "http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorCambiarDatos.php"
  );
  let password = document.getElementById("password");
  let confirmPassword = document.getElementById("confirmPassword");
  let inputs = [password, confirmPassword];

  // Función para validar campos vacíos
  let validarCampo = (campo) => {
    if (campo.value.trim().length === 0) {
      campo.style.border = "2px solid red";
      ok = false;
    } else {
      campo.style.border = "";
    }
  };

  // Validar cada campo
  inputs.forEach((input) => validarCampo(input));

  if (ok) {
    let datos = {
      password: password.value,
      confirmPassword: confirmPassword.value,
    };

    let options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    };

    // Realizar la solicitud Fetch
    try {
      let response = await fetch(url, options);
      let data = await response.json();

      if (data.hasOwnProperty("ok")) {
        window.location.reload();
      } else if (data.hasOwnProperty("error")) {
        error2.innerHTML = data.error;
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}

async function sacarReservas(str) {
  await fetch("servidor/servidorReservas.php?usuario=" + usuario.username)
    .then(function (response) {
      return response.json(); // Este response.json() que devolvemos...
    })
    .then((data) => {
      reservas = data[0].reservas;
      pistas = data[0].pistas;

      if (str == "reservas") {
        pintarReservas(data[0], "reservas");
      } else if (str == "pistas") {
        pintarReservas(data[0], "pistas");
      }
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

function pintarReservas(data, str) {
  let divReservas = document.getElementById("reservas");
  let divResenia = document.getElementById("resenias");

  divReservas.innerHTML = "";
  divResenia.innerHTML = "";

  if (data.error) {
    let h2 = document.createElement("h2");
    h2.innerHTML = data.error;
    divReservas.appendChild(h2);
  } else {
    data.reservas.forEach((item) => {
      let divElement = document.createElement("div");
      divElement.className = "reserva";

      let h4 = document.createElement("h4");
      h4.innerHTML = `Reserva ID: ${item.id_reserva}`;
      divElement.appendChild(h4);

      if (str === "reservas") {
        let fechaInicio = new Date(item.fecha_start);
        let fechaFinal = new Date(item.fecha_finish);

        let pFecha = document.createElement("p");
        pFecha.innerHTML =
          "Fecha: " +
          fechaInicio.getDate() +
          "/" +
          (fechaInicio.getMonth() + 1) +
          "/" +
          fechaInicio.getFullYear();
        divElement.appendChild(pFecha);

        let pHora = document.createElement("p");
        pHora.innerHTML = "Hora Inicio: " + fechaInicio.getHours() + ":00";
        divElement.appendChild(pHora);

        let pHoraFinal = document.createElement("p");
        pHoraFinal.innerHTML = "Hora Final: " + fechaFinal.getHours() + ":00";
        divElement.appendChild(pHoraFinal);

        let pImporte = document.createElement("p");
        pImporte.innerHTML = "Precio: " + item.importe + "€";
        divElement.appendChild(pImporte);

        let btnEliminar = document.createElement("button");
        btnEliminar.innerHTML = "Anular";
        btnEliminar.addEventListener("click", () =>
          eliminarReserva(item.id_reserva)
        );
        divElement.appendChild(btnEliminar);

        divReservas.appendChild(divElement);
      }
    });

    // Bloque para manejar la visualización de las pistas
    if (str === "pistas") {
      data.pistas.forEach((pista) => {
        let divPista = document.createElement("div");
        divPista.className = "reserva";
    
        let h4 = document.createElement("h4");
        h4.innerHTML = `Nombre de la Pista: ${pista.nombre}`;
        divPista.appendChild(h4);
    
        // Filtrar las reservas solo para la pista actual
        let reservasPista = data.reservas.filter(reserva => reserva.pista === pista.id);
    
        reservasPista.forEach((reserva) => {
          let puntuacion = document.createElement("p");
          puntuacion.innerHTML = "Puntuación: " + reserva.puntuacion;
          divPista.appendChild(puntuacion);
    
          let comentario = document.createElement("p");
          comentario.innerHTML = "Comentario: " + reserva.comentario;
          divPista.appendChild(comentario);
        });
    
        divResenia.appendChild(divPista);
      });
    }
    
  }      
}

async function eliminarReserva(idReserva) {
  await fetch(`servidor/servidorReservas.php?borrar=${idReserva}`)
    .then((data) => {
      if (data.ok) {
        window.location.reload();
      }
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

document.addEventListener("DOMContentLoaded", async () => {
  document.getElementById("username").disabled = true;
  mostrarDatos();
});
cambioDatos.addEventListener("click", async (event) => {
  event.preventDefault();
  modificarDatos();
});

cambioContrasenia.addEventListener("click", async (event) => {
  event.preventDefault();
  modificarContrasenia();
});

reservasBoton.addEventListener("click", async () => {
  sacarReservas("reservas");
});

reseniasBoton.addEventListener("click", async () => {
  sacarReservas("pistas");
});
