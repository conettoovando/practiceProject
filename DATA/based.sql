CREATE DATABASE IF NOT EXISTS usuarios;	
use usuarios; 

-- -----------------------------------------------------
-- -----------------------------------------------------
-- Table `usuarios`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Roles` (
  `idRoles` INT NOT NULL,
  `nombrerol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRoles`));

-- -----------------------------------------------------
-- Table `usuarios`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`usuarios` (
  `email` VARCHAR(45) NOT NULL,
  `PASSWORD` VARCHAR(45) NOT NULL,
  `idRol` INT NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `idrol`
    FOREIGN KEY (`idRol`)
    REFERENCES `usuarios`.`Roles` (`idRoles`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);



-- -----------------------------------------------------
-- Table `usuarios`.`Supervisor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Supervisor` (
  `RutSupervisor` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`RutSupervisor`),
  CONSTRAINT `email`
    FOREIGN KEY (`email`)
    REFERENCES `usuarios`.`usuarios` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `usuarios`.`JefeCarrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`JefeCarrera` (
  `rutJefeCarrera` VARCHAR(45) NOT NULL,
  `sede` VARCHAR(45) NOT NULL,
  `Facultad` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`rutJefeCarrera`),
  CONSTRAINT `email_JC`
    FOREIGN KEY (`email`)
    REFERENCES `usuarios`.`usuarios` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`Carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Carrera` (
  `idCarrera` INT NOT NULL AUTO_INCREMENT,
  `CodigoCarrera` VARCHAR(45) NOT NULL,
  `Carrera` VARCHAR(45) NOT NULL,
  `Rutjefe` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCarrera`),
  UNIQUE (`CodigoCarrera`),
  CONSTRAINT `rutjefe_carrera`
    FOREIGN KEY (`Rutjefe`)
    REFERENCES `usuarios`.`JefeCarrera` (`rutJefeCarrera`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `usuarios`.`centro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`centro` (
  `rut_empresa` VARCHAR(10) NOT NULL,
  `email_empresa` VARCHAR(45) NOT NULL,
  `descripcion_empresa` VARCHAR(45) NOT NULL,
  `telefonoJefe` VARCHAR(45) NOT NULL,
  `nombreJefe` VARCHAR(45) NOT NULL,
  `idrol` INT NOT NULL,
  PRIMARY KEY (`rut_empresa`),
  CONSTRAINT `id_R`
    FOREIGN KEY (`idrol`)
    REFERENCES `usuarios`.`roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table `usuarios`.`estudiantes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`estudiantes` (
  `rutEstudiante` VARCHAR(45) NOT NULL,
  `rutSupervisor` VARCHAR(45) NOT NULL,
  `rutEmpresa` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `CodigoCarrera` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`rutEstudiante`),
  CONSTRAINT `Rutsupervisor_estudiante`
    FOREIGN KEY (`rutSupervisor`)
    REFERENCES `usuarios`.`Supervisor` (`RutSupervisor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `email_estudiante`
    FOREIGN KEY (`email`)
    REFERENCES `usuarios`.`usuarios` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `CCarrera_estudiante`
    FOREIGN KEY (`CodigoCarrera`)
    REFERENCES `usuarios`.`Carrera` (`CodigoCarrera`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `rut_empresa`
    FOREIGN KEY (`rutEmpresa`)
    REFERENCES `usuarios`.`centro` (`rut_empresa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `usuarios`.`Informe Final`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`InformeFinal` (
  `IdInforme` INT NOT NULL AUTO_INCREMENT,
  `fechaEntrega` DATE NOT NULL,
  `fechaCalificacion` DATE NOT NULL,
  `calificacionSupervisor` VARCHAR(8) NOT NULL,
  `ObservacionSupervisor` VARCHAR(255) NOT NULL,
  `calificacionJefeCarrera` VARCHAR(8) NOT NULL,
  `ObservacionJefeCarrera` VARCHAR(255) NOT NULL,
  `calificacionFinal` VARCHAR(8) NOT NULL,
  `rutEstudiante` VARCHAR(45) NOT NULL,
  `rutJefeCarrera` VARCHAR(45) NOT NULL,
  `ruta` VARCHAR(255) NOT NULL,
  `Size` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`IdInforme`),
  CONSTRAINT `rutJefeCarrera`
    FOREIGN KEY (`rutJefeCarrera`)
    REFERENCES `usuarios`.`JefeCarrera` (`rutJefeCarrera`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `rutEstudiante`
    FOREIGN KEY (`rutEstudiante`)
    REFERENCES `usuarios`.`estudiantes` (`rutEstudiante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);



-- -----------------------------------------------------
-- Table `usuarios`.`Bitacora`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Bitacora` (
  `idBitacora` INT NOT NULL AUTO_INCREMENT,
  `descripcionBitacora` VARCHAR(255) NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `ruta` VARCHAR(255) NOT NULL,
  `Size` VARCHAR(45) NOT NULL,
  `respuestaBitacora` VARCHAR(255) NOT NULL,
  `fechaBitacora` DATE NOT NULL,
  `rutEstudiante` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idBitacora`),
  CONSTRAINT `rutestudiante_bitacora`
    FOREIGN KEY (`rutEstudiante`)
    REFERENCES `usuarios`.`estudiantes` (`rutEstudiante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `usuarios`.`consultas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`consultas` (
  `idconsultas` INT NOT NULL AUTO_INCREMENT,
  `descripcionconsulta` VARCHAR(255) NOT NULL,
  `fecha` DATE NOT NULL,
  `rutEstudiante` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idconsultas`),
  CONSTRAINT `rutEstuante_Consultas`
    FOREIGN KEY (`rutEstudiante`)
    REFERENCES `usuarios`.`estudiantes` (`rutEstudiante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `usuarios`.`Respuestas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Respuestas` (
  `idRespuestas` INT NOT NULL AUTO_INCREMENT,
  `descripcionrespuestas` VARCHAR(255) NOT NULL,
  `fecha` DATE NOT NULL,
  `idConsulta` INT NOT NULL,
  PRIMARY KEY (`idRespuestas`),
  CONSTRAINT `IdConsulta_respuestas`
    FOREIGN KEY (`idConsulta`)
    REFERENCES `usuarios`.`consultas` (`idconsultas`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `usuarios`.`Informacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios`.`Informacion` (
  `email` VARCHAR(45) NOT NULL,
  `Nombre` VARCHAR(45) NOT NULL,
  `ApellidoPat` VARCHAR(45) NOT NULL,
  `ApellidoMat` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `email_inf`
    FOREIGN KEY (`email`)
    REFERENCES `usuarios`.`usuarios` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

INSERT INTO roles (idRoles, nombrerol) VALUES(1,'Administrador');
INSERT INTO roles (idRoles, nombrerol) VALUES(2,'Alumno');
INSERT INTO roles (idRoles, nombrerol) VALUES(3,'Tutor');
INSERT INTO roles (idRoles, nombrerol) VALUES(4,'Jefe de carrera');
INSERT INTO roles (idRoles, nombrerol) VALUES(5,'Centro Practica');

INSERT INTO usuarios (email,PASSWORD,idRol) VALUES ('NA','NA',3);
INSERT INTO supervisor (RutSupervisor,email) VALUES ('NA','NA');

INSERT INTO usuarios (email,PASSWORD,idRol) VALUES ('NAJefe','NAJefe',3);
INSERT INTO jefecarrera (rutJefeCarrera,sede,Facultad,email) VALUES ('NAJefe','NA','NA','NAJefe');

INSERT INTO Carrera (CodigoCarrera, Carrera, Rutjefe) VALUES ('ICINF1100','ING EN COMPUTACION E INFORMATICA','NAJefe');
INSERT INTO Carrera (CodigoCarrera, Carrera, Rutjefe) VALUES ('ICI1200','ING CIVIL INDUSTRIAL','NAJefe');
INSERT INTO Carrera (CodigoCarrera, Carrera, Rutjefe) VALUES ('ICRI1300','ING ROBOTICA','NAJefe');

INSERT INTO usuarios (email,PASSWORD,idRol) VALUES ('admin@unab.cl','12345678',1);
