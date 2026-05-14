<?php
class GestorNomina {
    private $cx;

    public function __construct($db_link) {
        $this->cx = $db_link;
    }

    public function obtenerStaffCompleto() {
        $query = "SELECT emp.*, sec.nombre AS dpto 
                  FROM empleados emp 
                  INNER JOIN areas sec ON emp.area_id = sec.id 
                  ORDER BY emp.id DESC";
        return $this->cx->query($query);
    }

    public function catalogos($tabla) {
        return $this->cx->query("SELECT * FROM $tabla ORDER BY nombre");
    }

    public function fichaIndividual($cod) {
        $res = $this->cx->query("SELECT * FROM empleados WHERE id = " . intval($cod));
        return $res->fetch_assoc();
    }

    public function rolesDeEmpleado($id_empleado) {
        $ids = [];
        $res = $this->cx->query("SELECT rol_id FROM empleado_rol WHERE empleado_id = ".intval($id_empleado));
        while($f = $res->fetch_assoc()) $ids[] = $f['rol_id'];
        return $ids;
    }

    public function procesarFicha($post, $roles) {
        $n = $post['nombre'] ?? '';
        $e = $post['email'] ?? '';
        $s = $post['sexo'] ?? '';
        $a = $post['area_id'] ?? 0;
        $b = isset($post['boletin']) ? 1 : 0;
        $d = $post['descripcion'] ?? '';

        if(isset($post['id_empleado']) && !empty($post['id_empleado'])) {
            $id = $post['id_empleado'];
            $stmt = $this->cx->prepare("UPDATE empleados SET nombre=?, email=?, sexo=?, area_id=?, boletin=?, descripcion=? WHERE id=?");
            $stmt->bind_param("sssiisi", $n, $e, $s, $a, $b, $d, $id);
        } else {
            $stmt = $this->cx->prepare("INSERT INTO empleados (nombre, email, sexo, area_id, boletin, descripcion) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("sssiis", $n, $e, $s, $a, $b, $d);
        }

        if($stmt->execute()) {
            $ultimo_id = isset($post['id_empleado']) ? $post['id_empleado'] : $this->cx->insert_id;
            $this->vincularRoles($ultimo_id, $roles);
            return true;
        }
        return false;
    }

    private function vincularRoles($id, $lista_roles) {
        $this->cx->query("DELETE FROM empleado_rol WHERE empleado_id = $id");
        if(!empty($lista_roles)) {
            foreach($lista_roles as $r) {
                $this->cx->query("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES ($id, $r)");
            }
        }
    }

    public function quitarDelSistema($id) {
        $id_limpio = intval($id);
        $this->cx->query("DELETE FROM empleado_rol WHERE empleado_id = $id_limpio");
        return $this->cx->query("DELETE FROM empleados WHERE id = $id_limpio");
    }
}