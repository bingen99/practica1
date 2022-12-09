window.onload = () => {
  barra();
};

function barra() {
  let navegasiao = document.getElementById("navbar");

  return fetch("./js/nav.html") //Fetch nos permite realizar peticiones HTTP asíncronas utilizando promesas
    .then((response) => response.text()) // .then es una promesa es decir un objeto devuelto al cual se adjuntan funciones callback y response representa la respuesta
    .then((text) => {
      navegasiao.innerHTML = text;
    });
}
