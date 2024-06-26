let navPropietario = document.getElementById("navPropietario");
let navConsumidor = document.getElementById("navConsumidor");
let navReservas = document.getElementById("navReservas");
let navContactos = document.getElementById("navContactos");
let aniadirPropietarioBoton = document.getElementById("aniadirPropietario");

let botonAniadir = document.getElementsByClassName("aniadirButton")[0];

let open = document.getElementById("open");
let modal_container2 = document.getElementById("modal_container2");
let close = document.getElementById("close");
let usuarios = [];
let consumidores = [];
let propietarios = [];

function validarEmail(email) {
  const regex = /^[^\s@]+@gmail\.com$|^[^\s@]+@[^\s@]+\.[^\s@]+\.es$/;
  return regex.test(email);
}

function showContent(id) {
  let propietario = document.getElementById("propietario");
  let usuarios = document.getElementById("usuarios");
  let reservas = document.getElementById("reservas");
  let contactos = document.getElementById("contactos");
  let comienzo = document.getElementById("comienzo");

  if (id == "propietario") {
    comienzo.style.display = "none";
    propietario.style.display = "";
    usuarios.style.display = "none";
    reservas.style.display = "none";
    contactos.style.display = "none";
  } else if (id == "usuarios") {
    comienzo.style.display = "none";
    propietario.style.display = "none";
    usuarios.style.display = "";
    reservas.style.display = "none";
    contactos.style.display = "none";
  } else if (id == "reservas") {
    comienzo.style.display = "none";
    propietario.style.display = "none";
    usuarios.style.display = "none";
    reservas.style.display = "";
    contactos.style.display = "none";
  } else if (id == "contactos") {
    comienzo.style.display = "none";
    propietario.style.display = "none";
    usuarios.style.display = "none";
    reservas.style.display = "none";
    contactos.style.display = "";
  }
}
async function sacarUsuarios() {
  try {
    let respuesta = await fetch("servidor/servidorAdmin.php");
    if (!respuesta.ok) {
      throw new Error("Error al obtener la sesión");
    }
    let datos = await respuesta.json();
    usuarios = datos;
    usuarios.forEach((usuario) => {
      if (usuario.rol === "propietario") {
        propietarios.push(usuario);
      } else if (usuario.rol === "consumidor") {
        consumidores.push(usuario);
      }
    });
  } catch (error) {
    console.error("Hubo un error:", error);
  }
}
async function pintarPropietarios(data) {
  let divPropietarios = document.getElementById("propietario");
  divPropietarios.innerHTML = ""; // Limpiar el contenido del div

  // Crear la tabla
  let table = document.createElement("table");
  table.id = "dynamicTable";

  // Crear thead
  let thead = document.createElement("thead");
  let theadRow = document.createElement("tr");

  let headers = [
    "Usuario",
    "Nombre",
    "Primer Apellido",
    "Segundo Apellido",
    "Correo",
    "Localidad",
    "",
  ];
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

    let usuarioCell = newRow.insertCell(0);
    let nombreCell = newRow.insertCell(1);
    let primerCell = newRow.insertCell(2);
    let segundoCell = newRow.insertCell(3);
    let correoCell = newRow.insertCell(4);
    let localidadCell = newRow.insertCell(5);
    let buttonCell = newRow.insertCell(6);

    usuarioCell.textContent = item.username;
    nombreCell.textContent = item.nombre;
    primerCell.textContent = item.apellido1;
    segundoCell.textContent = item.apellido2;
    correoCell.textContent = item.correo;
    localidadCell.textContent = item.localidad;

    let deleteButton = document.createElement("button");
    deleteButton.textContent = "X";
    deleteButton.classList.add("deleteButton");
    deleteButton.onclick = function () {
      deleteRow(this, item.username);
    };
    buttonCell.appendChild(deleteButton);
  });

  table.appendChild(tbody);
  divPropietarios.appendChild(table);

  let aniadirButton = document.createElement("button");
  aniadirButton.textContent = "Añadir Propietario";
  aniadirButton.classList.add("aniadirButton");
  aniadirButton.onclick = function () {
    modal_container2.classList.add("show");
  };
  divPropietarios.appendChild(aniadirButton);

  divPropietarios.style.display = "block"; // Mostrar el contenedor de la tabla
}

function pintarConsumidores(data) {
  let divConsumidores = document.getElementById("usuarios");
  divConsumidores.innerHTML = ""; // Limpiar el contenido del div

  // Crear la tabla
  let table = document.createElement("table");
  table.id = "dynamicTable";

  // Crear thead
  let thead = document.createElement("thead");
  let theadRow = document.createElement("tr");

  let headers = [
    "Usuario",
    "Nombre",
    "Primer Apellido",
    "Segundo Apellido",
    "Correo",
    "Reservas",
    "",
  ];
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

    let usuarioCell = newRow.insertCell(0);
    let nombreCell = newRow.insertCell(1);
    let primerCell = newRow.insertCell(2);
    let segundoCell = newRow.insertCell(3);
    let correoCell = newRow.insertCell(4);
    let reservasCell = newRow.insertCell(5);
    let buttonCell = newRow.insertCell(6);

    usuarioCell.textContent = item.username;
    nombreCell.textContent = item.nombre;
    primerCell.textContent = item.apellido1;
    segundoCell.textContent = item.apellido2;
    correoCell.textContent = item.correo;
    reservasCell.textContent = item.reservas;

    let deleteButton = document.createElement("button");
    deleteButton.textContent = "X";
    deleteButton.classList.add("deleteButton");
    deleteButton.onclick = function () {
      deleteUser(this, item.username);
    };
    buttonCell.appendChild(deleteButton);
  });

  table.appendChild(tbody);
  divConsumidores.appendChild(table);

  divConsumidores.style.display = "block"; // Mostrar el contenedor de la tabla
}

async function aniadirPropietario() {
  let error = document.getElementById("divError");

  let ok = true;
  let url = new URL(
    "http://localhost:3000/xampp/htdocs/Aplicacion/servidor/servidorAdmin.php"
  );
  let nombre = document.getElementById("propietarioNombre");
  let apellido1 = document.getElementById("primerApellido");
  let apellido2 = document.getElementById("segundoApellido");
  let correo = document.getElementById("propietariocorreo");
  let pueblo = document.getElementById("propietarioPueblo");
  let contrasenia = document.getElementById("propietariocontrasenia");
  let inputs = [nombre, apellido1, apellido2, correo, contrasenia, pueblo];

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
    let datos = {
      nombre: nombre.value,
      apellido1: apellido1.value,
      apellido2: apellido2.value,
      pueblo: pueblo.value,
      correo: correo.value,
      contrasenia: contrasenia.value,
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

      if (data.ok) {
        alert(data.ok);
        window.location.reload();
      } else if (data.error) {
        error.innerHTML = data.error;
      }
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
}

async function deleteRow(button, id) {
  if (
    confirm(
      "¿Estás seguro? Si borras al propietario también eliminarás sus pistas"
    )
  ) {
    await fetch("servidor/servidorAdmin.php?propietarioBorrar=" + id)
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

async function deleteUser(button, id) {
  if (
    confirm("¿Estás seguro? Si borras al usuario también borrarás sus reservas")
  ) {
    await fetch("servidor/servidorAdmin.php?usuarioBorrar=" + id)
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

async function deleteReserva(button, id) {
  if (confirm("¿Estás seguro?")) {
    await fetch("servidor/servidorAdmin.php?reservaBorrar=" + id)
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

async function mostrarReservas() {
  let reservas = "reservas";
  await fetch("servidor/servidorAdmin.php?reservas=" + reservas)
    .then(function (response) {
      return response.json(); // Este response.json() que devolvemos...
    })
    .then((data) => {
      pintarReservas(data);
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

async function pintarReservas(data) {
  let divReservas = document.getElementById("reservas");
  divReservas.innerHTML = ""; // Limpiar el contenido del div

  // Crear la tabla
  let table = document.createElement("table");
  table.id = "dynamicTable";

  // Crear thead
  let thead = document.createElement("thead");
  let theadRow = document.createElement("tr");

  let headers = [
    "Id",
    "Fecha",
    "Hora",
    "Importe",
    "Puntuación",
    "Comentario",
    "Consumidor",
    "Pista",
    "",
  ];
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
    let fechaCell = newRow.insertCell(1);
    let horaCell = newRow.insertCell(2);
    let importeCell = newRow.insertCell(3);
    let puntuacionCell = newRow.insertCell(4);
    let comentarioCell = newRow.insertCell(5);
    let consumidorCell = newRow.insertCell(6);
    let pistaCell = newRow.insertCell(7);
    let buttonCell = newRow.insertCell(8);

    idCell.textContent = item.id_reserva;
    fechaCell.textContent = item.fecha;
    horaCell.textContent = item.hora_inicio;
    importeCell.textContent = item.importe + " €";
    puntuacionCell.textContent = item.puntuacion;
    comentarioCell.textContent = item.comentario;
    consumidorCell.textContent = item.consumidor;
    pistaCell.textContent = item.pista;

    let deleteButton = document.createElement("button");
    deleteButton.textContent = "X";
    deleteButton.classList.add("deleteButton");
    deleteButton.onclick = function () {
      deleteReserva(this, item.id_reserva);
    };
    buttonCell.appendChild(deleteButton);
  });

  table.appendChild(tbody);
  divReservas.appendChild(table);

  divReservas.style.display = "block"; // Mostrar el contenedor de la tabla
}

async function mostrarContactos() {
  let reservas = "contactos";
  await fetch("servidor/servidorAdmin.php?contactos=" + contactos)
    .then(function (response) {
      return response.json(); // Este response.json() que devolvemos...
    })
    .then((data) => {
      pintarContactos(data);
    })
    .catch((error) => {
      console.error("Error en la solicitud:", error);
    });
}

async function pintarContactos(data) {
  let divContactos = document.getElementById("contactos");
  divContactos.innerHTML = ""; // Limpiar el contenido del div

  // Crear la tabla
  let table = document.createElement("table");
  table.id = "dynamicTable";

  // Crear thead
  let thead = document.createElement("thead");
  let theadRow = document.createElement("tr");

  let headers = ["Id", "Nombre", "Correo", "Teléfono", "Mensaje", "Estado", ""];
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
    let correoCell = newRow.insertCell(2);
    let telefonoCell = newRow.insertCell(3);
    let mensajeCell = newRow.insertCell(4);
    let estadoCell = newRow.insertCell(5);
    let buttonCell = newRow.insertCell(6);

    idCell.textContent = item.id;
    nombreCell.textContent = item.nombre;
    correoCell.textContent = item.correo;
    telefonoCell.textContent = item.telefono;
    mensajeCell.textContent = item.mensaje;
    estadoCell.textContent = item.estado;
    if (item.estado != "Finalizado") {
      let editButton = document.createElement("button");
      editButton.textContent = "Finalizar";
      editButton.classList.add("editButton");

      editButton.onclick = function () {
        editContacto(this, item.id);
      };
      buttonCell.appendChild(editButton);
    }
  });

  table.appendChild(tbody);
  divContactos.appendChild(table);

  divContactos.style.display = "block"; // Mostrar el contenedor de la tabla
}

async function editContacto(button,id) {
  if (confirm("¿Estás seguro?")) {
    await fetch("servidor/servidorAdmin.php?contactoID=" + id)
      .then(function (response) {
        return response.json(); // Este response.json() que devolvemos...
      })
      .then((data) => {
        if (data.ok) {
          alert(data.ok);
          let row = button.parentNode;
          row.removeChild(button);
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  }
}





document.addEventListener("DOMContentLoaded", async () => {
  sacarUsuarios();
});

navPropietario.addEventListener("click", async () => {
  pintarPropietarios(propietarios);
  1;
});

navConsumidor.addEventListener("click", async () => {
  pintarConsumidores(consumidores);
});

close.addEventListener("click", () => {
  modal_container2.classList.remove("show");
});

aniadirPropietarioBoton.addEventListener("click", async () => {
  aniadirPropietario();
});

navReservas.addEventListener("click", async () => {
  mostrarReservas();
});

navContactos.addEventListener("click", async () => {
  mostrarContactos();
});
