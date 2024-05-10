let boton = document.getElementById("boton");
let usuario;

async function login(){
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
      "username": user.value,
      "password": pass.value,
    };

    let options={
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    }
    // Realizar la solicitud Fetch
     await fetch("login.php",options)    
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        usuario = data;
        console.log(data);
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}

boton.addEventListener("click", async (event) => {
  event.preventDefault();
  login();
});
