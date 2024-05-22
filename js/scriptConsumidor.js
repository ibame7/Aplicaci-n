let cambioDatos = document.getElementById("cambioDatos");
let cambioContrasenia = document.getElementById("cambioContrasenia");
let usuario;

function showContent(id) {
  let perfil = document.getElementById("perfil");
  let reservas = document.getElementById("reservas");
  let resenias = document.getElementById("resenias");
  if (id == "perfil") {
    perfil.style.display = "block";
    reservas.style.display = "none";
    resenias.style.display = "none";
  } else if (id == "reservas") {
    perfil.style.display = "none";
    reservas.style.display = "block";
    resenias.style.display = "none";
  } else if (id == "resenias") {
    perfil.style.display = "none";
    reservas.style.display = "none";
    resenias.style.display = "block";
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

