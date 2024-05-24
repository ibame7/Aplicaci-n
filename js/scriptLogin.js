var usuario;
let botonLogin = document.getElementById("boton");
let botonRegistro = document.getElementById("botonRegistro");
let botonRecuperar = document.getElementById("botonRecuperar");
let botonContacto = document.getElementById("enviar");

function volverIndex(){
  window.location.href="index.php";
}
function validarEmail(email) {
  const regex = /^[^\s@]+@gmail\.com$|^[^\s@]+@[^\s@]+\.[^\s@]+\.es$/;
  return regex.test(email);
}

function validarTelefono(telefono) {
  const regex = /^[6789]\d{8}$/;
  return regex.test(telefono);
}

async function login() {
  let url = new URL(
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorAcceso.php`
  );
  usuario = null;
  let user = document.getElementById("login-name");
  let pass = document.getElementById("login-pass");
  let error = document.getElementsByClassName("error")[0];

  if (user.value.trim().length === 0 || pass.value.trim().length === 0) {
    user.style.border = "2px solid red";
    pass.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
  } else {
    user.style.border = "";
    pass.style.border = "";
    error.innerHTML = "";

    let datos = {
      username: user.value,
      password: pass.value,
    };

    let options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    };
    // Realizar la solicitud Fetch

    await fetch(url, options)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        if (data.hasOwnProperty("usuario")) {
          usuario = data;
          window.location.href = "index.php";
          // console.log(usuario);
        } else if (data.hasOwnProperty("error")) {
          user.style.border = "2px solid red";
          pass.style.border = "2px solid red";
          error.innerHTML = data.error;
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}

async function registro() {
  let url = new URL(
    "http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorRegistro.php"
  );
  let ok = true;
  let error = document.getElementsByClassName("error")[0];

  let nombre = document.getElementById("nombre");
  let user = document.getElementById("usuario");
  let apellido1 = document.getElementById("primerApellido");
  let apellido2 = document.getElementById("segundoApellido");
  let correo = document.getElementById("correo");
  let contrasenia = document.getElementById("contrasenia");
  let confirmarContrasenia = document.getElementById("confirmarContrasenia");

  let inputs = [
    nombre,
    user,
    apellido1,
    apellido2,
    correo,
    contrasenia,
    confirmarContrasenia,
  ];

  // Función para validar campos vacíos
  let validarCampo = (campo) => {
    if (campo.value.trim().length === 0) {
      campo.style.border = "2px solid red";
      error.innerHTML = "Debe rellenar todos los datos";
      ok = false;
    } else {
      campo.style.border = "";
      error.innerHTML = "";
    }
  };

  // Validar cada campo
  inputs.forEach((input) => validarCampo(input));

  // Validar el correo
  if (ok && !validarEmail(correo.value)) {
    correo.style.border = "2px solid red";
    error.innerHTML = "Correo no válido";
    ok = false;
  }

  // Validar las contraseñas
  if (ok) {
    if (contrasenia.value.length < 4 || contrasenia.value.length > 10) {
      contrasenia.style.border = "2px solid red";
      error.innerHTML = "La contraseña debe tener entre 4 y 10 caracteres";
      ok = false;
    } else if (contrasenia.value !== confirmarContrasenia.value) {
      contrasenia.style.border = "2px solid red";
      confirmarContrasenia.style.border = "2px solid red";
      error.innerHTML = "Ambas contraseñas deben ser iguales";
      ok = false;
    }
  }

  if (ok) {
    let datos = {
      nombre: nombre.value,
      apellido1: apellido1.value,
      apellido2: apellido2.value,
      user: user.value,
      correo: correo.value,
      contrasenia: contrasenia.value,
      confirmarContrasenia: confirmarContrasenia.value,
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

      if (data.hasOwnProperty("usuario")) {
        window.location.href = "index.php";
      } else if (data.hasOwnProperty("error")) {
        inputs.forEach((input) => (input.style.border = "2px solid red"));
        error.innerHTML = data.error;
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}

async function recuperar() {
  let url = new URL(
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorRecuperar.php`
  );
  let ok = false;
  usuario = null;
  let error = document.getElementsByClassName("error")[0];

  let nombre = document.getElementById("nombre");
  let user = document.getElementById("usuario");
  let apellido1 = document.getElementById("primerApellido");
  let apellido2 = document.getElementById("segundoApellido");
  let contrasenia = document.getElementById("contrasenia");
  let confirmarContrasenia = document.getElementById("confirmarContrasenia");

  if (nombre.value.trim().length === 0) {
    nombre.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    nombre.style.border = "";
    error.innerHTML = "";
    ok = true;
  }
  if (apellido1.value.trim().length === 0) {
    apellido1.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    apellido1.style.border = "";
    error.innerHTML = "";
    ok = true;
  }
  if (apellido2.value.trim().length === 0) {
    apellido2.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    apellido2.style.border = "";
    error.innerHTML = "";
    ok = true;
  }
  if (user.value.trim().length === 0) {
    user.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    user.style.border = "";
    error.innerHTML = "";
    ok = true;
  }
  if (contrasenia.value.trim().length === 0) {
    contrasenia.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    contrasenia.style.border = "";
    error.innerHTML = "";
    ok = true;
  }
  if (confirmarContrasenia.value.trim().length === 0) {
    confirmarContrasenia.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    if (confirmarContrasenia.value === contrasenia.value) {
      confirmarContrasenia.style.border = "";
      contrasenia.style.border = "";
      error.innerHTML = "";
      ok = true;
    } else if (
      confirmarContrasenia.value.length < 4 ||
      confirmarContrasenia.value.length > 10 ||
      contrasenia.value.length < 4 ||
      contrasenia.value.length > 10
    ) {
      contrasenia.style.border = "2px solid red";
      confirmarContrasenia.style.border = "2px solid red";
      error.innerHTML = "Ambas contraseñas deben tener entre 4 y 10 caracteres";
      ok = false;
    } else {
      contrasenia.style.border = "2px solid red";
      confirmarContrasenia.style.border = "2px solid red";
      error.innerHTML = "Ambas contraseñas deben ser iguales";
      ok = false;
    }
  }

  if (ok) {
    let datos = {
      nombre: nombre.value,
      apellido1: apellido1.value,
      apellido2: apellido2.value,
      user: user.value,
      contrasenia: contrasenia.value,
      confirmarContrasenia: confirmarContrasenia.value,
    };

    let options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    };
    // Realizar la solicitud Fetch

    await fetch(url, options)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        if (data.hasOwnProperty("usuario")) {
          usuario = data;
          window.location.href = "index.php";
          // console.log(usuario);
        } else if (data.hasOwnProperty("error")) {
          nombre.style.border = "2px solid red";
          user.style.border = "2px solid red";
          apellido1.style.border = "2px solid red";
          apellido2.style.border = "2px solid red";
          contrasenia.style.border = "2px solid red";
          confirmarContrasenia.style.border = "2px solid red";
          error.innerHTML = data.error;
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}

async function contacto() {
  let url = new URL(
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorContacto.php`
  );
  let ok = true;
  let nombre = document.getElementById("nombre");
  let correo = document.getElementById("email");
  let telefono = document.getElementById("telefono");
  let mensaje = document.getElementById("mensaje");
  let estado = "sin responder";
  let div = document.getElementsByClassName("formulario")[0];
  let error = document.getElementsByClassName("error")[0];

  let inputs = [nombre, correo, telefono, mensaje];

  let validarCampos = (campo) => {
    if (campo.value.trim().length === 0) {
      campo.style.border = "2px solid red";
      ok = false;
    } else {
      campo.style.border = "";
    }
  };

  //Validar campos
  inputs.forEach((input) => validarCampos(input));


  if (ok) {
    if (!validarEmail(correo.value)) {
      correo.style.border = "2px solid red";
      error.textContent = "Correo electrónico no válido";
      return;
    }

    if (!validarTelefono(telefono.value)) {
      telefono.style.border = "2px solid red";
      error.textContent = "Número de teléfono no válido";
      return;
    }
    let datos = {
      nombre: nombre.value,
      correo: correo.value,
      telefono: telefono.value,
      mensaje: mensaje.value,
      estado:estado
    };

    let options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    };
    // Realizar la solicitud Fetch

    await fetch(url, options)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        if (data.hasOwnProperty("mensaje")) {
          div.innerHTML="<a style='display: flex; justify-content: center;'>"+data.mensaje+"</a><br><a href='index.php' style='display: flex; justify-content: center;'>Volver</a>";
        } else if (data.hasOwnProperty("error")) {
          div.innerHTML="<a style='display: flex; justify-content: center;'>"+data.error+"</a><br><a href='index.php' style='display: flex; justify-content: center;'>Volver</a>";
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}

if (botonLogin !== null) {
  botonLogin.addEventListener("click", async (event) => {
    event.preventDefault();
    login();
  });
} else if (botonRegistro !== null) {
  botonRegistro.addEventListener("click", async (event) => {
    event.preventDefault();
    registro();
  });
} else if (botonRecuperar !== null) {
  botonRecuperar.addEventListener("click", async (event) => {
    event.preventDefault();
    recuperar();
  });
} else if (botonContacto !== null) {
  botonContacto.addEventListener("click", async (event) => {
    event.preventDefault();
    contacto();
  });
}
