function chequearEnvio() {
    const f = document.querySelector('.form-empleado');
    const nom = document.getElementById('nombre_completo').value.trim();
    const email = document.getElementById('correo_inst').value.trim();
    const sexo = document.querySelector('input[name="sexo"]:checked');
    const desc = document.getElementById('desc_txt').value.trim();
    const roles = document.querySelectorAll('input[name="roles[]"]:checked');

    if(nom === "" || email === "" || !sexo || desc === "" || roles.length === 0) {
        alert("Faltan campos obligatorios o roles por asignar.");
        return false;
    }
    f.submit();
}