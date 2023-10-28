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
  PRIMARY KEY (`CodigoDepartamento`)
);

ALTER TABLE `Departamento` ADD CONSTRAINT `FK_Departamento_CodigoComision` FOREIGN KEY (`CodigoComision`) REFERENCES `Comision`(`CodigoComision`) 
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Rol` (
  `CodigoRol` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(50),
  `GestionaEmpleados` INT,
  `GestionaMenu` INT,
  `GestionaReportes` INT,
  `GestionaNomina` INT,
  `GestionaCaja` INT,
  `GestionaPrestamos` INT,
  PRIMARY KEY (`CodigoRol`)
);

CREATE TABLE `UsuarioSistema` (
  `CodigoUsuarioSistema` INT AUTO_INCREMENT NOT NULL,
  `Email` VARCHAR(50),
  `Clave` VARCHAR(200),
  `CodigoRol` INT,
  PRIMARY KEY (`CodigoUsuarioSistema`)
);

ALTER TABLE `UsuarioSistema` ADD CONSTRAINT `FK_UsuarioSistema_CodigoRol` FOREIGN KEY (`CodigoRol`) REFERENCES `Rol`(`CodigoRol`) 
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `JornadaLaboral` (
  `CodigoJornadaLaboral` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(50),
  `DiasPorSemana` INT,
  PRIMARY KEY (`CodigoJornadaLaboral`)
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
  `DPI` VARCHAR(13),
  `NIT` VARCHAR(13),
  `IRTRA` VARCHAR(13),
  `IGSS` VARCHAR(13),
  `Estado` BOOLEAN,
  `CodigoDepartamento` INT,
  `CodigoUsuarioSistema` INT,
  `CodigoJornadaLaboral` INT,
  PRIMARY KEY (`CodigoEmpleado`)
);

ALTER TABLE `Empleado` ADD CONSTRAINT `FK_Empleado_CodigoDepartamento` FOREIGN KEY (`CodigoDepartamento`) REFERENCES `Departamento`(`CodigoDepartamento`)
ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Empleado` ADD CONSTRAINT `FK_Empleado_CodigoUsuarioSistema` FOREIGN KEY (`CodigoUsuarioSistema`) REFERENCES `UsuarioSistema`(`CodigoUsuarioSistema`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Empleado` ADD CONSTRAINT `FK_Empleado_CodigoJornadaLaboral` FOREIGN KEY (`CodigoJornadaLaboral`) REFERENCES `JornadaLaboral`(`CodigoJornadaLaboral`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `PagoComision` (
  `Fecha` DATE,
  `CodigoEmpleado` VARCHAR(10)
);

ALTER TABLE `PagoComision` ADD CONSTRAINT `FK_EmpleadoDepartamentoComision_CodigoEmpleado` 
FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Prestamo` (
  `CodigoPrestamo` INT AUTO_INCREMENT NOT NULL,
  `Fecha` DATE,
  `Monto` DECIMAL(10,2),
  `Cuotas` INT,
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoPrestamo`)
);

ALTER TABLE `Prestamo` ADD CONSTRAINT `FK_Prestamo_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `Abono` (
  `CodigoAbono` INT AUTO_INCREMENT NOT NULL,
  `Monto` DECIMAL(10,2),
  `Fecha` DATETIME,
  `CodigoPrestamo` INT,
  PRIMARY KEY (`CodigoAbono`)
);

ALTER TABLE `Abono` ADD CONSTRAINT `FK_Abono_CodigoPrestamo` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `Prestamo`(`CodigoPrestamo`)
ON DELETE NO ACTION ON UPDATE CASCADE;

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
  PRIMARY KEY (`CodigoLiquidacion`)
);

ALTER TABLE `Liquidacion` ADD CONSTRAINT `FK_Liquidacion_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Liquidacion` ADD CONSTRAINT `FK_Liquidacion_CodigoPrestamo` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `Prestamo`(`CodigoPrestamo`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Asistencia` (
  `CodigoAsistencia` INT AUTO_INCREMENT NOT NULL,
  `Entrada` DATETIME,
  `Salida` DATETIME,
  `CodigoUsuarioSistema` INT,
  PRIMARY KEY (`CodigoAsistencia`)
);

ALTER TABLE `Asistencia` ADD CONSTRAINT `FK_Asistencia_CodigoUsuarioSistema` FOREIGN KEY (`CodigoUsuarioSistema`) REFERENCES `UsuarioSistema`(`CodigoUsuarioSistema`)
ON DELETE NO ACTION ON UPDATE CASCADE;

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
  PRIMARY KEY (`CodigoItem`)
);

ALTER TABLE `Item` ADD CONSTRAINT `FK_Item_CodigoCategoriaItem` FOREIGN KEY (`CodigoCategoriaItem`) REFERENCES `CategoriaItem`(`CodigoCategoriaItem`)
ON DELETE NO ACTION ON UPDATE CASCADE;

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
  PRIMARY KEY (`CodigoOrden`)
);

ALTER TABLE `Orden` ADD CONSTRAINT `FK_Orden_CodigoMesa` FOREIGN KEY (`CodigoMesa`) REFERENCES `Mesa`(`CodigoMesa`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `DetalleOrden` (
  `CodigoDetalleOrden` INT AUTO_INCREMENT NOT NULL,
  `CodigoOrden` INT,
  `CodigoItem` VARCHAR(10),
  `Cantidad` INT,
  PRIMARY KEY (`CodigoDetalleOrden`)
);

ALTER TABLE `DetalleOrden` ADD CONSTRAINT `FK_DetalleOrden_CodigoOrden` FOREIGN KEY (`CodigoOrden`) REFERENCES `Orden`(`CodigoOrden`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `DetalleOrden` ADD CONSTRAINT `FK_DetalleOrden_CodigoItem` FOREIGN KEY (`CodigoItem`) REFERENCES `Item`(`CodigoItem`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `TipoDePago` (
  `CodigoTipoDePago` INT AUTO_INCREMENT NOT NULL,
  `Tipo` VARCHAR(50),
  PRIMARY KEY (`CodigoTipoDePago`)
);

CREATE TABLE `Caja` (
  `CodigoCaja` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(30),
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY (`CodigoCaja`)
);

ALTER TABLE `Caja` ADD CONSTRAINT `FK_Caja_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Cierre` (
  `CodigoCierre` INT AUTO_INCREMENT NOT NULL,
  `FechaApertura` DATETIME,
  `FechaCierre` DATETIME,
  `SaldoInicial` DECIMAL(10,2),
  `SaldoFinal` DECIMAL(10,2),
  `CodigoEmpleado` VARCHAR(10),
  `CodigoCaja` INT,
  PRIMARY KEY (`CodigoCierre`)
);

ALTER TABLE `Cierre` ADD CONSTRAINT `FK_Cierre_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Cierre` ADD CONSTRAINT `FK_Cierre_CodigoCaja` FOREIGN KEY (`CodigoCaja`) REFERENCES `Caja`(`CodigoCaja`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Factura` (
  `CodigoFactura` VARCHAR(10) NOT NULL,
  `Nit` VARCHAR(13),
  `Fecha` DATETIME,
  `Total` DECIMAL(10,2),
  `CodigoTipoDePago` INT,
  `CodigoOrden` INT,
  `CodigoCaja` INT,
  PRIMARY KEY (`CodigoFactura`)
);

ALTER TABLE `Factura` ADD CONSTRAINT `FK_Factura_CodigoTipoDePago` FOREIGN KEY (`CodigoTipoDePago`) REFERENCES `TipoDePago`(`CodigoTipoDePago`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Factura` ADD CONSTRAINT `FK_Factura_CodigoOrden` FOREIGN KEY (`CodigoOrden`) REFERENCES `Orden`(`CodigoOrden`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Factura` ADD CONSTRAINT `FK_Factura_CodigoCaja` FOREIGN KEY (`CodigoCaja`) REFERENCES `Caja`(`CodigoCaja`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Productividad` (
  `Fecha` DATE,
  `CodigoEmpleado` VARCHAR(10),
  `CodigoItem` VARCHAR(10),
  `CodigoMesa` INT
);

ALTER TABLE `Productividad` ADD CONSTRAINT `FK_Productividad_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Productividad` ADD CONSTRAINT `FK_Productividad_CodigoItem` FOREIGN KEY (`CodigoItem`) REFERENCES `Item`(`CodigoItem`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `Productividad` ADD CONSTRAINT `FK_Productividad_CodigoMesa` FOREIGN KEY (`CodigoMesa`) REFERENCES `Mesa`(`CodigoMesa`)
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `Asueto` (
  `CodigoAsueto` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(50),
  `Fecha` DATE NOT NULL,
  `CantidadDias` INT NULL,
  PRIMARY KEY(`CodigoAsueto`)
);

CREATE TABLE `Honorarios` (
  `CodigoHonorario` INT AUTO_INCREMENT NOT NULL,
  `FechaPago` DATE,
  `SalarioBase` DECIMAL(10,2),
  `HorasBase` INT,
  `HorasTrabajadas` DECIMAL(10,2),
  `HorasExtras` DECIMAL(10,2),
  `HorasNoTrabajadas` DECIMAL(10,2),
  `PrecioHora` DECIMAL(10,2),
  `PrecioHoraExtra` DECIMAL(10,2),
  `Comisiones` DECIMAL(10,2),
  `BonoIncentivo` DECIMAL(10,2),
  `IGSS` DECIMAL(10,2),
  `IGSSPatrono` DECIMAL(10,2),
  `IRTRA` DECIMAL(10,2),
  `AbonoPrestamo` DECIMAL(10,2),
  `CodigoEmpleado` VARCHAR(10),
  PRIMARY KEY(`CodigoHonorario`)
);

ALTER TABLE `Honorarios` ADD CONSTRAINT `FK_Honorarios_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;

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
  PRIMARY KEY (`CodigoPagoBonificacion`)
);

ALTER TABLE `PagoBonificacion` ADD CONSTRAINT `FK_PagoBonificacion_CodigoTipoBonificacion` FOREIGN KEY (`CodigoTipoBonificacion`) REFERENCES `TipoBonificacion`(`CodigoTipoBonificacion`)
ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `PagoBonificacion` ADD CONSTRAINT `FK_PagoBonificacion_CodigoEmpleado` FOREIGN KEY (`CodigoEmpleado`) REFERENCES `Empleado`(`CodigoEmpleado`)
ON DELETE NO ACTION ON UPDATE CASCADE;


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
	SELECT CodigoRol, Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, GestionaPrestamos
    FROM Rol
   	ORDER BY CodigoRol ASC;
END //
DELIMITER ;

/*GUARDAR ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarRol
(IN VarNombre VARCHAR(50), IN VarGestionaNomina INT, IN VarGestionaEmpleados INT,
IN VarGestionaMenu INT, IN VarGestionaReportes INT, IN VarGestionaCaja INT, IN VarGestionaPrestamos INT)
BEGIN
	INSERT INTO Rol (Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, GestionaPrestamos) 
    VALUES(VarNombre, VarGestionaNomina, VarGestionaEmpleados, VarGestionaMenu, VarGestionaReportes, VarGestionaCaja, VarGestionaPrestamos);
    SELECT ROW_COUNT() AS afected;
END //
DELIMITER ;

/*ACTUALIZAR ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS actualizarRol
(IN VarCodigoRol INT, IN VarNombre VARCHAR(50), IN VarGestionaNomina INT, IN VarGestionaEmpleados INT,
IN VarGestionaMenu INT, IN VarGestionaReportes INT, IN VarGestionaCaja INT, IN VarGestionaPrestamos INT)
BEGIN
	UPDATE Rol 
    SET Nombre = VarNombre, GestionaNomina = VarGestionaNomina, GestionaEmpleados = VarGestionaEmpleados, 
    GestionaMenu = VarGestionaMenu, GestionaReportes = VarGestionaReportes, GestionaCaja = VarGestionaCaja,  
    GestionaPrestamos = VarGestionaPrestamos
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
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento,
            E.CodigoJornadaLaboral
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
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento,
            E.CodigoJornadaLaboral
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
IN VarFotografia VARCHAR(100), IN VarDPI VARCHAR(13), IN VarNIT VARCHAR(13), IN VarIRTRA VARCHAR(13),
IN VarIGSS VARCHAR(13), IN VarEstado TINYINT, IN VarCodigoDepartamento INT, IN VarCodigoUsuarioSistema INT, IN VarCodigoJornadaLaboral INT)
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
                      , DPI
                      , NIT
                      , IRTRA
                      , IGSS
                      , Estado
                      , CodigoDepartamento
                      , CodigoUsuarioSistema
                      , CodigoJornadaLaboral)
VALUES (
    generarCodigoEmpleado(VarNombres, VarApellidos, VarDPI),
    VarNombres, VarApellidos, VarEmail, VarTelefono, VarSalarioBase, VarFechaNacimiento,
    VarFechaIngreso, VarFechaRetiro, VarProfesion, VarFotografia, VarDPI, VarNIT, VarIRTRA,
    VarIGSS, VarEstado, VarCodigoDepartamento, VarCodigoUsuarioSistema, VarCodigoJornadaLaboral
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
IN VarFotografia VARCHAR(100), IN VarDPI VARCHAR(13), IN VarNIT VARCHAR(13), IN VarIRTRA VARCHAR(13),
IN VarIGSS VARCHAR(13), IN VarEstado TINYINT, IN VarCodigoDepartamento INT, IN VarCodigoUsuarioSistema INT, IN VarCodigoJornadaLaboral INT)
BEGIN

	UPDATE Empleado
    SET CodigoEmpleado = generarCodigoEmpleado(VarNombres, VarApellidos, VarDPI), Nombres = VarNombres, Apellidos = VarApellidos,
    Email = VarEmail, Telefono = VarTelefono,
    SalarioBase = VarSalarioBase, FechaNacimiento = VarFechaNacimiento,
    FechaIngreso = VarFechaIngreso, FechaRetiro = VarFechaRetiro,
    Profesion = VarProfesion, Fotografia = VarFotografia,
    CodigoJornadaLaboral = VarCodigoJornadaLaboral, DPI = VarDPI, NIT = VarNIT, IRTRA = VarIRTRA,
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
            DPI,
            NIT,
            IRTRA,
            IGSS,
            Estado,
            D.Nombre AS Departamento,
            CodigoUsuarioSistema,
            D.CodigoDepartamento,
            E.CodigoJornadaLaboral
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
    GROUP BY E.CodigoEmpleado
    HAVING SaldoPendiente > 0;
END //
DELIMITER ;

/*VALIDAR ASISTENCIA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarAsistencia
(IN VarCodigoUsuarioSistema INT, IN VarFecha DATE)
BEGIN
    DECLARE VarCodigoEmpleado VARCHAR(10);
    SET VarCodigoEmpleado = (SELECT E.CodigoEmpleado FROM Empleado AS E WHERE E.CodigoUsuarioSistema = VarCodigoUsuarioSistema);
	  SELECT IFNULL(A.Entrada, 0) AS ExisteEntrada, IFNULL(A.Salida, 0) AS ExisteSalida, COUNT(*) AS Existe, IFNULL(VarCodigoEmpleado, 0) AS ExisteEmpleado
    FROM Asistencia AS A
    INNER JOIN UsuarioSistema AS U ON U.CodigoUsuarioSistema = A.CodigoUsuarioSistema
    LEFT JOIN Empleado AS E ON E.CodigoUsuarioSistema = U.CodigoUsuarioSistema
    WHERE U.CodigoUsuarioSistema = VarCodigoUsuarioSistema AND DATE(A.Entrada) = VarFecha;
END //
DELIMITER ;

/*ASISTENCIA ENTRADA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS asistenciaEntrada
(IN VarCodigoUsuarioSistema INT, IN VarFechaHora DATETIME)
BEGIN
	INSERT INTO Asistencia (Entrada, CodigoUsuarioSistema) 
    VALUES (VarFechaHora, VarCodigoUsuarioSistema);
END //
DELIMITER ;


/*ASISTENCIA SALIDA*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS asistenciaSalida
(IN VarCodigoUsuarioSistema INT, IN VarFechaHora DATETIME)
BEGIN
	UPDATE Asistencia
    SET Salida = VarFechaHora
    WHERE CodigoUsuarioSistema = VarCodigoUsuarioSistema
    AND DATE(Entrada) = DATE(VarFechaHora);
END //
DELIMITER ;

/*VALIDAR USUARIO ROL*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarRolUsuario
(IN VarCodigoUsuarioSistema INT)
BEGIN
    SELECT R.GestionaNomina
          , R.GestionaEmpleados
          , R.GestionaReportes
          , R.GestionaMenu
          , R.GestionaCaja
          , R.GestionaPrestamos
          , COUNT(*) AS Existe
    FROM Rol AS R
    INNER JOIN UsuarioSistema AS U ON U.CodigoRol = R.CodigoRol
    WHERE U.CodigoUsuarioSistema = VarCodigoUsuarioSistema;
END //
DELIMITER ;

/*VALIDAR USUARIO YA ASIGNADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarUsuarioSistemaEnUso
(IN VarCodigoUsuarioSistema INT)
BEGIN
    SELECT COUNT(*) AS EnUso, E.CodigoEmpleado
    FROM Empleado AS E
    INNER JOIN UsuarioSistema AS U ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
    WHERE U.CodigoUsuarioSistema = VarCodigoUsuarioSistema;
END //
DELIMITER ;


/*CALCULO NOMINA SALARIO*/
DROP PROCEDURE IF EXISTS calcularNominaSalario;

DELIMITER //
CREATE PROCEDURE calcularNominaSalario(IN VarFecha DATE)
BEGIN
	WITH HorasCalculo AS
	(
		SELECT VarFecha AS Fecha
			, ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8) AS HorasBase
			, SUM(ABS(TIME_TO_SEC(TIMEDIFF(Entrada, Salida)) / 3600.0)) AS HorasTrabajadas
	        , (SUM(ABS(TIME_TO_SEC(TIMEDIFF(Entrada, Salida)) / 3600.0))) - (((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8)) As HorasExtras
	        , (E.SalarioBase / ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8)) AS PrecioHora
	        , ((E.SalarioBase / ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8))*2) AS PrecioHoraExtra
	        , U.CodigoUsuarioSistema
		FROM Empleado AS E
		INNER JOIN UsuarioSistema AS U ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
		INNER JOIN Asistencia AS A ON A.CodigoUsuarioSistema = U.CodigoUsuarioSistema
		INNER JOIN JornadaLaboral AS JL ON JL.CodigoJornadaLaboral = E.CodigoJornadaLaboral
		WHERE MONTH(A.Entrada) = MONTH(VarFecha) AND E.Estado = 1
		GROUP BY U.CodigoUsuarioSistema
	
	), EmpleadoCalculos AS
	(
		SELECT (E.SalarioBase * 0.0483) AS IGSSEmpleado
	        , (E.SalarioBase * 0.1067) AS IGSSPatrono
	        , (E.SalarioBase * 0.01) AS IRTRA
	        , U.CodigoUsuarioSistema
	        , E.SalarioBase
		FROM Empleado AS E
		INNER JOIN UsuarioSistema AS U ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
    WHERE E.Estado = 1
	
	), BonificacionPago AS
	(
		SELECT PC.Fecha
		, C.Bono
		, U.CodigoUsuarioSistema
		FROM Empleado AS E
		INNER JOIN UsuarioSistema AS U ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
		INNER JOIN PagoComision AS PC ON PC.CodigoEmpleado = E.CodigoEmpleado
		INNER JOIN Departamento AS D ON D.CodigoDepartamento = E.CodigoDepartamento
		INNER JOIN Comision AS C ON C.CodigoComision = D.CodigoComision
		WHERE MONTH(PC.Fecha) = MONTH(VarFecha) AND E.Estado = 1
		GROUP BY U.CodigoUsuarioSistema
		
	), PrestamosDescuento AS 
	(
		SELECT E.CodigoUsuarioSistema
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
      WHERE E.Estado = 1
	    GROUP BY P.CodigoPrestamo
	    HAVING CuotasPendientes > 0
	)
	
	SELECT H.Fecha
		, EM.CodigoEmpleado
		, CONCAT(EM.Nombres, ' ', EM.Apellidos) AS NombreCompleto
		, CASE WHEN (H.HorasTrabajadas < H.HorasBase) 
			THEN (H.PrecioHora * H.HorasTrabajadas)
			ELSE E.SalarioBase 
			END AS SalarioBase
		, H.HorasBase
		, H.HorasTrabajadas
		, CASE WHEN (H.HorasTrabajadas < H.HorasBase)
			THEN 0
			ELSE H.HorasExtras END AS HorasExtras
		, CASE WHEN (H.HorasTrabajadas < H.HorasBase)
			THEN (H.HorasBase - H.HorasTrabajadas) * H.PrecioHora
			ELSE 0 END AS DescuentoHorasNoTrabajadas
		, H.PrecioHora
		, H.PrecioHoraExtra
		, E.IGSSEmpleado
		, E.IGSSPatrono
		, E.IRTRA
		, IFNULL(B.Bono, 0) AS Comision
		, IFNULL((PS.SaldoPendiente/PS.CuotasPendientes), 0) AS CuotaPrestamo
		, CASE WHEN (H.HorasTrabajadas > H.HorasBase)
			THEN (H.PrecioHoraExtra * H.HorasExtras) 
			ELSE 0 END AS DevengadoHorasExtras 
    	, 235.00 AS BonoIncentivo
		, (
			(CASE WHEN (H.HorasTrabajadas < H.HorasBase) 
				THEN (H.PrecioHora * H.HorasTrabajadas)
				ELSE E.SalarioBase END)
			+ (CASE WHEN (H.HorasTrabajadas > H.HorasBase)
				THEN (H.PrecioHoraExtra * H.HorasExtras) 
				ELSE 0 END)
			- (CASE WHEN (H.HorasTrabajadas < H.HorasBase)
				THEN (H.HorasBase - H.HorasTrabajadas) * H.PrecioHora
				ELSE 0 END)
			+ (IFNULL(B.Bono, 0)) 
			+ (235.00) 
			- (IFNULL((PS.SaldoPendiente/PS.CuotasPendientes), 0)) 
			- (E.IGSSEmpleado) 
			- (E.IRTRA)
			) AS SalarioNetoDevengado
	FROM HorasCalculo AS H
	INNER JOIN EmpleadoCalculos AS E ON E.CodigoUsuarioSistema = H.CodigoUsuarioSistema
	LEFT JOIN BonificacionPago AS B ON B.CodigoUsuarioSistema = H.CodigoUsuarioSistema
	LEFT JOIN PrestamosDescuento AS PS ON PS.CodigoUsuarioSistema = E.CodigoUsuarioSistema
	INNER JOIN Empleado AS EM ON EM.CodigoUsuarioSistema = E.CodigoUsuarioSistema
	GROUP BY H.CodigoUsuarioSistema, H.Fecha;
END //
DELIMITER ;

/* EJECUTAR LUEGO DE CREACION DE LA DB
call guardarRol('Administrador', 1, 1, 1, 1, 1, 1);
call guardarUsuario('admin@admin.com', 'admin', 1, 'UMG2023');
*/

/*GUARDAR HONORARIO*/
DROP PROCEDURE IF EXISTS guardarHonorarios;

DELIMITER //
CREATE PROCEDURE IF NOT EXISTS guardarHonorarios(IN VarFecha DATE)
BEGIN
IF (SELECT COUNT(*) AS Existe FROM Honorarios WHERE MONTH(FechaPago) = MONTH(VarFecha)) = 0
THEN
INSERT INTO Honorarios (FechaPago, SalarioBase, HorasBase, HorasTrabajadas, HorasExtras,
HorasNoTrabajadas, PrecioHora, PrecioHoraExtra, Comisiones, BonoIncentivo,
IGSS, IGSSPatrono, IRTRA, AbonoPrestamo, CodigoEmpleado)
  SELECT
    O.Fecha,
    O.SalarioBase,
    O.HorasBase,
    O.HorasTrabajadas,
    O.HorasExtras,
    O.HorasNoTrabajadas,
    O.PrecioHora,
    O.PrecioHoraExtra,
    O.Comision,
    O.BonoIncentivo,
    O.IGSSEmpleado,
    O.IGSSPatrono,
    O.IRTRA,
    O.CuotaPrestamo,
    O.CodigoEmpleado
  FROM (SELECT
    H.Fecha,
    EM.CodigoEmpleado,
    CONCAT(EM.Nombres, ' ', EM.Apellidos) AS NombreCompleto,
    CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN (H.PrecioHora * H.HorasTrabajadas)
      ELSE E.SalarioBase
    END AS SalarioBase,
    H.HorasBase,
    H.HorasTrabajadas,
    CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN H.HorasBase - H.HorasTrabajadas
      ELSE 0
    END AS HorasNoTrabajadas,
    CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN 0
      ELSE H.HorasExtras
    END AS HorasExtras,
    CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN (H.HorasBase - H.HorasTrabajadas) * H.PrecioHora
      ELSE 0
    END AS DescuentoHorasNoTrabajadas,
    H.PrecioHora,
    H.PrecioHoraExtra,
    E.IGSSEmpleado,
    E.IGSSPatrono,
    E.IRTRA,
    IFNULL(B.Bono, 0) AS Comision,
    IFNULL((PS.SaldoPendiente / PS.CuotasPendientes), 0) AS CuotaPrestamo,
    CASE
      WHEN (H.HorasTrabajadas > H.HorasBase) THEN (H.PrecioHoraExtra * H.HorasExtras)
      ELSE 0
    END AS DevengadoHorasExtras,
    235.00 AS BonoIncentivo,
    (
    (CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN (H.PrecioHora * H.HorasTrabajadas)
      ELSE E.SalarioBase
    END)
    + (CASE
      WHEN (H.HorasTrabajadas > H.HorasBase) THEN (H.PrecioHoraExtra * H.HorasExtras)
      ELSE 0
    END)
    - (CASE
      WHEN (H.HorasTrabajadas < H.HorasBase) THEN (H.HorasBase - H.HorasTrabajadas) * H.PrecioHora
      ELSE 0
    END)
    + (IFNULL(B.Bono, 0))
    + (235.00)
    - (IFNULL((PS.SaldoPendiente / PS.CuotasPendientes), 0))
    - (E.IGSSEmpleado)
    - (E.IRTRA)
    ) AS SalarioNetoDevengado
  FROM (SELECT
    VarFecha AS Fecha,
    ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8) AS HorasBase,
    SUM(ABS(TIME_TO_SEC(TIMEDIFF(Entrada, Salida)) / 3600.0)) AS HorasTrabajadas,
    (SUM(ABS(TIME_TO_SEC(TIMEDIFF(Entrada, Salida)) / 3600.0))) - (((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8)) AS HorasExtras,
    (E.SalarioBase / ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8)) AS PrecioHora,
    ((E.SalarioBase / ((DAY(LAST_DAY(A.Entrada)) - JL.DiasPorSemana) * 8)) * 2) AS PrecioHoraExtra,
    U.CodigoUsuarioSistema
  FROM Empleado AS E
  INNER JOIN UsuarioSistema AS U
    ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
  INNER JOIN Asistencia AS A
    ON A.CodigoUsuarioSistema = U.CodigoUsuarioSistema
  INNER JOIN JornadaLaboral AS JL
    ON JL.CodigoJornadaLaboral = E.CodigoJornadaLaboral
  WHERE MONTH(A.Entrada) = MONTH(VarFecha)
  AND E.Estado = 1
  GROUP BY U.CodigoUsuarioSistema) AS H
  INNER JOIN (SELECT
    (E.SalarioBase * 0.0483) AS IGSSEmpleado,
    (E.SalarioBase * 0.1067) AS IGSSPatrono,
    (E.SalarioBase * 0.01) AS IRTRA,
    U.CodigoUsuarioSistema,
    E.SalarioBase
  FROM Empleado AS E
  INNER JOIN UsuarioSistema AS U
    ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
  WHERE E.Estado = 1) AS E
    ON E.CodigoUsuarioSistema = H.CodigoUsuarioSistema
  LEFT JOIN (SELECT
    PC.Fecha,
    C.Bono,
    U.CodigoUsuarioSistema
  FROM Empleado AS E
  INNER JOIN UsuarioSistema AS U
    ON U.CodigoUsuarioSistema = E.CodigoUsuarioSistema
  INNER JOIN PagoComision AS PC
    ON PC.CodigoEmpleado = E.CodigoEmpleado
  INNER JOIN Departamento AS D
    ON D.CodigoDepartamento = E.CodigoDepartamento
  INNER JOIN Comision AS C
    ON C.CodigoComision = D.CodigoComision
  WHERE MONTH(PC.Fecha) = MONTH(VarFecha)
  AND E.Estado = 1
  GROUP BY U.CodigoUsuarioSistema) AS B
    ON B.CodigoUsuarioSistema = H.CodigoUsuarioSistema
  LEFT JOIN (SELECT
    E.CodigoUsuarioSistema,
    P.Monto,
    P.Cuotas,
    P.Cuotas - COUNT(A.CodigoAbono) AS CuotasPendientes,
    CASE
      WHEN (P.Monto - SUM(IFNULL(A.Monto, 1))) = 0 THEN 0
      WHEN (P.Monto - SUM(A.Monto)) IS NULL THEN P.Monto
      WHEN (P.Monto - SUM(A.Monto)) IS NOT NULL THEN (P.Monto - SUM(A.Monto))
    END AS SaldoPendiente
  FROM Prestamo AS P
  INNER JOIN Empleado AS E
    ON E.CodigoEmpleado = P.CodigoEmpleado
  LEFT JOIN Abono AS A
    ON A.CodigoPrestamo = P.CodigoPrestamo
  WHERE E.Estado = 1
  GROUP BY P.CodigoPrestamo
  HAVING CuotasPendientes > 0) AS PS
    ON PS.CodigoUsuarioSistema = E.CodigoUsuarioSistema
  INNER JOIN Empleado AS EM
    ON EM.CodigoUsuarioSistema = E.CodigoUsuarioSistema
  GROUP BY H.CodigoUsuarioSistema,
           H.Fecha) AS O;
  IF(ROW_COUNT() > 0) THEN
    call realizarAbonoPorNomina(VarFecha);
  END IF;
  SELECT COUNT(*) AS afected FROM Honorarios WHERE MONTH(FechaPago) = MONTH(VarFecha);
  ELSE
  SELECT 0 AS afected;
  END IF;
END //
DELIMITER ;

/*REALIZAR ABONO POR PRESTAMO*/
DROP PROCEDURE IF EXISTS realizarAbonoPorNomina;

DELIMITER //
CREATE PROCEDURE IF NOT EXISTS realizarAbonoPorNomina(IN VarFecha DATE)
BEGIN
	DECLARE done INT DEFAULT 0;
	DECLARE CodigoPrestamo INT;
  
  	DECLARE cur CURSOR FOR 
  		(SELECT PS.CodigoPrestamo
		FROM Honorarios AS H
		INNER JOIN Empleado AS E ON E.CodigoEmpleado = H.CodigoEmpleado
		INNER JOIN Prestamo AS PS ON PS.CodigoEmpleado = E.CodigoEmpleado
		WHERE FechaPago = VarFecha
		AND AbonoPrestamo > 0);
		
  	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
  
  	OPEN cur;
  
  	read_loop: LOOP
    	FETCH cur INTO CodigoPrestamo;
    	IF done THEN
      		LEAVE read_loop;
    	END IF;
   	 	call guardarAbono(VarFecha, 1, CodigoPrestamo);
  	END LOOP;
  CLOSE cur;
END //
DELIMITER ;

/*VALIDAR EXISTE NOMINA SALARIO GENERADO*/
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS validarExisteReporteNominaSalario(IN VarFecha DATE)
BEGIN
	  SELECT COUNT(*) AS Existe
    FROM Honorarios
    WHERE MONTH(FechaPago) = MONTH(VarFecha);
END //
DELIMITER ;