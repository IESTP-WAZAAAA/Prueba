$('#buscar').click(function () {
    let dni = $('#documento').val();

    if (!/^\d{8}$/.test(dni)) {
        alert("El DNI debe tener 8 dígitos.");
        return;
    }

    $.ajax({
        url: 'PHP/consulta_dni.php',
        type: 'post',
        data: { dni: dni },
        dataType: 'json',
        success: function (r) {
            if (r.numeroDocumento === dni) {
                $("#nombres").val(r.nombres);
                $("#apellidoPaterno").val(`${r.apellidoPaterno} ${r.apellidoMaterno}`);
            } else {
                alert("No existe el DNI.");
            }
        },
        error: function (xhr, status, error) {
            alert("Error al consultar el DNI: " + error);
        }
    });
});