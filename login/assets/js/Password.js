//Cuando se escribe una password, el input field toma el valor encriptado, se limpia  para que el user
// no tenga que borrarlo por el mismo, y se elimna la notificacion
const mensajeResultado = document.getElementById("resultado");
const inputClave = document.getElementById("txtClave");
inputClave.addEventListener("click", () => {
  inputClave.value = "";
  mensajeResultado.style.display = "none";
});
