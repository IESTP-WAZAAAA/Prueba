function alternarClave(inputId, icono) {
    const campoClave = document.getElementById(inputId);

    if (campoClave.type === "password") {
        campoClave.type = "text";
        icono.textContent = "visibility_off";
    } else {
        campoClave.type = "password";
        icono.textContent = "visibility";
    }
}
