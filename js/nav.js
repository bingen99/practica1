window.onload = () => {
  barra();
};

function barra() {
  let navegasiao = document.getElementById("navbar");

  return fetch("./js/nav.html")
    .then((response) => response.text())
    .then((text) => {
      navegasiao.innerHTML = text;
    });
}
