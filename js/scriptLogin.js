let botonLogin = document.getElementById("boton");
let url = new URL(`http://localhost:3000/xampp/htdocs/Aplicacion/login.php`);
let usuario;

async function login() {
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

botonLogin.addEventListener("click", async (event) => {
  event.preventDefault();
  login();
});


