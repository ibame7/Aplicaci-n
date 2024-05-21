window.addEventListener("DOMContentLoaded", (event) => {
  var navbarShrink = function () {
    const navbarCollapsible = document.body.querySelector("#mainNav");
    if (!navbarCollapsible) {
      return;
    }
    if (window.scrollY === 0) {
      navbarCollapsible.classList.remove("navbar-shrink");
    } else {
      navbarCollapsible.classList.add("navbar-shrink");
    }
  };
  navbarShrink();
  document.addEventListener("scroll", navbarShrink);
  const mainNav = document.body.querySelector("#mainNav");
  if (mainNav) {
    new bootstrap.ScrollSpy(document.body, {
      target: "#mainNav",
      rootMargin: "0px 0px -40%",
    });
  }
  const navbarToggler = document.body.querySelector(".navbar-toggler");
  const responsiveNavItems = [].slice.call(
    document.querySelectorAll("#navbarResponsive .nav-link")
  );
  responsiveNavItems.map(function (responsiveNavItem) {
    responsiveNavItem.addEventListener("click", () => {
      if (window.getComputedStyle(navbarToggler).display !== "none") {
        navbarToggler.click();
      }
    });
  });
});

let faq = document.getElementById("faq");
faq.addEventListener("click", () => {
  window.location.href = "faq.php";
});

let buscar = document.getElementById("buscarInstalacion");
/////////////////////////////////////////////////MODIFICAR BOTON/////////////////////////////////////////////////////
if(buscar){


buscar.addEventListener("click", () => {
  let poPup = document.querySelector(".popup-container");

  let popupDiv = document.createElement("div");
  popupDiv.className = "popup-container";

  // Crear el input de texto
  let input = document.createElement("input");
  input.setAttribute("id", "valorMunicipio");
  input.type = "text";
  input.placeholder = "Escribe una ciudad";

  // Crear el botón
  let button = document.createElement("button");
  button.setAttribute("id", "buscarMunicipio");
  button.textContent = "Buscar";

  // Crear el botón de cerrar
  let closeBtn = document.createElement("span");
  closeBtn.className = "close-btn";
  closeBtn.innerHTML = "&times";
  closeBtn.onclick = function () {
    document.body.removeChild(popupDiv);
  };

  // Agregar elementos al div del pop-up
  popupDiv.appendChild(input);
  popupDiv.appendChild(button);
  popupDiv.appendChild(closeBtn);

  if (!poPup) {
    document.body.appendChild(popupDiv);
  }

  button.addEventListener("click", () => {
    if (input.value.trim().length > 0) {
      input.style.border = "";
      localStorage.setItem("municipio", input.value.split(' ').join(''));
      window.location.href = "cadaMunicipio.php";
    } else {
      input.style.border = "2px red solid";
    }
  });
});
}