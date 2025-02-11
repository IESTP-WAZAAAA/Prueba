document.getElementById('consultaForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('./PHP/guardarconsulta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            document.getElementById('consultaForm').reset();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Hubo un error al procesar la solicitud.");
        console.error('Error:', error);
    });
});