-- Active: 1695306407955@@127.0.0.1@5432@stsgtic@sistec

DROP TABLE IF EXISTS sistec.historial;
DROP TABLE IF EXISTS sistec.servicio;
DROP TABLE IF EXISTS sistec.ticket;
DROP TABLE IF EXISTS sistec.archivo;
DROP TABLE IF EXISTS sistec.equipo;
DROP TABLE IF EXISTS sistec.usuario;
DROP TABLE IF EXISTS sistec.item;
DROP TABLE IF EXISTS sistec.categoria;
CREATE TABLE sistec.categoria(
                            id_categoria SERIAL PRIMARY KEY,
                            descripcion VARCHAR(128)
);
-- TABLA CATEGORIA
INSERT INTO sistec.categoria(id_categoria,descripcion)
VALUES
  (1,'Tipo equipo'), --listo
  (2,'Tipo servicio'), --listo
  (3,'Estado equipo'), --listo
  (4,'Estado ticket'), --listo
  (5,'Estado servicio'), --listo
  (6,'Tipo usuario'), --listo
  (7,'Tipo archivo') --listo
;
-- TABLA ITEM
CREATE TABLE sistec.item(
                      id_item SERIAL PRIMARY KEY,
                      descripcion VARCHAR(128),
                      id_categoria INT,
                      FOREIGN KEY (id_categoria) REFERENCES sistec.categoria(id_categoria)
);

INSERT INTO sistec.item(id_item,descripcion,id_categoria)
VALUES
  (1,'Impresora',1),
  (2,'Laptop',1),
  (3,'Computadora (sin pantalla)',1),
  (4,'Pantalla',1),
  (5,'Escaner',1),
  (6,'Proyector',1),
  (7,'Television',1),
  (8,'Radio',1),
  (9,'Dron',1),
  (10,'No incluido',1),
  (11,'Mantenimiento',2),
  (12,'Correccion',2),
  (13,'Dictamen',2),
  (14,'En cola',3),
  (15,'Mantenimiento',3),
  (16,'Finalizado',3),
  (17,'Entregado',3),
  (18,'Abierto',4),
  (19,'Cerrado',4),
  (20,'En espera',5),
  (21,'Iniciado',5),
  (22,'Finalizado',5),
  (23,'Tecnico',6),
  (24,'Administrador',6),
  (25,'Visitante',6),
  (26,'Dictamen',7),
  (27,'QR',7)
;


-- TABLA USUARIO -> Quiza se descentralice al de la Institucion
CREATE TABLE sistec.usuario(
                            id_usuario SERIAL PRIMARY KEY,
                            cui INT,
                            nombres VARCHAR(128),
                            apellidos VARCHAR(128),
                            id_tipo_usuario INT,
                            FOREIGN KEY (id_tipo_usuario) REFERENCES sistec.item(id_item)
);

-- TABLA EQUIPO
CREATE TABLE sistec.equipo(
                            id_equipo SERIAL PRIMARY KEY,
                            id_tipo_equipo INT,
                            numero_serie VARCHAR(128),
                            marca VARCHAR(128),
                            modelo VARCHAR(128),
                            dependencia_policial VARCHAR(128),
                            id_estado_equipo INT,
                            FOREIGN KEY (id_tipo_equipo) REFERENCES sistec.item(id_item),
                            FOREIGN KEY (id_estado_equipo) REFERENCES sistec.item(id_item)
);
-- TABLA ARCHIVO
CREATE TABLE sistec.archivo(
                            id_archivo SERIAL PRIMARY KEY,
                            id_equipo INT,
                            id_tipo_archivo INT,
                            nombre VARCHAR,
                            nombre_hash VARCHAR,
                            mime VARCHAR,
                            FOREIGN KEY (id_tipo_archivo) REFERENCES sistec.item(id_item),
                            FOREIGN KEY (id_equipo) REFERENCES sistec.equipo(id_equipo)
);
-- TABLA TICKET
CREATE TABLE sistec.ticket(
                            id_ticket SERIAL PRIMARY KEY,
                            numero_documento VARCHAR(128),
                            id_archivo_referencia INT,
                            id_tecnico_revisa INT,
                            nip_usuario_ingresa VARCHAR(128),
                            nip_usuario_recibe VARCHAR(128),
                            fecha_creacion TIMESTAMP,
                            fecha_entrega TIMESTAMP,
                            id_estado_ticket INT,
                            FOREIGN KEY (id_archivo_referencia) REFERENCES sistec.archivo(id_archivo),
                            FOREIGN KEY (id_tecnico_revisa) REFERENCES sistec.usuario(id_usuario),
                            FOREIGN KEY (id_estado_ticket) REFERENCES sistec.item(id_item)
);

-- TABLA SERVICIO
CREATE TABLE sistec.servicio(
                            id_servicio SERIAL PRIMARY KEY,
                            id_ticket INT,
                            id_equipo INT,
                            id_tecnico_asignado INT,
                            id_tipo_servicio INT,
                            fecha_inicio TIMESTAMP,
                            fecha_finalizacion TIMESTAMP,
                            id_estado_servicio INT,
                            FOREIGN KEY (id_ticket) REFERENCES sistec.ticket(id_ticket),
                            FOREIGN KEY (id_equipo) REFERENCES sistec.equipo(id_equipo),
                            FOREIGN KEY (id_tecnico_asignado) REFERENCES sistec.usuario(id_usuario),
                            FOREIGN KEY (id_tipo_servicio) REFERENCES sistec.item(id_item),
                            FOREIGN KEY (id_estado_servicio) REFERENCES sistec.item(id_item)
);

CREATE TABLE sistec.historial(
                            id_historial SERIAL PRIMARY KEY,
                            id_ticket INT,
                            id_equipo INT,
                            id_servicio INT,
                            FOREIGN KEY (id_ticket) REFERENCES sistec.ticket(id_ticket),
                            FOREIGN KEY (id_equipo) REFERENCES sistec.equipo(id_equipo),
                            FOREIGN KEY (id_servicio) REFERENCES sistec.servicio(id_servicio)
);



