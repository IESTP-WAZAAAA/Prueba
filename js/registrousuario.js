document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('./PHP/registrer.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                this.reset();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Error al registrar los datos: ' + error.message);
        });
});