<?php
include 'config_db.php';
include 'gestor_nomina.php';
$db = (new ConectorLocal())->abrirConexion();
$operaciones = new GestorNomina($db);
$codigo = isset($_GET['cod']) ? intval($_GET['cod']) : 0;
$perfil = $operaciones->fichaIndividual($codigo);
if(!$perfil) die("No existe el perfil.");
$roles_actuales = $operaciones->rolesDeEmpleado($codigo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ficha</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper" style="justify-content:center;">
        <div class="form-container" style="max-width:500px;">
            <h2>Editar Empleado</h2>
            <form action="guardar.php" method="POST" class="form-empleado">
                <input type="hidden" name="id_empleado" value="<?=$codigo?>">
                <div class="campo">
                    <label>Nombre completo</label>
                    <input type="text" name="nombre" id="nombre_completo" value="<?=$perfil['nombre']?>">
                </div>
                <div class="campo">
                    <label>Email</label>
                    <input type="email" name="email" id="correo_inst" value="<?=$perfil['email']?>">
                </div>
                <div class="campo">
                    <label>Género</label>
                    <div style="display:flex; gap:10px;">
                        <label style="font-weight:normal;"><input type="radio" name="sexo" value="M" <?=($perfil['sexo']=='M')?'checked':''?>> M</label>
                        <label style="font-weight:normal;"><input type="radio" name="sexo" value="F" <?=($perfil['sexo']=='F')?'checked':''?>> F</label>
                    </div>
                </div>
                <div class="campo">
                    <label>Área</label>
                    <select name="area_id">
                        <?php $areas = $operaciones->catalogos('areas'); 
                        while($a = $areas->fetch_assoc()): ?>
                            <option value="<?=$a['id']?>" <?=($a['id']==$perfil['area_id'])?'selected':''?>><?=$a['nombre']?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="campo">
                    <label>Descripción</label>
                    <textarea name="descripcion" id="desc_txt"><?=$perfil['descripcion']?></textarea>
                </div>
                <div class="campo">
                    <label>Roles</label>
                    <div style="background:#f9f9f9; padding:8px; border-radius:4px;">
                        <?php $roles = $operaciones->catalogos('roles'); 
                        while($r = $roles->fetch_assoc()): 
                            $m = in_array($r['id'], $roles_actuales) ? 'checked' : ''; ?>
                            <label style="font-weight:normal; display:block;">
                                <input type="checkbox" name="roles[]" value="<?=$r['id']?>" <?=$m?>> <?=$r['nombre']?>
                            </label>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div style="display:flex; gap:10px; margin-top:15px;">
                    <button type="button" onclick="chequearEnvio()" class="btn-primario" style="flex:2;">Actualizar</button>
                    <a href="index.php" class="btn-cancelar" style="flex:1;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <script src="validar_form.js"></script>
</body>
</html>