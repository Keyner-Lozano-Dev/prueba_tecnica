<?php
include 'config_db.php';
include 'gestor_nomina.php';
$db = (new ConectorLocal())->abrirConexion();
$operaciones = new GestorNomina($db);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Personal</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="form-container">
            <h2><i class="fas fa-user-plus"></i> Registro</h2>
            <form action="guardar.php" method="POST" class="form-empleado">
                <div class="campo">
                    <label>Nombre completo *</label>
                    <input type="text" name="nombre" id="nombre_completo">
                </div>
                <div class="campo">
                    <label>Email *</label>
                    <input type="email" name="email" id="correo_inst">
                </div>
                <div class="campo">
                    <label>Género *</label>
                    <div style="display:flex; gap:10px;">
                        <label style="font-weight:normal;"><input type="radio" name="sexo" value="M"> M</label>
                        <label style="font-weight:normal;"><input type="radio" name="sexo" value="F"> F</label>
                    </div>
                </div>
                <div class="campo">
                    <label>Área *</label>
                    <select name="area_id">
                        <?php $areas = $operaciones->catalogos('areas'); 
                        while($a = $areas->fetch_assoc()): ?>
                            <option value="<?=$a['id']?>"><?=$a['nombre']?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="campo">
                    <label>Descripción *</label>
                    <textarea name="descripcion" id="desc_txt"></textarea>
                </div>
                <div class="campo">
                    <label>Roles *</label>
                    <div style="background:#f9f9f9; padding:8px; border-radius:4px;">
                        <?php $roles = $operaciones->catalogos('roles'); 
                        while($r = $roles->fetch_assoc()): ?>
                            <label style="font-weight:normal; display:block;">
                                <input type="checkbox" name="roles[]" value="<?=$r['id']?>"> <?=$r['nombre']?>
                            </label>
                        <?php endwhile; ?>
                    </div>
                </div>
                <button type="button" onclick="chequearEnvio()" class="btn-primario">Guardar Empleado</button>
            </form>
        </div>

        <div class="table-container">
            <h2><i class="fas fa-list"></i> Listado</h2>
            <table class="tabla-nomina">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Área</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $staff = $operaciones->obtenerStaffCompleto();
                    while($e = $staff->fetch_assoc()): ?>
                    <tr>
                        <td><?=$e['nombre']?></td>
                        <td><?=$e['email']?></td>
                        <td><?=$e['dpto']?></td>
                        <td style="text-align:center;">
                            <a href="editar_ficha.php?cod=<?=$e['id']?>" class="btn-editar"><i class="fas fa-edit"></i></a>
                            <a href="borrar.php?cod=<?=$e['id']?>" class="btn-borrar" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="validar_form.js"></script>
</body>
</html>