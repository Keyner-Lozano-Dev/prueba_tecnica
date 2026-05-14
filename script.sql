CREATE DATABASE IF NOT EXISTS prueba_tecnica;
USE prueba_tecnica;

CREATE TABLE areas (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO areas (id, nombre) VALUES
(1, 'Administración'), (2, 'Ventas'), (3, 'Calidad'), (4, 'Producción');

CREATE TABLE roles (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO roles (id, nombre) VALUES
(1, 'Desarrollador'), (2, 'Gerente estratégico'), (3, 'Auxiliar administrativo');

CREATE TABLE empleados (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  sexo char(1) NOT NULL,
  area_id int(11) NOT NULL,
  boletin int(11) NOT NULL,
  descripcion text NOT NULL,
  FOREIGN KEY (area_id) REFERENCES areas(id)
) ENGINE=InnoDB;

CREATE TABLE empleado_rol (
  empleado_id int(11) NOT NULL,
  rol_id int(11) NOT NULL,
  FOREIGN KEY (empleado_id) REFERENCES empleados(id),
  FOREIGN KEY (rol_id) REFERENCES roles(id)
) ENGINE=InnoDB;