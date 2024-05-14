var usuario;
let botonLogin = document.getElementById("boton");
let botonRegistro = document.getElementById("botonRegistro");
let botonRecuperar = document.getElementById("botonRecuperar");


async function login() {
  let url = new URL(
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidorAcceso.php`
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
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidorRegistro.php`
  );
  let ok = false;
  usuario = null;
  let error = document.getElementsByClassName("error")[0];

  let nombre = document.getElementById("nombre");
  let user = document.getElementById("usuario");
  let apellido1 = document.getElementById("primerApellido");
  let apellido2 = document.getElementById("segundoApellido");
  let correo = document.getElementById("correo");
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
  if (correo.value.trim().length === 0) {
    correo.style.border = "2px solid red";
    error.innerHTML = "Debe rellenar todos los datos";
    ok = false;
  } else {
    correo.style.border = "";
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
          correo.style.border = "2px solid red";
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

async function recuperar() {
  let url = new URL(
    `http://localhost:3000/xampp/htdocs/Aplicacion/servidorRecuperar.php`
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
}else if(botonRecuperar!==null){
  botonRecuperar.addEventListener("click", async (event) => {
    event.preventDefault();
    recuperar();
  });
}
