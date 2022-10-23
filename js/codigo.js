const DATOS = [
  {
    nombre: "bingen",
    descripcion: "mecanico industrial",
    numeroserie: "1234",
    estado: "on",
    prioridad: "medio",
  },
  {
    nombre: "paco",
    descripcion: "mecanico cuantico",
    numeroserie: "1234567",
    estado: "off",
    prioridad: "bajo",
  },
  {
    nombre: "pepe",
    descripcion: "astronauta",
    numeroserie: "123456789",
    estado: "on",
    prioridad: "alto",
  },

  {
    nombre: "alexelcapo",
    descripcion: "astronauta++",
    numeroserie: "12345678011",
    estado: "off",
    prioridad: "medio",
  },
];

window.onload = function tablarellenadatos() {
  const cuerpotabla = document.getElementById("cuerpoTabla");

  for (i = 0; i < DATOS.length; i++) {
    const tr = document.createElement("tr");

    tr.setAttribute("id", "fila" + i); //asigna un id independiente a cada fila que mas adelante servira para el filtro

    let tdacciones = document.createElement("td");
    let boton = document.createElement("button");
    boton.textContent = "X";
    boton.setAttribute("onclick", "borrafilas(this)");
    tdacciones.appendChild(boton);
    tr.appendChild(tdacciones);

    let tdnombre = document.createElement("td");

    tdnombre.textContent = DATOS[i].nombre;

    tr.appendChild(tdnombre);

    let tddescripcion = document.createElement("td");

    tddescripcion.textContent = DATOS[i].descripcion;

    tr.appendChild(tddescripcion);

    let tdnumeroserie = document.createElement("td");

    tdnumeroserie.textContent = DATOS[i].numeroserie;

    tr.appendChild(tdnumeroserie);

    let tdestado = document.createElement("td");

    tdestado.textContent = DATOS[i].estado;

    tr.appendChild(tdestado);

    let tdprioridad = document.createElement("td");

    tdprioridad.textContent = DATOS[i].prioridad;

    tr.appendChild(tdprioridad);

    //agregamos las filas al cuerpo de la tabla y ya estaria creada

    cuerpotabla.appendChild(tr);
  }
};

function borrafilas(i) {
  let padre = i.parentNode.parentNode;
  document.getElementById("cuerpoTabla").removeChild(padre);
}

function filtrado() {
  let filtrar = document.getElementById("filtrar").value.toLowerCase();

  if (filtrar.length >= 3) {
    DATOS.filter((dato) => {
      let i = DATOS.indexOf(dato);
      if (document.getElementById("fila" + i) != null) {
        if (
          dato.nombre.toLowerCase().includes(filtrar) ||
          dato.descripcion.toLowerCase().includes(filtrar)
        ) {
          document.getElementById("fila" + i).style = "display:table-row;"; //esta linea saca los resultados que coincidan con el filtro dejandolos solos y ocultando los que no coinciden
        } else {
          document.getElementById("fila" + i).style = "display:none;"; //esta linea hace desaparecer toda la tabla si no coincide ninguno de los 3 primeros caracteres con los datos de la tabla
        }
      }
    });

    //estas lineas debajo del else son para recuperar la tabla una vez borremos la busqueda realizada en el fitro
  } else {
    for (j = 0; j < DATOS.length; j++) {
      if (document.getElementById("fila" + j) != null)
        document.getElementById("fila" + j).style = "display:table-row;"; //recupera la tabla entera
    }
  }
}
