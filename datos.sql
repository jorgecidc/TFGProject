CREATE DATABASE padelbd;
USE padelbd;

CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(100),
    contrasena VARCHAR(100)
);

CREATE TABLE Pista (
    id_pista INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50)
);

CREATE TABLE Partido (
    id_partido INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    hora_inicio TIME,
    id_usuario INT,
    id_pista INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_pista) REFERENCES Pista(id_pista)
);

CREATE TABLE Clase (
    id_clase INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    instructor VARCHAR(100),
    id_usuario INT,
    id_pista INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_pista) REFERENCES Pista(id_pista)
);

CREATE TABLE Administrador (
    id_administrador INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(100),
    contrasena VARCHAR(100)
);
CREATE TABLE Aviso (
    id_aviso INT PRIMARY KEY AUTO_INCREMENT,
    mensaje TEXT,
    id_usuario INT,
    id_administrador INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_administrador) REFERENCES Administrador(id_administrador)
);



CREATE TABLE Gestion_de_usuarios (
    id_gestion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_administrador INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_administrador) REFERENCES Administrador(id_administrador)
);

CREATE TABLE Gestion_de_partidos (
    id_gestion INT PRIMARY KEY AUTO_INCREMENT,
    id_partido INT,
    id_administrador INT,
    FOREIGN KEY (id_partido) REFERENCES Partido(id_partido),
    FOREIGN KEY (id_administrador) REFERENCES Administrador(id_administrador)
);

CREATE TABLE Gestion_de_clases (
    id_gestion INT PRIMARY KEY AUTO_INCREMENT,
    id_clase INT,
    id_administrador INT,
    FOREIGN KEY (id_clase) REFERENCES Clase(id_clase),
    FOREIGN KEY (id_administrador) REFERENCES Administrador(id_administrador)
);

-- Insertar datos de ejemplo
INSERT INTO Usuario (nombre, apellido, correo, contrasena) VALUES
('Juan', 'Pérez', 'juan@example.com', 'password1'),
('María', 'López', 'maria@example.com', 'password2'),
('Carlos', 'García', 'carlos@example.com', 'password3');

INSERT INTO Pista (nombre) VALUES
('Pista 1'),
('Pista 2'),
('Pista 3'),
('Pista 4');

INSERT INTO Partido (fecha, hora_inicio, id_usuario, id_pista) VALUES
('2024-05-20', '10:00', 1, 1),
('2024-05-21', '15:00', 2, 2),
('2024-05-22', '18:00', 3, 3);

INSERT INTO Clase (fecha, hora_inicio, hora_fin, instructor, id_usuario, id_pista) VALUES
('2024-05-20', '10:00', '11:00', 'Instructor 1', 1, 1),
('2024-05-21', '15:00', '16:00', 'Instructor 2', 2, 2),
('2024-05-22', '18:00', '19:00', 'Instructor 3', 3, 3);

INSERT INTO Administrador (nombre, apellido, correo, contrasena) VALUES
('Admin', 'Admin', 'admin@example.com', 'adminpassword');

INSERT INTO Aviso (mensaje, id_usuario, id_administrador) VALUES
('Este es un aviso de ejemplo', 1, 1),
('Otro aviso importante', 2, 1),
('Aviso urgente', 3, 1);

INSERT INTO Gestion_de_usuarios (id_usuario, id_administrador) VALUES
(1, 1),
(2, 1),
(3, 1);

INSERT INTO Gestion_de_partidos (id_partido, id_administrador) VALUES
(1, 1),
(2, 1),
(3, 1);

INSERT INTO Gestion_de_clases (id_clase, id_administrador) VALUES
(1, 1),
(2, 1),
(3, 1);
