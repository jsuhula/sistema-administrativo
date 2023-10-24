CREATE DATABASE DeAquiSoy;

USE DeAquiSoy;

CREATE TABLE `Comision` (
  `CodigoComision` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(150),
  `Restricciones` VARCHAR(150),
  `Bono` DECIMAL(10,2),
  PRIMARY KEY (`CodigoComision`)
);

CREATE TABLE `Departamento` (
  `CodigoDepartamento` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(100),
  `CodigoComision` INT,
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoDepartamento`),
  FOREIGN KEY (`CodigoComision`) REFERENCES `Comision`(`CodigoComision`)
);

CREATE TABLE `Rol` (
  `CodigoRol` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(50),
  `GestionaEmpleados` INT,
  `GestionaMenu` INT,
  `GestionaReportes` INT,
  `GestionaNomina` INT,
  `GestionaCaja` INT,
  `Asistencia` INT,
  PRIMARY KEY (`CodigoRol`)
);

CREATE TABLE `UsuarioSistema` (
  `CodigoUsuarioSistema` INT AUTO_INCREMENT NOT NULL,
  `Email` VARCHAR(50),
  `Clave` VARCHAR(200),
  `CodigoRol` INT,
  PRIMARY KEY (`CodigoUsuarioSistema`),
  FOREIGN KEY (`CodigoRol`) REFERENCES `Rol`(`CodigoRol`)
);

CREATE TABLE `Empleado` (
  `CodigoEmpleado` VARCHAR(10) NOT NULL,
  `Nombres` VARCHAR(100),
  `Apellidos` VARCHAR(100),
  `Email` VARCHAR(75),
  `Telefono` VARCHAR(10),
  `SalarioBase` DECIMAL(10,2),
  `FechaNacimiento` DATE,
  `FechaIngreso` DATE,
  `FechaRetiro` DATE,
  `Profesion` VARCHAR(50),
  `Fotografia` VARCHAR(100),
  `Jornada` VARCHAR(100),
  `DPI` VARCHAR(13),
  `NIT` VARCHAR(13),
  `IRTRA` VARCHAR(13),
  `IGSS` VARCHAR(13),
  `Estado` BOOLEAN,
  `CodigoDepartamento` INT,
  `CodigoUsuarioSistema` INT,
  PRIMARY KEY (`CodigoEmpleado`),
  FOREIGN KEY (`CodigoDepartamento`) REFERENCES `Departamento`(`CodigoDepartamento`),
  FOREIGN KEY (`CodigoUsuarioSistema`) REFERENCES `UsuarioSistema`(`CodigoUsuarioSistema`)
);

CREATE TABLE `Prestamo` (
  `CodigoPrestamo` INT AUTO_INCREMENT NOT NULL,
  `Fecha` DATE,
  `Monto` DECIMAL(10,2),
  `Cuotas` INT,
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoPrestamo`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
);

CREATE TABLE `Abono` (
  `CodigoAbono` INT AUTO_INCREMENT NOT NULL,
  `Monto` DECIMAL(10,2),
  `Fecha` DATETIME,
  `CodigoPrestamo` INT,
  PRIMARY KEY (`CodigoAbono`),
  FOREIGN KEY (`CodigoPrestamo`) REFERENCES `Prestamo`(`CodigoPrestamo`)
);

CREATE TABLE `Liquidacion` (
  `CodigoLiquidacion` INT AUTO_INCREMENT NOT NULL,
  `FechaLiquidacion` DATE,
  `Indemnizacion` DECIMAL(10,2),
  `Aguinaldo` DECIMAL(10,2),
  `Bono14` DECIMAL(10,2),
  `Vacaciones` DECIMAL(10,2),
  `HorasExtras` DECIMAL(10,2),
  `CantidadHorasExtrasPendientes` DOUBLE,
  `CantidadDiasVacacionesPendientes` DOUBLE,
  `CodigoEmpleado` VARCHAR(10),
  `CodigoPrestamo` INT,
  PRIMARY KEY (`CodigoLiquidacion`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`),
  FOREIGN KEY (`CodigoPrestamo`) REFERENCES `Prestamo`(`CodigoPrestamo`)
);

CREATE TABLE `Asistencia` (
  `CodigoAsistencia` INT AUTO_INCREMENT NOT NULL,
  `Entrada` DATETIME,
  `Salida` DATETIME,
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoAsistencia`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
);

CREATE TABLE `CategoriaItem` (
  `CodigoCategoriaItem` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(50),
  `Descripcion` VARCHAR(100),
  PRIMARY KEY (`CodigoCategoriaItem`)
);

CREATE TABLE `Item` (
  `CodigoItem` VARCHAR(10) NOT NULL,
  `Nombre` VARCHAR(50),
  `Descripcion` VARCHAR(300),
  `Precio` DECIMAL(10,2),
  `Imagen` VARCHAR(200),
  `Descuento` DOUBLE,
  `CodigoCategoriaItem` INT,
  PRIMARY KEY (`CodigoItem`),
  FOREIGN KEY (`CodigoCategoriaItem`) REFERENCES `CategoriaItem`(`CodigoCategoriaItem`)
);

CREATE TABLE `Mesa` (
  `CodigoMesa` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(20),
  `Capacidad` INT,
  `Estado` BOOLEAN,
  PRIMARY KEY (`CodigoMesa`)
);

CREATE TABLE `Orden` (
  `CodigoOrden` INT AUTO_INCREMENT NOT NULL,
  `Observaciones` VARCHAR(200),
  `Estado` INT,
  `DescuentoEspecial` BOOLEAN, 
  `CodigoMesa` INT,
  PRIMARY KEY (`CodigoOrden`),
  FOREIGN KEY (`CodigoMesa`) REFERENCES `Mesa`(`CodigoMesa`)
);


CREATE TABLE `DetalleOrden` (
  `CodigoDetalleOrden` INT AUTO_INCREMENT NOT NULL,
  `CodigoOrden` INT,
  `CodigoItem` VARCHAR(10),
  `Cantidad` INT,
  PRIMARY KEY (`CodigoDetalleOrden`),
  FOREIGN KEY (`CodigoOrden`) REFERENCES `Orden`(`CodigoOrden`),
  FOREIGN KEY (`CodigoItem`) REFERENCES `Item`(`CodigoItem`)
);

CREATE TABLE `TipoDePago` (
  `CodigoTipoDePago` INT AUTO_INCREMENT NOT NULL,
  `Tipo` VARCHAR(50),
  PRIMARY KEY (`CodigoTipoDePago`)
);

CREATE TABLE `Caja` (
  `CodigoCaja` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(30),
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoCaja`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
);

CREATE TABLE `Cierre` (
  `CodigoCierre` INT AUTO_INCREMENT NOT NULL,
  `FechaApertura` DATETIME,
  `FechaCierre` DATETIME,
  `SaldoInicial` DECIMAL(10,2),
  `SaldoFinal` DECIMAL(10,2),
  `CodigoEmpleado` VARCHAR(10),
  `CodigoCaja` INT,
  PRIMARY KEY (`CodigoCierre`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`),
  FOREIGN KEY (`CodigoCaja`) REFERENCES `Caja`(`CodigoCaja`)
);

CREATE TABLE `Factura` (
  `CodigoFactura` VARCHAR(10) NOT NULL,
  `Nit` VARCHAR(13),
  `Fecha` DATETIME,
  `Total` DECIMAL(10,2),
  `CodigoTipoDePago` INT,
  `CodigoOrden` INT,
  `CodigoCaja` INT,
  PRIMARY KEY (`CodigoFactura`),
  FOREIGN KEY (`CodigoTipoDePago`) REFERENCES `TipoDePago`(`CodigoTipoDePago`),
  FOREIGN KEY (`CodigoOrden`) REFERENCES `Orden`(`CodigoOrden`),
  FOREIGN KEY (`CodigoCaja`) REFERENCES `Caja`(`CodigoCaja`)
);

CREATE TABLE `Productividad` (
  `Fecha` DATE,
  `CodigoEmpleado` VARCHAR(10),
  `CodigoItem` VARCHAR(10),
  `CodigoMesa` INT,
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`),
  FOREIGN KEY (`CodigoItem`) REFERENCES `Item`(`CodigoItem`),
  FOREIGN KEY (`CodigoMesa`) REFERENCES `Mesa`(`CodigoMesa`)
);

CREATE TABLE `Honorarios` (
  `CodigoHonorario` INT AUTO_INCREMENT NOT NULL,
  `FechaPago` DATE,
  `SalarioBase` DECIMAL(10,2),
  `TotalComisiones` DECIMAL(10,2),
  `BonoIncentivo` DECIMAL(10,2),
  `HorasExtras` DOUBLE,
  `HorasNoTrabajadas` DOUBLE,
  `DescuentoHorasNoTrabajadas` DECIMAL(10,2),
  `DescuentoIGSS` DECIMAL(10,2),
  `DescuentoIRTRA` DECIMAL(10,2),
  `DescuentoISR` DECIMAL(10,2),
  `AbonoPrestamo` DECIMAL(10,2),
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY(`CodigoHonorario`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
);

CREATE TABLE `TipoBonificacion` (
  `CodigoTipoBonificacion` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(30),
  `Descripcion` VARCHAR(150),
  `FechaPagoSugerida` DATE,
  PRIMARY KEY (`CodigoTipoBonificacion`)
);

CREATE TABLE `PagoBonificacion` (
  `CodigoPagoBonificacion` INT AUTO_INCREMENT NOT NULL,
  `Monto` DECIMAL(10,2),
  `Fecha` DATETIME,
  `CodigoEmpleado` VARCHAR(10),
  `CodigoTipoBonificacion` INT,
  PRIMARY KEY (`CodigoPagoBonificacion`),
  FOREIGN KEY (`CodigoTipoBonificacion`) REFERENCES `TipoBonificacion`(`CodigoTipoBonificacion`),
  FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
);

/* FUNCION GENERA CODIGO COMBINADO */

DELIMITER //
CREATE FUNCTION generarCodigoEmpleado(Nombres VARCHAR(50), Apellidos VARCHAR(50), DPI VARCHAR(13))
RETURNS VARCHAR(10)
BEGIN
  DECLARE Codigo VARCHAR(10);

  SET Codigo = CONCAT(
    UPPER(LEFT(REPLACE(Nombres, ' ', ''), 3)),
    UPPER(LEFT(REPLACE(Apellidos, ' ', ''), 3)),
    RIGHT(DPI, 4)
  );
  RETURN Codigo;
END //
DELIMITER ;

/*PROCEDURES */

/*VALIDAR CREDENCIALES*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarCredenciales 
(IN VarEmail VARCHAR(50), IN VarClave VARCHAR(50), IN VarPalabraClave VARCHAR(50))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoUsuarioSistema AS CodigoUsuario 
    FROM UsuarioSistema WHERE Email = VarEmail 
    AND VarClave = AES_DECRYPT(UNHEX(Clave), VarPalabraClave);
END //
DELIMITER ;

/*LISTAR USUARIOS*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarUsuarios()
BEGIN
	SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.CodigoRol
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol
                    ORDER BY Codigo ASC;
END //
DELIMITER ;

/*LISTAR USUARIOS BUSQUEDA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarUsuariosBusqueda(IN VarEmailBusqueda VARCHAR(50))
BEGIN
	SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.CodigoRol
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol
                    WHERE US.Email LIKE CONCAT('%', VarEmailBusqueda, '%')
                    ORDER BY Codigo ASC;
END //
DELIMITER ;

/*LISTAR USUARIOS POR ASIGNAR*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarUsuariosPorAsignar()
BEGIN
	SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.CodigoRol
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol
                    LEFT JOIN Empleado AS EM ON EM.CodigoUsuarioSistema = US.CodigoUsuarioSistema
                    WHERE EM.CodigoEmpleado IS NULL
                    ORDER BY Codigo ASC;
END //
DELIMITER ;

/* VALIDAR EXISTENCIA USUARIO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExistenciaUsuario (IN VarEmail VARCHAR (50))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoUsuarioSistema FROM `UsuarioSistema` WHERE Email = VarEmail;
END //
DELIMITER ;

/*GUARDAR USUARIO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarUsuario
(IN VarEmail VARCHAR(50), IN VarClave VARCHAR(200), IN VarCodigoRol INT, IN VarPalabraClave VARCHAR(50))
BEGIN
 INSERT INTO UsuarioSistema (Email, Clave, CodigoRol) VALUES(VarEmail, HEX(AES_ENCRYPT(VarClave, VarPalabraClave)), VarCodigoRol);
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*OBTENER DATOS PARA LA SESION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS obtenerDatosDeSesion
(IN VarCodigoUsuarioSistema INT)
BEGIN
	SELECT us.CodigoUsuarioSistema AS CodigoUsuario
    	, CONCAT(SUBSTRING_INDEX(Nombres, ' ', 1), ' ', SUBSTRING_INDEX(Apellidos, ' ', 1)) AS NombreUsuarioSesion
        , em.Nombres
        , em.Apellidos
        , em.Email
        , us.CodigoRol
        , us.Email AS UsuarioEmail
    FROM UsuarioSistema AS us
    LEFT JOIN Empleado  AS em ON em.CodigoUsuarioSistema = us.CodigoUsuarioSistema
    INNER JOIN Rol AS r ON r.CodigoRol = us.CodigoRol
    WHERE us.CodigoUsuarioSistema = VarCodigoUsuarioSistema;
END //
DELIMITER ;

/*ACTUALIZAR USUARIO Y NO LA CLAVE*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarUsuarioNoClave
(IN VarCodigoUsuarioSistema VARCHAR(10), IN VarEmail VARCHAR(50), IN VarCodigoRol INT, IN VarPalabraClave VARCHAR(50))
BEGIN
  DECLARE ClaveAux VARCHAR(100);
  SET ClaveAux = (SELECT AES_DECRYPT(UNHEX(Clave), VarPalabraClave) As Clave FROM UsuarioSistema 
  WHERE CodigoUsuarioSistema = VarCodigoUsuarioSistema);
	UPDATE UsuarioSistema SET Email = VarEmail, CodigoRol = VarCodigoRol, Clave = HEX(AES_ENCRYPT(ClaveAux, VarPalabraClave))
	WHERE CodigoUsuarioSistema = VarCodigoUsuarioSistema;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR USUARIO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarUsuario
( IN VarCodigoUsuarioSistema VARCHAR(10), IN VarEmail VARCHAR(50), IN VarClave VARCHAR(200), IN VarCodigoRol INT, IN VarPalabraClave VARCHAR(50))
BEGIN
	UPDATE UsuarioSistema SET Email = VarEmail, Clave = HEX(AES_ENCRYPT(VarClave, VarPalabraClave)), CodigoRol = VarCodigoRol 
  WHERE CodigoUsuarioSistema = VarCodigoUsuarioSistema;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ELIMINAR USUARIO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS eliminarUsuario
(IN VarCodigoUsuarioSistema VARCHAR(10))
BEGIN
	DELETE FROM UsuarioSistema WHERE CodigoUsuarioSistema = VarCodigoUsuarioSistema;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*LISTAR ROLES*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarRoles()
BEGIN
	SELECT CodigoRol, Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, Asistencia
    FROM Rol
   	ORDER BY CodigoRol ASC;
END //
DELIMITER ;

/*GUARDAR ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarRol
(IN VarNombre VARCHAR(50), IN VarGestionaNomina INT, IN VarGestionaEmpleados INT,
IN VarGestionaMenu INT, IN VarGestionaReportes INT, IN VarGestionaCaja INT, IN VarAsistencia INT)
BEGIN
	INSERT INTO Rol (Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, Asistencia) 
    VALUES(VarNombre, VarGestionaNomina, VarGestionaEmpleados, VarGestionaMenu, VarGestionaReportes, VarGestionaCaja, VarAsistencia);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarRol
(IN VarCodigoRol INT, IN VarNombre VARCHAR(50), IN VarGestionaNomina INT, IN VarGestionaEmpleados INT,
IN VarGestionaMenu INT, IN VarGestionaReportes INT, IN VarGestionaCaja INT, IN VarAsistencia INT)
BEGIN
	UPDATE Rol 
    SET Nombre = VarNombre, GestionaNomina = VarGestionaNomina, GestionaEmpleados = VarGestionaEmpleados, 
    GestionaMenu = VarGestionaMenu, GestionaReportes = VarGestionaReportes, GestionaCaja = VarGestionaCaja,  
    Asistencia = VarAsistencia
    WHERE CodigoRol = VarCodigoRol;
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ELIMINAR ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS eliminarRol(IN VarCodigoRol INT)
BEGIN
	DELETE FROM Rol WHERE CodigoRol = VarCodigoRol;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*VALIDAR EXISTENCIA ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExistenciaRol (IN VarNombre VARCHAR(50))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoRol FROM Rol WHERE Nombre = VarNombre;
END //
DELIMITER ;

/*LISTAR DEPARTAMENTO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarDepartamentos()
BEGIN
    SELECT D.CodigoDepartamento AS CodigoDepartamento,
                            D.Nombre AS NombreDepartamento,
                            C.CodigoComision,
                            C.Nombre AS NombreComision,
                            E.CodigoEmpleado,
                            CONCAT(E.Nombres, ' ', E.Apellidos) AS NombreJefe
    FROM Departamento AS D
    INNER JOIN Comision AS C ON C.CodigoComision = D.CodigoComision
    LEFT JOIN Empleado AS E ON E.CodigoEmpleado = D.CodigoEmpleado
    ORDER BY CodigoDepartamento ASC;
END  //
DELIMITER ;

/*VALIDAR DEPARTAMENTO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExistenciaDepartamento (IN VarNombre VARCHAR(100))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoDepartamento FROM Departamento WHERE Nombre = VarNombre;
END //
DELIMITER ;

/*GUARDAR DEPARTAMENTO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarDepartamento 
(IN VarNombre VARCHAR(100), IN VarCodigoComision INT, IN VarCodigoEmpleado VARCHAR(10))
BEGIN
	INSERT INTO Departamento (Nombre, CodigoComision, CodigoEmpleado) 
    VALUES(VarNombre, VarCodigoComision, VarCodigoEmpleado);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR DEPARTAMENTO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarDepartamento
(IN VarCodigoDepartamento INT, IN VarNombreDepartamento  VARCHAR(100), IN VarCodigoComision INT, IN VarCodigoEmpleado VARCHAR(10))
BEGIN
	UPDATE Departamento  
    SET Nombre = VarNombreDepartamento, CodigoComision = VarCodigoComision, CodigoEmpleado = VarCodigoEmpleado
    WHERE CodigoDepartamento = VarCodigoDepartamento;
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ELIMINAR DEPARTAMENTO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS eliminarDepartamento(IN VarCodigoDepartamento INT)
BEGIN
	DELETE FROM Departamento  WHERE CodigoDepartamento = VarCodigoDepartamento;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*LISTAR COMISION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarComisiones()
BEGIN
    SELECT CodigoComision, Nombre, Restricciones, Bono
    FROM Comision
    ORDER BY CodigoComision ASC;
END  //
DELIMITER ;

/*VALIDAR EXISTENCIA COMISION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExistenciaComision (IN VarNombre VARCHAR(100))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoComision FROM Comision WHERE Nombre = VarNombre;
END //
DELIMITER ;

/*GUARDAR COMISION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarComision 
(IN VarNombre VARCHAR(150), IN VarRestricciones VARCHAR(150), IN VarBono DECIMAL(10,2))
BEGIN
	INSERT INTO Comision (Nombre, Restricciones, Bono)
    VALUES(VarNombre, VarRestricciones, VarBono);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR COMISION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarComision 
(IN VarCodigoComision INT, IN VarNombre VARCHAR(150), IN VarRestricciones VARCHAR(150), IN VarBono DECIMAL(10,2))
BEGIN
	UPDATE Comision SET Nombre = VarNombre,
    Restricciones = VarRestricciones, Bono = VarBono
    WHERE CodigoComision = VarCodigoComision;
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ELIMINAR COMISION*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS eliminarComision(IN VarCodigoComision INT)
BEGIN
	DELETE FROM Comision  WHERE CodigoComision = VarCodigoComision;
  SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

 /*LISTAR MENU*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarMenu()
BEGIN
	SELECT CodigoItem, Nombre
    		, Nombre, Precio
            , Imagen , Descuento
            , CodigoCategoriaItem
    FROM Item;
END //
DELIMITER ;

/*LISTAR EMPLEADOS*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarEmpleados(IN VarEstado INT)
BEGIN
	SELECT 
            E.CodigoEmpleado,
            Nombres,
            Apellidos,
            CONCAT(Nombres, ' ', Apellidos) AS NombreCompleto,
            Email,
            Telefono,
            SalarioBase,
            FechaNacimiento,
            FechaIngreso,
            FechaRetiro,
            Profesion,
            Fotografia,
            Jornada,
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento
            FROM Empleado AS E
            INNER JOIN Departamento AS D ON D.CodigoDepartamento = E.CodigoDepartamento
            WHERE Estado = VarEstado
            ORDER BY E.CodigoEmpleado ASC;
END //
DELIMITER ;

/*LISTAR EMPLEADOS BUSQUEDA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarEmpleadosBusqueda(IN VarNombreBusqueda VARCHAR(50), IN VarEstado INT)
BEGIN
	SELECT 
            E.CodigoEmpleado,
            Nombres,
            Apellidos,
            CONCAT(Nombres, ' ', Apellidos) AS NombreCompleto,
            Email,
            Telefono,
            SalarioBase,
            FechaNacimiento,
            FechaIngreso,
            FechaRetiro,
            Profesion,
            Fotografia,
            Jornada,
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento
            FROM Empleado AS E
            INNER JOIN Departamento AS D ON D.CodigoDepartamento = E.CodigoDepartamento
            WHERE CONCAT(Nombres, ' ', Apellidos, ' ', DPI) LIKE CONCAT('%', VarNombreBusqueda, '%')
            AND Estado = VarEstado
            ORDER BY E.CodigoEmpleado ASC;
END //
DELIMITER ;

/*GUARDAR EMPLEADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarEmpleado
(IN VarNombres VARCHAR(100), IN VarApellidos VARCHAR(100), IN VarEmail VARCHAR(75),
IN VarTelefono VARCHAR(10), IN VarSalarioBase DECIMAL(10,2), IN VarFechaNacimiento DATE,
IN VarFechaIngreso DATE, IN VarFechaRetiro DATE, IN VarProfesion VARCHAR(50),
IN VarFotografia VARCHAR(100), IN VarJornada VARCHAR(100), IN VarDPI VARCHAR(13), IN VarNIT VARCHAR(13), IN VarIRTRA VARCHAR(13),
IN VarIGSS VARCHAR(13), IN VarEstado TINYINT, IN VarCodigoDepartamento INT, IN VarCodigoUsuarioSistema INT)
BEGIN
	INSERT INTO Empleado (CodigoEmpleado
                      , Nombres
                      , Apellidos
                      , Email
                      , Telefono
                      , SalarioBase
                      , FechaNacimiento
                      , FechaIngreso
                      , FechaRetiro
                      , Profesion
                      , Fotografia
                      , Jornada
                      , DPI
                      , NIT
                      , IRTRA
                      , IGSS
                      , Estado
                      , CodigoDepartamento
                      , CodigoUsuarioSistema)
VALUES (
    generarCodigoEmpleado(VarNombres, VarApellidos, VarDPI),
    VarNombres, VarApellidos, VarEmail, VarTelefono, VarSalarioBase, VarFechaNacimiento,
    VarFechaIngreso, VarFechaRetiro, VarProfesion, VarFotografia, VarJornada, VarDPI, VarNIT, VarIRTRA,
    VarIGSS, VarEstado, VarCodigoDepartamento, VarCodigoUsuarioSistema
);
SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR EMPLEADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarEmpleado
(IN VarCodigoEmpleado VARCHAR(10), IN VarNombres VARCHAR(100), IN VarApellidos VARCHAR(100), IN VarEmail VARCHAR(75),
IN VarTelefono VARCHAR(10), IN VarSalarioBase DECIMAL(10,2), IN VarFechaNacimiento DATE,
IN VarFechaIngreso DATE, IN VarFechaRetiro DATE, IN VarProfesion VARCHAR(50),
IN VarFotografia VARCHAR(100), IN VarJornada VARCHAR(100), IN VarDPI VARCHAR(13), IN VarNIT VARCHAR(13), IN VarIRTRA VARCHAR(13),
IN VarIGSS VARCHAR(13), IN VarEstado TINYINT, IN VarCodigoDepartamento INT, IN VarCodigoUsuarioSistema INT)
BEGIN

	UPDATE Empleado
    SET CodigoEmpleado = generarCodigoEmpleado(VarNombres, VarApellidos, VarDPI), Nombres = VarNombres, Apellidos = VarApellidos,
    Email = VarEmail, Telefono = VarTelefono,
    SalarioBase = VarSalarioBase, FechaNacimiento = VarFechaNacimiento,
    FechaIngreso = VarFechaIngreso, FechaRetiro = VarFechaRetiro,
    Profesion = VarProfesion, Fotografia = VarFotografia,
    Jornada = VarJornada, DPI = VarDPI, NIT = VarNIT, IRTRA = VarIRTRA,
    IGSS = VarIGSS, Estado = VarEstado, CodigoDepartamento = VarCodigoDepartamento,
    CodigoUsuarioSistema = VarCodigoUsuarioSistema
    WHERE DPI = VarDPI OR CodigoEmpleado = VarCodigoEmpleado;
    SELECT ROW_COUNT() AS afected;
    
END //
DELIMITER ;

/* VALIDAR EXISTENCIA DEL EMPLEADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExistenciaEmpleado (IN VarDPI VARCHAR(13))
BEGIN
	SELECT COUNT(*) AS Existe, CodigoEmpleado FROM Empleado WHERE DPI = VarDPI;
END //
DELIMITER ;

/*OBTENER EMPLEADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS obtenerEmpleado(IN VarCodigoEmpleado VARCHAR(10))
BEGIN
	SELECT 
            E.CodigoEmpleado,
            Nombres,
            Apellidos,
            CONCAT(Nombres, ' ', Apellidos) AS NombreCompleto,
            Email,
            Telefono,
            SalarioBase,
            FechaNacimiento,
            FechaIngreso,
            FechaRetiro,
            Profesion,
            Fotografia,
            Jornada,
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento
            FROM Empleado AS E
            INNER JOIN Departamento AS D ON D.CodigoDepartamento = E.CodigoDepartamento
            WHERE E.CodigoEmpleado = VarCodigoEmpleado;
END //
DELIMITER ;

/* GUARDAR PRESTAMOS */
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarPrestamo 
(IN VarFecha DATE, IN VarMonto DECIMAL(10,2), IN VarCuotas INT, IN VarCodigoEmpleado VARCHAR(10))
BEGIN
	INSERT INTO Prestamo(Fecha, Monto, Cuotas, CodigoEmpleado)
    VALUES(VarFecha, VarMonto, VarCuotas, VarCodigoEmpleado);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/* LISTAR PRESTAMOS */
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarPrestamos ()
BEGIN
	SELECT P.CodigoPrestamo
    	  	, P.Fecha
        	, CONCAT(Nombres, ' ', Apellidos) AS NombreEmpleado
        	, E.CodigoEmpleado
        	, P.Monto
        	, P.Cuotas
            , P.Cuotas - COUNT(A.CodigoAbono) AS CuotasPendientes
        	, CASE
            	WHEN (P.Monto - SUM(IFNULL(A.Monto, 1))) = 0 
                	THEN 0
                WHEN (P.Monto - SUM(A.Monto)) IS NULL
                	THEN P.Monto
                WHEN (P.Monto - SUM(A.Monto)) IS NOT NULL
                     THEN (P.Monto - SUM(A.Monto))
            	END AS SaldoPendiente
    FROM Prestamo AS P
    INNER JOIN Empleado AS E ON E.CodigoEmpleado = P.CodigoEmpleado
    LEFT JOIN Abono AS A ON A.CodigoPrestamo = P.CodigoPrestamo
    GROUP BY P.CodigoPrestamo
    HAVING SaldoPendiente > 0;
END //
DELIMITER ;

/*LISTAR PRESTAMOS DE EMPLEADO ESPECIFICO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarPrestamosEmpleado (IN VarNombreEmpleado VARCHAR(50))
BEGIN
	SELECT P.CodigoPrestamo
    	  	, P.Fecha
        	, CONCAT(Nombres, ' ', Apellidos) AS NombreEmpleado
        	, E.CodigoEmpleado
        	, P.Monto
        	, P.Cuotas
          , P.Cuotas - COUNT(A.CodigoAbono) AS CuotasPendientes
        	, CASE
            	WHEN (P.Monto - SUM(IFNULL(A.Monto, 1))) = 0 
                	THEN 0
                WHEN (P.Monto - SUM(A.Monto)) IS NULL
                	THEN P.Monto
                WHEN (P.Monto - SUM(A.Monto)) IS NOT NULL
                     THEN (P.Monto - SUM(A.Monto))
            	END AS SaldoPendiente
    FROM Prestamo AS P
    INNER JOIN Empleado AS E ON E.CodigoEmpleado = P.CodigoEmpleado
    LEFT JOIN Abono AS A ON A.CodigoPrestamo = P.CodigoPrestamo
    WHERE CONCAT(E.Nombres, '', E.Apellidos) LIKE CONCAT('%', VarNombreEmpleado, '%')
    GROUP BY P.CodigoPrestamo;
END //
DELIMITER ;

/*VALIDAR PRESTAMO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarPrestamo (IN VarCodigoPrestamo INT)
BEGIN
	IF VarCodigoPrestamo = (SELECT CodigoPrestamo FROM Prestamo WHERE CodigoPrestamo = VarCodigoPrestamo) THEN
    BEGIN
        SELECT P.CodigoPrestamo 
                , CONCAT(Nombres, ' ', Apellidos) AS NombreEmpleado
                , E.CodigoEmpleado
                , P.Monto
                , P.Monto/P.Cuotas AS MontoCuota
                , CASE
                    WHEN (P.Monto - SUM(IFNULL(A.Monto, 1))) = 0 
                        THEN 0
                      WHEN (P.Monto - SUM(A.Monto)) IS NULL
                        THEN P.Monto
                      WHEN (P.Monto - SUM(A.Monto)) IS NOT NULL
                          THEN (P.Monto - SUM(A.Monto))
                    END AS SaldoPendiente
        FROM Prestamo AS P
        LEFT JOIN Empleado AS E ON E.CodigoEmpleado = P.CodigoEmpleado
        LEFT JOIN Abono AS A ON A.CodigoPrestamo = P.CodigoPrestamo
        WHERE P.CodigoPrestamo = VarCodigoPrestamo
        GROUP BY P.CodigoPrestamo;
    END;
  ELSE
  	SELECT 0 AS Afected;
  END IF;
END //
DELIMITER ;

/*GUARDAR ABONO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarAbono 
(IN VarFecha DATE, IN VarCuotas INT, IN VarCodigoPrestamo INT)
BEGIN
	DECLARE MontoCuota DECIMAL(10,2);
    SET MontoCuota = (SELECT Monto/Cuotas AS Monto FROM Prestamo WHERE CodigoPrestamo = VarCodigoPrestamo);
	INSERT INTO Abono(Monto, Fecha, CodigoPrestamo)
    VALUES(MontoCuota*VarCuotas, VarFecha, VarCodigoPrestamo);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*LISTAR ABONOS PRESTAMO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS listarAbonosPrestamo 
(IN VarCodigoPrestamo INT)
BEGIN
	SELECT P.CodigoPrestamo 
           , A.CodigoAbono
           , A.Monto
           , A.Fecha
    FROM Prestamo AS P
    INNER JOIN Abono AS A ON A.CodigoPrestamo = P.CodigoPrestamo
    WHERE P.CodigoPrestamo = VarCodigoPrestamo;
END //
DELIMITER ;

/*VALIDAR PRESTAMOS DE EMPLEADO PENDIENTES*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarEmpleadoPrestamosPendientes 
(IN VarCodigoEmpleado VARCHAR(10))
BEGIN
	SELECT E.CodigoEmpleado
        	, CONCAT(Nombres, ' ', Apellidos) AS NombreEmpleado
        	, CASE
            	WHEN (P.Monto - (SUM(IFNULL(A.Monto,1)))) = 0 
                	THEN 0
            	ELSE 
                	1
            	END AS SaldoPendiente
    FROM Prestamo AS P
    INNER JOIN Empleado AS E ON E.CodigoEmpleado = P.CodigoEmpleado
    LEFT JOIN Abono AS A ON A.CodigoPrestamo = P.CodigoPrestamo
    WHERE E.CodigoEmpleado = VarCodigoEmpleado
    GROUP BY E.CodigoEmpleado;
END //
DELIMITER ;

/*VALIDAR ASISTENCIA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarAsistencia
(IN VarCodigoUsuarioSistema INT, IN VarFecha DATE)
BEGIN
	  DECLARE VarCodigoEmpleado VARCHAR(10);
    SET VarCodigoEmpleado = (SELECT E.CodigoEmpleado FROM Empleado AS E WHERE E.CodigoUsuarioSistema = VarCodigoUsuarioSistema);
	  SELECT IFNULL(Entrada, 0) AS ExisteEntrada, IFNULL(Salida, 0) AS ExisteSalida, COUNT(*) AS Existe, IFNULL(CodigoEmpleado, 0) AS ExisteEmpleado
    FROM Asistencia
    WHERE DATE(Entrada) = VarFecha OR DATE(Salida) = VarFecha
    AND CodigoEmpleado = VarCodigoEmpleado;
END //
DELIMITER ;

/*ASISTENCIA ENTRADA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS asistenciaEntrada
(IN VarCodigoUsuarioSistema INT, IN VarFechaHora DATETIME)
BEGIN
	DECLARE VarCodigoEmpleado VARCHAR(10);
    SET VarCodigoEmpleado = (SELECT E.CodigoEmpleado FROM Empleado AS E WHERE E.CodigoUsuarioSistema = VarCodigoUsuarioSistema);
	INSERT INTO Asistencia (Entrada, CodigoEmpleado) 
    VALUES (VarFechaHora, VarCodigoEmpleado);
END //
DELIMITER ;


/*ASISTENCIA SALIDA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS asistenciaSalida
(IN VarCodigoUsuarioSistema INT, IN VarFechaHora DATETIME)
BEGIN
	DECLARE VarCodigoEmpleado VARCHAR(10);
    SET VarCodigoEmpleado = (SELECT E.CodigoEmpleado FROM Empleado AS E WHERE E.CodigoUsuarioSistema = VarCodigoUsuarioSistema);
	UPDATE Asistencia
    SET Salida = VarFechaHora
    WHERE CodigoEmpleado = VarCodigoEmpleado
    AND DATE(Entrada) = DATE(VarFechaHora);
END //
DELIMITER ;

/* EJECUTAR LUEGO DE CREACION DE LA DB
call guardarRol('Administrador', 1, 1, 1, 1, 1, 1);
call guardarUsuario('admin@admin.com', 'admin', 1, 'UMG2023');
*/