let cambioDatos = document.getElementById("cambioDatos");
let reservasBoton = document.getElementById("pistasBoton");
let open = document.getElementById("open");
let modal_container2 = document.getElementById("modal_container2");
let close = document.getElementById("close");
let usuario;
let pistas;

function showContent(id) {
  let propietario = document.getElementById("propietario");
  let usuarios = document.getElementById("usuarios");
  let reservas = document.getElementById("reservas");
  let contactos = document.getElementById("contactos");
  if (id == "propietario") {
    propietario.style.display = "";
    usuarios.style.display = "none";
    reservas.style.display = "none";
    contactos.style.display = "none";

  } else if (id == "usuarios") {
    propietario.style.display = "none";
    usuarios.style.display = "";
    reservas.style.display = "none";
    contactos.style.display = "none";

  } else if (id == "reservas") {
    propietario.style.display = "none";
    usuarios.style.display = "none";
    reservas.style.display = "";
    contactos.style.display = "none";
  }
  else if (id == "contactos") {
    propietario.style.display = "none";
    usuarios.style.display = "none";
    reservas.style.display = "none";
    contactos.style.display = "";
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
async function sacarPistas() {
  await fetch(
    "servidor/servidorPistasPropietario.php?usuario=" + usuario.username
  )
    .then(function (response) {
      return response.json(); // Este response.json() que devolvemos...
    })
    .then((data) => {
      pistas = data;
      pintarPistas(pistas);
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

function pintarPistas(data) {
  let divPistas = document.getElementById("pistas");
  divPistas.innerHTML = ""; // Limpiar el contenido del div
  if (data.length == 0) {
    let h1 = document.createElement("h1");
    h1.innerHTML = "Aún no posee ninguna instalación deportiva";
    divPistas.appendChild(h1);
  } else {
    // Crear la tabla
    let table = document.createElement("table");
    table.id = "dynamicTable";

    // Crear thead
    let thead = document.createElement("thead");
    let theadRow = document.createElement("tr");

    let headers = ["id", "nombre", "deporte", "precio", "¿Activo?", ""];
    headers.forEach((headerText) => {
      let th = document.createElement("th");
      th.textContent = headerText;
      theadRow.appendChild(th);
    });
    thead.appendChild(theadRow);
    table.appendChild(thead);

    // Crear tbody
    let tbody = document.createElement("tbody");
    data.forEach((item) => {
      let newRow = tbody.insertRow();

      let idCell = newRow.insertCell(0);
      let nombreCell = newRow.insertCell(1);
      let deporteCell = newRow.insertCell(2);
      let precioCell = newRow.insertCell(3);
      let activoCell = newRow.insertCell(4);
      let eliminarCell = newRow.insertCell(5);

      idCell.textContent = item.id;
      nombreCell.textContent = item.nombre;
      deporteCell.textContent = item.deporte;
      precioCell.textContent = item.precio;
      activoCell.textContent = item.activo == 1 ? "SÍ" : "NO";

      let deleteButton = document.createElement("button");
      deleteButton.textContent = "Eliminar";
      deleteButton.classList.add("deleteButton");
      deleteButton.onclick = function () {
        deleteRow(this, item.id);
      };
      eliminarCell.appendChild(deleteButton);
      let modificarButton = document.createElement("button");
      modificarButton.textContent = "Modificar";
      modificarButton.classList.add("modificarButton");
      modificarButton.onclick = function () {
        modificarRow(item.id);
      };
      eliminarCell.appendChild(modificarButton);
    });

    table.appendChild(tbody);
    divPistas.appendChild(table);
  }
  let aniadirButton = document.createElement("button");
  aniadirButton.textContent = "Añadir Pista";
  aniadirButton.classList.add("aniadirButton");
  aniadirButton.onclick = function () {
    aniadirPista();
  };
  divPistas.appendChild(aniadirButton);

  divPistas.style.display = "block"; // Mostrar el contenedor de la tabla
}

async function deleteRow(button, id) {
  if (confirm("¿Seguro de que quieres borrar la pista?")) {
    await fetch("servidor/servidorPistasPropietario.php?pistaBorrar=" + id)
      .then(function (response) {
        return response.json(); // Este response.json() que devolvemos...
      })
      .then((data) => {
        if (data.ok) {
          alert(data.ok);
          let row = button.parentNode.parentNode;
          row.parentNode.removeChild(row);
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}

async function modificarRow(id) {
  let activacion;
  modal_container2.classList.add("show");
  let modificarPista = document.getElementById("modificarPista");
  modificarPista.addEventListener("click", async () => {
    let url = new URL(
      `http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorPistasPropietario.php`
    );
    let ok = false;

    let nombre = document.getElementById("pistaNombre");
    let deporte = document.getElementById("pistaDeporte");
    let precio = document.getElementById("pistaPrecio");
    let activo = document.getElementById("pistaActivo");

    if (nombre.value.trim().length === 0) {
      nombre.style.border = "2px solid red";
      ok = false;
    } else {
      nombre.style.border = "";
      ok = true;
    }
    if (deporte.value.trim().length === 0) {
      deporte.style.border = "2px solid red";
      ok = false;
    } else {
      deporte.style.border = "";
      ok = true;
    }
    if (precio.value.trim().length === 0) {
      precio.style.border = "2px solid red";
      ok = false;
    } else {
      precio.style.border = "";
      ok = true;
    }
    if (activo.value.trim().length === 0) {
      activo.style.border = "2px solid red";
      ok = false;
    } else {
      if (
        activo.value.toLowerCase() == "si" ||
        activo.value.toLowerCase() == "sí"
      ) {
        activacion = 1;
        activo.style.border = "";
        ok = true;
      } else if (activo.value.toLowerCase() == "no") {
        activacion = 0;
        activo.style.border = "";
        ok = true;
      } else {
        activo.style.border = "2px solid red";
        ok = false;
      }
    }

    if (ok) {
      let datos = {
        id: id,
        nombre: nombre.value,
        deporte: deporte.value,
        precio: precio.value,
        activo: activacion,
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
          if (data.ok) {
            alert(data.ok);
            window.location.reload();
          } else if (data.error) {
            nombre.style.border = "2px solid red";
            precio.style.border = "2px solid red";
            deporte.style.border = "2px solid red";
            activo.style.border = "2px solid red";
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
        });
    }
  });
}

function aniadirPista() {
  modificarRow("no");  
}

document.addEventListener("DOMContentLoaded", async () => {
  document.getElementById("username").disabled = true;
  mostrarDatos();
});

cambioDatos.addEventListener("click", async (event) => {
  event.preventDefault();
  modificarDatos();
});

reservasBoton.addEventListener("click", async () => {
  sacarPistas();
});

close.addEventListener("click", () => {
  modal_container2.classList.remove("show");
});
