function eliminarConsulta(id) {
    if (confirm("¿Estás seguro de eliminar esta consulta?")) {
        fetch("./PHP/eliminarconsulta.php", {
            method: "POST",
            body: JSON.stringify({ id: id }),
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                location.reload();
            }
        })
        .catch(error => console.error("Error:", error));
    }
}