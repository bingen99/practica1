/*
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

*/

//con el metodo window.onload lo que hacemos es que cuando la pagina se cargue completamente en el navegador realize la funcion tablarellenadatos y realize lo que hay
//en su interior

window.onload = obtenerelementos().then((dato) => tablarellenadatos(dato.data));

//crearelementos().then((dato) => tablarellenadatos(dato.data));

function borrafilas(i) {
  Swal.fire({
    title: "Estas seguro?",
    text: "Seguro que quieres eliminar este elemento!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      let padre = i.parentNode.parentNode; //con parentNode selecciono el elemento padre de otro elemento
      document.getElementById("cuerpoTabla").removeChild(padre);
      Swal.fire("Deleted!", "Your file has been deleted.", "success");
    }
  });
  eliminarelementos();
}

function filtrado() {
  let filtrar = document.getElementById("filtrar").value.toLowerCase(); //cojo el input

  if (filtrar.length >= 3) {
    DATOS.filter((dato) => {
      let i = DATOS.indexOf(dato);
      if (document.getElementById("fila" + i) != null) {
        if (
          dato.nombre.toLowerCase().includes(filtrar) || //includes nos determina si se encuentra el elemento en el array y devuelve true o false
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

function modificar(i) {
  Swal.fire({
    title: "Estas seguro?",
    text: "Seguro que quieres modificar un elemento!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si quiero modificarlo!",
  }).then((result) => {
    if (result.isConfirmed) {
      let tr = i.parentNode.parentNode;

      let tdnombre = tr.children[1].innerHTML;
      let tddescripcion = tr.children[2].innerHTML;
      let tdnserie = tr.children[3].innerHTML;
      let tdestado = tr.children[4].innerHTML;
      let tdprioridad = tr.children[5].innerHTML;

      tr.children[1].innerHTML =
        '<input type="text" id="nombrevalue" value="' + tdnombre + '"/>';
      tr.children[2].innerHTML =
        '<input type="text" id="descripcionvalue" value="' +
        tddescripcion +
        '"/>';
      tr.children[3].innerHTML =
        '<input type="text" id="nserievalue" value="' + tdnserie + '"/>';
      tr.children[4].innerHTML =
        '<input type="text" id="estadovalue" value="' + tdestado + '"/>';
      tr.children[5].innerHTML =
        '<input type="text" id="prioridadvalue" value="' + tdprioridad + '"/>';
    }

    modificarelementos();
  });
}

function guardar(i) {
  let tr = i.parentNode.parentNode;

  let nombrevalue = document.getElementById("nombrevalue").value;
  let descripcionvalue = document.getElementById("descripcionvalue").value;
  let numeroserievalue = document.getElementById("nserievalue").value;
  let estadovalue = document.getElementById("estadovalue").value;
  let prioridadvalue = document.getElementById("prioridadvalue").value;

  let tdnombre = tr.children[1].innerHTML;
  let tddescripcion = tr.children[2].innerHTML;
  let tdnserie = tr.children[3].innerHTML;
  let tdestado = tr.children[4].innerHTML;
  let tdprioridad = tr.children[5].innerHTML;

  tr.children[1].innerHTML = nombrevalue;
  tr.children[2].innerHTML = descripcionvalue;
  tr.children[3].innerHTML = numeroserievalue;
  tr.children[4].innerHTML = estadovalue;
  tr.children[5].innerHTML = prioridadvalue;

  DATOS.push({
    nombre: (tdnombre[1] = nombrevalue),
    descripcion: (tddescripcion[2] = descripcionvalue),
    numeroserie: (tdnserie[3] = numeroserievalue),
    estado: (tdestado[4] = estadovalue),
    prioridad: (tdprioridad[5] = prioridadvalue),
  });

  DATOS.splice(tr, 1);

  console.log(DATOS);
}

async function obtenerelementos(DATOS) {
  const GET = "http://localhost/practica1/ws/getElement.php";
  return fetch(GET).then((response) => response.json());
}

async function modificarelementos(id) {
  const MOD = `http://localhost/practica1/ws/modifyElement.php?id=${id}`;

  let nombre = document.getElementById("nombrevalue").value;
  let descripcion = document.getElementById("descripcionvalue").value;
  let nserie = document.getElementById("nserievalue").value;
  let estado = document.getElementById("estadovalue").value;
  let prioridad = document.getElementById("prioridadvalue").value;

  return fetch(MOD, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      nombre: nombre,
      descripcion: descripcion,
      numeroserie: nserie,
      estado: estado,
      prioridad: prioridad,
    }),
  })
    .then((res) => res.json())
    .then((data) => console.log(data));
}

async function eliminarelementos(id) {
  return fetch(`http://localhost/practica1/ws/deleteElement.php?id=${id}`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: null,
  })
    .then((response) => console.log(response))
    .catch((e) => {
      console.log(e);
    });
}

function tablarellenadatos(DATOS) {
  const cuerpotabla = document.getElementById("cuerpoTabla"); //aqui cojo el cuerpo de la tabla por su id

  for (i = 0; i < DATOS.length; i++) {
    const tr = document.createElement("tr"); //sirve para crear filas tr significa table-row

    tr.setAttribute("id", "fila" + i); //asigna un id independiente a cada fila

    let tdacciones = document.createElement("td"); //aqui creo las celdas que contendran los botones de acciones los cuales sirven para borrar las filas
    let boton = document.createElement("button"); //creo los botones para borrar las filas
    boton.textContent = "X";
    boton.setAttribute("onclick", "borrafilas(this)"); //a todos los botones les asigno un evento onclick que nos permite ejecutar una funcion cuando le damos click al elemento
    tdacciones.appendChild(boton); //appendchild nos sirve para introducir un nodo hijo dentro de la celda acciones es decir meto los botones dentro de las celdas
    let boton2 = document.createElement("button");
    boton2.textContent = "editar";
    boton2.setAttribute("onclick", "modificar(this)");
    boton2.setAttribute("id", "editar");
    tdacciones.appendChild(boton2);
    let boton3 = document.createElement("button");
    boton3.textContent = "guardar";
    boton3.setAttribute("onclick", "guardar(this)");
    boton3.setAttribute("id", "guardar");
    tdacciones.appendChild(boton3);

    tr.appendChild(tdacciones); //meto las celdas de acciones dentro de las filas y en base al numero de datos que existan se generaran x filas en este caso 4 filas

    let tdnombre = document.createElement("td");

    tdnombre.textContent = DATOS[i].nombre; //relleno las celdas de nombre con los nombres de los json

    tdnombre.setAttribute("id", "nombres");

    tr.appendChild(tdnombre); //meto las celdas de nombre dentro de las filas y con el resto lo mismo

    let tddescripcion = document.createElement("td");

    tddescripcion.textContent = DATOS[i].descripcion;

    tddescripcion.setAttribute("id", "descripciones");

    tr.appendChild(tddescripcion);

    let tdnumeroserie = document.createElement("td");

    tdnumeroserie.textContent = DATOS[i].numeroserie;

    tdnumeroserie.setAttribute("id", "numerosseries");

    tr.appendChild(tdnumeroserie);

    let tdestado = document.createElement("td");

    tdestado.textContent = DATOS[i].estado;

    tdestado.setAttribute("id", "estados");

    tr.appendChild(tdestado);

    let tdprioridad = document.createElement("td");

    tdprioridad.textContent = DATOS[i].prioridad;

    tdprioridad.setAttribute("id", "prioridades");

    tr.appendChild(tdprioridad);

    //agregamos las filas al cuerpo de la tabla y ya estaria creada

    cuerpotabla.appendChild(tr);
  }
}
