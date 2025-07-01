-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-09-2023 a las 04:08:03
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_alfrio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `am_alertas`
--

CREATE TABLE `am_alertas` (
  `id_alerta` int(11) NOT NULL,
  `id_tipoalerta` int(11) NOT NULL,
  `id_proceso` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_show` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `fec_modif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Alertas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `am_usuarios`
--

CREATE TABLE `am_usuarios` (
  `codusr` varchar(15) NOT NULL COMMENT 'Código usuario',
  `nombre` varchar(80) NOT NULL COMMENT 'Nombre',
  `numid` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL COMMENT 'E-mail',
  `paswd` varchar(10) NOT NULL COMMENT 'Contraseña',
  `id_rol` int(11) NOT NULL COMMENT 'Id Rol',
  `estado` int(11) NOT NULL COMMENT 'Estado',
  `grabador` varchar(15) NOT NULL COMMENT 'Grabador',
  `fec_graba` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` varchar(40) NOT NULL COMMENT 'Foto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='usuarios';

--
-- Volcado de datos para la tabla `am_usuarios`
--

INSERT INTO `am_usuarios` (`codusr`, `nombre`, `numid`, `email`, `paswd`, `id_rol`, `estado`, `grabador`, `fec_graba`, `foto`) VALUES
('usr1', 'Miguel Borbón', '79405370', 'maborbon@gmail.com', 'usr1', 1, 61, 'user1', '2023-08-22 16:21:12', '../imagenes/avatar/MiguelBorbon.jpg'),
('usr2', 'Ricardo Mora Guzmán', '17316300', 'ricmorag@gmail.com', 'usr2', 1, 68, 'usr2', '0000-00-00 00:00:00', '../imagenes/avatar/RicardoMora.jpg'),
('usr3', 'Eliecer Mora', '17328718', 'sistemas@alfrio.com', 'usr3', 1, 61, 'usr3', '2023-08-22 16:19:23', '../imagenes/avatar/eliecer.jpg'),
('usr4', 'Wilmer P. Silva', '79725743', 'wilmerpsilva@gmail.com', 'wilmer', 1, 61, 'usr4', '2023-08-29 15:55:18', '../imagenes/avatar/WilmerPSilva.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_ctros_costo`
--

CREATE TABLE `ap_ctros_costo` (
  `cod_centro` varchar(15) NOT NULL COMMENT 'Código de Centro',
  `nom_centro` varchar(40) NOT NULL COMMENT 'Nombre de Centro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Centros de Costo';

--
-- Volcado de datos para la tabla `ap_ctros_costo`
--

INSERT INTO `ap_ctros_costo` (`cod_centro`, `nom_centro`) VALUES
('1060006', 'Sistemas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_grupos`
--

CREATE TABLE `ap_grupos` (
  `cod_grupo` varchar(3) NOT NULL COMMENT 'Código del Grupo',
  `descrip` varchar(20) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Grupos de Programas';

--
-- Volcado de datos para la tabla `ap_grupos`
--

INSERT INTO `ap_grupos` (`cod_grupo`, `descrip`) VALUES
('adm', 'Administración'),
('com', 'Compras'),
('fin', 'Financiera'),
('ing', 'Ingenieria'),
('inv', 'Inventarios'),
('nit', 'Nits'),
('set', 'Servicio Técnico'),
('ven', 'Ventas-Comercial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_interface`
--

CREATE TABLE `ap_interface` (
  `id_codigo` int(11) NOT NULL COMMENT 'Id',
  `color_fondo` varchar(10) NOT NULL COMMENT 'Color de Fondo',
  `tipo_letra` varchar(40) NOT NULL COMMENT 'Tipo de Letra',
  `color_boton` varchar(10) NOT NULL COMMENT 'Color de Botón'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Interfaces';

--
-- Volcado de datos para la tabla `ap_interface`
--

INSERT INTO `ap_interface` (`id_codigo`, `color_fondo`, `tipo_letra`, `color_boton`) VALUES
(1, 'FONDO', 'LETRA', 'BOTON');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_opc_permi`
--

CREATE TABLE `ap_opc_permi` (
  `cod_opcion` varchar(3) NOT NULL COMMENT 'Código de Opción',
  `descrip` varchar(20) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Opciones Permisos a Programas';

--
-- Volcado de datos para la tabla `ap_opc_permi`
--

INSERT INTO `ap_opc_permi` (`cod_opcion`, `descrip`) VALUES
('A', 'Adicionar'),
('C', 'Consultar'),
('E', 'Eliminar'),
('L', 'Listar'),
('M', 'Modificar'),
('O', 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_param`
--

CREATE TABLE `ap_param` (
  `variable` varchar(30) NOT NULL COMMENT 'Variable',
  `descrip` varchar(80) NOT NULL COMMENT 'Descripción',
  `valor` varchar(200) NOT NULL COMMENT 'Valor',
  `estado` int(11) NOT NULL COMMENT 'Estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Parametros Plataforma';

--
-- Volcado de datos para la tabla `ap_param`
--

INSERT INTO `ap_param` (`variable`, `descrip`, `valor`, `estado`) VALUES
('colfon', 'Color de Fondo', '#B9B7B7', 1),
('nitempre', 'nit empresa', '860500689', 1),
('nomempre', 'nombre de empresa', 'Alfrio S.A.S.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_permpro`
--

CREATE TABLE `ap_permpro` (
  `id_permpro` int(11) NOT NULL,
  `codprog` varchar(15) NOT NULL COMMENT 'Código del Programa',
  `permpro` varchar(1) NOT NULL COMMENT 'Permiso',
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Permisos de Programa';

--
-- Volcado de datos para la tabla `ap_permpro`
--

INSERT INTO `ap_permpro` (`id_permpro`, `codprog`, `permpro`, `estado`) VALUES
(1, 'usuarios', 'A', 1),
(2, 'usuarios', 'M', 1),
(3, 'usuarios', 'C', 1),
(4, 'usuarios', 'L', 1),
(5, 'gruposprog', 'A', 1),
(6, 'gruposprog', 'M', 1),
(7, 'gruposprog', 'L', 1),
(8, 'gruposprog', 'C', 1),
(9, 'usuarios', 'E', 1),
(12, 'gruposprog', 'E', 1),
(13, 'gruposprog', 'E', 1),
(14, 'centroscostos', 'A', 1),
(15, 'centroscostos', 'C', 1),
(16, 'centroscostos', 'E', 1),
(17, 'centroscostos', 'L', 1),
(18, 'centroscostos', 'M', 1),
(19, 'basicos', 'A', 1),
(20, 'basicos', 'C', 1),
(21, 'basicos', 'E', 1),
(22, 'basicos', 'L', 1),
(23, 'basicos', 'M', 1),
(24, 'caracteristicas', 'A', 1),
(25, 'caracteristicas', 'C', 1),
(26, 'caracteristicas', 'E', 1),
(27, 'caracteristicas', 'L', 1),
(28, 'caracteristicas', 'M', 1),
(29, 'contenedores', 'A', 1),
(30, 'contenedores', 'C', 1),
(31, 'contenedores', 'E', 1),
(32, 'contenedores', 'L', 1),
(33, 'contenedores', 'M', 1),
(34, 'dtos_prov', 'A', 1),
(35, 'dtos_prov', 'C', 1),
(36, 'dtos_prov', 'E', 1),
(37, 'dtos_prov', 'L', 1),
(38, 'dtos_prov', 'M', 1),
(39, 'embarq_puert', 'A', 1),
(40, 'embarq_puert', 'C', 1),
(41, 'embarq_puert', 'E', 1),
(42, 'embarq_puert', 'L', 1),
(43, 'embarq_puert', 'M', 1),
(44, 'empaques', 'A', 1),
(45, 'empaques', 'C', 1),
(46, 'empaques', 'E', 1),
(47, 'empaques', 'L', 1),
(48, 'empaques', 'M', 1),
(49, 'etap_import', 'A', 1),
(50, 'etap_import', 'C', 1),
(51, 'etap_import', 'E', 1),
(52, 'etap_import', 'L', 1),
(53, 'etap_import', 'M', 1),
(54, 'interfaces', 'A', 1),
(55, 'interfaces', 'C', 1),
(56, 'interfaces', 'E', 1),
(57, 'interfaces', 'L', 1),
(58, 'interfaces', 'M', 1),
(59, 'marg_util_item', 'A', 1),
(60, 'marg_util_item', 'C', 1),
(61, 'marg_util_item', 'E', 1),
(62, 'marg_util_item', 'L', 1),
(63, 'marg_util_item', 'M', 1),
(64, 'opc_per_pro', 'A', 1),
(65, 'opc_per_pro', 'C', 1),
(66, 'opc_per_pro', 'E', 1),
(67, 'opc_per_pro', 'L', 1),
(68, 'opc_per_pro', 'M', 1),
(69, 'param_plataf', 'A', 1),
(70, 'param_plataf', 'C', 1),
(71, 'param_plataf', 'E', 1),
(72, 'param_plataf', 'L', 1),
(73, 'param_plataf', 'M', 1),
(74, 'perm_programas', 'A', 1),
(75, 'perm_programas', 'C', 1),
(76, 'perm_programas', 'E', 1),
(77, 'perm_programas', 'L', 1),
(78, 'perm_programas', 'M', 1),
(79, 'programas', 'A', 1),
(80, 'programas', 'C', 1),
(81, 'programas', 'E', 1),
(82, 'programas', 'L', 1),
(83, 'programas', 'M', 1),
(84, 'roles', 'A', 1),
(85, 'roles', 'C', 1),
(86, 'roles', 'E', 1),
(87, 'roles', 'L', 1),
(88, 'roles', 'M', 1),
(89, 'tbl_arancel', 'A', 1),
(90, 'tbl_arancel', 'C', 1),
(91, 'tbl_arancel', 'E', 1),
(92, 'tbl_arancel', 'L', 1),
(93, 'tbl_arancel', 'M', 1),
(94, 'terms_import', 'A', 1),
(95, 'terms_import', 'C', 1),
(96, 'terms_import', 'E', 1),
(97, 'terms_import', 'L', 1),
(98, 'terms_import', 'M', 1),
(99, 'tipo_alerta', 'A', 1),
(100, 'tipo_alerta', 'C', 1),
(101, 'tipo_alerta', 'E', 1),
(102, 'tipo_alerta', 'L', 1),
(103, 'tipo_alerta', 'M', 1),
(104, 'tip_contenedor', 'A', 1),
(105, 'tip_contenedor', 'C', 1),
(106, 'tip_contenedor', 'E', 1),
(107, 'tip_contenedor', 'L', 1),
(108, 'tip_contenedor', 'M', 1),
(109, 'tip_transport', 'A', 1),
(110, 'tip_transport', 'C', 1),
(111, 'tip_transport', 'E', 1),
(112, 'tip_transport', 'L', 1),
(113, 'tip_transport', 'M', 1),
(114, 'departamentos', 'A', 1),
(115, 'departamentos', 'C', 1),
(116, 'departamentos', 'E', 1),
(117, 'departamentos', 'L', 1),
(118, 'departamentos', 'M', 1),
(119, 'tipo_nit', 'A', 1),
(120, 'tipo_nit', 'C', 1),
(121, 'tipo_nit', 'E', 1),
(122, 'tipo_nit', 'L', 1),
(123, 'tipo_nit', 'M', 1),
(124, 'paises', 'A', 1),
(125, 'paises', 'C', 1),
(126, 'paises', 'E', 1),
(127, 'paises', 'L', 1),
(128, 'paises', 'M', 1),
(129, 'tipo_nit', 'A', 0),
(130, 'tipo_nit', 'C', 0),
(131, 'tipo_nit', 'E', 0),
(132, 'tipo_nit', 'L', 0),
(133, 'tipo_nit', 'M', 0),
(134, 'actividades', 'A', 1),
(135, 'actividades', 'C', 1),
(136, 'actividades', 'E', 1),
(137, 'actividades', 'L', 1),
(138, 'actividades', 'M', 1),
(139, 'concep_viaje', 'A', 1),
(140, 'concep_viaje', 'C', 1),
(141, 'concep_viaje', 'E', 1),
(142, 'concep_viaje', 'L', 1),
(143, 'concep_viaje', 'M', 1),
(144, 'estado_mante', 'A', 1),
(145, 'estado_mante', 'C', 1),
(146, 'estado_mante', 'E', 1),
(147, 'estado_mante', 'L', 1),
(148, 'estado_mante', 'M', 1),
(149, 'novedades', 'A', 1),
(150, 'novedades', 'C', 1),
(151, 'novedades', 'E', 1),
(152, 'novedades', 'L', 1),
(153, 'novedades', 'M', 1),
(154, 'tiempos', 'A', 1),
(155, 'tiempos', 'C', 1),
(156, 'tiempos', 'E', 1),
(157, 'tiempos', 'L', 1),
(158, 'tiempos', 'M', 1),
(159, 'tipo_activ', 'A', 1),
(160, 'tipo_activ', 'C', 1),
(161, 'tipo_activ', 'E', 1),
(162, 'tipo_activ', 'L', 1),
(163, 'tipo_activ', 'M', 1),
(164, 'tipo_concep', 'A', 1),
(165, 'tipo_concep', 'C', 1),
(166, 'tipo_concep', 'E', 1),
(167, 'tipo_concep', 'L', 1),
(168, 'tipo_concep', 'M', 1),
(169, 'dscto_vol', 'A', 1),
(170, 'dscto_vol', 'C', 1),
(171, 'dscto_vol', 'E', 1),
(172, 'dscto_vol', 'L', 1),
(173, 'dscto_vol', 'M', 1),
(174, 'financia', 'A', 1),
(175, 'financia', 'C', 1),
(176, 'financia', 'E', 1),
(177, 'financia', 'L', 1),
(178, 'financia', 'M', 1),
(179, 'limites', 'A', 1),
(180, 'limites', 'C', 1),
(181, 'limites', 'E', 1),
(182, 'limites', 'L', 1),
(183, 'limites', 'M', 1),
(184, 'terminos_pago', 'A', 1),
(185, 'terminos_pago', 'C', 1),
(186, 'terminos_pago', 'E', 1),
(187, 'terminos_pago', 'L', 1),
(188, 'terminos_pago', 'M', 1),
(189, 'grupos', 'A', 1),
(190, 'lubricantes', 'A', 1),
(191, 'lubricantes', 'C', 1),
(192, 'lubricantes', 'E', 1),
(193, 'lubricantes', 'L', 1),
(194, 'lubricantes', 'M', 1),
(195, 'marcas', 'A', 1),
(196, 'marcas', 'C', 1),
(197, 'marcas', 'E', 1),
(198, 'marcas', 'L', 1),
(199, 'marcas', 'M', 1),
(200, 'modelos', 'A', 1),
(201, 'modelos', 'C', 1),
(202, 'modelos', 'E', 1),
(203, 'modelos', 'L', 1),
(204, 'modelos', 'M', 1),
(205, 'tip_modelo', 'A', 1),
(206, 'tip_modelo', 'C', 1),
(207, 'tip_modelo', 'E', 1),
(208, 'tip_modelo', 'L', 1),
(209, 'tip_modelo', 'M', 1),
(210, 'ubi_item_invent', 'A', 1),
(211, 'ubi_item_invent', 'C', 1),
(212, 'ubi_item_invent', 'E', 1),
(213, 'ubi_item_invent', 'L', 1),
(214, 'ubi_item_invent', 'M', 1),
(215, 'unidades', 'A', 1),
(216, 'unidades', 'C', 1),
(217, 'unidades', 'E', 1),
(218, 'unidades', 'L', 1),
(219, 'unidades', 'M', 1),
(220, 'cargos', 'A', 1),
(221, 'cargos', 'C', 1),
(222, 'cargos', 'E', 1),
(223, 'cargos', 'L', 1),
(224, 'cargos', 'M', 1),
(225, 'ciudades', 'A', 1),
(226, 'ciudades', 'C', 1),
(227, 'ciudades', 'E', 1),
(228, 'ciudades', 'L', 1),
(229, 'ciudades', 'M', 1),
(230, 'continentes', 'A', 1),
(231, 'continentes', 'C', 1),
(232, 'continentes', 'E', 1),
(233, 'continentes', 'L', 1),
(234, 'continentes', 'M', 1),
(235, 'diccio_foreing', 'A', 1),
(236, 'diccio_foreing', 'C', 1),
(237, 'diccio_foreing', 'E', 1),
(238, 'diccio_foreing', 'L', 1),
(239, 'diccio_foreing', 'M', 1),
(240, 'dic_foreign_col', 'A', 1),
(241, 'dic_foreign_col', 'C', 1),
(242, 'dic_foreign_col', 'E', 1),
(243, 'dic_foreign_col', 'L', 1),
(244, 'dic_foreign_col', 'M', 1),
(245, 'diccio_tablas', 'A', 1),
(246, 'diccio_tablas', 'C', 1),
(247, 'diccio_tablas', 'E', 1),
(248, 'diccio_tablas', 'L', 1),
(249, 'diccio_tablas', 'M', 1),
(250, 'actividades', 'O', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_programs`
--

CREATE TABLE `ap_programs` (
  `codprog` varchar(15) NOT NULL COMMENT 'Código',
  `nomprog` varchar(80) NOT NULL COMMENT 'Nombre del Programa',
  `estado` int(11) NOT NULL COMMENT 'Estado',
  `path` varchar(50) NOT NULL COMMENT 'Path',
  `grupo` varchar(3) NOT NULL COMMENT 'Grupo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Programas';

--
-- Volcado de datos para la tabla `ap_programs`
--

INSERT INTO `ap_programs` (`codprog`, `nomprog`, `estado`, `path`, `grupo`) VALUES
('actividades', 'Actividades', 68, 'carga.php?tabla=sp_activid', 'set'),
('basicos', 'Parámetros Básicos', 68, 'carga.php?tabla=ip_basicos', 'inv'),
('caracteristicas', 'Características', 68, 'carga.php?tabla=ip_caracte', 'inv'),
('cargos', 'Cargos de Empleados', 68, 'carga.php?tabla=np_cargos', 'nit'),
('centroscostos', 'Centros de Costo', 68, 'carga.php?tabla=ap_ctros_costo', 'adm'),
('ciudades', 'Ciudades', 68, 'carga.php?tabla=np_ciudades', 'nit'),
('concep_viaje', 'Conceptos de Viaje', 68, 'carga.php?tabla=sp_concepviaje', 'set'),
('contenedores', 'Contenedores', 68, 'carga.php?tabla=cp_contened', 'com'),
('continentes', 'Continentes', 68, 'carga.php?tabla=np_continen', 'nit'),
('departamentos', 'Departamentos', 68, 'carga.php?tabla=np_deptos', 'nit'),
('diccio_foreing', 'Diccio foreing', 68, 'carga.php?tabla=diccio_foreign', 'adm'),
('diccio_tablas', 'Diccionario tablas', 68, 'carga.php?tabla=diccionario_tablas', 'adm'),
('dic_foreign_col', 'Diccio foreing cols ', 68, 'carga.php?tabla=diccio_foreign_cols', 'adm'),
('dscto_vol', 'Descto Autor. por Vol. de Venta', 68, 'carga.php?tabla=vp_dscto_vol', 'ven'),
('dtbasicos', 'DT Básicos', 68, 'carga.php?tabla=ip_dtbasicos', 'inv'),
('dtos_prov', 'Descuentos de Proveedores', 68, 'carga.php?tabla=cp_dsctos_prov', 'com'),
('embarq_puert', 'Puertos de Embarque', 68, 'carga.php?tabla=cp_puertos', 'com'),
('empaques', 'Empaques', 68, 'carga.php?tabla=cp_empaque', 'com'),
('estado_mante', 'Estados de Mantenimiento', 68, 'carga.php?tabla=sp_estado_man', 'set'),
('etap_import', 'Etapas de Importación', 68, 'carga.php?tabla=cp_etapas_imp', 'com'),
('financia', 'Margen de Financiación', 68, 'carga.php?tabla=vp_financia', 'ven'),
('grupos', 'Grupos', 68, 'carga.php?tabla=ip_grupos', 'inv'),
('gruposprog', 'Grupos de Programas', 68, 'carga.php?tabla=ap_grupos', 'adm'),
('interfaces', 'Interfaces', 68, 'carga.php?tabla=ap_interface', 'adm'),
('limites', 'Descuento Autorizado', 68, 'carga.php?tabla=vp_limites', 'ven'),
('lubricantes', 'Lubricantes', 68, 'carga.php?tabla=ip_lubricantes', 'inv'),
('marcas', 'Marcas', 68, 'carga.php?tabla=ip_marcas', 'inv'),
('marg_util_item', 'Margen de Utilidad por Item', 68, 'carga.php?tabla=fp_utilidad', 'fin'),
('modelos', 'Modelos de Equipos', 68, 'carga.php?tabla=ip_modelos', 'inv'),
('novedades', 'Novedades de Técnicos', 68, 'carga.php?tabla=sp_novedades', 'set'),
('opc_per_pro', 'Opciones Permisos a Programas', 68, 'carga.php?tabla=ap_opc_permi', 'adm'),
('paises', 'Países', 68, 'carga.php?tabla=np_paises', 'nit'),
('param_plataf', 'Parametros Plataforma', 68, 'carga.php?tabla=ap_param', 'adm'),
('perm_programas', 'Permisos de Programa', 68, 'carga.php?tabla=ap_permpro', 'adm'),
('programas', 'Programas', 68, 'carga.php?tabla=ap_programs', 'adm'),
('roles', 'Roles', 68, 'carga.php?tabla=ap_roles', 'adm'),
('tbl_arancel', 'Tabla Arancelaria', 68, 'carga.php?tabla=cp_arancel', 'com'),
('terminos_pago', 'Terminos de Pago', 68, 'carga.php?tabla=vp_terminospago', 'ven'),
('terms_import', 'Terminos de Importación', 68, 'carga.php?tabla=cp_incoterm', 'com'),
('tiempos', 'Tiempos Horas Extra', 68, 'carga.php?tabla=sp_tiempos', 'set'),
('tipo_activ', 'Tipos de Actividad', 68, 'carga.php?tabla=sp_tipoactiv', 'set'),
('tipo_alerta', 'Tipos de Alerta', 68, 'carga.php?tabla=ap_tipoalerta', 'adm'),
('tipo_concep', 'Tipos de Concepto de Viaje', 68, 'carga.php?tabla=sp_tipoconcep', 'set'),
('tipo_nit', 'Tipos de NIT', 68, 'carga.php?tabla=np_tiponit', 'nit'),
('tip_contenedor', 'Tipos de Contenedores', 68, 'carga.php?tabla=cp_contened', 'com'),
('tip_modelo', 'Tipos de Modelo', 68, 'carga.php?tabla=ip_tipomodelo', 'inv'),
('tip_transport', 'Tipos de Transporte', 68, 'carga.php?tabla=cp_tipo_transporte', 'com'),
('ubi_item_invent', 'Ubicación Items Inventario', 68, 'carga.php?tabla=ip_ubica', 'inv'),
('unidades', 'Unidades de Medida', 68, 'carga.php?tabla=ip_unidades', 'inv'),
('usuarios', 'Usuarios', 68, 'carga.php?tabla=am_usuarios', 'adm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_roles`
--

CREATE TABLE `ap_roles` (
  `id_rol` int(11) NOT NULL,
  `descrip_rol` varchar(30) NOT NULL COMMENT 'Descripción',
  `id_cargo` varchar(10) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Roles';

--
-- Volcado de datos para la tabla `ap_roles`
--

INSERT INTO `ap_roles` (`id_rol`, `descrip_rol`, `id_cargo`, `estado`) VALUES
(1, 'Superadministrador', '111600', 66),
(2, 'Administrador', '111000', 66),
(3, 'Presidencia', '110000', 66),
(4, 'Director comercial', '111200', 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ap_tipoalerta`
--

CREATE TABLE `ap_tipoalerta` (
  `id_tipoalerta` int(11) NOT NULL COMMENT 'Id',
  `descrip_alert` varchar(40) NOT NULL COMMENT 'Nombre alerta',
  `dias_aplica` int(11) NOT NULL COMMENT 'Días de Aplicación',
  `despues_fec` tinyint(1) NOT NULL COMMENT 'Después de Fecha',
  `antes_fec` tinyint(1) NOT NULL COMMENT 'Antes de Fecha',
  `tabla_ini` varchar(40) NOT NULL COMMENT 'Tabla Inicial',
  `campo_ini` varchar(40) NOT NULL COMMENT 'Campo Inicial',
  `tabla_fin` varchar(40) NOT NULL COMMENT 'Tabla Final',
  `campo_fin` varchar(40) NOT NULL COMMENT 'Campo Final',
  `programa` varchar(80) NOT NULL COMMENT 'Programa',
  `descripcion` text NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Alerta';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ar_bloqueo`
--

CREATE TABLE `ar_bloqueo` (
  `id_bloqueo` int(11) NOT NULL,
  `fechora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `codusr` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL,
  `grabador` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Registro de cambios estado Usuarios';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ar_roles`
--

CREATE TABLE `ar_roles` (
  `id_rrol` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_permpro` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Permisos a Roles';

--
-- Volcado de datos para la tabla `ar_roles`
--

INSERT INTO `ar_roles` (`id_rrol`, `id_rol`, `id_permpro`, `estado`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 12, 1),
(11, 1, 13, 1),
(12, 1, 14, 1),
(13, 1, 14, 1),
(14, 1, 15, 1),
(15, 1, 16, 1),
(16, 1, 17, 1),
(17, 1, 18, 1),
(18, 1, 19, 1),
(19, 1, 20, 1),
(20, 1, 21, 1),
(21, 1, 22, 1),
(22, 1, 23, 1),
(23, 1, 24, 1),
(24, 1, 25, 1),
(25, 1, 26, 1),
(26, 1, 27, 1),
(27, 1, 28, 1),
(28, 1, 29, 1),
(29, 1, 30, 1),
(30, 1, 31, 1),
(31, 1, 32, 1),
(32, 1, 33, 1),
(33, 1, 34, 0),
(34, 1, 35, 1),
(35, 1, 36, 1),
(36, 1, 37, 1),
(37, 1, 38, 1),
(38, 1, 39, 1),
(39, 1, 40, 1),
(40, 1, 41, 1),
(41, 1, 42, 1),
(42, 1, 43, 1),
(43, 1, 44, 1),
(44, 1, 45, 1),
(45, 1, 46, 1),
(46, 1, 47, 1),
(47, 1, 48, 1),
(48, 1, 49, 1),
(49, 1, 50, 1),
(50, 1, 51, 1),
(51, 1, 52, 1),
(52, 1, 53, 1),
(53, 1, 54, 1),
(54, 1, 55, 1),
(55, 1, 56, 1),
(56, 1, 57, 1),
(57, 1, 58, 1),
(58, 1, 59, 1),
(59, 1, 60, 1),
(60, 1, 61, 1),
(61, 1, 62, 1),
(62, 1, 63, 1),
(63, 1, 64, 1),
(64, 1, 65, 1),
(65, 1, 66, 1),
(66, 1, 67, 1),
(67, 1, 68, 1),
(68, 1, 69, 1),
(69, 1, 70, 1),
(70, 1, 71, 1),
(71, 1, 72, 1),
(72, 1, 73, 1),
(73, 1, 74, 1),
(74, 1, 75, 1),
(75, 1, 76, 1),
(76, 1, 77, 1),
(77, 1, 78, 1),
(78, 1, 79, 1),
(79, 1, 80, 1),
(80, 1, 81, 0),
(81, 1, 82, 1),
(82, 1, 83, 1),
(83, 1, 84, 1),
(84, 1, 85, 1),
(85, 1, 86, 1),
(86, 1, 87, 1),
(87, 1, 88, 1),
(88, 1, 89, 1),
(89, 1, 90, 1),
(90, 1, 91, 1),
(91, 1, 92, 1),
(92, 1, 93, 1),
(93, 1, 94, 1),
(94, 1, 95, 1),
(95, 1, 96, 1),
(96, 1, 97, 1),
(97, 1, 98, 1),
(98, 1, 99, 1),
(99, 1, 100, 1),
(100, 1, 101, 1),
(101, 1, 102, 1),
(102, 1, 103, 1),
(103, 1, 104, 1),
(104, 1, 105, 1),
(105, 1, 106, 1),
(106, 1, 107, 1),
(107, 1, 108, 1),
(108, 1, 109, 1),
(109, 1, 110, 1),
(110, 1, 112, 1),
(111, 1, 113, 1),
(112, 1, 114, 1),
(113, 1, 115, 1),
(114, 1, 116, 1),
(115, 1, 117, 1),
(116, 1, 118, 1),
(117, 1, 119, 1),
(118, 1, 120, 1),
(119, 1, 121, 1),
(120, 1, 122, 1),
(121, 1, 123, 1),
(122, 1, 124, 1),
(123, 1, 125, 1),
(124, 1, 126, 1),
(125, 1, 127, 1),
(126, 1, 128, 1),
(127, 1, 134, 1),
(128, 1, 135, 0),
(129, 1, 136, 1),
(130, 1, 137, 1),
(131, 1, 138, 1),
(132, 1, 139, 1),
(133, 1, 140, 1),
(134, 1, 141, 1),
(135, 1, 142, 1),
(136, 1, 143, 1),
(137, 1, 144, 1),
(138, 1, 145, 1),
(139, 1, 146, 1),
(140, 1, 147, 1),
(141, 1, 148, 1),
(142, 1, 149, 1),
(143, 1, 150, 1),
(144, 1, 151, 1),
(145, 1, 152, 1),
(146, 1, 153, 1),
(147, 1, 154, 1),
(148, 1, 155, 1),
(149, 1, 156, 1),
(150, 1, 157, 1),
(151, 1, 158, 1),
(152, 1, 159, 1),
(153, 1, 160, 1),
(154, 1, 161, 1),
(155, 1, 162, 1),
(156, 1, 163, 1),
(157, 1, 164, 1),
(158, 1, 165, 1),
(159, 1, 166, 1),
(160, 1, 167, 1),
(161, 1, 168, 1),
(162, 1, 169, 1),
(163, 1, 170, 1),
(164, 1, 171, 1),
(165, 1, 172, 1),
(166, 1, 173, 1),
(167, 1, 174, 1),
(168, 1, 175, 1),
(169, 1, 176, 1),
(170, 1, 177, 1),
(171, 1, 178, 1),
(172, 1, 179, 1),
(173, 1, 180, 1),
(174, 1, 181, 1),
(175, 1, 182, 1),
(176, 1, 183, 1),
(177, 1, 184, 1),
(178, 1, 185, 1),
(179, 1, 186, 1),
(180, 1, 187, 1),
(181, 1, 188, 1),
(182, 1, 111, 1),
(2001, 1, 189, 1),
(2002, 1, 190, 1),
(2003, 1, 191, 1),
(2004, 1, 192, 1),
(2005, 1, 193, 1),
(2006, 1, 194, 1),
(2007, 1, 195, 1),
(2008, 1, 196, 1),
(2009, 1, 197, 1),
(2010, 1, 198, 1),
(2011, 1, 199, 1),
(2012, 1, 200, 1),
(2013, 1, 201, 1),
(2014, 1, 202, 1),
(2015, 1, 203, 1),
(2016, 1, 204, 1),
(2017, 1, 205, 1),
(2018, 1, 206, 1),
(2019, 1, 207, 1),
(2020, 1, 208, 1),
(2021, 1, 209, 1),
(2022, 1, 210, 1),
(2023, 1, 211, 1),
(2024, 1, 212, 1),
(2025, 1, 213, 1),
(2026, 1, 214, 1),
(2027, 1, 215, 1),
(2028, 1, 216, 1),
(2029, 1, 217, 1),
(2030, 1, 218, 1),
(2031, 1, 219, 1),
(2032, 1, 220, 1),
(2033, 1, 221, 1),
(2034, 1, 221, 1),
(2035, 1, 222, 1),
(2036, 1, 223, 1),
(2037, 1, 225, 1),
(2038, 1, 226, 1),
(2039, 1, 227, 1),
(2040, 1, 228, 1),
(2041, 1, 229, 1),
(2042, 1, 230, 1),
(2043, 1, 231, 1),
(2044, 1, 232, 1),
(2045, 1, 233, 1),
(2046, 1, 234, 1),
(2047, 1, 235, 0),
(2048, 1, 236, 0),
(2049, 1, 237, 0),
(2050, 1, 238, 0),
(2051, 1, 239, 0),
(2052, 1, 240, 0),
(2053, 1, 241, 0),
(2054, 1, 242, 0),
(2055, 1, 243, 0),
(2056, 1, 244, 0),
(2057, 1, 245, 0),
(2058, 1, 246, 0),
(2059, 1, 247, 0),
(2060, 1, 248, 0),
(2061, 1, 249, 0),
(2064, 1, 250, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ch_import`
--

CREATE TABLE `ch_import` (
  `id_po` int(11) NOT NULL,
  `campo` varchar(40) NOT NULL,
  `valor` decimal(12,2) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `fec_modif` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Historico de Importaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cm_trm`
--

CREATE TABLE `cm_trm` (
  `id_moneda` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `trm` decimal(10,2) NOT NULL COMMENT 'Dolar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='TRM USD';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_arancel`
--

CREATE TABLE `cp_arancel` (
  `cod_arancel` varchar(30) NOT NULL COMMENT 'Código',
  `descrip` varchar(80) NOT NULL COMMENT 'Descripción',
  `porcentaje` decimal(4,2) NOT NULL COMMENT 'Porcentaje'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla Arancelaria';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_contened`
--

CREATE TABLE `cp_contened` (
  `id_contene` int(11) NOT NULL,
  `capacd_ton` int(11) NOT NULL COMMENT 'Cap. en Toneladas',
  `ancho` int(11) NOT NULL COMMENT 'Ancho',
  `alto` int(11) NOT NULL COMMENT 'Alto',
  `tipo` int(11) NOT NULL COMMENT 'Tipo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Contenedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_dsctos_prov`
--

CREATE TABLE `cp_dsctos_prov` (
  `id_dscto` int(11) NOT NULL COMMENT 'Id',
  `id_proveedor` int(11) NOT NULL COMMENT 'Id Proveedor',
  `id_marca` int(11) NOT NULL COMMENT 'Id Marca',
  `cod_item` varchar(15) NOT NULL COMMENT 'Código del Item',
  `porctj_dscto` decimal(5,2) NOT NULL COMMENT 'Porcentaje de Descuento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Descuentos de Proveedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_empaque`
--

CREATE TABLE `cp_empaque` (
  `id_empaque` int(11) NOT NULL,
  `nom_empaq` varchar(30) NOT NULL COMMENT 'Nombre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Empaques';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_etapas_imp`
--

CREATE TABLE `cp_etapas_imp` (
  `id_etapa` int(11) NOT NULL,
  `nom_etapa` varchar(20) NOT NULL COMMENT 'Nombre de la Etapa',
  `subtotal` tinyint(1) NOT NULL COMMENT 'Sub total'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Etapas de Importación';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_incoterm`
--

CREATE TABLE `cp_incoterm` (
  `id_incoterm` int(11) NOT NULL,
  `acronimo` varchar(5) NOT NULL COMMENT 'Acrónimo',
  `descrip` varchar(30) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Terminos de Importación';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_puertos`
--

CREATE TABLE `cp_puertos` (
  `id_puerto` int(11) NOT NULL,
  `nom_puerto` varchar(60) NOT NULL COMMENT 'Nombre del Puerto',
  `ciudad` int(11) NOT NULL COMMENT 'Id ciudad',
  `pais` int(11) NOT NULL COMMENT 'Id país'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Puertos de Embarque';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_tipocontenedor`
--

CREATE TABLE `cp_tipocontenedor` (
  `id_tipo` int(11) NOT NULL COMMENT 'Id',
  `descrip` varchar(40) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Contenedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cp_tipo_transporte`
--

CREATE TABLE `cp_tipo_transporte` (
  `id_tipotrans` int(11) NOT NULL,
  `nom_tipo` varchar(30) NOT NULL COMMENT 'Tipo de Transporte'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Transporte';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cr_costos_imprt`
--

CREATE TABLE `cr_costos_imprt` (
  `id_po` int(11) NOT NULL,
  `fecha_solic` date NOT NULL,
  `codemple` varchar(15) NOT NULL,
  `area` int(11) NOT NULL,
  `fec_comprmso` date NOT NULL,
  `dias_po` int(11) NOT NULL,
  `ctro_costo` varchar(10) NOT NULL,
  `cliente` int(11) NOT NULL,
  `id_consecot` int(11) NOT NULL,
  `proveedor` int(11) NOT NULL,
  `observs` text NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `cant` int(11) NOT NULL,
  `vr_unit` decimal(15,2) NOT NULL,
  `etapa` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `trm` decimal(7,2) NOT NULL,
  `costo_usd` decimal(15,2) NOT NULL,
  `costo_cop` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Costos Totales de Importacion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cr_cotprov`
--

CREATE TABLE `cr_cotprov` (
  `id_cotprov` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `suc_prov` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL,
  `fecha_vence` date NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `trm` decimal(7,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Cotizaciones de Proveedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cr_cotprovdet`
--

CREATE TABLE `cr_cotprovdet` (
  `id_cotprov` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `descrip` varchar(80) NOT NULL,
  `caracterist` varchar(120) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `vr_unit` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Detalle Cotizaciones de Proveedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cr_importacio`
--

CREATE TABLE `cr_importacio` (
  `id_po` int(11) NOT NULL COMMENT 'Purchase Order',
  `estado` int(11) NOT NULL,
  `sli_consol` int(11) NOT NULL,
  `codemple` varchar(15) NOT NULL COMMENT 'Solicita',
  `area` int(11) NOT NULL,
  `fec_solic` date NOT NULL COMMENT 'Fecha Solicitud',
  `cotiz_alfrio` int(11) NOT NULL COMMENT 'Cotizacion Alfrio',
  `fec_proce` date NOT NULL,
  `fec_comprmso` date NOT NULL COMMENT 'Fecha Compromiso',
  `dias_po` int(11) NOT NULL,
  `nro_confirm` int(11) NOT NULL,
  `ctro_costo` varchar(15) NOT NULL,
  `cliente` int(11) NOT NULL,
  `proveedor` int(11) NOT NULL COMMENT 'Proveedor',
  `observs` text NOT NULL,
  `fec_estm_dspch` date NOT NULL COMMENT 'Fecha Estimada Despacho',
  `factura_prov` varchar(15) NOT NULL COMMENT 'Factura Proveedor',
  `fec_fac_prov` date NOT NULL COMMENT 'Fecha Factura Proveedor',
  `trm_fac_prov_usd` decimal(12,2) NOT NULL,
  `fec_entrga_fac` date NOT NULL,
  `vr_unt_prov` decimal(12,2) NOT NULL,
  `multiplic` decimal(6,4) NOT NULL,
  `vr_unt_prov_multip` decimal(12,2) NOT NULL,
  `total_exw` decimal(12,2) NOT NULL,
  `vr_inland` decimal(12,2) NOT NULL,
  `descuentos` decimal(12,2) NOT NULL,
  `vr_fob` decimal(12,2) NOT NULL,
  `nro_wh` int(11) NOT NULL,
  `vr_flete_int_usd` decimal(12,2) NOT NULL,
  `forwarder` int(11) NOT NULL,
  `doc_transp` varchar(10) NOT NULL,
  `fac_forwarder` varchar(10) NOT NULL,
  `fec_entrga_fac_forw` date NOT NULL,
  `pais_origen` int(11) NOT NULL,
  `ciudad_destino` int(11) NOT NULL,
  `modo_transprt` int(11) NOT NULL,
  `fec_ing_colmbia` date NOT NULL,
  `vr_seguro_transprt` decimal(12,2) NOT NULL,
  `cif_usd` decimal(12,2) NOT NULL,
  `cif_cop` decimal(12,2) NOT NULL,
  `partida_arancel` varchar(30) NOT NULL,
  `arancel_%` decimal(6,4) NOT NULL,
  `vr_arancel_cop` decimal(12,2) NOT NULL,
  `vr_iva_cop_estim` decimal(12,2) NOT NULL,
  `total_imptos_estim` decimal(12,2) NOT NULL,
  `formula_estim` decimal(6,4) NOT NULL,
  `fc_estim_pag_impts` date NOT NULL,
  `sem_estim_pag_impts` int(11) NOT NULL,
  `agencia_cop` decimal(12,2) NOT NULL,
  `nro_fact_agencia` varchar(10) NOT NULL,
  `agencia_aduanas` int(11) NOT NULL,
  `fec_entrga_fac_agen` date NOT NULL,
  `alma_cop` decimal(12,2) NOT NULL,
  `nro_fact_alma` varchar(10) NOT NULL,
  `almacenaje` int(11) NOT NULL,
  `fec_entrga_fac_alma` date NOT NULL,
  `transp_local_cop` decimal(12,2) NOT NULL,
  `nro_fac_transp` varchar(10) NOT NULL,
  `transp_local` int(11) NOT NULL,
  `fec_entrga_fac_transp` date NOT NULL,
  `sem_llegada` int(11) NOT NULL,
  `lugar_llegada` int(11) NOT NULL,
  `costo_total_cop` decimal(12,2) NOT NULL,
  `costo_unit_cop` decimal(12,2) NOT NULL,
  `multiplic_final` decimal(6,4) NOT NULL,
  `dias_importac` int(11) NOT NULL,
  `dias_para_entrega` int(11) NOT NULL,
  `seguimiento` varchar(200) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `f_ult_mod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Importaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cr_seg_imprt`
--

CREATE TABLE `cr_seg_imprt` (
  `id_po` int(11) NOT NULL,
  `id_etapa` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `estado_etapa` varchar(20) NOT NULL,
  `documento` varchar(10) NOT NULL,
  `fecha_docum` date NOT NULL,
  `fec_entrgadoc` date NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `valor_total` decimal(12,2) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `fec_grabacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Seguimiento de importacion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diccionario_tablas`
--

CREATE TABLE `diccionario_tablas` (
  `table_name` varchar(64) NOT NULL,
  `column_name` varchar(64) NOT NULL,
  `data_type` varchar(64) NOT NULL,
  `is_nullable` varchar(3) NOT NULL,
  `column_key` varchar(3) NOT NULL,
  `character_maximum_length` bigint(20) DEFAULT NULL,
  `numeric_precision` bigint(20) DEFAULT NULL,
  `numeric_scale` bigint(20) DEFAULT NULL,
  `column_default` longtext DEFAULT NULL,
  `column_comment` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `diccionario_tablas`
--

INSERT INTO `diccionario_tablas` (`table_name`, `column_name`, `data_type`, `is_nullable`, `column_key`, `character_maximum_length`, `numeric_precision`, `numeric_scale`, `column_default`, `column_comment`) VALUES
('am_alertas', 'id_alerta', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('am_alertas', 'id_tipoalerta', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('am_alertas', 'id_proceso', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('am_alertas', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('am_alertas', 'fecha_show', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('am_alertas', 'fecha_fin', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('am_alertas', 'descripcion', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('am_alertas', 'id_estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('am_alertas', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('am_alertas', 'fec_modif', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('am_usuarios', 'codusr', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'Código usuario'),
('am_usuarios', 'nombre', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Nombre'),
('am_usuarios', 'nit', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, 'NIT'),
('am_usuarios', 'email', 'varchar', 'NO', '', 150, NULL, NULL, NULL, 'E-mail'),
('am_usuarios', 'paswd', 'varchar', 'NO', '', 10, NULL, NULL, NULL, 'Contraseña'),
('am_usuarios', 'id_rol', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Rol'),
('am_usuarios', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('am_usuarios', 'grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, 'Grabador'),
('am_usuarios', 'fec_graba', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('am_usuarios', 'foto', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Foto'),
('ap_ctros_costo', 'cod_centro', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'Código de Centro'),
('ap_ctros_costo', 'nom_centro', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Nombre de Centro'),
('ap_grupos', 'cod_grupo', 'varchar', 'NO', 'PRI', 3, NULL, NULL, NULL, 'Código del Grupo'),
('ap_grupos', 'descrip', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Descripción'),
('ap_interface', 'id_codigo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ap_interface', 'color_fondo', 'varchar', 'NO', '', 10, NULL, NULL, NULL, 'Color de Fondo'),
('ap_interface', 'tipo_letra', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Tipo de Letra'),
('ap_interface', 'color_boton', 'varchar', 'NO', '', 10, NULL, NULL, NULL, 'Color de Botón'),
('ap_opc_permi', 'cod_opcion', 'varchar', 'NO', 'PRI', 3, NULL, NULL, NULL, 'Código de Opción'),
('ap_opc_permi', 'descrip', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Descripción'),
('ap_param', 'variable', 'varchar', 'NO', 'PRI', 30, NULL, NULL, NULL, 'Variable'),
('ap_param', 'descrip', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Descripción'),
('ap_param', 'valor', 'varchar', 'NO', '', 200, NULL, NULL, NULL, 'Valor'),
('ap_param', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('ap_permpro', 'id_permpro', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ap_permpro', 'codprog', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, 'Código del Programa'),
('ap_permpro', 'permpro', 'varchar', 'NO', 'MUL', 1, NULL, NULL, NULL, 'Permiso'),
('ap_permpro', 'estado', 'tinyint', 'NO', '', NULL, 3, 0, '1', 'Estado'),
('ap_programs', 'codprog', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'Código'),
('ap_programs', 'nomprog', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Nombre del Programa'),
('ap_programs', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('ap_programs', 'path', 'varchar', 'NO', '', 50, NULL, NULL, NULL, 'Path'),
('ap_programs', 'grupo', 'varchar', 'NO', 'MUL', 3, NULL, NULL, NULL, 'Grupo'),
('ap_roles', 'id_rol', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ap_roles', 'descrip_rol', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Descripción'),
('ap_roles', 'id_cargo', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, 'Id Cargo'),
('ap_roles', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('ap_tipoalerta', 'id_tipoalerta', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ap_tipoalerta', 'descrip_alert', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Nombre alerta'),
('ap_tipoalerta', 'dias_aplica', 'int', 'NO', '', NULL, 10, 0, NULL, 'Días de Aplicación'),
('ap_tipoalerta', 'despues_fec', 'tinyint', 'NO', '', NULL, 3, 0, NULL, 'Después de Fecha'),
('ap_tipoalerta', 'antes_fec', 'tinyint', 'NO', '', NULL, 3, 0, NULL, 'Antes de Fecha'),
('ap_tipoalerta', 'tabla_ini', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Tabla Inicial'),
('ap_tipoalerta', 'campo_ini', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Campo Inicial'),
('ap_tipoalerta', 'tabla_fin', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Tabla Final'),
('ap_tipoalerta', 'campo_fin', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Campo Final'),
('ap_tipoalerta', 'programa', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Programa'),
('ap_tipoalerta', 'descripcion', 'text', 'NO', '', 65535, NULL, NULL, NULL, 'Descripción'),
('ar_bloqueo', 'id_bloqueo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('ar_bloqueo', 'fechora', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('ar_bloqueo', 'codusr', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('ar_bloqueo', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ar_bloqueo', 'grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('ar_roles', 'id_rrol', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('ar_roles', 'id_rol', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('ar_roles', 'id_permpro', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('ar_roles', 'estado', 'tinyint', 'NO', '', NULL, 3, 0, '1', 'Estado'),
('ch_import', 'id_po', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ch_import', 'campo', 'varchar', 'NO', '', 40, NULL, NULL, NULL, ''),
('ch_import', 'valor', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('ch_import', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('ch_import', 'fec_modif', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cm_trm', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cm_trm', 'fecha', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cm_trm', 'trm', 'decimal', 'NO', '', NULL, 10, 2, NULL, 'Dolar'),
('cp_arancel', 'cod_arancel', 'varchar', 'NO', 'PRI', 30, NULL, NULL, NULL, 'Código'),
('cp_arancel', 'descrip', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Descripción'),
('cp_arancel', 'porcentaje', 'decimal', 'NO', '', NULL, 4, 2, NULL, 'Porcentaje'),
('cp_contened', 'id_contene', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_contened', 'capacd_ton', 'int', 'NO', '', NULL, 10, 0, NULL, 'Cap. en Toneladas'),
('cp_contened', 'ancho', 'int', 'NO', '', NULL, 10, 0, NULL, 'Ancho'),
('cp_contened', 'alto', 'int', 'NO', '', NULL, 10, 0, NULL, 'Alto'),
('cp_contened', 'tipo', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Tipo'),
('cp_dsctos_prov', 'id_dscto', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_dsctos_prov', 'id_proveedor', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Proveedor'),
('cp_dsctos_prov', 'id_marca', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Marca'),
('cp_dsctos_prov', 'cod_item', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, 'Código del Item'),
('cp_dsctos_prov', 'porctj_dscto', 'decimal', 'NO', '', NULL, 5, 2, NULL, 'Porcentaje de Descuento'),
('cp_empaque', 'id_empaque', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_empaque', 'nom_empaq', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre'),
('cp_etapas_imp', 'id_etapa', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_etapas_imp', 'nom_etapa', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Nombre de la Etapa'),
('cp_etapas_imp', 'subtotal', 'tinyint', 'NO', '', NULL, 3, 0, NULL, 'Sub total'),
('cp_incoterm', 'id_incoterm', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_incoterm', 'acronimo', 'varchar', 'NO', '', 5, NULL, NULL, NULL, 'Acrónimo'),
('cp_incoterm', 'descrip', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Descripción'),
('cp_puertos', 'id_puerto', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_puertos', 'nom_puerto', 'varchar', 'NO', '', 60, NULL, NULL, NULL, 'Nombre del Puerto'),
('cp_puertos', 'ciudad', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id ciudad'),
('cp_puertos', 'pais', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id país'),
('cp_tipocontenedor', 'id_tipo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_tipocontenedor', 'descrip', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción'),
('cp_tipo_transporte', 'id_tipotrans', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('cp_tipo_transporte', 'nom_tipo', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Tipo de Transporte'),
('cr_costos_imprt', 'id_po', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'fecha_solic', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'codemple', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'area', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'fec_comprmso', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'dias_po', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'ctro_costo', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'id_consecot', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'proveedor', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'observs', 'text', 'NO', '', 65535, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'descripcion', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('cr_costos_imprt', 'cant', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'vr_unit', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('cr_costos_imprt', 'etapa', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_costos_imprt', 'trm', 'decimal', 'NO', '', NULL, 7, 2, NULL, ''),
('cr_costos_imprt', 'costo_usd', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('cr_costos_imprt', 'costo_cop', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('cr_cotprov', 'id_cotprov', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('cr_cotprov', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_cotprov', 'suc_prov', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprov', 'id_contacto', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprov', 'fecha_vence', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_cotprov', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprov', 'trm', 'decimal', 'NO', '', NULL, 7, 2, NULL, ''),
('cr_cotprov', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprovdet', 'id_cotprov', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_cotprovdet', 'orden', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprovdet', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('cr_cotprovdet', 'descrip', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('cr_cotprovdet', 'caracterist', 'varchar', 'NO', '', 120, NULL, NULL, NULL, ''),
('cr_cotprovdet', 'cantidad', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_cotprovdet', 'vr_unit', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'id_po', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Purchase Order'),
('cr_importacio', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'sli_consol', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'codemple', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, 'Solicita'),
('cr_importacio', 'area', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'fec_solic', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'Fecha Solicitud'),
('cr_importacio', 'cotiz_alfrio', 'int', 'NO', '', NULL, 10, 0, NULL, 'Cotizacion Alfrio'),
('cr_importacio', 'fec_proce', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'fec_comprmso', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'Fecha Compromiso'),
('cr_importacio', 'dias_po', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'nro_confirm', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'ctro_costo', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('cr_importacio', 'cliente', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'proveedor', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Proveedor'),
('cr_importacio', 'observs', 'text', 'NO', '', 65535, NULL, NULL, NULL, ''),
('cr_importacio', 'fec_estm_dspch', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'Fecha Estimada Despacho'),
('cr_importacio', 'factura_prov', 'varchar', 'NO', '', 15, NULL, NULL, NULL, 'Factura Proveedor'),
('cr_importacio', 'fec_fac_prov', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'Fecha Factura Proveedor'),
('cr_importacio', 'trm_fac_prov_usd', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'fec_entrga_fac', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'vr_unt_prov', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'multiplic', 'decimal', 'NO', '', NULL, 6, 4, NULL, ''),
('cr_importacio', 'vr_unt_prov_multip', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'total_exw', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'vr_inland', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'descuentos', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'vr_fob', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'nro_wh', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'vr_flete_int_usd', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'forwarder', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'doc_transp', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_importacio', 'fac_forwarder', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_importacio', 'fec_entrga_fac_forw', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'pais_origen', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'ciudad_destino', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'modo_transprt', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'fec_ing_colmbia', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'vr_seguro_transprt', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'cif_usd', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'cif_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'partida_arancel', 'varchar', 'NO', 'MUL', 30, NULL, NULL, NULL, ''),
('cr_importacio', 'arancel_%', 'decimal', 'NO', '', NULL, 6, 4, NULL, ''),
('cr_importacio', 'vr_arancel_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'vr_iva_cop_estim', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'total_imptos_estim', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'formula_estim', 'decimal', 'NO', '', NULL, 6, 4, NULL, ''),
('cr_importacio', 'fc_estim_pag_impts', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'sem_estim_pag_impts', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'agencia_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'nro_fact_agencia', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_importacio', 'agencia_aduanas', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_importacio', 'fec_entrga_fac_agen', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'alma_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'nro_fact_alma', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_importacio', 'almacenaje', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'fec_entrga_fac_alma', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'transp_local_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'nro_fac_transp', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_importacio', 'transp_local', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'fec_entrga_fac_transp', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_importacio', 'sem_llegada', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'lugar_llegada', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'costo_total_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'costo_unit_cop', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_importacio', 'multiplic_final', 'decimal', 'NO', '', NULL, 6, 4, NULL, ''),
('cr_importacio', 'dias_importac', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'dias_para_entrega', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_importacio', 'seguimiento', 'varchar', 'NO', '', 200, NULL, NULL, NULL, ''),
('cr_importacio', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('cr_importacio', 'f_ult_mod', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('cr_seg_imprt', 'id_po', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_seg_imprt', 'id_etapa', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('cr_seg_imprt', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'estado_etapa', 'varchar', 'NO', '', 20, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'documento', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'fecha_docum', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'fec_entrgadoc', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('cr_seg_imprt', 'valor_total', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('cr_seg_imprt', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('cr_seg_imprt', 'fec_grabacion', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('diccionario_tablas', 'table_name', 'varchar', 'NO', '', 64, NULL, NULL, NULL, ''),
('diccionario_tablas', 'column_name', 'varchar', 'NO', '', 64, NULL, NULL, NULL, ''),
('diccionario_tablas', 'data_type', 'varchar', 'NO', '', 64, NULL, NULL, NULL, ''),
('diccionario_tablas', 'is_nullable', 'varchar', 'NO', '', 3, NULL, NULL, NULL, ''),
('diccionario_tablas', 'column_key', 'varchar', 'NO', '', 3, NULL, NULL, NULL, ''),
('diccionario_tablas', 'character_maximum_length', 'bigint', 'YES', '', NULL, 19, 0, 'NULL', ''),
('diccionario_tablas', 'numeric_precision', 'bigint', 'YES', '', NULL, 19, 0, 'NULL', ''),
('diccionario_tablas', 'numeric_scale', 'bigint', 'YES', '', NULL, 19, 0, 'NULL', ''),
('diccionario_tablas', 'column_default', 'longtext', 'YES', '', 4294967295, NULL, NULL, 'NULL', ''),
('diccionario_tablas', 'column_comment', 'varchar', 'NO', '', 60, NULL, NULL, NULL, ''),
('diccio_foreign', 'id', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign', 'for_name', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign', 'ref_name', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign', 'n_col', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('diccio_foreign', 'type', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('diccio_foreign_cols', 'id', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign_cols', 'for_col_name', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign_cols', 'ref_col_name', 'varchar', 'NO', '', 193, NULL, NULL, NULL, ''),
('diccio_foreign_cols', 'pos', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('fp_utilidad', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, 'Código del Item'),
('fp_utilidad', 'porc_utild', 'decimal', 'NO', '', NULL, 5, 2, NULL, 'Porcentaje de Utilidad'),
('fp_utilidad', 'dscto_max_u', 'decimal', 'NO', '', NULL, 5, 2, NULL, 'Dto. Max. Utilidad'),
('fr_cartera', 'id_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('fr_cartera', 'vr_dia', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('fr_cartera', 'vr_30d', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('fr_cartera', 'vr_60d', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('fr_cartera', 'vr_90d', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('fr_cartera', 'vr_90+d', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('fr_cartera', 'vr_total', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('gr_analisisdt', 'id_consec', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('gr_analisisdt', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('gr_analisisdt', 'codcarac', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('gr_analisisdt', 'vr_carac', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('gr_analisism', 'id_consec', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('gr_analisism', 'fechora', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('gr_analisism', 'id_fuente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('gr_analisism', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('gr_analisism', 'area', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('gr_analisism', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('gr_analisism', 'proyecto', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('im_bodeg', 'cod_bodega', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Código'),
('im_bodeg', 'nom_bodega', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Nombre'),
('im_bodeg', 'ciudad_bodega', 'int', 'NO', '', NULL, 10, 0, NULL, 'Ciudad'),
('im_bodeg', 'estado_bodeg', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('im_equivalen', 'coditem', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, 'codigo item'),
('im_equivalen', 'equitem', 'varchar', 'NO', '', 15, NULL, NULL, NULL, 'equivalente'),
('im_equivalen', 'stdequiv', 'int', 'NO', '', NULL, 10, 0, NULL, 'estado equivalente'),
('im_items', 'cod_item', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'Referencia'),
('im_items', 'nom_item', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Descripcion'),
('im_items', 'unidad', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, 'unidad'),
('im_items', 'grup_item', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, 'grupo'),
('im_items', 'id_proveedor', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'proveedor'),
('im_items', 'id_marca', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('im_items', 'unid_desgaste', 'int', 'NO', '', NULL, 10, 0, NULL, 'unidad desgaste'),
('im_items', 'cant_desgaste', 'int', 'NO', '', NULL, 10, 0, NULL, 'cantidad desgaste'),
('im_items', 'facturable', 'int', 'NO', '', NULL, 10, 0, NULL, 'facturable item'),
('im_items', 'area_item', 'int', 'NO', '', NULL, 10, 0, NULL, 'area por item'),
('im_items', 'tipo_item', 'int', 'NO', '', NULL, 10, 0, NULL, 'tipo de item'),
('im_items', 'num_parte', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'nro de parte'),
('im_items', 'estado_item', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('im_items', 'modelo', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('im_items', 'peso', 'varchar', 'NO', '', 30, NULL, NULL, NULL, ''),
('im_items', 'volumen', 'varchar', 'NO', '', 30, NULL, NULL, NULL, ''),
('im_items', 'dimensiones', 'varchar', 'NO', '', 40, NULL, NULL, NULL, ''),
('im_relaciones', 'codrefpal', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('im_relaciones', 'codrefparte', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('im_relaciones', 'cantidad', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('im_seriales', 'nro_serie', 'varchar', 'NO', 'PRI', 30, NULL, NULL, NULL, ''),
('im_seriales', 'cod_item', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('im_seriales', 'id_cliente', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('im_trans', 'cod_trans', 'varchar', 'NO', 'PRI', 6, NULL, NULL, NULL, 'Código Transacción'),
('im_trans', 'descrip', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción Transacción'),
('im_trans', 'consec', 'int', 'NO', '', NULL, 10, 0, NULL, 'Consecutivo Transacción'),
('im_trans', 'afecta_inve', 'tinyint', 'NO', '', NULL, 3, 0, NULL, 'Afecta Inventarios'),
('im_trans', 'estado_trans', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado'),
('ip_basicos', 'id_basico', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ip_basicos', 'descrip', 'varchar', 'NO', '', 50, NULL, NULL, NULL, 'Descripción'),
('ip_caracte', 'codcarac', 'varchar', 'NO', 'PRI', 10, NULL, NULL, NULL, 'Codigo'),
('ip_caracte', 'desccarac', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Descripcion'),
('ip_caracte', 'cod_unidad', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, 'Código unidad'),
('ip_dtbasicos', 'id_basico', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id'),
('ip_dtbasicos', 'estado', 'tinyint', 'NO', '', NULL, 3, 0, '1', 'Código'),
('ip_dtbasicos', 'dt_basico', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Valor'),
('ip_dtbasicos', 'sec_basico', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('ip_grupos', 'cod_grupo', 'varchar', 'NO', 'PRI', 10, NULL, NULL, NULL, 'Código del Grupo'),
('ip_grupos', 'nom_grupo', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Nombre del Grupo'),
('ip_grupos', 'subdivide', 'char', 'NO', '', 1, NULL, NULL, NULL, 'Subdivisión'),
('ip_lubricantes', 'cod_lubricante', 'varchar', 'NO', 'PRI', 10, NULL, NULL, NULL, 'Código del Lubricante'),
('ip_lubricantes', 'descrip_lubric', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Descripción'),
('ip_lubricantes', 'id_proveedor', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Proveedor'),
('ip_marcas', 'id_marca', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ip_marcas', 'nom_marca', 'int', 'NO', '', NULL, 10, 0, NULL, 'Nombre de la Marca'),
('ip_marcas', 'id_proveedor', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Proveedor'),
('ip_modelos', 'id_modelo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ip_modelos', 'descrip_modelo', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción'),
('ip_modelos', 'id_tipomodelo', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Tipo Modelo'),
('ip_modelos', 'id_inventario', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Inventario'),
('ip_tipomodelo', 'id_tipo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('ip_tipomodelo', 'descrip_tipo', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción'),
('ip_ubica', 'cod_item', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'Código del Item'),
('ip_ubica', 'cod_bodeg', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Código de la Bodega'),
('ip_ubica', 'cod_ubica', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Código de Ubicación'),
('ip_unidades', 'cod_unidad', 'varchar', 'NO', 'PRI', 10, NULL, NULL, NULL, 'Codigo'),
('ip_unidades', 'nom_unidad', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Descripcion'),
('ip_unidades', 'desgaste', 'tinyint', 'NO', '', NULL, 3, 0, '0', 'desgaste No'),
('ir_caracte', 'codgrup', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, ''),
('ir_caracte', 'codcarac', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, ''),
('ir_detalle_oper', 'id_operacion', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('ir_detalle_oper', 'id_detalle', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_detalle_oper', 'origen', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_detalle_oper', 'destino', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_detalle_oper', 'cod_item', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('ir_detalle_oper', 'cantidad', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('ir_detalle_oper', 'cantidad_entregada', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('ir_detalle_oper', 'costo', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('ir_detalle_oper', 'valor', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('ir_detalle_oper', 'iva', 'decimal', 'NO', '', NULL, 4, 2, NULL, ''),
('ir_detalle_oper', 'fec_entrega_item', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('ir_operaciones', 'id_operacion', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'cod_trans', 'varchar', 'NO', 'MUL', 6, NULL, NULL, NULL, 'Transaccion'),
('ir_operaciones', 'numero_trans', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'version', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'fecha_registro', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('ir_operaciones', 'fecha_entrega', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('ir_operaciones', 'fecha_vence', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('ir_operaciones', 'trans_base', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('ir_operaciones', 'id_suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'codemple', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'id_area', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'c_costo', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'origen', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'destino', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'trm', 'decimal', 'NO', '', NULL, 7, 2, NULL, ''),
('ir_operaciones', 'subtotal', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('ir_operaciones', 'iva_total', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('ir_operaciones', 'descuento', 'decimal', 'NO', '', NULL, 4, 2, NULL, ''),
('ir_operaciones', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('ir_operaciones', 'num_antiguo_trans', 'varchar', 'NO', '', 12, NULL, NULL, NULL, ''),
('ir_operaciones', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'id_financia', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_operaciones', 'terminospago', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('ir_salinve', 'cod_item', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('ir_salinve', 'codbodeg', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('ir_salinve', 'saldo', 'decimal', 'NO', '', NULL, 10, 3, NULL, ''),
('ir_salinve', 'costo', 'decimal', 'NO', '', NULL, 15, 2, NULL, ''),
('nm_contactos', 'id_sucursal', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Num. Identif'),
('nm_contactos', 'id_contacto', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('nm_contactos', 'cc_contacto', 'decimal', 'NO', '', NULL, 15, 0, NULL, 'id Sucursal'),
('nm_contactos', 'nom_contacto', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Nombre Conctacto'),
('nm_contactos', 'cargo', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_contactos', 'tel_contacto', 'varchar', 'NO', '', 35, NULL, NULL, NULL, 'Telef. Contacto'),
('nm_contactos', 'email', 'varchar', 'NO', '', 100, NULL, NULL, NULL, ''),
('nm_empleados', 'codemple', 'varchar', 'NO', 'PRI', 15, NULL, NULL, NULL, 'codigo'),
('nm_empleados', 'fecha_ingreso', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'fecha ingreso'),
('nm_empleados', 'fecha_retiro', 'date', 'YES', '', NULL, NULL, NULL, 'NULL', 'fecha retiro'),
('nm_empleados', 'id_estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'estado'),
('nm_empleados', 'numid', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, 'Nit Empleado'),
('nm_empleados', 'id_cargo', 'varchar', 'NO', 'MUL', 10, NULL, NULL, NULL, 'cargo'),
('nm_empleados', 'id_nivel', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_juridicas', 'numid', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, ''),
('nm_juridicas', 'razon_social', 'varchar', 'NO', '', 120, NULL, NULL, NULL, ''),
('nm_nits', 'numid', 'decimal', 'NO', 'PRI', NULL, 15, 0, NULL, ''),
('nm_nits', 'dv', 'int', 'NO', '', NULL, 10, 0, NULL, 'digito verif'),
('nm_nits', 'idclase', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('nm_nits', 'stdnit', 'int', 'NO', '', NULL, 10, 0, NULL, 'estado del nit'),
('nm_nits', 'tipo_per', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_nits', 'actividad', 'varchar', 'NO', 'MUL', 6, NULL, NULL, NULL, ''),
('nm_nits', 'tipo_identidad', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_personas', 'numid', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, ''),
('nm_personas', 'apellidos', 'varchar', 'NO', '', 40, NULL, NULL, NULL, ''),
('nm_personas', 'nombres', 'varchar', 'NO', '', 40, NULL, NULL, NULL, ''),
('nm_personas', 'sexo', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_personas', 'est_civil', 'int', 'NO', '', NULL, 10, 0, NULL, 'Estado Civil'),
('nm_personas', 'fecha_naci', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('nm_personas', 'tipo_sangre', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_sucursal', 'id_sucursal', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('nm_sucursal', 'numid', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, ''),
('nm_sucursal', 'orden', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('nm_sucursal', 'direccion', 'varchar', 'NO', '', 200, NULL, NULL, NULL, ''),
('nm_sucursal', 'telefono', 'varchar', 'NO', '', 35, NULL, NULL, NULL, ''),
('nm_sucursal', 'ciudad', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('nm_sucursal', 'pais', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('nm_sucursal', 'nom_sucur', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'nombre de sucursal'),
('nm_sucursal', 'suc_lat_gps', 'varchar', 'NO', '', 12, NULL, NULL, NULL, ''),
('nm_sucursal', 'suc_lng_gps', 'varchar', 'NO', '', 12, NULL, NULL, NULL, ''),
('np_activeco', 'codigo', 'varchar', 'NO', 'PRI', 6, NULL, NULL, NULL, ''),
('np_activeco', 'descrip', 'varchar', 'NO', '', 200, NULL, NULL, NULL, ''),
('np_cargos', 'id_cargo', 'varchar', 'NO', 'PRI', 10, NULL, NULL, NULL, 'Id'),
('np_cargos', 'nom_cargo', 'varchar', 'NO', '', 50, NULL, NULL, NULL, 'Nombre Cargo'),
('np_cargos', 'sup_cargo', 'int', 'NO', '', NULL, 10, 0, NULL, 'Cargo Superior'),
('np_cargos', 'area_cargo', 'int', 'NO', '', NULL, 10, 0, NULL, 'Area'),
('np_cargos', 'codigo_helisa', 'varchar', 'NO', '', 10, NULL, NULL, NULL, 'Código Helisa'),
('np_ciudades', 'id_ciudad', 'int', 'NO', 'PRI', NULL, 10, 0, '0', 'Id'),
('np_ciudades', 'nom_ciudad', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Nombre Ciudad'),
('np_ciudades', 'id_dpto', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Departamento'),
('np_ciudades', 'id_pais', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id País'),
('np_continen', 'id_continen', 'int', 'NO', 'PRI', NULL, 10, 0, '0', 'Id'),
('np_continen', 'nom_conti', 'varchar', 'NO', '', 25, NULL, NULL, NULL, 'Nombre'),
('np_deptos', 'id_dpto', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Código'),
('np_deptos', 'nom_dpto', 'varchar', 'NO', '', 150, NULL, NULL, NULL, 'Nombre'),
('np_deptos', 'id_pais', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Código País'),
('np_paises', 'id_pais', 'int', 'NO', 'PRI', NULL, 10, 0, '0', 'Id'),
('np_paises', 'nom_pais', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre del País'),
('np_paises', 'id_continen', 'int', 'YES', 'MUL', NULL, 10, 0, 'NULL', 'Id Continente'),
('np_paises', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Moneda'),
('np_tiponit', 'idclase', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('np_tiponit', 'clsnit', 'varchar', 'NO', '', 1, NULL, NULL, NULL, 'Clase de NIT'),
('np_tiponit', 'nomclase', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre de la Clase'),
('np_tiponit', 'tipoper', 'int', 'NO', '', NULL, 10, 0, NULL, 'Tipo de Persona'),
('sp_activid', 'codactiv', 'int', 'NO', '', NULL, 10, 0, NULL, 'Código'),
('sp_activid', 'area', 'int', 'NO', '', NULL, 10, 0, NULL, 'Area'),
('sp_activid', 'descactiv', 'varchar', 'NO', '', 150, NULL, NULL, NULL, 'Descripción'),
('sp_activid', 'id_tipoactiv', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Tipo Actividad'),
('sp_concepviaje', 'id_concep', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('sp_concepviaje', 'nom_concep', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre'),
('sp_concepviaje', 'id_tipo', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Tipo'),
('sp_estado_man', 'id_estado', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id'),
('sp_estado_man', 'descr_estado', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Descripción'),
('sp_novedades', 'cod_nove', 'varchar', 'NO', '', 5, NULL, NULL, NULL, 'Código'),
('sp_novedades', 'nom_nove', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre'),
('sp_tiempos', 'cod_tiempo', 'varchar', 'NO', '', 3, NULL, NULL, NULL, 'Código'),
('sp_tiempos', 'descr_tiempo', 'varchar', 'NO', '', 20, NULL, NULL, NULL, 'Descripción'),
('sp_tipoactiv', 'id_tipoact', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id'),
('sp_tipoactiv', 'descripact', 'varchar', 'NO', '', 80, NULL, NULL, NULL, 'Descripción'),
('sp_tipoconcep', 'id_tipo', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('sp_tipoconcep', 'nom_tipo', 'varchar', 'NO', '', 30, NULL, NULL, NULL, 'Nombre'),
('sr_ctr_tecnicos', 'cod_emple', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_ctr_tecnicos', 'orden_serv', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'ctro_costo', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'fechora_ini', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'codactiv', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_ctr_tecnicos', 'id_estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_ctr_tecnicos', 'hr_empleado', 'decimal', 'NO', '', NULL, 5, 2, NULL, ''),
('sr_ctr_tecnicos', 'cod_nove', 'varchar', 'NO', '', 5, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'fechora_fin', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'observs', 'text', 'NO', '', 65535, NULL, NULL, NULL, ''),
('sr_ctr_tecnicos', 'lat_gps', 'float', 'NO', '', NULL, 10, 6, NULL, 'Latitud'),
('sr_ctr_tecnicos', 'lng_gps', 'float', 'NO', '', NULL, 10, 6, NULL, 'Longitud'),
('sr_gastosviaje', 'id_consec', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('sr_gastosviaje', 'fecha', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_gastosviaje', 'cod_ermple', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_gastosviaje', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_gastosviaje', 'orden_serv', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('sr_gastosviaje', 'ctro_costo', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('sr_gastosviaje', 'id_concep', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_gastosviaje', 'id_proveedor', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_gastosviaje', 'detalle', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('sr_infortec', 'id_consec', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('sr_infortec', 'fechora', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('sr_infortec', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_infortec', 'orden_sev', 'varchar', 'NO', '', 10, NULL, NULL, NULL, ''),
('sr_infortec', 'codactiv', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_infortec', 'observs', 'text', 'NO', '', 65535, NULL, NULL, NULL, ''),
('sr_infortec', 'grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_prog_mant', 'id_prog', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_mant', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_prog_mant', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_mant', 'equipo', 'varchar', 'NO', '', 30, NULL, NULL, NULL, ''),
('sr_prog_mant', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_prog_mant', 'nro_parte', 'varchar', 'NO', '', 30, NULL, NULL, NULL, ''),
('sr_prog_mant', 'codactiv', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_mant', 'fec_ult_mant', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_prog_mant', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_prog_mant', 'fec_prox_mant', 'date', 'NO', '', NULL, NULL, NULL, NULL, 'Fecha Prox Mantto'),
('sr_prog_mant', 'fec_modif', 'datetime', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_prog_mant', 'nro_serie', 'varchar', 'NO', '', 30, NULL, NULL, NULL, ''),
('sr_prog_vis', 'id_consec', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_vis', 'fecha_prob', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_prog_vis', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_vis', 'equipo', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('sr_prog_vis', 'parte', 'varchar', 'NO', '', 40, NULL, NULL, NULL, ''),
('sr_prog_vis', 'cod_emple', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('sr_prog_vis', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('sr_prog_vis', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('sr_prog_vis', 'orden_serv', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vh_cotizapdf', 'nro_cot', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vh_cotizapdf', 'version', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vh_cotizapdf', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vh_cotizapdf', 'fechora_pdf', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('vm_dsctos_especiales', 'cliente', 'decimal', 'NO', '', NULL, 15, 0, NULL, ''),
('vm_dsctos_especiales', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vm_dsctos_especiales', 'dscto_%', 'decimal', 'NO', '', NULL, 5, 2, NULL, ''),
('vp_dscto_vol', 'id_rol', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Rol'),
('vp_dscto_vol', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Moneda'),
('vp_dscto_vol', 'tope', 'int', 'NO', '', NULL, 10, 0, NULL, 'Tope'),
('vp_dscto_vol', 'margen_dscto', 'decimal', 'NO', '', NULL, 5, 2, NULL, 'Margen de descuento'),
('vp_financia', 'id_financia', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('vp_financia', 'descr_tope', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción del Tope'),
('vp_financia', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, 'Id Moneda'),
('vp_financia', 'margen', 'int', 'NO', '', NULL, 10, 0, NULL, 'Porcentaje de Desfase del Tope'),
('vp_limites', 'id_rol', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, 'Id Rol'),
('vp_limites', 'minimo', 'decimal', 'NO', '', NULL, 4, 2, NULL, 'Mínimo'),
('vp_limites', 'maximo', 'decimal', 'NO', '', NULL, 4, 2, NULL, 'Máximo'),
('vp_terminospago', 'id_termino', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, 'Id'),
('vp_terminospago', 'descrip', 'varchar', 'NO', '', 40, NULL, NULL, NULL, 'Descripción'),
('vp_terminospago', 'dias', 'int', 'NO', '', NULL, 10, 0, NULL, 'Días'),
('vr_cotiza', 'id_consecot', 'int', 'NO', 'PRI', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'nro_cot', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'version', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'fecha_ini', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('vr_cotiza', 'suc_cliente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'id_contacto', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'fecha_vence', 'date', 'NO', '', NULL, NULL, NULL, NULL, ''),
('vr_cotiza', 'id_moneda', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'subtotal', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('vr_cotiza', 'iva', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('vr_cotiza', 'descuento', 'decimal', 'NO', '', NULL, 4, 2, NULL, ''),
('vr_cotiza', 'termn_pago', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'autoriza', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vr_cotiza', 'estado', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotiza', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vr_cotizadet', 'id_consecot', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('vr_cotizadet', 'version', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotizadet', 'orden', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotizadet', 'opcion', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotizadet', 'cod_item', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vr_cotizadet', 'descrip', 'varchar', 'NO', '', 200, NULL, NULL, NULL, ''),
('vr_cotizadet', 'cantidad', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_cotizadet', 'valor_unit', 'decimal', 'NO', '', NULL, 12, 2, NULL, ''),
('vr_requerim', 'id_fuente', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_requerim', 'fechora', 'timestamp', 'NO', '', NULL, NULL, NULL, 'current_timestamp()', ''),
('vr_requerim', 'nom_cliente', 'varchar', 'NO', '', 80, NULL, NULL, NULL, ''),
('vr_requerim', 'nit_cliente', 'decimal', 'NO', 'MUL', NULL, 15, 0, NULL, ''),
('vr_requerim', 'suc_cliente', 'int', 'NO', 'MUL', NULL, 10, 0, NULL, ''),
('vr_requerim', 'cod_item', 'varchar', 'NO', 'MUL', 15, NULL, NULL, NULL, ''),
('vr_requerim', 'cantidad', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_requerim', 'observs', 'text', 'NO', '', 65535, NULL, NULL, NULL, ''),
('vr_requerim', 'cod_grabador', 'varchar', 'NO', '', 15, NULL, NULL, NULL, ''),
('vr_requerim', 'area', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_requerim', 'id_contacto', 'int', 'NO', '', NULL, 10, 0, NULL, ''),
('vr_requerimdet', 'id_requerim', 'int', 'YES', 'MUL', NULL, 10, 0, 'NULL', ''),
('vr_requerimdet', 'cod_item', 'varchar', 'YES', 'MUL', 15, NULL, NULL, 'NULL', ''),
('vr_requerimdet', 'cantidad', 'int', 'YES', '', NULL, 10, 0, 'NULL', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diccio_foreign`
--

CREATE TABLE `diccio_foreign` (
  `id` varchar(193) NOT NULL,
  `for_name` varchar(193) NOT NULL,
  `ref_name` varchar(193) NOT NULL,
  `n_col` int(11) UNSIGNED NOT NULL,
  `type` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `diccio_foreign`
--

INSERT INTO `diccio_foreign` (`id`, `for_name`, `ref_name`, `n_col`, `type`) VALUES
('cubo/fk_activecon', 'cubo/nm_nits', 'cubo/np_activeco', 1, 0),
('cubo/fk_alerta', 'cubo/am_alertas', 'cubo/ap_tipoalerta', 1, 0),
('cubo/fk_arancelimport', 'cubo/cr_importacio', 'cubo/cp_arancel', 1, 0),
('cubo/fk_basico', 'cubo/ip_dtbasicos', 'cubo/ip_basicos', 1, 0),
('cubo/fk_bodegau', 'cubo/ip_ubica', 'cubo/im_bodeg', 1, 0),
('cubo/fk_bodegs', 'cubo/ir_salinve', 'cubo/im_bodeg', 1, 0),
('cubo/fk_caracc', 'cubo/ir_caracte', 'cubo/ip_caracte', 1, 0),
('cubo/fk_cargoe', 'cubo/nm_empleados', 'cubo/np_cargos', 1, 0),
('cubo/fk_cargorol', 'cubo/ap_roles', 'cubo/np_cargos', 1, 0),
('cubo/fk_cia_import', 'cubo/cr_importacio', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_ciudadpto', 'cubo/cp_puertos', 'cubo/np_ciudades', 1, 0),
('cubo/fk_ciudestimport', 'cubo/cr_importacio', 'cubo/np_ciudades', 1, 0),
('cubo/fk_clase', 'cubo/nm_nits', 'cubo/np_tiponit', 1, 0),
('cubo/fk_clienteimprt', 'cubo/cr_importacio', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_clientesr', 'cubo/im_seriales', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_cotizadet', 'cubo/vr_cotizadet', 'cubo/vr_cotiza', 1, 0),
('cubo/fk_ctrocostoimprt', 'cubo/cr_importacio', 'cubo/ap_ctros_costo', 1, 0),
('cubo/fk_empleimprt', 'cubo/cr_importacio', 'cubo/nm_empleados', 1, 0),
('cubo/fk_etapaseg', 'cubo/cr_seg_imprt', 'cubo/cp_etapas_imp', 1, 0),
('cubo/fk_forwarderimport', 'cubo/cr_importacio', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_grupc', 'cubo/ir_caracte', 'cubo/ip_grupos', 1, 0),
('cubo/fk_grupo', 'cubo/ap_programs', 'cubo/ap_grupos', 1, 0),
('cubo/fk_grupoi', 'cubo/im_items', 'cubo/ip_grupos', 1, 0),
('cubo/fk_idciudads', 'cubo/nm_sucursal', 'cubo/np_ciudades', 1, 0),
('cubo/fk_idcontinenp', 'cubo/np_paises', 'cubo/np_continen', 1, 0),
('cubo/fk_idcotdet', 'cubo/cr_cotprovdet', 'cubo/cr_cotprov', 1, 0),
('cubo/fk_idopdet', 'cubo/ir_detalle_oper', 'cubo/ir_operaciones', 1, 0),
('cubo/fk_idpaiss', 'cubo/nm_sucursal', 'cubo/np_paises', 1, 0),
('cubo/fk_idsucursalc', 'cubo/nm_contactos', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_itemcs', 'cubo/cp_dsctos_prov', 'cubo/im_items', 1, 0),
('cubo/fk_itemdet', 'cubo/ir_detalle_oper', 'cubo/im_items', 1, 0),
('cubo/fk_itemi', 'cubo/im_equivalen', 'cubo/im_items', 1, 0),
('cubo/fk_itemr', 'cubo/im_relaciones', 'cubo/im_items', 1, 0),
('cubo/fk_itemreq', 'cubo/vr_requerim', 'cubo/im_items', 1, 0),
('cubo/fk_items', 'cubo/ir_salinve', 'cubo/im_items', 1, 0),
('cubo/fk_itemsr', 'cubo/im_seriales', 'cubo/im_items', 1, 0),
('cubo/fk_itemu', 'cubo/ip_ubica', 'cubo/im_items', 1, 0),
('cubo/fk_marcacs', 'cubo/cp_dsctos_prov', 'cubo/ip_marcas', 1, 0),
('cubo/fk_marcasi', 'cubo/im_items', 'cubo/ip_marcas', 1, 0),
('cubo/fk_modeloi', 'cubo/im_items', 'cubo/ip_modelos', 1, 0),
('cubo/fk_modelot', 'cubo/ip_modelos', 'cubo/ip_tipomodelo', 1, 0),
('cubo/fk_nitreq', 'cubo/vr_requerim', 'cubo/nm_nits', 1, 0),
('cubo/fk_numide', 'cubo/nm_empleados', 'cubo/nm_nits', 1, 0),
('cubo/fk_numidj', 'cubo/nm_juridicas', 'cubo/nm_nits', 1, 0),
('cubo/fk_numidp', 'cubo/nm_personas', 'cubo/nm_nits', 1, 0),
('cubo/fk_numids', 'cubo/nm_sucursal', 'cubo/nm_nits', 1, 0),
('cubo/fk_numidu', 'cubo/am_usuarios', 'cubo/nm_nits', 1, 0),
('cubo/fk_pais', 'cubo/np_deptos', 'cubo/np_paises', 1, 0),
('cubo/fk_paisoriimport', 'cubo/cr_importacio', 'cubo/np_paises', 1, 0),
('cubo/fk_paispto', 'cubo/cp_puertos', 'cubo/np_paises', 1, 0),
('cubo/fk_permpro', 'cubo/ar_roles', 'cubo/ap_permpro', 1, 0),
('cubo/fk_per_opc', 'cubo/ap_permpro', 'cubo/ap_opc_permi', 1, 0),
('cubo/fk_pocst', 'cubo/cr_costos_imprt', 'cubo/cr_importacio', 1, 0),
('cubo/fk_poseg', 'cubo/cr_seg_imprt', 'cubo/cr_importacio', 1, 0),
('cubo/fk_prog_per', 'cubo/ap_permpro', 'cubo/ap_programs', 1, 0),
('cubo/fk_proveecs', 'cubo/cp_dsctos_prov', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_proveedorlub', 'cubo/ip_lubricantes', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_proveeimprt', 'cubo/cr_importacio', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_rol', 'cubo/ar_roles', 'cubo/ap_roles', 1, 0),
('cubo/fk_roldsct', 'cubo/vp_dscto_vol', 'cubo/ap_roles', 1, 0),
('cubo/fk_rollim', 'cubo/vp_limites', 'cubo/ap_roles', 1, 0),
('cubo/fk_rolusu', 'cubo/am_usuarios', 'cubo/ap_roles', 1, 0),
('cubo/fk_sucreq', 'cubo/vr_requerim', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_sucuri', 'cubo/im_items', 'cubo/nm_sucursal', 1, 0),
('cubo/fk_termn_pagocot', 'cubo/vr_cotiza', 'cubo/vp_terminospago', 1, 0),
('cubo/fk_tipocontened', 'cubo/cp_contened', 'cubo/cp_tipocontenedor', 1, 0),
('cubo/fk_tipotransimport', 'cubo/cr_importacio', 'cubo/cp_tipo_transporte', 1, 0),
('cubo/fk_transop', 'cubo/ir_operaciones', 'cubo/im_trans', 1, 0),
('cubo/fk_unidadc', 'cubo/ip_caracte', 'cubo/ip_unidades', 1, 0),
('cubo/fk_unidadi', 'cubo/im_items', 'cubo/ip_unidades', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diccio_foreign_cols`
--

CREATE TABLE `diccio_foreign_cols` (
  `id` varchar(193) NOT NULL,
  `for_col_name` varchar(193) NOT NULL,
  `ref_col_name` varchar(193) NOT NULL,
  `pos` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `diccio_foreign_cols`
--

INSERT INTO `diccio_foreign_cols` (`id`, `for_col_name`, `ref_col_name`, `pos`) VALUES
('cubo/fk_activecon', 'actividad', 'codigo', 0),
('cubo/fk_alerta', 'id_tipoalerta', 'id_tipoalerta', 0),
('cubo/fk_arancelimport', 'partida_arancel', 'cod_arancel', 0),
('cubo/fk_basico', 'id_basico', 'id_basico', 0),
('cubo/fk_bodegau', 'cod_bodeg', 'cod_bodega', 0),
('cubo/fk_bodegs', 'codbodeg', 'cod_bodega', 0),
('cubo/fk_caracc', 'codcarac', 'codcarac', 0),
('cubo/fk_cargoe', 'id_cargo', 'id_cargo', 0),
('cubo/fk_cargorol', 'id_cargo', 'id_cargo', 0),
('cubo/fk_cia_import', 'agencia_aduanas', 'id_sucursal', 0),
('cubo/fk_ciudadpto', 'ciudad', 'id_ciudad', 0),
('cubo/fk_ciudestimport', 'ciudad_destino', 'id_ciudad', 0),
('cubo/fk_clase', 'idclase', 'idclase', 0),
('cubo/fk_clienteimprt', 'cliente', 'id_sucursal', 0),
('cubo/fk_clientesr', 'id_cliente', 'id_sucursal', 0),
('cubo/fk_cotizadet', 'id_consecot', 'id_consecot', 0),
('cubo/fk_ctrocostoimprt', 'ctro_costo', 'cod_centro', 0),
('cubo/fk_empleimprt', 'codemple', 'codemple', 0),
('cubo/fk_etapaseg', 'id_etapa', 'id_etapa', 0),
('cubo/fk_forwarderimport', 'forwarder', 'id_sucursal', 0),
('cubo/fk_grupc', 'codgrup', 'cod_grupo', 0),
('cubo/fk_grupo', 'grupo', 'cod_grupo', 0),
('cubo/fk_grupoi', 'grup_item', 'cod_grupo', 0),
('cubo/fk_idciudads', 'ciudad', 'id_ciudad', 0),
('cubo/fk_idcontinenp', 'id_continen', 'id_continen', 0),
('cubo/fk_idcotdet', 'id_cotprov', 'id_cotprov', 0),
('cubo/fk_idopdet', 'id_operacion', 'id_operacion', 0),
('cubo/fk_idpaiss', 'pais', 'id_pais', 0),
('cubo/fk_idsucursalc', 'id_sucursal', 'id_sucursal', 0),
('cubo/fk_itemcs', 'cod_item', 'cod_item', 0),
('cubo/fk_itemdet', 'cod_item', 'cod_item', 0),
('cubo/fk_itemi', 'coditem', 'cod_item', 0),
('cubo/fk_itemr', 'codrefpal', 'cod_item', 0),
('cubo/fk_itemreq', 'cod_item', 'cod_item', 0),
('cubo/fk_items', 'cod_item', 'cod_item', 0),
('cubo/fk_itemsr', 'cod_item', 'cod_item', 0),
('cubo/fk_itemu', 'cod_item', 'cod_item', 0),
('cubo/fk_marcacs', 'id_marca', 'id_marca', 0),
('cubo/fk_marcasi', 'id_marca', 'id_marca', 0),
('cubo/fk_modeloi', 'modelo', 'id_modelo', 0),
('cubo/fk_modelot', 'id_tipomodelo', 'id_tipo', 0),
('cubo/fk_nitreq', 'nit_cliente', 'numid', 0),
('cubo/fk_numide', 'numid', 'numid', 0),
('cubo/fk_numidj', 'numid', 'numid', 0),
('cubo/fk_numidp', 'numid', 'numid', 0),
('cubo/fk_numids', 'numid', 'numid', 0),
('cubo/fk_numidu', 'nit', 'numid', 0),
('cubo/fk_pais', 'id_pais', 'id_pais', 0),
('cubo/fk_paisoriimport', 'pais_origen', 'id_pais', 0),
('cubo/fk_paispto', 'pais', 'id_pais', 0),
('cubo/fk_permpro', 'id_permpro', 'id_permpro', 0),
('cubo/fk_per_opc', 'permpro', 'cod_opcion', 0),
('cubo/fk_pocst', 'id_po', 'id_po', 0),
('cubo/fk_poseg', 'id_po', 'id_po', 0),
('cubo/fk_prog_per', 'codprog', 'codprog', 0),
('cubo/fk_proveecs', 'id_proveedor', 'id_sucursal', 0),
('cubo/fk_proveedorlub', 'id_proveedor', 'id_sucursal', 0),
('cubo/fk_proveeimprt', 'proveedor', 'id_sucursal', 0),
('cubo/fk_rol', 'id_rol', 'id_rol', 0),
('cubo/fk_roldsct', 'id_rol', 'id_rol', 0),
('cubo/fk_rollim', 'id_rol', 'id_rol', 0),
('cubo/fk_rolusu', 'id_rol', 'id_rol', 0),
('cubo/fk_sucreq', 'suc_cliente', 'id_sucursal', 0),
('cubo/fk_sucuri', 'id_proveedor', 'id_sucursal', 0),
('cubo/fk_termn_pagocot', 'termn_pago', 'id_termino', 0),
('cubo/fk_tipocontened', 'tipo', 'id_tipo', 0),
('cubo/fk_tipotransimport', 'modo_transprt', 'id_tipotrans', 0),
('cubo/fk_transop', 'cod_trans', 'cod_trans', 0),
('cubo/fk_unidadc', 'cod_unidad', 'cod_unidad', 0),
('cubo/fk_unidadi', 'unidad', 'cod_unidad', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fp_utilidad`
--

CREATE TABLE `fp_utilidad` (
  `cod_item` varchar(15) NOT NULL COMMENT 'Código del Item',
  `porc_utild` decimal(5,2) NOT NULL COMMENT 'Porcentaje de Utilidad',
  `dscto_max_u` decimal(5,2) NOT NULL COMMENT 'Dto. Max. Utilidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Margen de Utilidad por item';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fr_cartera`
--

CREATE TABLE `fr_cartera` (
  `id_cliente` int(11) NOT NULL,
  `vr_dia` decimal(12,2) NOT NULL,
  `vr_30d` decimal(12,2) NOT NULL,
  `vr_60d` decimal(12,2) NOT NULL,
  `vr_90d` decimal(12,2) NOT NULL,
  `vr_90+d` decimal(12,2) NOT NULL,
  `vr_total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Cartera por edades de Helisa';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gr_analisisdt`
--

CREATE TABLE `gr_analisisdt` (
  `id_consec` int(11) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `codcarac` varchar(10) NOT NULL,
  `vr_carac` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Análisis en Detalle';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gr_analisism`
--

CREATE TABLE `gr_analisism` (
  `id_consec` int(11) NOT NULL,
  `fechora` datetime NOT NULL,
  `id_fuente` int(11) NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `proyecto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Maestro Análisis de Proyecto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_bodeg`
--

CREATE TABLE `im_bodeg` (
  `cod_bodega` int(11) NOT NULL COMMENT 'Código',
  `nom_bodega` varchar(40) NOT NULL COMMENT 'Nombre',
  `ciudad_bodega` int(11) NOT NULL COMMENT 'Ciudad',
  `estado_bodeg` int(11) NOT NULL COMMENT 'Estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='bodegas';

--
-- Volcado de datos para la tabla `im_bodeg`
--

INSERT INTO `im_bodeg` (`cod_bodega`, `nom_bodega`, `ciudad_bodega`, `estado_bodeg`) VALUES
(1, 'Principal Bogota - Galerias', 11001, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_equivalen`
--

CREATE TABLE `im_equivalen` (
  `coditem` varchar(15) NOT NULL COMMENT 'codigo item',
  `equitem` varchar(15) NOT NULL COMMENT 'equivalente',
  `stdequiv` int(11) NOT NULL COMMENT 'estado equivalente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Equivalentes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_items`
--

CREATE TABLE `im_items` (
  `cod_item` varchar(15) NOT NULL COMMENT 'Referencia',
  `nom_item` varchar(80) NOT NULL COMMENT 'Descripcion',
  `unidad` varchar(10) NOT NULL COMMENT 'unidad',
  `grup_item` varchar(10) NOT NULL COMMENT 'grupo',
  `id_proveedor` int(11) NOT NULL COMMENT 'proveedor',
  `id_marca` int(11) NOT NULL,
  `unid_desgaste` int(11) NOT NULL COMMENT 'unidad desgaste',
  `cant_desgaste` int(11) NOT NULL COMMENT 'cantidad desgaste',
  `facturable` int(11) NOT NULL COMMENT 'facturable item',
  `area_item` int(11) NOT NULL COMMENT 'area por item',
  `articulo` int(11) NOT NULL,
  `tipo_item` int(11) NOT NULL COMMENT 'tipo de item',
  `num_parte` varchar(30) NOT NULL COMMENT 'nro de parte',
  `estado_item` int(11) NOT NULL,
  `precio_vta` decimal(12,2) NOT NULL,
  `modelo` int(11) NOT NULL,
  `linea` int(11) NOT NULL,
  `peso` varchar(30) NOT NULL,
  `volumen` varchar(30) NOT NULL,
  `dimensiones` varchar(40) NOT NULL,
  `precio_vta_usd` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Items de Inventario';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_relaciones`
--

CREATE TABLE `im_relaciones` (
  `codrefpal` varchar(15) NOT NULL,
  `codrefparte` varchar(15) NOT NULL,
  `cantidad` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Relaciones equipo - partes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_seriales`
--

CREATE TABLE `im_seriales` (
  `nro_serie` varchar(30) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Maestro de Equipos Serializados ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `im_trans`
--

CREATE TABLE `im_trans` (
  `cod_trans` varchar(6) NOT NULL COMMENT 'Código Transacción',
  `descrip` varchar(40) NOT NULL COMMENT 'Descripción Transacción',
  `consec` int(11) NOT NULL COMMENT 'Consecutivo Transacción',
  `afecta_inve` tinyint(1) NOT NULL COMMENT 'Afecta Inventarios',
  `estado_trans` int(11) NOT NULL COMMENT 'Estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transacciomes ';

--
-- Volcado de datos para la tabla `im_trans`
--

INSERT INTO `im_trans` (`cod_trans`, `descrip`, `consec`, `afecta_inve`, `estado_trans`) VALUES
('ODC', 'Orden de Compra a Prov. Nal.', 0, 0, 0),
('PO', 'Purchase Order (Orden de Compra Ext)', 0, 0, 0),
('REQ', 'Requerimiento', 0, 0, 0),
('SIPV', 'Solicitud Interna Precio de Venta', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_articulos`
--

CREATE TABLE `ip_articulos` (
  `id_articulo` int(11) NOT NULL,
  `descrip` varchar(80) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Articulos de Referencias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_basicos`
--

CREATE TABLE `ip_basicos` (
  `id_basico` int(11) NOT NULL,
  `descrip` varchar(50) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Parámetros Básicos';

--
-- Volcado de datos para la tabla `ip_basicos`
--

INSERT INTO `ip_basicos` (`id_basico`, `descrip`) VALUES
(1, 'sexo'),
(2, 'estado civil'),
(3, 'tipo de sangre'),
(4, 'area'),
(5, 'Tipo de Persona'),
(6, 'Cliente / Proveedor'),
(7, 'Ubicaciones'),
(8, 'Estado de Items'),
(9, 'Estado de Nit'),
(10, 'Estado de Sucursal'),
(11, 'monedas'),
(12, 'Estado de Transaccion'),
(13, 'Fuentes'),
(14, 'Tipo de Requerimiento'),
(15, 'Lineas Misionales'),
(16, 'Modo de Importación'),
(17, 'Alertas'),
(18, 'Estados de Usuarios'),
(19, 'Estado de Roles'),
(20, 'Estado de Programas'),
(21, 'Tipo de Entidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_caracte`
--

CREATE TABLE `ip_caracte` (
  `codcarac` varchar(10) NOT NULL COMMENT 'Codigo',
  `desccarac` varchar(30) NOT NULL COMMENT 'Descripcion',
  `cod_unidad` varchar(10) NOT NULL COMMENT 'Código unidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Caracteristicas';

--
-- Volcado de datos para la tabla `ip_caracte`
--

INSERT INTO `ip_caracte` (`codcarac`, `desccarac`, `cod_unidad`) VALUES
('HP', 'Horse Power', 'UND'),
('kWh', 'Kilovatios Hora', 'UND'),
('RFG', 'Refrigerante', 'UND'),
('RPM', 'Revoluciones Por Minuto', 'UND'),
('TBR', 'Tuberia', 'UND'),
('V/Ph/Hz', 'Voltaje', 'UND');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_dtbasicos`
--

CREATE TABLE `ip_dtbasicos` (
  `id_basico` int(11) NOT NULL COMMENT 'Id',
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Código',
  `dt_basico` varchar(30) NOT NULL COMMENT 'Valor',
  `sec_basico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='DT Básicos';

--
-- Volcado de datos para la tabla `ip_dtbasicos`
--

INSERT INTO `ip_dtbasicos` (`id_basico`, `estado`, `dt_basico`, `sec_basico`) VALUES
(1, 1, 'Masculino', 1),
(1, 1, 'Femenino', 2),
(1, 1, 'Indefinido', 3),
(2, 1, 'Soltero', 4),
(2, 1, 'Casado', 5),
(2, 1, 'Union Libre', 6),
(2, 1, 'Separado', 7),
(2, 1, 'Divorciado', 8),
(2, 1, 'Viudo', 9),
(3, 1, 'A+', 10),
(3, 1, 'A-', 11),
(3, 1, 'B+', 12),
(3, 1, 'B-', 13),
(3, 1, 'AB+', 14),
(3, 1, 'AB-', 15),
(3, 1, 'O+', 16),
(3, 1, 'O-', 17),
(4, 1, 'Financiero', 18),
(4, 1, 'Ingenieria', 19),
(4, 1, 'Comercial', 20),
(4, 1, 'Compras y Logistica', 21),
(4, 1, 'Serv.Mantenim.Tecnico', 22),
(5, 1, 'Persona Natural', 23),
(5, 1, 'Persona Juridica', 24),
(6, 1, 'Cliente', 25),
(6, 1, 'Proveedor', 26),
(6, 1, 'Cliente-Proveedor', 27),
(6, 1, 'empresa', 28),
(7, 1, 'Principal Bogota-Galerias', 29),
(8, 1, 'Item Activo', 30),
(8, 1, 'Item Obsoleto', 31),
(9, 1, 'Nit Activo', 32),
(10, 1, 'Sucursal Activa', 33),
(11, 1, 'COP Colombia', 34),
(11, 1, 'USD Dolar EEUU', 35),
(11, 1, 'EUR Euros', 36),
(12, 1, 'Transaccion Activa', 37),
(13, 1, 'Telefono', 38),
(13, 1, 'Email', 39),
(13, 1, 'Pagina Web', 40),
(13, 1, 'Whatsapp', 41),
(13, 1, 'Referido', 42),
(14, 1, 'Inventario', 43),
(14, 1, 'Equipos', 44),
(14, 1, 'Insumos', 45),
(14, 1, 'Servicios', 46),
(14, 1, 'Montajes', 47),
(14, 1, 'Administrativos', 48),
(15, 1, 'Repuestos', 49),
(15, 1, 'Servicio Mantenimiento', 50),
(15, 1, 'Equipos', 51),
(15, 1, 'Proyectos', 52),
(16, 1, 'Ordinario/Marítimo', 53),
(16, 1, 'Aéreo', 54),
(16, 1, 'Courrier', 55),
(17, 1, 'En Compras', 56),
(17, 1, 'En Financiera', 57),
(17, 1, 'En Comercial', 58),
(17, 1, 'En Clientes', 59),
(17, 1, 'Cerrado', 60),
(18, 1, 'Activo', 61),
(18, 1, 'Bloqueado', 62),
(18, 1, 'Retirado', 63),
(4, 1, 'Gerencia', 64),
(4, 1, 'Presidencia', 65),
(19, 1, 'Activo', 66),
(19, 1, 'Bloqueado', 67),
(20, 1, 'Activo', 68),
(20, 1, 'Bloqueado', 69),
(21, 1, 'Proveedor Transporte', 70),
(21, 1, 'Proveedor Agencia CIA', 71),
(21, 1, 'E.P.S.', 72),
(21, 1, 'Proveedor de Servicios', 73),
(21, 1, 'Cliente', 74);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_grupos`
--

CREATE TABLE `ip_grupos` (
  `cod_grupo` varchar(10) NOT NULL COMMENT 'Código del Grupo',
  `nom_grupo` varchar(40) NOT NULL COMMENT 'Nombre del Grupo',
  `subdivide` char(1) NOT NULL COMMENT 'Subdivisión'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Grupos';

--
-- Volcado de datos para la tabla `ip_grupos`
--

INSERT INTO `ip_grupos` (`cod_grupo`, `nom_grupo`, `subdivide`) VALUES
('01', 'Equipos', 'S'),
('0101', 'Condensadores', 'N'),
('0102', 'Torrres de Enfriamiento', 'N'),
('0103', 'Compresores', 'N'),
('0104', 'Intercambiadores', 'N'),
('0105', 'Unidad Condensadora', 'N'),
('0106', 'Chiller', 'N'),
('0107', 'Evaporador', 'N'),
('0108', 'Maquina de Hielo', 'N'),
('0109', 'Tanque', 'N'),
('0110', 'Bomba', 'N'),
('0111', 'IQF', 'N'),
('0112', 'Banco de Hielo', 'N'),
('02', 'Repuestos', 'S'),
('03', 'Serv.Mantenimiento', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_lineas`
--

CREATE TABLE `ip_lineas` (
  `id_linea` int(11) NOT NULL,
  `descrip` varchar(80) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Líneas de Referencias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_lubricantes`
--

CREATE TABLE `ip_lubricantes` (
  `cod_lubricante` varchar(10) NOT NULL COMMENT 'Código del Lubricante',
  `descrip_lubric` varchar(30) NOT NULL COMMENT 'Descripción',
  `id_proveedor` int(11) NOT NULL COMMENT 'Id Proveedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Lubricantes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_marcas`
--

CREATE TABLE `ip_marcas` (
  `id_marca` int(11) NOT NULL COMMENT 'Id',
  `nom_marca` int(11) NOT NULL COMMENT 'Nombre de la Marca',
  `id_proveedor` int(11) NOT NULL COMMENT 'Id Proveedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Marcas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_modelos`
--

CREATE TABLE `ip_modelos` (
  `id_modelo` int(11) NOT NULL COMMENT 'Id',
  `descrip_modelo` varchar(40) NOT NULL COMMENT 'Descripción',
  `id_tipomodelo` int(11) NOT NULL COMMENT 'Tipo Modelo',
  `id_inventario` int(40) NOT NULL COMMENT 'Id Inventario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Modelos de Equipos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_tipomodelo`
--

CREATE TABLE `ip_tipomodelo` (
  `id_tipo` int(11) NOT NULL COMMENT 'Id',
  `descrip_tipo` varchar(40) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Modelo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_tipos`
--

CREATE TABLE `ip_tipos` (
  `id_tipo` int(11) NOT NULL,
  `descrip` varchar(80) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Referencias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_ubica`
--

CREATE TABLE `ip_ubica` (
  `cod_item` varchar(15) NOT NULL COMMENT 'Código del Item',
  `cod_bodeg` int(11) NOT NULL COMMENT 'Código de la Bodega',
  `cod_ubica` varchar(20) NOT NULL COMMENT 'Código de Ubicación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ubicación Items Inventario';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_unidades`
--

CREATE TABLE `ip_unidades` (
  `cod_unidad` varchar(10) NOT NULL COMMENT 'Codigo',
  `nom_unidad` varchar(30) NOT NULL COMMENT 'Descripcion',
  `desgaste` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'desgaste No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Unidades de Medida';

--
-- Volcado de datos para la tabla `ip_unidades`
--

INSERT INTO `ip_unidades` (`cod_unidad`, `nom_unidad`, `desgaste`) VALUES
('AJ', 'AJUSTE', 0),
('LT', 'Litro', 0),
('UND', 'Unidad', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ir_caracte`
--

CREATE TABLE `ir_caracte` (
  `codgrup` varchar(10) NOT NULL,
  `codcarac` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Caracteristicas Grupo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ir_detalle_oper`
--

CREATE TABLE `ir_detalle_oper` (
  `id_operacion` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `cantidad_entregada` decimal(12,2) NOT NULL,
  `costo` decimal(15,2) NOT NULL,
  `valor` decimal(15,2) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `fec_entrega_item` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ir_operaciones`
--

CREATE TABLE `ir_operaciones` (
  `id_operacion` int(11) NOT NULL,
  `cod_trans` varchar(6) NOT NULL COMMENT 'Transaccion',
  `numero_trans` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_vence` date NOT NULL,
  `trans_base` varchar(10) NOT NULL,
  `id_suc_cliente` int(11) NOT NULL,
  `codemple` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `c_costo` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `trm` decimal(7,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `iva_total` decimal(15,2) NOT NULL,
  `descuento` decimal(4,2) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `num_antiguo_trans` varchar(12) NOT NULL,
  `estado` int(11) NOT NULL,
  `id_financia` int(11) NOT NULL,
  `terminospago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Operaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ir_salinve`
--

CREATE TABLE `ir_salinve` (
  `cod_item` varchar(15) NOT NULL,
  `codbodeg` int(11) NOT NULL,
  `saldo` decimal(10,3) NOT NULL,
  `costo` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='saldos inventario';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_contactos`
--

CREATE TABLE `nm_contactos` (
  `id_sucursal` int(11) NOT NULL COMMENT 'Num. Identif',
  `id_contacto` int(11) NOT NULL,
  `cc_contacto` decimal(15,0) NOT NULL COMMENT 'id Sucursal',
  `nom_contacto` varchar(80) NOT NULL COMMENT 'Nombre Conctacto',
  `cargo` varchar(20) NOT NULL,
  `tel_contacto` varchar(35) NOT NULL COMMENT 'Telef. Contacto',
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contactos';

--
-- Volcado de datos para la tabla `nm_contactos`
--

INSERT INTO `nm_contactos` (`id_sucursal`, `id_contacto`, `cc_contacto`, `nom_contacto`, `cargo`, `tel_contacto`, `email`) VALUES
(1, 1, 17316300, 'RICARDO MORA GUZMAN', 'PROPIETARIO', '', 'contador@empresa.com.co'),
(1, 2, 80206531, 'RAUL MENDOZA', 'JEFE DE OPERACIONES', '3115759658', 'operaciones@empresa.com.co');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_empleados`
--

CREATE TABLE `nm_empleados` (
  `codemple` varchar(15) NOT NULL COMMENT 'codigo',
  `fecha_ingreso` date NOT NULL COMMENT 'fecha ingreso',
  `fecha_retiro` date DEFAULT NULL COMMENT 'fecha retiro',
  `id_estado` int(11) NOT NULL COMMENT 'estado',
  `numid` varchar(20) NOT NULL COMMENT 'Nit Empleado',
  `id_cargo` varchar(10) NOT NULL COMMENT 'cargo',
  `id_nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='empleados';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_juridicas`
--

CREATE TABLE `nm_juridicas` (
  `numid` varchar(20) NOT NULL,
  `razon_social` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Personas Juridicas';

--
-- Volcado de datos para la tabla `nm_juridicas`
--

INSERT INTO `nm_juridicas` (`numid`, `razon_social`) VALUES
('17316300', 'LA EMPRESA DE RICARDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_nits`
--

CREATE TABLE `nm_nits` (
  `numid` varchar(20) NOT NULL,
  `dv` int(11) NOT NULL COMMENT 'digito verif',
  `idclase` int(11) NOT NULL,
  `stdnit` int(11) NOT NULL COMMENT 'estado del nit',
  `tipo_per` int(11) NOT NULL,
  `actividad` varchar(6) NOT NULL,
  `tipo_entidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Nits';

--
-- Volcado de datos para la tabla `nm_nits`
--

INSERT INTO `nm_nits` (`numid`, `dv`, `idclase`, `stdnit`, `tipo_per`, `actividad`, `tipo_entidad`) VALUES
('17316300', 4, 13, 32, 23, '6201', 73),
('17328718', 0, 13, 32, 23, '6201', 73),
('79405370', 7, 13, 32, 23, '6201', 73),
('79725743', 3, 13, 32, 23, '6201', 73);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_personas`
--

CREATE TABLE `nm_personas` (
  `numid` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `sexo` int(11) NOT NULL,
  `est_civil` int(11) NOT NULL COMMENT 'Estado Civil',
  `fecha_naci` date NOT NULL,
  `tipo_sangre` int(11) NOT NULL,
  `apelli_nom` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Nits Personas Naturales';

--
-- Volcado de datos para la tabla `nm_personas`
--

INSERT INTO `nm_personas` (`numid`, `apellidos`, `nombres`, `sexo`, `est_civil`, `fecha_naci`, `tipo_sangre`, `apelli_nom`) VALUES
('17316300', 'MORA GUZMAN', 'RICARDO', 0, 0, '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nm_sucursal`
--

CREATE TABLE `nm_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `numid` varchar(20) NOT NULL,
  `orden` int(11) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(35) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `pais` int(11) NOT NULL,
  `nom_sucur` varchar(30) NOT NULL COMMENT 'nombre de sucursal',
  `suc_lat_gps` varchar(20) NOT NULL,
  `suc_lng_gps` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Sucursales';

--
-- Volcado de datos para la tabla `nm_sucursal`
--

INSERT INTO `nm_sucursal` (`id_sucursal`, `numid`, `orden`, `direccion`, `telefono`, `ciudad`, `pais`, `nom_sucur`, `suc_lat_gps`, `suc_lng_gps`) VALUES
(1, '17316300', 0, 'CR 96B # 17B 40', '3108676344', 11001, 7, 'SEDE PRINCIPAL', '4.668110044488629', '-74.13999080664966');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_activeco`
--

CREATE TABLE `np_activeco` (
  `codigo` varchar(6) NOT NULL,
  `descrip` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Actividad Económica';

--
-- Volcado de datos para la tabla `np_activeco`
--

INSERT INTO `np_activeco` (`codigo`, `descrip`) VALUES
('0010', ' Asalariados.'),
('0020', 'Pensionados.'),
('0081', ' Personas Naturales sin Actividad Económica'),
('0082', ' Personas Naturales Subsidiadas por Terceros'),
('0090', ' Rentistas de Capital, solo para personas naturales.'),
('011', 'Cultivos agrícolas transitorios.'),
('0111', 'Cultivo de cereales (excepto arroz), legumbres y semillas oleaginosas.'),
('0112', 'Cultivo de arroz.'),
('0113', 'Cultivo de hortalizas, raíces y tubérculos.'),
('0114', 'Cultivo de tabaco.'),
('0115', 'Cultivo de plantas textiles.'),
('0119', 'Otros cultivos transitorios n.c.p.'),
('012', 'Cultivos agrícolas permanentes.'),
('0121', 'Cultivo de frutas tropicales y subtropicales.'),
('0122', 'Cultivo de plátano y banano.'),
('0123', 'Cultivo de café.'),
('0124', 'Cultivo de caña de azúcar.'),
('0125', 'Cultivo de flor de corte.'),
('0126', 'Cultivo de palma para aceite (palma africana) y otros frutos oleaginosos.'),
('0127', 'Cultivo de plantas con las que se preparan bebidas.'),
('0128', 'Cultivo de especias y de plantas aromáticas y medicinales.'),
('0129', 'Otros cultivos permanentes n.c.p.'),
('013', 'Propagación de plantas (actividades de los viveros, excepto viveros forestales)'),
('0130', 'Propagación de plantas (actividades de los viveros, excepto viveros forestales).'),
('014', 'Ganadería.'),
('0141', 'Cría de ganado bovino y bufalino.'),
('0142', 'Cría de caballos y otros equinos.'),
('0143', 'Cría de ovejas y cabras.'),
('0144', 'Cría de ganado porcino.'),
('0145', 'Cría de aves de corral.'),
('0149', 'Cría de otros animales n.c.p.'),
('015', 'Explotación mixta (agrícola y pecuaria).'),
('0150', 'Explotación mixta (agrícola y pecuaria).'),
('016', 'Actividades de apoyo a la agricultura y la ganadería, y actividades posteriores a la cosecha.'),
('0161', 'Actividades de apoyo a la agricultura.'),
('0162', 'Actividades de apoyo a la ganadería.'),
('0163', 'Actividades posteriores a la cosecha.'),
('0164', 'Tratamiento de semillas para propagación.'),
('017', 'Caza ordinaria y mediante trampas y actividades de servicios conexas.'),
('01710', 'Caza ordinaria y mediante trampas y actividades de servicios conexas.'),
('021', 'Silvicultura y otras actividades forestales.'),
('0210', 'Silvicultura y otras actividades forestales.'),
('022', 'Extracción de madera.'),
('0220', 'Extracción de madera.'),
('023', 'Recolección de productos forestales diferentes a la madera.'),
('0230', 'Recolección de productos forestales diferentes a la madera.'),
('024', 'Servicios de apoyo a la silvicultura.'),
('0240', 'Servicios de apoyo a la silvicultura.'),
('031', 'Pesca.'),
('0311', 'Pesca marítima.'),
('0312', 'Pesca de agua dulce.'),
('032', 'Acuicultura.'),
('0321', 'Acuicultura marítima.'),
('0322', 'Acuicultura de agua dulce.'),
('051', 'Extracción de hulla (carbón de piedra).'),
('0510', 'Extracción de hulla (carbón de piedra).'),
('052', 'Extracción de carbón lignito.'),
('0520', 'Extracción de carbón lignito.'),
('061', 'Extracción de petróleo crudo.'),
('0610', 'Extracción de petróleo crudo.'),
('062', 'Extracción de gas natural.'),
('0620', 'Extracción de gas natural.'),
('071', 'Extracción de minerales de hierro.'),
('0710', 'Extracción de minerales de hierro.'),
('072', 'Extracción de minerales metalíferos no ferrosos.'),
('0721', 'Extracción de minerales de uranio y de torio.'),
('0722', 'Extracción de oro y otros metales preciosos.'),
('0723', 'Extracción de minerales de níquel.'),
('0729', 'Extracción de otros minerales metalíferos no ferrosos n.c.p.'),
('081', 'Extracción de piedra, arena, arcillas, cal, yeso, caolín, bentonitas y similares'),
('0811', 'Extracción de piedra, arena, arcillas comunes, yeso y anhidrita.'),
('0812', 'Extracción de arcillas de uso industrial, caliza, caolín y bentonitas.'),
('082', 'Extracción de esmeraldas, piedras preciosas y semipreciosas.'),
('0820', 'Extracción de esmeraldas, piedras preciosas y semipreciosas.'),
('089', 'Extracción de otros minerales no metálicos n.c.p.'),
('0891', 'Extracción de minerales para la fabricación de abonos y productos químicos.'),
('0892', 'Extracción de halita (sal).'),
('0899', 'Extracción de otros minerales no metálicos n.c.p.'),
('091', 'Actividades de apoyo para la extracción de petróleo y de gas natural.'),
('0910', 'Actividades de apoyo para la extracción de petróleo y de gas natural.'),
('099', 'Actividades de apoyo para otras actividades de explotación de minas y canteras'),
('0990', 'Actividades de apoyo para otras actividades de explotación de minas y canteras.'),
('101', 'Procesamiento y conservación de carne, pescado, crustáceos y moluscos.'),
('1011', ' Procesamiento y conservación de carne y productos cárnicos.'),
('1012', ' Procesamiento y conservación de pescados, crustáceos y moluscos.'),
('102', 'Procesamiento y conservación de frutas, legumbres, hortalizas y turbérculo'),
('1020', 'Procesamiento y conservación de frutas, legumbres, hortalizas y tubérculos.'),
('103', 'Elaboración de aceites y grasas de origen vegetal y animal.'),
('1030', 'Elaboración de aceites y grasas de origen vegetal y animal.'),
('104', 'Elaboración de productos lácteos.'),
('1040', 'Elaboración de productos lácteos.'),
('105', 'Elaboración de productos de molinería, almidones y productos derivados del almidón.'),
('1051', 'Elaboración de productos de molinería.'),
('1052', 'Elaboración de almidones y productos derivados del almidón.'),
('106', 'Elaboración de productos de café.'),
('1061', 'Trilla de café.'),
('1062', 'Descafeinado, tostión y molienda del café.'),
('1063', 'Otros derivados del café.'),
('107', 'Elaboración de azúcar y panela.'),
('1071', 'Elaboración y refinación de azúcar.'),
('1072', 'Elaboración de panela.'),
('108', 'Elaboración de otros productos alimenticios.'),
('1081', 'Elaboración de productos de panadería.'),
('1082', 'Elaboración de cacao, chocolate y productos de confitería.'),
('1083', 'Elaboración de macarrones, fideos, alcuzcuz y productos farináceos similares.'),
('1084', 'Elaboración de comidas y platos preparados.'),
('1089', 'Elaboración de otros productos alimenticios n.c.p.'),
('109', 'Elaboración de alimentos preparados para animales.'),
('1090', 'Elaboración de alimentos preparados para animales.'),
('110', 'Elaboración de bebidas.'),
('1101', 'Destilación, rectificación y mezcla de bebidas alcohólicas.'),
('1102', 'Elaboración de bebidas fermentadas no destiladas.'),
('1103', 'Producción de malta, elaboración de cervezas y otras bebidas malteadas.'),
('1104', 'Elaboración de bebidas no alcohólicas, producción de aguas minerales y de otras aguas embotelladas.'),
('120', ' Elaboración de productos de tabaco.'),
('1200', ' Elaboración de productos de tabaco.'),
('131', 'Preparación, hilatura, tejeduría y acabado de productos textiles.'),
('1311', 'Preparación e hilatura de fibras textiles.'),
('1312', 'Tejeduría de productos textiles.'),
('1313', 'Acabado de productos textiles.'),
('139', 'Fabricación de otros productos textiles.'),
('1391', 'Fabricación de tejidos de punto y ganchillo.'),
('1392', 'Confección de artículos con materiales textiles, excepto prendas de vestir.'),
('1393', 'Fabricación de tapetes y alfombras para pisos.'),
('1394', 'Fabricación de cuerdas, cordeles, cables, bramantes y redes.'),
('1399', 'Fabricación de otros artículos textiles n.c.p.'),
('141', 'Confección de prendas de vestir, excepto prendas de piel.'),
('1410', 'Confección de prendas de vestir, excepto prendas de piel.'),
('142', 'Fabricación de artículos de piel.'),
('1420', 'Fabricación de artículos de piel.'),
('143', 'Fabricación de artículos de punto y ganchillo.'),
('1430', 'Fabricación de artículos de punto y ganchillo.'),
('151', 'Curtido y recurtido de cueros, fabricación de artículos de viaje, bolsos de mano y artículos similares, y fabricación de artículos de talabartería y guarnicionería, adobo y teñido de pieles.'),
('1511', 'Curtido y recurtido de cueros, recurtido y teñido de pieles.'),
('1512', 'Fabricación de artículos de viaje, bolsos de mano y artículos similares elaborados en cuero, y fabricación de artículos de talabartería y guarnicionería.'),
('1513', 'Fabricación de artículos de viaje, bolsos de mano y artículos similares elaborados en cuero, y fabricación de artículos de talabartería y guarnicionería.'),
('152', 'Fabricación de calzado.'),
('1521', 'Fabricación de calzado de cuero y piel, con cualquier tipo de suela.'),
('1522', 'Fabricación de otros tipos de calzado, excepto calzado de cuero y piel.'),
('1523', 'Fabricación de partes del calzado.'),
('161', ' Aserrado, acepillado e impregnación de la madera.'),
('1610', ' Aserrado, acepillado e impregnación de la madera.'),
('162', 'Fabricación de hojas de madera para enchapado, fabricación de tableros contrachapados, tableros laminados, tableros de partículas y otros tableros y paneles.'),
('1620', 'Fabricación de hojas de madera para enchapado, fabricación de tableros contrachapados, tableros laminados, tableros de partículas y otros tableros y paneles.'),
('1625', ' Actividades de saneamiento ambiental y otros servicios de gestión de desechos.'),
('163', 'Fabricación de partes y piezas de madera, de carpintería y ebanistería para la construcción.'),
('1630', 'Fabricación de partes y piezas de madera, de carpintería y ebanistería para la construcción.'),
('164', 'Fabricación de recipientes de madera.'),
('1640', 'Fabricación de recipientes de madera.'),
('169', 'Fabricación de otros productos de madera, fabricación de artículos de cestería y espartería.'),
('1690', 'Fabricación de otros productos de madera, fabricación de artículos de cestería y espartería.'),
('170', 'Fabricación de papel, cartón y productos de papel y cartón.'),
('1701', 'Fabricación de pulpas (pastas) celulósicas, papel y cartón.'),
('1702', 'Fabricación de papel y cartón ondulado (corrugado), fabricación de envases, empaques y de embalajes de papel y cartón.'),
('1709', 'Fabricación de otros artículos de papel y cartón.'),
('181', 'Actividades de impresión y actividades de servicios relacionados con la impresión'),
('1811', 'Actividades de impresión.'),
('1812', 'Actividades de servicios relacionados con la impresión.'),
('182', 'Producción de copias a partir de grabaciones originales.'),
('1820', 'Producción de copias a partir de grabaciones originales.'),
('191', 'Fabricación de productos de hornos de coque.'),
('1910', 'Fabricación de productos de hornos de coque.'),
('192', 'Fabricación de productos de la refinación del petróleo.'),
('1921', 'Fabricación de productos de la refinación del petróleo.'),
('1922', 'Actividad de mezcla de combustibles.'),
('201', 'Fabricación de sustancias químicas básicas, abonos y compuestos inorgánicos nitrogenados, plásticos y caucho sintético en formas primarias.'),
('2011', 'Fabricación de sustancias y productos químicos básicos.'),
('2012', 'Fabricación de abonos y compuestos inorgánicos nitrogenados.'),
('2013', 'Fabricación de plásticos en formas primarias.'),
('2014', 'Fabricación de caucho sintético en formas primarias.'),
('202', 'Fabricación de otros productos químicos.'),
('2021', 'Fabricación de plaguicidas y otros productos químicos de uso agropecuario.'),
('2022', 'Fabricación de pinturas, barnices y revestimientos similares, tintas para impresión y masillas.'),
('2023', 'Fabricación de jabones y detergentes, preparados para limpiar y pulir, perfumes y preparados de tocador.'),
('2029', 'perfumes y preparados de tocador. Fabricación de otros productos químicos n.c.p.'),
('203', 'Fabricación de fibras sintéticas y artificiales.'),
('2030', 'Fabricación de fibras sintéticas y artificiales.'),
('210', 'Fabricación de productos farmacéuticos, sustancias químicas medicinales y productos botánicos de uso farmacéutico.'),
('2100', ' Fabricación de productos farmacéuticos, sustancias químicas medicinales y productos botánicos de uso farmacéutico.'),
('221', 'Fabricación de productos de caucho.'),
('2211', 'Fabricación de llantas y neumáticos de caucho'),
('2212', 'Reencauche de llantas usadas'),
('2219', 'Fabricación de formas básicas de caucho y otros productos de caucho n.c.p.'),
('222', 'Fabricación de productos de plástico.'),
('2221', 'Fabricación de formas básicas de plástico.'),
('2229', 'Fabricación de artículos de plástico n.c.p.'),
('231', 'Fabricación de vidrio y productos de vidrio.'),
('2310', 'Fabricación de vidrio y productos de vidrio.'),
('239', 'Fabricación de productos minerales no metálicos n.c.p.'),
('2391', 'Fabricación de productos refractarios.'),
('2392', 'Fabricación de materiales de arcilla para la construcción.'),
('2393', 'Fabricación de otros productos de cerámica y porcelana.'),
('2394', 'Fabricación de cemento, cal y yeso.'),
('2395', 'Fabricación de artículos de hormigón, cemento y yeso.'),
('2396', 'Corte, tallado y acabado de la piedra.'),
('2399', 'Fabricación de otros productos minerales no metálicos n.c.p.'),
('241', 'Industrias básicas de hierro y de acero.'),
('2410', 'Industrias básicas de hierro y de acero.'),
('242', 'Industrias básicas de metales preciosos y de metales no ferrosos.'),
('2421', 'Industrias básicas de metales preciosos.'),
('2429', 'Industrias básicas de otros metales no ferrosos.'),
('243', 'Fundición de metales.'),
('2431', 'Fundición de hierro y de acero.'),
('2432', 'Fundición de metales no ferrosos.'),
('251', 'Fabricación de productos metálicos para uso estructural, tanques, depósitos y generadores de vapor.'),
('2511', 'Fabricación de productos metálicos para uso estructural.'),
('2512', 'Fabricación de tanques, depósitos y recipientes de metal, excepto los utilizados para el envase o transporte de mercancías.'),
('2513', 'Fabricación de generadores de vapor, excepto calderas de agua caliente para calefacción central,'),
('252', 'Fabricación de armas y municiones.'),
('2520', 'Fabricación de armas y municiones.'),
('259', 'Fabricación de otros productos elaborados de metal y actividades de servicios relacionadas con el trabajo de metales.'),
('2591', 'Forja, prensado, estampado y laminado de metal, pulvimetalurgia.'),
('2592', 'Tratamiento y revestimiento de metales, mecanizado.'),
('2593', 'Fabricación de artículos de cuchillería, herramientas de mano y artículos de ferretería.'),
('2599', ' Fabricación de otros productos laborados de metal n.c.p.'),
('261', 'Fabricación de componentes y tableros electrónicos.'),
('2610', 'Fabricación de componentes y tableros electrónicos.'),
('262', 'Fabricación de computadoras y de equipo periférico.'),
('2620', 'Fabricación de computadoras y de equipo periférico.'),
('263', 'Fabricación de equipos de comunicación.'),
('2630', 'Fabricación de equipos de comunicación.'),
('264', 'Fabricación de aparatos electrónicos de consumo.'),
('2640', 'Fabricación de aparatos electrónicos de consumo.'),
('265', 'Fabricación de equipo de medición, prueba, navegación y control, fabricación de relojes.'),
('2651', 'abricación de equipo de medición, prueba, navegación y control'),
('2652', 'Fabricación de relojes.'),
('266', 'Fabricación de equipo de irradiación y equipo electrónico de uso médico y terapéutico.'),
('2660', 'Fabricación de equipo de irradiación y equipo electrónico de uso médico y terapéutico.'),
('267', 'Fabricación de instrumentos ópticos y equipo fotográfico.'),
('2670', 'Fabricación de instrumentos ópticos y equipo fotográfico.'),
('268', 'Fabricación de medios magnéticos y ópticos para almacenamiento de datos'),
('2680', 'Fabricación de medios magnéticos y ópticos para almacenamiento de datos.'),
('271', 'Fabricación de motores, generadores y transformadores eléctricos y de aparatos de distribución y control de la energía eléctrica.'),
('2711', 'Fabricación de motores, generadores y transformadores eléctricos.'),
('2712', 'Fabricación de aparatos de distribución y control de la energía eléctrica.'),
('272', 'Fabricación de pilas, baterías y acumuladores eléctricos.'),
('2720', 'Fabricación de pilas, baterías y acumuladores eléctricos.'),
('273', 'Fabricación de hilos y cables aislados y sus dispositivos.'),
('2731', 'Fabricación de hilos y cables eléctricos y de fibra óptica.'),
('2732', 'Fabricación de dispositivos de cableado.'),
('274', 'Fabricación de equipos eléctricos de iluminación.'),
('2740', 'Fabricación de equipos eléctricos de iluminación.'),
('275', 'Fabricación de aparatos de uso doméstico.'),
('2750', 'Fabricación de aparatos de uso doméstico.'),
('279', 'Fabricación de otros tipos de equipo eléctrico n.c.p.'),
('2790', 'Fabricación de otros tipos de equipo eléctrico n.c.p.'),
('281', ' Fabricación de maquinaria y equipo de uso general.'),
('2811', ' Fabricación de motores, turbinas, y partes para motores de combustión interna.'),
('2812', 'Fabricación de equipos de potencia hidráulica y neumática.'),
('2813', 'Fabricación de otras bombas, compresores, grifos y válvulas.'),
('2814', 'Fabricación de cojinetes, engranajes, trenes de engranajes y piezas de transmisión'),
('2815', 'Fabricación de hornos, hogares y quemadores industriales.'),
('2816', 'Fabricación de equipo de elevación y manipulación.'),
('2817', 'Fabricación de maquinaria y equipo de oficina (excepto computadoras y equipo periférico).'),
('2818', 'Fabricación de herramientas manuales con motor.'),
('2819', 'Fabricación de otros tipos de maquinaria y equipo de uso general n.c.p.'),
('282', 'Fabricación de maquinaria y equipo de uso especial.'),
('2821', 'Fabricación de maquinaria agropecuaria y forestal.'),
('2822', 'Fabricación de máquinas formadoras de metal y de máquinas herramienta.'),
('2823', 'Fabricación de maquinaria para la metalurgia.'),
('2824', 'Fabricación de maquinaria para explotación de minas y canteras y para obras de construcción.'),
('2825', 'Fabricación de maquinaria para la elaboración de alimentos, bebidas y tabaco'),
('2826', 'Fabricación de maquinaria para la elaboración de productos textiles, prendas de vestir y cueros.'),
('2829', 'Fabricación de otros tipos de maquinaria y equipo de uso especial n.c.p.'),
('291', 'Fabricación de vehículos automotores y sus motores.'),
('2910', 'Fabricación de vehículos automotores y sus motores.'),
('292', 'Fabricación de carrocerías para vehículos automotores, fabricación de remolques y semirremolques.'),
('2920', 'Fabricación de carrocerías para vehículos automotores, fabricación de remolques y semirremolques.'),
('293', 'Fabricación de partes, piezas (autopartes) y accesorios (lujos) para vehículos automotores.'),
('2930', 'Fabricación de partes, piezas (autopartes) y accesorios (lujos) para vehículos automotores.'),
('301', 'Construcción de barcos y otras embarcaciones.'),
('3011', 'Construcción de barcos y de estructuras flotantes.'),
('3012', 'Construcción de embarcaciones de recreo y deporte.'),
('302', 'Fabricación de locomotoras y de material rodante para ferrocarriles.'),
('3020', 'Fabricación de locomotoras y de material rodante para ferrocarriles.'),
('303', 'Fabricación de aeronaves, naves espaciales y de maquinaria conexa.'),
('3030', 'Fabricación de aeronaves, naves espaciales y de maquinaria conexa.'),
('304', 'Fabricación de vehículos militares de combate.'),
('3040', 'Fabricación de vehículos militares de combate.'),
('309', 'Fabricación de otros tipos de equipo de transporte n.c.p.'),
('3091', 'Fabricación de motocicletas.'),
('3092', 'Fabricación de bicicletas y de sillas de ruedas para personas con discapacidad.'),
('3099', 'Fabricación de otros tipos de equipo de transporte n.c.p.'),
('311', 'Fabricación de muebles.'),
('3110', 'Fabricación de muebles.'),
('312', 'Fabricación de colchones y somieres.'),
('3120', 'Fabricación de colchones y somieres.'),
('3211', 'Fabricación de joyas y artículos conexos.'),
('3212', 'Fabricación de bisutería y artículos conexos.'),
('322', 'Fabricación de instrumentos musicales.'),
('3220', 'Fabricación de instrumentos musicales.'),
('323', 'Fabricación de artículos y equipo para la práctica del deporte.'),
('3230', 'Fabricación de artículos y equipo para la práctica del deporte.'),
('324', 'Fabricación de juegos, juguetes y rompecabezas.'),
('3240', 'Fabricación de juegos, juguetes y rompecabezas.'),
('325', 'Fabricación de instrumentos, aparatos y materiales médicos y odontológicos (incluido mobiliario).'),
('3250', 'Fabricación de instrumentos, aparatos y materiales médicos y odontológicos (incluido mobiliario).'),
('329', 'Otras industrias manufactureras n.c.p.'),
('3290', 'Otras industrias manufactureras n.c.p.'),
('331', 'Mantenimiento y reparación especializado de productos elaborados en metal y de maquinaria y equipo.'),
('3311', 'Mantenimiento y reparación especializado de productos elaborados en metal.'),
('3312', 'Mantenimiento y reparación especializado de maquinaria y equipo.'),
('3313', 'Mantenimiento y reparación especializado de equipo electrónico y óptico.'),
('3314', 'Mantenimiento y reparación especializado de equipo eléctrico.'),
('3315', 'Mantenimiento y reparación especializado de equipo de transporte, excepto los vehículos automotores, motocicletas y bicicletas.'),
('3319', 'Mantenimiento y reparación de otros tipos de equipos y sus componentes n.c.p.'),
('332', 'Instalación especializada de maquinaria y equipo industrial.'),
('3320', 'Instalación especializada de maquinaria y equipo industrial.'),
('351', 'Generación, transmisión, distribución y comercialización de energía eléctrica'),
('3511', 'Generación de energía eléctrica.'),
('3512', 'Transmisión de energía eléctrica.'),
('3513', 'Distribución de energía eléctrica.'),
('3514', 'Comercialización de energía eléctrica.'),
('352', 'Producción de gas, distribución de combustibles gaseosos por tuberías.'),
('3520', 'Producción de gas, distribución de combustibles gaseosos por tuberías.'),
('353', 'Suministro de vapor y aire acondicionado.'),
('3530', 'Suministro de vapor y aire acondicionado.'),
('360', ' Captación, tratamiento y distribución de agua.'),
('3600', ' Captación, tratamiento y distribución de agua.'),
('381', 'Recolección de desechos.'),
('3811', 'Recolección de desechos no peligrosos.'),
('3812', 'Recolección de desechos peligrosos.'),
('382', 'Tratamiento y disposición de desechos.'),
('3821', 'Tratamiento y disposición de desechos no peligrosos.'),
('3822', 'Tratamiento y disposición de desechos peligrosos.'),
('383', 'Recuperación de materiales.'),
('3830', 'Recuperación de materiales.'),
('3900', ' Actividades de saneamiento ambiental y otros servicios de gestión de desechos.'),
('411', 'Construcción de edificios.'),
('4111', 'Construcción de edificios residenciales.'),
('4112', 'Construcción de edificios no residenciales.'),
('421', 'Construcción de carreteras y vías de ferrocarril.'),
('4210', 'Construcción de carreteras y vías de ferrocarril.'),
('422', 'Construcción de proyectos de servicio público.'),
('4220', 'Construcción de proyectos de servicio público.'),
('429', 'Construcción de otras obras de ingeniería civil.'),
('4290', 'Construcción de otras obras de ingeniería civil.'),
('431', 'Demolición y preparación del terreno.'),
('4311', 'Demolición.'),
('4312', 'Preparación del terreno.'),
('432', 'Instalaciones eléctricas, de fontanería y otras instalaciones especializadas.'),
('4321', 'Instalaciones eléctricas.'),
('4322', 'Instalaciones de fontanería, calefacción y aire acondicionado.'),
('4329', 'Otras instalaciones especializadas.'),
('433', 'Terminación y acabado de edificios y obras de ingeniería civil.'),
('4330', 'Terminación y acabado de edificios y obras de ingeniería civil.'),
('439', ' Otras actividades especializadas para la construcción de edificios y obras de ingeniería civil.'),
('4390', ' Otras actividades especializadas para la construcción de edificios y obras de ingeniería civil.'),
('451', 'Comercio de vehículos automotores.'),
('4511', 'Comercio de vehículos automotores nuevos.'),
('4512', 'Comercio de vehículos automotores usados.'),
('452', 'Mantenimiento y reparación de vehículos automotores.'),
('4520', 'Mantenimiento y reparación de vehículos automotores.'),
('453', 'Comercio de partes, piezas (autopartes) y accesorios (lujos) para vehículos automotores.'),
('4530', 'Comercio de partes, piezas (autopartes) y accesorios (lujos) para vehículos automotores'),
('454', 'Comercio, mantenimiento y reparación de motocicletas y de sus partes, piezas y accesorios.'),
('4541', 'Comercio de motocicletas y de sus partes, piezas y accesorios.'),
('4542', 'Mantenimiento y reparación de motocicletas y de sus partes y piezas.'),
('46', 'Comercio al por mayor y en comisión o por contrata, excepto el comercio de vehículos automotores y motocicletas.'),
('461', 'Comercio al por mayor a cambio de una retribución o por contrata.'),
('4610', 'Comercio al por mayor a cambio de una retribución o por contrata.'),
('462', 'Comercio al por mayor de materias primas agropecuarias, animales vivos'),
('4620', 'Comercio al por mayor de materias primas agropecuarias, animales vivos.'),
('463', 'Comercio al por mayor de alimentos, bebidas y tabaco.'),
('4631', 'Comercio al por mayor de productos alimenticios.'),
('4632', 'Comercio al por mayor de bebidas y tabaco.'),
('464', 'Comercio al por mayor de artículos y enseres domésticos (incluidas prendas de vestir).'),
('4641', 'Comercio al por mayor de productos textiles, productos confeccionados para uso doméstico.'),
('4642', 'Comercio al por mayor de prendas de vestir.'),
('4643', 'Comercio al por mayor de calzado.'),
('4644', 'Comercio al por mayor de aparatos y equipo de uso doméstico.'),
('4645', 'Comercio al por mayor de productos farmacéuticos, medicinales, cosméticos y de tocador.'),
('4649', 'Comercio al por mayor de otros utensilios domésticos n.c.p.'),
('465', 'Comercio al por mayor de maquinaria y equipo.'),
('4651', 'Comercio al por mayor de computadores, equipo periférico y programas de informática.'),
('4652', 'Comercio al por mayor de equipo, partes y piezas electrónicos y de telecomunicaciones.'),
('4653', 'Comercio al por mayor de maquinaria y equipo agropecuarios.'),
('4659', 'Comercio al por mayor de otros tipos de maquinaria y equipo n.c.p.'),
('466', 'Comercio al por mayor especializado de otros productos.'),
('4661', 'Comercio al por mayor de combustibles sólidos, líquidos, gaseosos y productos conexos.'),
('4662', 'Comercio al por mayor de metales y productos metalíferos.'),
('4663', 'Comercio al por mayor de materiales de construcción, artículos de ferretería, pinturas, productos de vidrio, equipo y materiales de fontanería y calefacción.'),
('4664', 'Comercio al por mayor de productos químicos básicos, cauchos y plásticos en formas primarias y productos químicos de uso agropecuario.'),
('4665', 'Comercio al por mayor de desperdicios, desechos y chatarra.'),
('4669', 'Comercio al por mayor de otros productos n.c.p.'),
('469', 'Comercio al por mayor no especializado.'),
('4690', 'Comercio al por mayor no especializado.'),
('471', 'Comercio al por menor en establecimientos no especializados.'),
('4711', 'Comercio al por menor en establecimientos no especializados con surtido compuesto principalmente por alimentos, bebidas o tabaco.'),
('4719', 'Comercio al por menor en establecimientos no especializados, con surtido compuesto principalmente por productos diferentes de alimentos (víveres en general), bebidas y tabaco.'),
('472', 'Comercio al por menor de alimentos (víveres en general), bebidas y tabaco, en establecimientos especializados.'),
('4721', 'abaco, en establecimientos especializados. 4721 Comercio al por menor de productos agrícolas para el consumo en establecimientos especializados.'),
('4722', 'Comercio al por menor de leche, productos lácteos y huevos, en establecimientos especializados.'),
('4723', 'Comercio al por menor de carnes (incluye aves de corral), productos cárnicos, pescados y productos de mar, en establecimientos especializados.'),
('4724', 'Comercio al por menor de bebidas y productos del tabaco, en establecimientos especializados.'),
('4729', 'Comercio al por menor de otros productos alimenticios n.c.p., en establecimientos especializados.'),
('473', ' Comercio al por menor de combustible, lubricantes, aditivos y productos de limpieza para automotores, en establecimientos especializados.'),
('4731', ' Comercio al por menor de combustible para automotores.'),
('4732', ' Comercio al por menor de lubricantes (aceites, grasas), aditivos y productos de limpieza para vehículos automotores.'),
('474', ' Comercio al por menor de equipos de informática y de comunicaciones, en establecimientos especializados.'),
('4741', ' Comercio al por menor de computadores, equipos periféricos, programas de informática y equipos de telecomunicaciones en establecimientos especializados.'),
('4742', ' Comercio al por menor de equipos y aparatos de sonido y de video, en establecimientos especializados.'),
('475', ' Comercio al por menor de otros enseres domésticos en establecimientos especializados.'),
('4751', ' Comercio al por menor de productos textiles en establecimientos especializados.'),
('4752', ' Comercio al por menor de artículos de ferretería, pinturas y productos de vidrio en establecimientos especializados.'),
('4753', ' Comercio al por menor de tapices, alfombras y cubrimientos para paredes y pisos en establecimientos especializados.'),
('4754', ' Comercio al por menor de electrodomésticos y gasodomésticos de uso doméstico, muebles y equipos de iluminación.'),
('4755', ' Comercio al por menor de artículos y utensilios de uso doméstico.'),
('4759', ' Comercio al por menor de otros artículos domésticos en establecimientos especializados.'),
('476', ' Comercio al por menor de artículos culturales y de entretenimiento, en establecimientos especializados.'),
('4761', ' Comercio al por menor de libros, periódicos, materiales y artículos de papelería y escritorio, en establecimientos especializados.'),
('4762', ' Comercio al por menor de artículos deportivos, en establecimientos especializados.'),
('4769', ' Comercio al por menor de otros artículos culturales y de entretenimiento n.c.p. en establecimientos especializados.'),
('477', ' Comercio al por menor de otros productos en establecimientos especializados.'),
('4771', ' Comercio al por menor de prendas de vestir y sus accesorios (incluye artículos de piel) en establecimientos especializados.'),
('4772', ' Comercio al por menor de todo tipo de calzado y artículos de cuero y sucedáneos del cuero en establecimientos especializados.'),
('4773', ' Comercio al por menor de productos farmacéuticos y medicinales, cosméticos y artículos de tocador en establecimientos especializados.'),
('4774', ' Comercio al por menor de otros productos nuevos en establecimientos especializados.'),
('4775', ' Comercio al por menor de artículos de segunda mano.'),
('478', ' Comercio al por menor en puestos de venta móviles.'),
('4781', ' Comercio al por menor de alimentos, bebidas y tabaco, en puestos de venta móviles.'),
('4789', ' Comercio al por menor de otros productos en puestos de venta móviles.'),
('479', ' Comercio al por menor no realizado en establecimientos, puestos de venta o mercados.'),
('4791', ' Comercio al por menor realizado a través de internet.'),
('4792', ' Comercio al por menor realizado a través de casas de venta o por correo.'),
('4799', ' Otros tipos de comercio al por menor no realizado en establecimientos, puestos de venta o mercados.'),
('491', 'Transporte férreo.'),
('4911', 'Transporte férreo de pasajeros.'),
('4912', 'Transporte férreo de carga.'),
('492', 'Transporte terrestre público automotor.'),
('4921', 'Transporte de pasajeros.'),
('4922', 'Transporte mixto.'),
('4923', 'Transporte de carga por carretera.'),
('493', 'Transporte por tuberías.'),
('4930', 'Transporte por tuberías.'),
('501', 'Transporte marítimo y de cabotaje.'),
('5011', 'Transporte de pasajeros marítimo y de cabotaje.'),
('5012', 'Transporte de carga marítimo y de cabotaje.'),
('502', 'Transporte fluvial.'),
('5021', 'Transporte fluvial de pasajeros.'),
('5022', 'Transporte fluvial de carga.'),
('511', 'Transporte aéreo de pasajeros.'),
('5111', 'Transporte aéreo nacional de pasajeros.'),
('5112', 'Transporte aéreo internacional de pasajeros.'),
('512', 'Transporte aéreo de carga.'),
('5121', 'Transporte aéreo nacional de carga.'),
('5122', 'Transporte aéreo internacional de carga.'),
('521', 'Almacenamiento y depósito.'),
('5210', 'Almacenamiento y depósito.'),
('522', ' Actividades de las estaciones, vías y servicios complementarios para el transporte.'),
('5221', ' Actividades de estaciones, vías y servicios complementarios para el transporte terrestre.'),
('5222', ' Actividades de puertos y servicios complementarios para el transporte acuático.'),
('5223', ' Actividades de aeropuertos, servicios de navegación aérea y demás actividades conexas al transporte aéreo.'),
('5224', ' Manipulación de carga.'),
('5229', ' Otras actividades complementarias al transporte.'),
('531', 'Actividades postales nacionales.'),
('5310', 'Actividades postales nacionales.'),
('532', 'Actividades de mensajería.'),
('5320', 'Actividades de mensajería.'),
('551', ' Actividades de alojamiento de estancias cortas.'),
('5511', ' Alojamiento en hoteles.'),
('5512', ' Alojamiento en apartahoteles.'),
('5513', ' Alojamiento en centros vacacionales.'),
('5514', ' Alojamiento rural.'),
('5519', ' Otros tipos de alojamientos para visitantes.'),
('5520', 'Actividades de zonas de camping y parques para vehículos recreacionales.'),
('553', 'Servicio por horas.'),
('5530', 'Servicio por horas'),
('559', 'Otros tipos de alojamiento n.c.p.'),
('5590', 'Otros tipos de alojamiento n.c.p.'),
('561', 'Actividades de restaurantes, cafeterías y servicio móvil de comidas.'),
('5611', 'Expendio a la mesa de comidas preparadas.'),
('5612', 'Expendio por autoservicio de comidas preparadas.'),
('5613', 'Expendio de comidas preparadas en cafeterías.'),
('5619', 'Otros tipos de expendio de comidas preparadas n.c.p.'),
('562', 'Actividades de catering para eventos y otros servicios de comidas.'),
('5621', 'Catering para eventos.'),
('5629', 'Actividades de otros servicios de comidas.'),
('563', 'Expendio de bebidas alcohólicas para el consumo dentro del establecimiento.'),
('5630', 'Expendio de bebidas alcohólicas para el consumo dentro del establecimiento.'),
('581', 'Edición de libros, publicaciones periódicas y otras actividades de edición.'),
('5811', 'Edición de libros.'),
('5812', 'Edición de directorios y listas de correo.'),
('5813', 'Edición de periódicos, revistas y otras publicaciones periódicas.'),
('5819', 'Otros trabajos de edición.'),
('582', 'Edición de programas de informática (software).'),
('5820', 'Edición de programas de informática (software).'),
('591', 'Actividades de producción de películas cinematográficas, video y producción de programas, anuncios y comerciales de televisión.'),
('5911', 'Actividades de producción de películas cinematográficas, videos, programas, anuncios y comerciales de televisión.'),
('5912', 'Actividades de posproducción de películas cinematográficas, videos, programas, anuncios y comerciales de televisión.'),
('5913', 'Actividades de distribución de películas cinematográficas, videos, programas, anuncios y comerciales de televisión.'),
('5914', 'ctividades de exhibición de películas cinematográficas y videos.'),
('592', 'Actividades de grabación de sonido y edición de música.'),
('5920', 'Actividades de grabación de sonido y edición de música.'),
('601', 'Actividades de programación y transmisión en el servicio de radiodifusión sonora.'),
('6010', 'Actividades de programación y transmisión en el servicio de radiodifusión sonora.'),
('602', 'Actividades de programación y transmisión de televisión.'),
('6020', 'Actividades de programación y transmisión de televisión.'),
('611', 'Actividades de telecomunicaciones alámbricas.'),
('6110', 'Actividades de telecomunicaciones alámbricas.'),
('612', 'Actividades de telecomunicaciones inalámbricas.'),
('6120', 'Actividades de telecomunicaciones inalámbricas.'),
('613', 'Actividades de telecomunicación satelital.'),
('6130', 'Actividades de telecomunicación satelital.'),
('619', 'Otras actividades de telecomunicaciones.'),
('6190', 'Otras actividades de telecomunicaciones.'),
('620', ' Desarrollo de sistemas informáticos (planificación, análisis, diseño, programación, pruebas), consultoría informática y actividades relacionadas.'),
('6201', ' Actividades de desarrollo de sistemas informáticos (planificación, análisis, diseño, programación, pruebas).'),
('6202', ' Actividades de consultoría informática y actividades de administración de instalaciones informáticas.'),
('6209', ' Otras actividades de tecnologías de información y actividades de servicios informáticos.'),
('6311', 'Procesamiento de datos, alojamiento (hosting) y actividades relacionadas, portales web.'),
('6312', 'Portales web.'),
('639', 'Otras actividades de servicio de información.'),
('6391', 'Actividades de agencias de noticias.'),
('6399', 'Otras actividades de servicio de información n.c.p.'),
('641', 'Intermediación monetaria.'),
('6411', 'Banco Central.'),
('6412', 'Bancos comerciales.'),
('642', 'Otros tipos de intermediación monetaria.'),
('6421', 'Actividades de las corporaciones financieras.'),
('6422', 'Actividades de las compañías de financiamiento.'),
('6423', 'Banca de segundo piso.'),
('6424', 'Actividades de las cooperativas financieras.'),
('643', 'Fideicomisos, fondos (incluye fondos de cesantías) y entidades financieras similares.'),
('6431', 'Fideicomisos, fondos y entidades financieras similares.'),
('6432', 'Fondos de cesantías.'),
('649', 'Otras actividades de servicio financiero, excepto las de seguros y pensiones'),
('6491', 'Leasing financiero (arrendamiento financiero).'),
('6492', 'Actividades financieras de fondos de empleados y otras formas asociativas del sector solidario.'),
('6493', 'Actividades de compra de cartera o factoring.'),
('6494', 'Otras actividades de distribución de fondos.'),
('6495', 'Instituciones especiales oficiales.'),
('6499', 'Otras actividades de servicio financiero, excepto las de seguros y pensiones n.c.p.'),
('651', 'Seguros y capitalización.'),
('6511', 'Seguros generales.'),
('6512', 'Seguros de vida.'),
('6513', 'Reaseguros.'),
('6514', 'Capitalización.'),
('652', 'Servicios de seguros sociales de salud y riesgos profesionales.'),
('6521', 'Servicios de seguros sociales de salud.'),
('6522', 'Servicios de seguros sociales de riesgos profesionales.'),
('653', 'Servicios de seguros sociales de pensiones.'),
('6531', 'Régimen de prima media con prestación definida (RPM).'),
('6532', 'Régimen de ahorro individual (RAI).'),
('661', 'Actividades auxiliares de las actividades de servicios financieros, excepto las de seguros y pensiones.'),
('6611', 'Administración de mercados financieros.'),
('6612', 'Corretaje de valores y de contratos de productos básicos.'),
('6613', 'Otras actividades relacionadas con el mercado de valores.'),
('6614', 'Actividades de las casas de cambio.'),
('6615', 'Actividades de los profesionales de compra y venta de divisas.'),
('6619', 'Otras actividades auxiliares de las actividades de servicios financieros n.c.p.'),
('662', 'Actividades de servicios auxiliares de los servicios de seguros y pensiones.'),
('6621', 'Actividades de agentes y corredores de seguros'),
('6629', 'Evaluación de riesgos y daños, y otras actividades de servicios auxiliares'),
('663', 'Actividades de administración de fondos.'),
('6630', 'Actividades de administración de fondos.'),
('681', 'Actividades inmobiliarias realizadas con bienes propios o arrendados.'),
('6810', 'Actividades inmobiliarias realizadas con bienes propios o arrendados.'),
('682', 'Actividades inmobiliarias realizadas a cambio de una retribución o por contrata.'),
('6820', 'Actividades inmobiliarias realizadas a cambio de una retribución o por contrata.'),
('691', 'Actividades jurídicas.'),
('6910', 'Actividades jurídicas.'),
('692', 'Actividades de contabilidad, teneduría de libros, auditoría financiera y asesoría tributaria.'),
('6920', 'Actividades de contabilidad, teneduría de libros, auditoría financiera y asesoría tributaria.'),
('711', 'Actividades de arquitectura e ingeniería y otras actividades conexas de consultoría técnica.'),
('7110', 'Actividades de arquitectura e ingeniería y otras actividades conexas de consultoría técnica.'),
('712', 'Ensayos y análisis técnicos.'),
('7120', 'Ensayos y análisis técnicos.'),
('721', ' Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingeniería.'),
('7210', ' Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingeniería.'),
('722', ' Investigaciones y desarrollo experimental en el campo de las ciencias sociales y las humanidades.'),
('7220', ' Investigaciones y desarrollo experimental en el campo de las  ciencias  sociales y las humanidades.'),
('731', 'Publicidad.'),
('7310', 'Publicidad.'),
('732', 'Estudios de mercado y realización de encuestas de opinión pública.'),
('7320', 'Estudios de mercado y realización de encuestas de opinión pública.'),
('741', 'Actividades especializadas de diseño.'),
('7410', 'Actividades especializadas de diseño.'),
('742', 'Actividades de fotografía.'),
('7420', 'Actividades de fotografía.'),
('749', 'Otras actividades profesionales, científicas y técnicas n.c.p.'),
('7490', 'Otras actividades profesionales, científicas y técnicas n.c.p.'),
('750', ' Actividades veterinarias.'),
('7500', ' Actividades veterinarias.'),
('771', 'Alquiler y arrendamiento de vehículos automotores.'),
('7710', 'Alquiler y arrendamiento de vehículos automotores.'),
('772', 'Alquiler y arrendamiento de efectos personales y enseres domésticos.'),
('7721', 'Alquiler y arrendamiento de equipo recreativo y deportivo.'),
('7722', 'Alquiler de videos y discos.'),
('7729', 'Alquiler y arrendamiento de otros efectos personales y enseres domésticos n.c.p.'),
('773', 'Alquiler y arrendamiento de otros tipos de maquinaria, equipo y bienes tangibles n.c.p.'),
('7730', 'Alquiler y arrendamiento de otros tipos de maquinaria, equipo y bienes tangibles n.c.p.'),
('774', 'Arrendamiento de propiedad intelectual y productos similares, excepto obras protegidas por derechos de autor.'),
('7740', ' Arrendamiento de propiedad intelectual y productos similares, excepto obras protegidas por derechos de autor.'),
('781', 'Actividades de agencias de empleo.'),
('7810', 'Actividades de agencias de empleo.'),
('782', 'Actividades de agencias de empleo temporal.'),
('7820', 'Actividades de agencias de empleo temporal.'),
('783', 'Otras actividades de suministro de recurso humano.'),
('7830', 'Otras actividades de suministro de recurso humano.'),
('791', 'Actividades de las agencias de viajes y operadores turísticos.'),
('7911', 'Actividades de las agencias de viaje.'),
('7912', 'Actividades de operadores turísticos.'),
('799', 'Otros servicios de reserva y actividades relacionadas.'),
('7990', 'Otros servicios de reserva y actividades relacionadas.'),
('801', 'Actividades de seguridad privada.'),
('8010', 'Actividades de seguridad privada.'),
('802', 'Actividades de servicios de sistemas de seguridad.'),
('8020', 'Actividades de servicios de sistemas de seguridad.'),
('803', 'Actividades de detectives e investigadores privados.'),
('8030', 'Actividades de detectives e investigadores privados.'),
('811', 'Actividades combinadas de apoyo a instalaciones.'),
('8110', 'Actividades combinadas de apoyo a instalaciones.'),
('812', 'Actividades de limpieza.'),
('8121', 'Limpieza general interior de edificios.'),
('8129', 'Otras actividades de limpieza de edificios e instalaciones industriales.'),
('813', 'Actividades de paisajismo y servicios de mantenimiento conexos.'),
('8130', 'Actividades de paisajismo y servicios de mantenimiento conexos.'),
('821', 'Actividades administrativas y de apoyo de oficina.'),
('8211', 'Actividades combinadas de servicios administrativos de oficina'),
('8219', 'Fotocopiado, preparación de documentos y otras actividades especializadas de apoyo a oficina.'),
('822', 'Actividades de centros de llamadas (Call center).'),
('8220', 'Actividades de centros de llamadas (Call center).'),
('823', 'Organización de convenciones y eventos comerciales.'),
('8230', 'Organización de convenciones y eventos comerciales.'),
('829', 'Actividades de servicios de apoyo a las empresas n.c.p.'),
('8291', 'Actividades de agencias de cobranza y oficinas de calificación crediticia.'),
('8292', 'Actividades de envase y empaque.'),
('8299', 'Otras actividades de servicio de apoyo a las empresas n.c.p.'),
('841', 'Administración del Estado y aplicación de la política económica y social de la comunidad.'),
('8411', 'Actividades legislativas de la administración pública.'),
('8412', 'Actividades ejecutivas de la administración pública.'),
('8413', 'Regulación de las actividades de organismos que prestan servicios de salud, educativos, culturales.y otros servicios sociales, excepto servicios de seguridad social.'),
('8414', 'Actividades reguladoras y facilitadoras de la actividad económica.'),
('8415', 'Actividades de los otros órganos de control.'),
('842', 'Prestación de servicios a la comunidad en general.'),
('8421', 'Relaciones exteriores.'),
('8422', 'Actividades de defensa.'),
('8423', 'Orden público y actividades de seguridad.'),
('8424', 'Administración de justicia.'),
('843', 'Actividades de planes de seguridad social de afiliación obligatoria.'),
('8430', 'Actividades de planes de seguridad social de afiliación obligatoria.'),
('851', 'Educación de la primera infancia, preescolar y básica primaria.'),
('8511', 'Educación de la primera infancia.'),
('8512', 'Educación preescolar.'),
('8513', 'Educación básica primaria.'),
('852', 'Educación secundaria y de formación laboral.'),
('8521', 'Educación básica secundaria.'),
('8522', 'Educación media académica.'),
('8523', 'Educación media técnica y de formación laboral.'),
('853', 'Establecimientos que combinan diferentes niveles de educación.'),
('8530', 'Establecimientos que combinan diferentes niveles de educación.'),
('854', 'Educación superior.'),
('8541', 'Educación técnica profesional.'),
('8542', 'Educación tecnológica.'),
('8543', 'Educación de instituciones universitarias o de escuelas tecnológicas.'),
('8544', 'Educación de universidades.'),
('855', 'Otros tipos de educación.'),
('8551', 'Formación académica no formal.'),
('8552', 'Enseñanza deportiva y recreativa.'),
('8553', 'Enseñanza cultural.'),
('8559', 'Otros tipos de educación n.c.p.'),
('856', 'Actividades de apoyo a la educación.'),
('8560', 'Actividades de apoyo a la educación.'),
('861', 'Actividades de hospitales y clínicas, con internación.'),
('8610', 'Actividades de hospitales y clínicas, con internación.'),
('862', 'Actividades de práctica médica y odontológica, sin internación.'),
('8621', 'Actividades de la práctica médica, sin internación.'),
('8622', 'Actividades de la práctica odontológica.'),
('869', 'Otras actividades de atención relacionadas con la salud humana.'),
('8691', 'Actividades de apoyo diagnóstico.'),
('8692', 'Actividades de apoyo terapéutico.'),
('8699', 'Otras actividades de atención de la salud humana.'),
('871', 'Actividades de atención residencial medicalizada de tipo general.'),
('8710', 'Actividades de atención residencial medicalizada de tipo general.'),
('872', 'Actividades de atención residencial, para el cuidado de pacientes con retardo mental, enfermedad mental y consumo de sustancias psicoactivas.'),
('8720', 'Actividades de atención residencial, para el cuidado de pacientes con retardo mental, enfermedad mental y consumo de sustancias psicoactivas.'),
('873', 'Actividades de atención en instituciones para el cuidado de personas mayores y/o discapacitadas.'),
('8730', 'Actividades de atención en instituciones para el cuidado de personas mayores y/o discapacitadas.'),
('879', 'Otras actividades de atención en instituciones con alojamiento.'),
('8790', 'Otras actividades de atención en instituciones con alojamiento'),
('881', 'Actividades de asistencia social sin alojamiento para personas mayores y discapacitadas.'),
('8810', 'Actividades de asistencia social sin alojamiento para personas mayores y discapacitadas.'),
('889', 'Otras actividades de asistencia social sin alojamiento.'),
('8890', 'Otras actividades de asistencia social sin alojamiento.'),
('900', 'Actividades creativas, artísticas y de entretenimiento.'),
('9001', 'Creación literaria.'),
('9002', 'Creación musical.'),
('9003', 'Creación teatral.'),
('9004', 'Creación audiovisual.'),
('9005', 'Artes plásticas y visuales.'),
('9006', 'Actividades teatrales.'),
('9007', 'Actividades de espectáculos musicales en vivo.'),
('9008', 'Otras actividades de espectáculos en vivo.'),
('910', 'Actividades de bibliotecas, archivos, museos y otras actividades culturales.'),
('9101', 'Actividades de bibliotecas y archivos.'),
('9102', 'Actividades y funcionamiento de museos, conservación de edificios y sitios históricos.'),
('9103', 'Actividades de jardines botánicos, zoológicos y reservas naturales.'),
('920', 'Actividades de juegos de azar y apuestas.'),
('9200', ' Actividades de juegos de azar y apuestas.'),
('931', 'Actividades deportivas.'),
('9311', 'Gestión de instalaciones deportivas.'),
('9312', 'Actividades de clubes deportivos.'),
('9319', 'Otras actividades deportivas.'),
('932', 'Otras actividades recreativas y de esparcimiento.'),
('9321', 'Actividades de parques de atracciones y parques temáticos.'),
('9329', 'Otras actividades recreativas y de esparcimiento n.c.p.'),
('941', 'Actividades de asociaciones empresariales y de empleadores, y asociaciones profesionales.'),
('9411', 'Actividades de asociaciones empresariales y de empleadores'),
('9412', 'Actividades de asociaciones profesionales'),
('942', 'Actividades de sindicatos de empleados.'),
('9420', 'Actividades de sindicatos de empleados.'),
('949', 'Actividades de otras asociaciones.'),
('9491', 'Actividades de asociaciones religiosas.'),
('9492', 'Actividades de asociaciones políticas.'),
('9499', 'Actividades de otras asociaciones n.c.p.'),
('951', 'Mantenimiento y reparación de computadores y equipo de comunicaciones.'),
('9511', ' Mantenimiento y reparación de computadores y de equipo periférico.'),
('9512', ' Mantenimiento y reparación de equipos de comunicación.'),
('9521', 'Mantenimiento y reparación de aparatos electrónicos de consumo.'),
('9522', 'Mantenimiento y reparación de aparatos y equipos domésticos y de jardinería.'),
('9523', 'Reparación de calzado y artículos de cuero.'),
('9524', 'Reparación de muebles y accesorios para el hogar.'),
('9529', 'Mantenimiento y reparación de otros efectos personales y enseres domésticos.'),
('960', 'Otras actividades de servicios personales.'),
('9601', 'Lavado y limpieza, incluso la limpieza en seco, de productos textiles y de piel.'),
('9602', 'Peluquería y otros tratamientos de belleza.'),
('9603', 'Pompas fúnebres y actividades relacionadas.'),
('9609', 'Otras actividades de servicios personales n.c.p.'),
('970', ' Actividades de los hogares individuales como empleadores de personal doméstico.'),
('9700', ' Actividades de los hogares individuales como empleadores de personal doméstico.'),
('981', 'Actividades no diferenciadas de los hogares individuales como productores de bienes para uso propio.'),
('9810', 'Actividades no diferenciadas de los hogares individuales como productores de bienes para uso propio.');
INSERT INTO `np_activeco` (`codigo`, `descrip`) VALUES
('982', 'Actividades no diferenciadas de los hogares individuales como productores de servicios para uso propio.'),
('9820', 'Actividades no diferenciadas de los hogares individuales como productores de servicios para uso propio.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_cargos`
--

CREATE TABLE `np_cargos` (
  `id_cargo` varchar(10) NOT NULL,
  `nom_cargo` varchar(50) NOT NULL COMMENT 'Nombre Cargo',
  `sup_cargo` int(11) NOT NULL COMMENT 'Cargo Superior',
  `area_cargo` int(11) NOT NULL,
  `codigo_helisa` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Cargos de Empleados';

--
-- Volcado de datos para la tabla `np_cargos`
--

INSERT INTO `np_cargos` (`id_cargo`, `nom_cargo`, `sup_cargo`, `area_cargo`, `codigo_helisa`) VALUES
('110000', 'Presidente', 110000, 65, ''),
('111000', 'Gerente General', 110000, 64, ''),
('111100', 'Contador', 111000, 18, ''),
('111110', 'Asistente Contable', 111100, 18, ''),
('111111', 'Auxiliar Contable', 111100, 18, ''),
('111200', 'Director Comercial', 111000, 20, ''),
('111210', 'Asesor Comercial', 111200, 20, ''),
('111300', 'Director Servicio Técnico', 111000, 22, ''),
('111310', 'Especialista Técnico', 111300, 22, ''),
('111311', 'Técnico Nivel 1', 111300, 22, ''),
('111312', 'Técnico Nivel 2', 111300, 22, ''),
('111313', 'Técnico Nivel 3', 111300, 22, ''),
('111400', 'Director Ingeniería', 111000, 19, ''),
('111410', 'Ingeniero', 111400, 19, ''),
('111500', 'Director de Compras', 111000, 21, ''),
('111510', 'Asistente de Compras', 111500, 21, ''),
('111511', 'Almacenista', 111500, 21, ''),
('111512', 'Auxiliar de Almacén ', 111500, 21, ''),
('111600', 'Super Administrador', 111000, 64, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_ciudades`
--

CREATE TABLE `np_ciudades` (
  `id_ciudad` int(11) NOT NULL DEFAULT 0 COMMENT 'Id',
  `nom_ciudad` varchar(40) NOT NULL COMMENT 'Nombre Ciudad',
  `id_dpto` int(11) NOT NULL COMMENT 'Id Departamento',
  `id_pais` int(11) NOT NULL COMMENT 'Id País'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ciudades';

--
-- Volcado de datos para la tabla `np_ciudades`
--

INSERT INTO `np_ciudades` (`id_ciudad`, `nom_ciudad`, `id_dpto`, `id_pais`) VALUES
(2, 'HONGKONG', 0, 6),
(4, 'MIAMI', 0, 29),
(5, 'HOUSTON', 0, 29),
(6, 'CIUDAD DE PANAMA', 0, 20),
(7, 'NINGBO', 0, 6),
(8, 'LONDON', 0, 150),
(9, 'NUEVO LEON', 0, 18),
(10, 'GENERIC', 0, 7),
(11, 'AMSTERDAM', 0, 19),
(12, 'PARIS', 0, 10),
(13, 'TOMBALL', 0, 29),
(14, 'GUATEMALA, GT', 0, 12),
(15, 'ESTADO DE MEXICO', 0, 18),
(16, 'LIMA', 0, 22),
(5001, 'MEDELLÍN', 0, 7),
(5002, 'ABEJORRAL', 0, 7),
(5004, 'ABRIAQUÍ', 0, 7),
(5021, 'ALEJANDRÍA', 0, 7),
(5030, 'AMAGÁ', 0, 7),
(5031, 'AMALFI', 0, 7),
(5034, 'ANDES', 0, 7),
(5036, 'ANGELÓPOLIS', 0, 7),
(5038, 'ANGOSTURA', 0, 7),
(5040, 'ANORÍ', 0, 7),
(5042, 'SANTAFÉ DE ANTIOQUIA', 0, 7),
(5044, 'ANZA', 0, 7),
(5045, 'APARTADÓ', 0, 7),
(5051, 'ARBOLETES', 0, 7),
(5055, 'ARGELIA', 0, 7),
(5059, 'ARMENIA', 0, 7),
(5079, 'BARBOSA', 0, 7),
(5086, 'BELMIRA', 0, 7),
(5088, 'BELLO', 0, 7),
(5091, 'BETANIA', 0, 7),
(5093, 'BETULIA', 0, 7),
(5101, 'CIUDAD BOLÍVAR', 0, 7),
(5107, 'BRICEÑO', 0, 7),
(5113, 'BURITICÁ', 0, 7),
(5120, 'CÁCERES', 0, 7),
(5125, 'CAICEDO', 0, 7),
(5129, 'CALDAS', 0, 7),
(5134, 'CAMPAMENTO', 0, 7),
(5138, 'CAÑASGORDAS', 0, 7),
(5142, 'CARACOLÍ', 0, 7),
(5145, 'CARAMANTA', 0, 7),
(5147, 'CAREPA', 0, 7),
(5148, 'EL CARMEN DE VIBORAL', 0, 7),
(5150, 'CAROLINA', 0, 7),
(5154, 'CAUCASIA', 0, 7),
(5172, 'CHIGORODÓ', 0, 7),
(5190, 'CISNEROS', 0, 7),
(5197, 'COCORNÁ', 0, 7),
(5206, 'CONCEPCIÓN', 0, 7),
(5209, 'CONCORDIA', 0, 7),
(5212, 'COPACABANA', 0, 7),
(5234, 'DABEIBA', 0, 7),
(5237, 'DONMATÍAS', 0, 7),
(5240, 'EBÉJICO', 0, 7),
(5250, 'EL BAGRE', 0, 7),
(5264, 'ENTRERRIOS', 0, 7),
(5266, 'ENVIGADO', 0, 7),
(5282, 'FREDONIA', 0, 7),
(5284, 'FRONTINO', 0, 7),
(5306, 'GIRALDO', 0, 7),
(5308, 'GIRARDOTA', 0, 7),
(5310, 'GÓMEZ PLATA', 0, 7),
(5313, 'GRANADA', 0, 7),
(5315, 'GUADALUPE', 0, 7),
(5318, 'GUARNE', 0, 7),
(5321, 'GUATAPE', 0, 7),
(5347, 'HELICONIA', 0, 7),
(5353, 'HISPANIA', 0, 7),
(5360, 'ITAGUI', 0, 7),
(5361, 'ITUANGO', 0, 7),
(5364, 'JARDÍN', 0, 7),
(5368, 'JERICÓ', 0, 7),
(5376, 'LA CEJA', 0, 7),
(5380, 'LA ESTRELLA', 0, 7),
(5390, 'LA PINTADA', 0, 7),
(5400, 'LA UNIÓN', 0, 7),
(5411, 'LIBORINA', 0, 7),
(5425, 'MACEO', 0, 7),
(5440, 'MARINILLA', 0, 7),
(5467, 'MONTEBELLO', 0, 7),
(5475, 'MURINDÓ', 0, 7),
(5480, 'MUTATÁ', 0, 7),
(5483, 'NARIÑO', 0, 7),
(5490, 'NECOCLÍ', 0, 7),
(5495, 'NECHÍ', 0, 7),
(5501, 'OLAYA', 0, 7),
(5541, 'PEÑOL', 0, 7),
(5543, 'PEQUE', 0, 7),
(5576, 'PUEBLORRICO', 0, 7),
(5579, 'PUERTO BERRÍO', 0, 7),
(5585, 'PUERTO NARE', 0, 7),
(5591, 'PUERTO TRIUNFO', 0, 7),
(5604, 'REMEDIOS', 0, 7),
(5607, 'RETIRO', 0, 7),
(5615, 'RIONEGRO', 0, 7),
(5628, 'SABANALARGA', 0, 7),
(5631, 'SABANETA', 0, 7),
(5642, 'SALGAR', 0, 7),
(5647, 'SAN ANDRÉS DE CUERQUÍA', 0, 7),
(5649, 'SAN CARLOS', 0, 7),
(5652, 'SAN FRANCISCO', 0, 7),
(5656, 'SAN JERÓNIMO', 0, 7),
(5658, 'SAN JOSÉ DE LA MONTAÑA', 0, 7),
(5659, 'SAN JUAN DE URABÁ', 0, 7),
(5660, 'SAN LUIS', 0, 7),
(5664, 'SAN PEDRO DE LOS MILAGROS', 0, 7),
(5665, 'SAN PEDRO DE URABA', 0, 7),
(5667, 'SAN RAFAEL', 0, 7),
(5670, 'SAN ROQUE', 0, 7),
(5674, 'SAN VICENTE', 0, 7),
(5679, 'SANTA BÁRBARA', 0, 7),
(5686, 'SANTA ROSA DE OSOS', 0, 7),
(5690, 'SANTO DOMINGO', 0, 7),
(5697, 'EL SANTUARIO', 0, 7),
(5736, 'SEGOVIA', 0, 7),
(5756, 'SONSON', 0, 7),
(5761, 'SOPETRÁN', 0, 7),
(5789, 'TÁMESIS', 0, 7),
(5790, 'TARAZÁ', 0, 7),
(5792, 'TARSO', 0, 7),
(5809, 'TITIRIBÍ', 0, 7),
(5819, 'TOLEDO', 0, 7),
(5837, 'TURBO', 0, 7),
(5842, 'URAMITA', 0, 7),
(5847, 'URRAO', 0, 7),
(5854, 'VALDIVIA', 0, 7),
(5856, 'VALPARAÍSO', 0, 7),
(5858, 'VEGACHÍ', 0, 7),
(5861, 'VENECIA', 0, 7),
(5873, 'VIGÍA DEL FUERTE', 0, 7),
(5885, 'YALÍ', 0, 7),
(5887, 'YARUMAL', 0, 7),
(5890, 'YOLOMBÓ', 0, 7),
(5893, 'YONDÓ', 0, 7),
(5895, 'ZARAGOZA', 0, 7),
(8001, 'BARRANQUILLA', 0, 7),
(8078, 'BARANOA', 0, 7),
(8137, 'CAMPO DE LA CRUZ', 0, 7),
(8141, 'CANDELARIA', 0, 7),
(8296, 'GALAPA', 0, 7),
(8372, 'JUAN DE ACOSTA', 0, 7),
(8421, 'LURUACO', 0, 7),
(8433, 'MALAMBO', 0, 7),
(8436, 'MANATÍ', 0, 7),
(8520, 'PALMAR DE VARELA', 0, 7),
(8549, 'PIOJÓ', 0, 7),
(8558, 'POLONUEVO', 0, 7),
(8560, 'PONEDERA', 0, 7),
(8573, 'PUERTO COLOMBIA', 0, 7),
(8606, 'REPELÓN', 0, 7),
(8634, 'SABANAGRANDE', 0, 7),
(8638, 'SABANALARGA', 0, 7),
(8675, 'SANTA LUCÍA', 0, 7),
(8685, 'SANTO TOMÁS', 0, 7),
(8758, 'SOLEDAD', 0, 7),
(8770, 'SUAN', 0, 7),
(8832, 'TUBARÁ', 0, 7),
(8849, 'USIACURÍ', 0, 7),
(11001, 'BOGOTÁ, D.C.', 0, 7),
(13001, 'CARTAGENA', 0, 7),
(13006, 'ACHÍ', 0, 7),
(13030, 'ALTOS DEL ROSARIO', 0, 7),
(13042, 'ARENAL', 0, 7),
(13052, 'ARJONA', 0, 7),
(13062, 'ARROYOHONDO', 0, 7),
(13074, 'BARRANCO DE LOBA', 0, 7),
(13140, 'CALAMAR', 0, 7),
(13160, 'CANTAGALLO', 0, 7),
(13188, 'CICUCO', 0, 7),
(13212, 'CÓRDOBA', 0, 7),
(13222, 'CLEMENCIA', 0, 7),
(13244, 'EL CARMEN DE BOLÍVAR', 0, 7),
(13248, 'EL GUAMO', 0, 7),
(13268, 'EL PEÑÓN', 0, 7),
(13300, 'HATILLO DE LOBA', 0, 7),
(13430, 'MAGANGUÉ', 0, 7),
(13433, 'MAHATES', 0, 7),
(13440, 'MARGARITA', 0, 7),
(13442, 'MARÍA LA BAJA', 0, 7),
(13458, 'MONTECRISTO', 0, 7),
(13468, 'MOMPÓS', 0, 7),
(13473, 'MORALES', 0, 7),
(13490, 'NOROSÍ', 0, 7),
(13549, 'PINILLOS', 0, 7),
(13580, 'REGIDOR', 0, 7),
(13600, 'RÍO VIEJO', 0, 7),
(13620, 'SAN CRISTÓBAL', 0, 7),
(13647, 'SAN ESTANISLAO', 0, 7),
(13650, 'SAN FERNANDO', 0, 7),
(13654, 'SAN JACINTO', 0, 7),
(13655, 'SAN JACINTO DEL CAUCA', 0, 7),
(13657, 'SAN JUAN NEPOMUCENO', 0, 7),
(13667, 'SAN MARTÍN DE LOBA', 0, 7),
(13670, 'SAN PABLO', 0, 7),
(13673, 'SANTA CATALINA', 0, 7),
(13683, 'SANTA ROSA', 0, 7),
(13688, 'SANTA ROSA DEL SUR', 0, 7),
(13744, 'SIMITÍ', 0, 7),
(13760, 'SOPLAVIENTO', 0, 7),
(13780, 'TALAIGUA NUEVO', 0, 7),
(13810, 'TIQUISIO', 0, 7),
(13836, 'TURBACO', 0, 7),
(13838, 'TURBANÁ', 0, 7),
(13873, 'VILLANUEVA', 0, 7),
(13894, 'ZAMBRANO', 0, 7),
(15001, 'TUNJA', 0, 7),
(15022, 'ALMEIDA', 0, 7),
(15047, 'AQUITANIA', 0, 7),
(15051, 'ARCABUCO', 0, 7),
(15087, 'BELÉN', 0, 7),
(15090, 'BERBEO', 0, 7),
(15092, 'BETÉITIVA', 0, 7),
(15097, 'BOAVITA', 0, 7),
(15104, 'BOYACÁ', 0, 7),
(15106, 'BRICEÑO', 0, 7),
(15109, 'BUENAVISTA', 0, 7),
(15114, 'BUSBANZÁ', 0, 7),
(15131, 'CALDAS', 0, 7),
(15135, 'CAMPOHERMOSO', 0, 7),
(15162, 'CERINZA', 0, 7),
(15172, 'CHINAVITA', 0, 7),
(15176, 'CHIQUINQUIRÁ', 0, 7),
(15180, 'CHISCAS', 0, 7),
(15183, 'CHITA', 0, 7),
(15185, 'CHITARAQUE', 0, 7),
(15187, 'CHIVATÁ', 0, 7),
(15189, 'CIÉNEGA', 0, 7),
(15204, 'CÓMBITA', 0, 7),
(15212, 'COPER', 0, 7),
(15215, 'CORRALES', 0, 7),
(15218, 'COVARACHÍA', 0, 7),
(15223, 'CUBARÁ', 0, 7),
(15224, 'CUCAITA', 0, 7),
(15226, 'CUÍTIVA', 0, 7),
(15232, 'CHÍQUIZA', 0, 7),
(15236, 'CHIVOR', 0, 7),
(15238, 'DUITAMA', 0, 7),
(15244, 'EL COCUY', 0, 7),
(15248, 'EL ESPINO', 0, 7),
(15272, 'FIRAVITOBA', 0, 7),
(15276, 'FLORESTA', 0, 7),
(15293, 'GACHANTIVÁ', 0, 7),
(15296, 'GAMEZA', 0, 7),
(15299, 'GARAGOA', 0, 7),
(15317, 'GUACAMAYAS', 0, 7),
(15322, 'GUATEQUE', 0, 7),
(15325, 'GUAYATÁ', 0, 7),
(15332, 'GÜICÁN', 0, 7),
(15362, 'IZA', 0, 7),
(15367, 'JENESANO', 0, 7),
(15368, 'JERICÓ', 0, 7),
(15377, 'LABRANZAGRANDE', 0, 7),
(15380, 'LA CAPILLA', 0, 7),
(15401, 'LA VICTORIA', 0, 7),
(15403, 'LA UVITA', 0, 7),
(15407, 'VILLA DE LEYVA', 0, 7),
(15425, 'MACANAL', 0, 7),
(15442, 'MARIPÍ', 0, 7),
(15455, 'MIRAFLORES', 0, 7),
(15464, 'MONGUA', 0, 7),
(15466, 'MONGUÍ', 0, 7),
(15469, 'MONIQUIRÁ', 0, 7),
(15476, 'MOTAVITA', 0, 7),
(15480, 'MUZO', 0, 7),
(15491, 'NOBSA', 0, 7),
(15494, 'NUEVO COLÓN', 0, 7),
(15500, 'OICATÁ', 0, 7),
(15507, 'OTANCHE', 0, 7),
(15511, 'PACHAVITA', 0, 7),
(15514, 'PÁEZ', 0, 7),
(15516, 'PAIPA', 0, 7),
(15518, 'PAJARITO', 0, 7),
(15522, 'PANQUEBA', 0, 7),
(15531, 'PAUNA', 0, 7),
(15533, 'PAYA', 0, 7),
(15537, 'PAZ DE RÍO', 0, 7),
(15542, 'PESCA', 0, 7),
(15550, 'PISBA', 0, 7),
(15572, 'PUERTO BOYACÁ', 0, 7),
(15580, 'QUÍPAMA', 0, 7),
(15599, 'RAMIRIQUÍ', 0, 7),
(15600, 'RÁQUIRA', 0, 7),
(15621, 'RONDÓN', 0, 7),
(15632, 'SABOYÁ', 0, 7),
(15638, 'SÁCHICA', 0, 7),
(15646, 'SAMACÁ', 0, 7),
(15660, 'SAN EDUARDO', 0, 7),
(15664, 'SAN JOSÉ DE PARE', 0, 7),
(15667, 'SAN LUIS DE GACENO', 0, 7),
(15673, 'SAN MATEO', 0, 7),
(15676, 'SAN MIGUEL DE SEMA', 0, 7),
(15681, 'SAN PABLO DE BORBUR', 0, 7),
(15686, 'SANTANA', 0, 7),
(15690, 'SANTA MARÍA', 0, 7),
(15693, 'SANTA ROSA DE VITERBO', 0, 7),
(15696, 'SANTA SOFÍA', 0, 7),
(15720, 'SATIVANORTE', 0, 7),
(15723, 'SATIVASUR', 0, 7),
(15740, 'SIACHOQUE', 0, 7),
(15753, 'SOATÁ', 0, 7),
(15755, 'SOCOTÁ', 0, 7),
(15757, 'SOCHA', 0, 7),
(15759, 'SOGAMOSO', 0, 7),
(15761, 'SOMONDOCO', 0, 7),
(15762, 'SORA', 0, 7),
(15763, 'SOTAQUIRÁ', 0, 7),
(15764, 'SORACÁ', 0, 7),
(15774, 'SUSACÓN', 0, 7),
(15776, 'SUTAMARCHÁN', 0, 7),
(15778, 'SUTATENZA', 0, 7),
(15790, 'TASCO', 0, 7),
(15798, 'TENZA', 0, 7),
(15804, 'TIBANÁ', 0, 7),
(15806, 'TIBASOSA', 0, 7),
(15808, 'TINJACÁ', 0, 7),
(15810, 'TIPACOQUE', 0, 7),
(15814, 'TOCA', 0, 7),
(15816, 'TOGÜÍ', 0, 7),
(15820, 'TÓPAGA', 0, 7),
(15822, 'TOTA', 0, 7),
(15832, 'TUNUNGUÁ', 0, 7),
(15835, 'TURMEQUÉ', 0, 7),
(15837, 'TUTA', 0, 7),
(15839, 'TUTAZÁ', 0, 7),
(15842, 'UMBITA', 0, 7),
(15861, 'VENTAQUEMADA', 0, 7),
(15879, 'VIRACACHÁ', 0, 7),
(15897, 'ZETAQUIRA', 0, 7),
(17001, 'MANIZALES', 0, 7),
(17013, 'AGUADAS', 0, 7),
(17042, 'ANSERMA', 0, 7),
(17050, 'ARANZAZU', 0, 7),
(17088, 'BELALCÁZAR', 0, 7),
(17174, 'CHINCHINÁ', 0, 7),
(17272, 'FILADELFIA', 0, 7),
(17380, 'LA DORADA', 0, 7),
(17388, 'LA MERCED', 0, 7),
(17433, 'MANZANARES', 0, 7),
(17442, 'MARMATO', 0, 7),
(17444, 'MARQUETALIA', 0, 7),
(17446, 'MARULANDA', 0, 7),
(17486, 'NEIRA', 0, 7),
(17495, 'NORCASIA', 0, 7),
(17513, 'PÁCORA', 0, 7),
(17524, 'PALESTINA', 0, 7),
(17541, 'PENSILVANIA', 0, 7),
(17614, 'RIOSUCIO', 0, 7),
(17616, 'RISARALDA', 0, 7),
(17653, 'SALAMINA', 0, 7),
(17662, 'SAMANÁ', 0, 7),
(17665, 'SAN JOSÉ', 0, 7),
(17777, 'SUPÍA', 0, 7),
(17867, 'VICTORIA', 0, 7),
(17873, 'VILLAMARÍA', 0, 7),
(17877, 'VITERBO', 0, 7),
(18001, 'FLORENCIA', 0, 7),
(18029, 'ALBANIA', 0, 7),
(18094, 'BELÉN DE LOS ANDAQUÍES', 0, 7),
(18150, 'CARTAGENA DEL CHAIRÁ', 0, 7),
(18205, 'CURILLO', 0, 7),
(18247, 'EL DONCELLO', 0, 7),
(18256, 'EL PAUJIL', 0, 7),
(18410, 'LA MONTAÑITA', 0, 7),
(18460, 'MILÁN', 0, 7),
(18479, 'MORELIA', 0, 7),
(18592, 'PUERTO RICO', 0, 7),
(18610, 'SAN JOSÉ DEL FRAGUA', 0, 7),
(18753, 'SAN VICENTE DEL CAGUÁN', 0, 7),
(18756, 'SOLANO', 0, 7),
(18785, 'SOLITA', 0, 7),
(18860, 'VALPARAÍSO', 0, 7),
(19001, 'POPAYÁN', 0, 7),
(19022, 'ALMAGUER', 0, 7),
(19050, 'ARGELIA', 0, 7),
(19075, 'BALBOA', 0, 7),
(19100, 'BOLÍVAR', 0, 7),
(19110, 'BUENOS AIRES', 0, 7),
(19130, 'CAJIBÍO', 0, 7),
(19137, 'CALDONO', 0, 7),
(19142, 'CALOTO', 0, 7),
(19212, 'CORINTO', 0, 7),
(19256, 'EL TAMBO', 0, 7),
(19290, 'FLORENCIA', 0, 7),
(19300, 'GUACHENÉ', 0, 7),
(19318, 'GUAPI', 0, 7),
(19355, 'INZÁ', 0, 7),
(19364, 'JAMBALÓ', 0, 7),
(19392, 'LA SIERRA', 0, 7),
(19397, 'LA VEGA', 0, 7),
(19418, 'LÓPEZ', 0, 7),
(19450, 'MERCADERES', 0, 7),
(19455, 'MIRANDA', 0, 7),
(19473, 'MORALES', 0, 7),
(19513, 'PADILLA', 0, 7),
(19517, 'PAEZ', 0, 7),
(19532, 'PATÍA', 0, 7),
(19533, 'PIAMONTE', 0, 7),
(19548, 'PIENDAMÓ', 0, 7),
(19573, 'PUERTO TEJADA', 0, 7),
(19585, 'PURACÉ', 0, 7),
(19622, 'ROSAS', 0, 7),
(19693, 'SAN SEBASTIÁN', 0, 7),
(19698, 'SANTANDER DE QUILICHAO', 0, 7),
(19701, 'SANTA ROSA', 0, 7),
(19743, 'SILVIA', 0, 7),
(19760, 'SOTARA', 0, 7),
(19780, 'SUÁREZ', 0, 7),
(19785, 'SUCRE', 0, 7),
(19807, 'TIMBÍO', 0, 7),
(19809, 'TIMBIQUÍ', 0, 7),
(19821, 'TORIBIO', 0, 7),
(19824, 'TOTORÓ', 0, 7),
(19845, 'VILLA RICA', 0, 7),
(20001, 'VALLEDUPAR', 0, 7),
(20011, 'AGUACHICA', 0, 7),
(20013, 'AGUSTÍN CODAZZI', 0, 7),
(20032, 'ASTREA', 0, 7),
(20045, 'BECERRIL', 0, 7),
(20060, 'BOSCONIA', 0, 7),
(20175, 'CHIMICHAGUA', 0, 7),
(20178, 'CHIRIGUANÁ', 0, 7),
(20228, 'CURUMANÍ', 0, 7),
(20238, 'EL COPEY', 0, 7),
(20250, 'EL PASO', 0, 7),
(20295, 'GAMARRA', 0, 7),
(20310, 'GONZÁLEZ', 0, 7),
(20383, 'LA GLORIA', 0, 7),
(20400, 'LA JAGUA DE IBIRICO', 0, 7),
(20443, 'MANAURE', 0, 7),
(20517, 'PAILITAS', 0, 7),
(20550, 'PELAYA', 0, 7),
(20570, 'PUEBLO BELLO', 0, 7),
(20614, 'RÍO DE ORO', 0, 7),
(20621, 'LA PAZ', 0, 7),
(20710, 'SAN ALBERTO', 0, 7),
(20750, 'SAN DIEGO', 0, 7),
(20770, 'SAN MARTÍN', 0, 7),
(20787, 'TAMALAMEQUE', 0, 7),
(23001, 'MONTERÍA', 0, 7),
(23068, 'AYAPEL', 0, 7),
(23079, 'BUENAVISTA', 0, 7),
(23090, 'CANALETE', 0, 7),
(23162, 'CERETÉ', 0, 7),
(23168, 'CHIMÁ', 0, 7),
(23182, 'CHINÚ', 0, 7),
(23189, 'CIÉNAGA DE ORO', 0, 7),
(23300, 'COTORRA', 0, 7),
(23350, 'LA APARTADA', 0, 7),
(23417, 'LORICA', 0, 7),
(23419, 'LOS CÓRDOBAS', 0, 7),
(23464, 'MOMIL', 0, 7),
(23466, 'MONTELÍBANO', 0, 7),
(23500, 'MOÑITOS', 0, 7),
(23555, 'PLANETA RICA', 0, 7),
(23570, 'PUEBLO NUEVO', 0, 7),
(23574, 'PUERTO ESCONDIDO', 0, 7),
(23580, 'PUERTO LIBERTADOR', 0, 7),
(23586, 'PURÍSIMA', 0, 7),
(23660, 'SAHAGÚN', 0, 7),
(23670, 'SAN ANDRÉS SOTAVENTO', 0, 7),
(23672, 'SAN ANTERO', 0, 7),
(23675, 'SAN BERNARDO DEL VIENTO', 0, 7),
(23678, 'SAN CARLOS', 0, 7),
(23682, 'SAN JOSÉ DE URÉ', 0, 7),
(23686, 'SAN PELAYO', 0, 7),
(23807, 'TIERRALTA', 0, 7),
(23815, 'TUCHÍN', 0, 7),
(23855, 'VALENCIA', 0, 7),
(25001, 'AGUA DE DIOS', 0, 7),
(25019, 'ALBÁN', 0, 7),
(25035, 'ANAPOIMA', 0, 7),
(25040, 'ANOLAIMA', 0, 7),
(25053, 'ARBELÁEZ', 0, 7),
(25086, 'BELTRÁN', 0, 7),
(25095, 'BITUIMA', 0, 7),
(25099, 'BOJACÁ', 0, 7),
(25120, 'CABRERA', 0, 7),
(25123, 'CACHIPAY', 0, 7),
(25126, 'CAJICÁ', 0, 7),
(25148, 'CAPARRAPÍ', 0, 7),
(25151, 'CAQUEZA', 0, 7),
(25154, 'CARMEN DE CARUPA', 0, 7),
(25168, 'CHAGUANÍ', 0, 7),
(25175, 'CHÍA', 0, 7),
(25178, 'CHIPAQUE', 0, 7),
(25181, 'CHOACHÍ', 0, 7),
(25183, 'CHOCONTÁ', 0, 7),
(25200, 'COGUA', 0, 7),
(25214, 'COTA', 0, 7),
(25224, 'CUCUNUBÁ', 0, 7),
(25245, 'EL COLEGIO', 0, 7),
(25258, 'EL PEÑÓN', 0, 7),
(25260, 'EL ROSAL', 0, 7),
(25269, 'FACATATIVÁ', 0, 7),
(25279, 'FOMEQUE', 0, 7),
(25281, 'FOSCA', 0, 7),
(25286, 'FUNZA', 0, 7),
(25288, 'FÚQUENE', 0, 7),
(25290, 'FUSAGASUGÁ', 0, 7),
(25293, 'GACHALA', 0, 7),
(25295, 'GACHANCIPÁ', 0, 7),
(25297, 'GACHETÁ', 0, 7),
(25299, 'GAMA', 0, 7),
(25307, 'GIRARDOT', 0, 7),
(25312, 'GRANADA', 0, 7),
(25317, 'GUACHETÁ', 0, 7),
(25320, 'GUADUAS', 0, 7),
(25322, 'GUASCA', 0, 7),
(25324, 'GUATAQUÍ', 0, 7),
(25326, 'GUATAVITA', 0, 7),
(25328, 'GUAYABAL DE SIQUIMA', 0, 7),
(25335, 'GUAYABETAL', 0, 7),
(25339, 'GUTIÉRREZ', 0, 7),
(25368, 'JERUSALÉN', 0, 7),
(25372, 'JUNÍN', 0, 7),
(25377, 'LA CALERA', 0, 7),
(25386, 'LA MESA', 0, 7),
(25394, 'LA PALMA', 0, 7),
(25398, 'LA PEÑA', 0, 7),
(25402, 'LA VEGA', 0, 7),
(25407, 'LENGUAZAQUE', 0, 7),
(25426, 'MACHETA', 0, 7),
(25430, 'MADRID', 0, 7),
(25436, 'MANTA', 0, 7),
(25438, 'MEDINA', 0, 7),
(25473, 'MOSQUERA', 0, 7),
(25483, 'NARIÑO', 0, 7),
(25486, 'NEMOCÓN', 0, 7),
(25488, 'NILO', 0, 7),
(25489, 'NIMAIMA', 0, 7),
(25491, 'NOCAIMA', 0, 7),
(25506, 'VENECIA', 0, 7),
(25513, 'PACHO', 0, 7),
(25518, 'PAIME', 0, 7),
(25524, 'PANDI', 0, 7),
(25530, 'PARATEBUENO', 0, 7),
(25535, 'PASCA', 0, 7),
(25572, 'PUERTO SALGAR', 0, 7),
(25580, 'PULÍ', 0, 7),
(25592, 'QUEBRADANEGRA', 0, 7),
(25594, 'QUETAME', 0, 7),
(25596, 'QUIPILE', 0, 7),
(25599, 'APULO', 0, 7),
(25612, 'RICAURTE', 0, 7),
(25645, 'SAN ANTONIO DEL TEQUENDAM', 0, 7),
(25649, 'SAN BERNARDO', 0, 7),
(25653, 'SAN CAYETANO', 0, 7),
(25658, 'SAN FRANCISCO', 0, 7),
(25662, 'SAN JUAN DE RÍO SECO', 0, 7),
(25718, 'SASAIMA', 0, 7),
(25736, 'SESQUILÉ', 0, 7),
(25740, 'SIBATÉ', 0, 7),
(25743, 'SILVANIA', 0, 7),
(25745, 'SIMIJACA', 0, 7),
(25754, 'SOACHA', 0, 7),
(25758, 'SOPÓ', 0, 7),
(25769, 'SUBACHOQUE', 0, 7),
(25772, 'SUESCA', 0, 7),
(25777, 'SUPATÁ', 0, 7),
(25779, 'SUSA', 0, 7),
(25781, 'SUTATAUSA', 0, 7),
(25785, 'TABIO', 0, 7),
(25793, 'TAUSA', 0, 7),
(25797, 'TENA', 0, 7),
(25799, 'TENJO', 0, 7),
(25805, 'TIBACUY', 0, 7),
(25807, 'TIBIRITA', 0, 7),
(25815, 'TOCAIMA', 0, 7),
(25817, 'TOCANCIPÁ', 0, 7),
(25823, 'TOPAIPÍ', 0, 7),
(25839, 'UBALÁ', 0, 7),
(25841, 'UBAQUE', 0, 7),
(25843, 'VILLA DE SAN DIEGO DE UBA', 0, 7),
(25845, 'UNE', 0, 7),
(25851, 'ÚTICA', 0, 7),
(25862, 'VERGARA', 0, 7),
(25867, 'VIANÍ', 0, 7),
(25871, 'VILLAGÓMEZ', 0, 7),
(25873, 'VILLAPINZÓN', 0, 7),
(25875, 'VILLETA', 0, 7),
(25878, 'VIOTÁ', 0, 7),
(25885, 'YACOPÍ', 0, 7),
(25898, 'ZIPACÓN', 0, 7),
(25899, 'ZIPAQUIRÁ', 0, 7),
(27001, 'QUIBDÓ', 0, 7),
(27006, 'ACANDÍ', 0, 7),
(27025, 'ALTO BAUDÓ', 0, 7),
(27050, 'ATRATO', 0, 7),
(27073, 'BAGADÓ', 0, 7),
(27075, 'BAHÍA SOLANO', 0, 7),
(27077, 'BAJO BAUDÓ', 0, 7),
(27099, 'BOJAYA', 0, 7),
(27135, 'EL CANTÓN DEL SAN PABLO', 0, 7),
(27150, 'CARMEN DEL DARIÉN', 0, 7),
(27160, 'CÉRTEGUI', 0, 7),
(27205, 'CONDOTO', 0, 7),
(27245, 'EL CARMEN DE ATRATO', 0, 7),
(27250, 'EL LITORAL DEL SAN JUAN', 0, 7),
(27361, 'ISTMINA', 0, 7),
(27372, 'JURADÓ', 0, 7),
(27413, 'LLORÓ', 0, 7),
(27425, 'MEDIO ATRATO', 0, 7),
(27430, 'MEDIO BAUDÓ', 0, 7),
(27450, 'MEDIO SAN JUAN', 0, 7),
(27491, 'NÓVITA', 0, 7),
(27495, 'NUQUÍ', 0, 7),
(27580, 'RÍO IRÓ', 0, 7),
(27600, 'RÍO QUITO', 0, 7),
(27615, 'RIOSUCIO', 0, 7),
(27660, 'SAN JOSÉ DEL PALMAR', 0, 7),
(27745, 'SIPÍ', 0, 7),
(27787, 'TADÓ', 0, 7),
(27800, 'UNGUÍA', 0, 7),
(27810, 'UNIÓN PANAMERICANA', 0, 7),
(41001, 'NEIVA', 0, 7),
(41006, 'ACEVEDO', 0, 7),
(41013, 'AGRADO', 0, 7),
(41016, 'AIPE', 0, 7),
(41020, 'ALGECIRAS', 0, 7),
(41026, 'ALTAMIRA', 0, 7),
(41078, 'BARAYA', 0, 7),
(41132, 'CAMPOALEGRE', 0, 7),
(41206, 'COLOMBIA', 0, 7),
(41244, 'ELÍAS', 0, 7),
(41298, 'GARZÓN', 0, 7),
(41306, 'GIGANTE', 0, 7),
(41319, 'GUADALUPE', 0, 7),
(41349, 'HOBO', 0, 7),
(41357, 'IQUIRA', 0, 7),
(41359, 'ISNOS', 0, 7),
(41378, 'LA ARGENTINA', 0, 7),
(41396, 'LA PLATA', 0, 7),
(41483, 'NÁTAGA', 0, 7),
(41503, 'OPORAPA', 0, 7),
(41518, 'PAICOL', 0, 7),
(41524, 'PALERMO', 0, 7),
(41530, 'PALESTINA', 0, 7),
(41548, 'PITAL', 0, 7),
(41551, 'PITALITO', 0, 7),
(41615, 'RIVERA', 0, 7),
(41660, 'SALADOBLANCO', 0, 7),
(41668, 'SAN AGUSTÍN', 0, 7),
(41676, 'SANTA MARÍA', 0, 7),
(41770, 'SUAZA', 0, 7),
(41791, 'TARQUI', 0, 7),
(41797, 'TESALIA', 0, 7),
(41799, 'TELLO', 0, 7),
(41801, 'TERUEL', 0, 7),
(41807, 'TIMANÁ', 0, 7),
(41872, 'VILLAVIEJA', 0, 7),
(41885, 'YAGUARÁ', 0, 7),
(44001, 'RIOHACHA', 0, 7),
(44035, 'ALBANIA', 0, 7),
(44078, 'BARRANCAS', 0, 7),
(44090, 'DIBULLA', 0, 7),
(44098, 'DISTRACCIÓN', 0, 7),
(44110, 'EL MOLINO', 0, 7),
(44279, 'FONSECA', 0, 7),
(44378, 'HATONUEVO', 0, 7),
(44420, 'LA JAGUA DEL PILAR', 0, 7),
(44430, 'MAICAO', 0, 7),
(44560, 'MANAURE', 0, 7),
(44650, 'SAN JUAN DEL CESAR', 0, 7),
(44847, 'URIBIA', 0, 7),
(44855, 'URUMITA', 0, 7),
(44874, 'VILLANUEVA', 0, 7),
(47001, 'SANTA MARTA', 0, 7),
(47030, 'ALGARROBO', 0, 7),
(47053, 'ARACATACA', 0, 7),
(47058, 'ARIGUANÍ', 0, 7),
(47161, 'CERRO SAN ANTONIO', 0, 7),
(47170, 'CHIVOLO', 0, 7),
(47189, 'CIÉNAGA', 0, 7),
(47205, 'CONCORDIA', 0, 7),
(47245, 'EL BANCO', 0, 7),
(47258, 'EL PIÑON', 0, 7),
(47268, 'EL RETÉN', 0, 7),
(47288, 'FUNDACIÓN', 0, 7),
(47318, 'GUAMAL', 0, 7),
(47460, 'NUEVA GRANADA', 0, 7),
(47541, 'PEDRAZA', 0, 7),
(47545, 'PIJIÑO DEL CARMEN', 0, 7),
(47551, 'PIVIJAY', 0, 7),
(47555, 'PLATO', 0, 7),
(47570, 'PUEBLOVIEJO', 0, 7),
(47605, 'REMOLINO', 0, 7),
(47660, 'SABANAS DE SAN ANGEL', 0, 7),
(47675, 'SALAMINA', 0, 7),
(47692, 'SAN SEBASTIÁN DE BUENAVIS', 0, 7),
(47703, 'SAN ZENÓN', 0, 7),
(47707, 'SANTA ANA', 0, 7),
(47720, 'SANTA BÁRBARA DE PINTO', 0, 7),
(47745, 'SITIONUEVO', 0, 7),
(47798, 'TENERIFE', 0, 7),
(47960, 'ZAPAYÁN', 0, 7),
(47980, 'ZONA BANANERA', 0, 7),
(50001, 'VILLAVICENCIO', 0, 7),
(50006, 'ACACÍAS', 0, 7),
(50110, 'BARRANCA DE UPÍA', 0, 7),
(50124, 'CABUYARO', 0, 7),
(50150, 'CASTILLA LA NUEVA', 0, 7),
(50223, 'CUBARRAL', 0, 7),
(50226, 'CUMARAL', 0, 7),
(50245, 'EL CALVARIO', 0, 7),
(50251, 'EL CASTILLO', 0, 7),
(50270, 'EL DORADO', 0, 7),
(50287, 'FUENTE DE ORO', 0, 7),
(50313, 'GRANADA', 0, 7),
(50318, 'GUAMAL', 0, 7),
(50325, 'MAPIRIPÁN', 0, 7),
(50330, 'MESETAS', 0, 7),
(50350, 'LA MACARENA', 0, 7),
(50370, 'URIBE', 0, 7),
(50400, 'LEJANÍAS', 0, 7),
(50450, 'PUERTO CONCORDIA', 0, 7),
(50568, 'PUERTO GAITÁN', 0, 7),
(50573, 'PUERTO LÓPEZ', 0, 7),
(50577, 'PUERTO LLERAS', 0, 7),
(50590, 'PUERTO RICO', 0, 7),
(50606, 'RESTREPO', 0, 7),
(50680, 'SAN CARLOS DE GUAROA', 0, 7),
(50683, 'SAN JUAN DE ARAMA', 0, 7),
(50686, 'SAN JUANITO', 0, 7),
(50689, 'SAN MARTÍN', 0, 7),
(50711, 'VISTAHERMOSA', 0, 7),
(52001, 'PASTO', 0, 7),
(52019, 'ALBÁN', 0, 7),
(52022, 'ALDANA', 0, 7),
(52036, 'ANCUYÁ', 0, 7),
(52051, 'ARBOLEDA', 0, 7),
(52079, 'BARBACOAS', 0, 7),
(52083, 'BELÉN', 0, 7),
(52110, 'BUESACO', 0, 7),
(52203, 'COLÓN', 0, 7),
(52207, 'CONSACA', 0, 7),
(52210, 'CONTADERO', 0, 7),
(52215, 'CÓRDOBA', 0, 7),
(52224, 'CUASPUD', 0, 7),
(52227, 'CUMBAL', 0, 7),
(52233, 'CUMBITARA', 0, 7),
(52240, 'CHACHAGÜÍ', 0, 7),
(52250, 'EL CHARCO', 0, 7),
(52254, 'EL PEÑOL', 0, 7),
(52256, 'EL ROSARIO', 0, 7),
(52258, 'EL TABLÓN DE GÓMEZ', 0, 7),
(52260, 'EL TAMBO', 0, 7),
(52287, 'FUNES', 0, 7),
(52317, 'GUACHUCAL', 0, 7),
(52320, 'GUAITARILLA', 0, 7),
(52323, 'GUALMATÁN', 0, 7),
(52352, 'ILES', 0, 7),
(52354, 'IMUÉS', 0, 7),
(52356, 'IPIALES', 0, 7),
(52378, 'LA CRUZ', 0, 7),
(52381, 'LA FLORIDA', 0, 7),
(52385, 'LA LLANADA', 0, 7),
(52390, 'LA TOLA', 0, 7),
(52399, 'LA UNIÓN', 0, 7),
(52405, 'LEIVA', 0, 7),
(52411, 'LINARES', 0, 7),
(52418, 'LOS ANDES', 0, 7),
(52427, 'MAGÜI', 0, 7),
(52435, 'MALLAMA', 0, 7),
(52473, 'MOSQUERA', 0, 7),
(52480, 'NARIÑO', 0, 7),
(52490, 'OLAYA HERRERA', 0, 7),
(52506, 'OSPINA', 0, 7),
(52520, 'FRANCISCO PIZARRO', 0, 7),
(52540, 'POLICARPA', 0, 7),
(52560, 'POTOSÍ', 0, 7),
(52565, 'PROVIDENCIA', 0, 7),
(52573, 'PUERRES', 0, 7),
(52585, 'PUPIALES', 0, 7),
(52612, 'RICAURTE', 0, 7),
(52621, 'ROBERTO PAYÁN', 0, 7),
(52678, 'SAMANIEGO', 0, 7),
(52683, 'SANDONÁ', 0, 7),
(52685, 'SAN BERNARDO', 0, 7),
(52687, 'SAN LORENZO', 0, 7),
(52693, 'SAN PABLO', 0, 7),
(52694, 'SAN PEDRO DE CARTAGO', 0, 7),
(52696, 'SANTA BÁRBARA', 0, 7),
(52699, 'SANTACRUZ', 0, 7),
(52720, 'SAPUYES', 0, 7),
(52786, 'TAMINANGO', 0, 7),
(52788, 'TANGUA', 0, 7),
(52835, 'SAN ANDRES DE TUMACO', 0, 7),
(52838, 'TÚQUERRES', 0, 7),
(52885, 'YACUANQUER', 0, 7),
(54001, 'CÚCUTA', 0, 7),
(54003, 'ABREGO', 0, 7),
(54051, 'ARBOLEDAS', 0, 7),
(54099, 'BOCHALEMA', 0, 7),
(54109, 'BUCARASICA', 0, 7),
(54125, 'CÁCOTA', 0, 7),
(54128, 'CACHIRÁ', 0, 7),
(54172, 'CHINÁCOTA', 0, 7),
(54174, 'CHITAGÁ', 0, 7),
(54206, 'CONVENCIÓN', 0, 7),
(54223, 'CUCUTILLA', 0, 7),
(54239, 'DURANIA', 0, 7),
(54245, 'EL CARMEN', 0, 7),
(54250, 'EL TARRA', 0, 7),
(54261, 'EL ZULIA', 0, 7),
(54313, 'GRAMALOTE', 0, 7),
(54344, 'HACARÍ', 0, 7),
(54347, 'HERRÁN', 0, 7),
(54377, 'LABATECA', 0, 7),
(54385, 'LA ESPERANZA', 0, 7),
(54398, 'LA PLAYA', 0, 7),
(54405, 'LOS PATIOS', 0, 7),
(54418, 'LOURDES', 0, 7),
(54480, 'MUTISCUA', 0, 7),
(54498, 'OCAÑA', 0, 7),
(54518, 'PAMPLONA', 0, 7),
(54520, 'PAMPLONITA', 0, 7),
(54553, 'PUERTO SANTANDER', 0, 7),
(54599, 'RAGONVALIA', 0, 7),
(54660, 'SALAZAR', 0, 7),
(54670, 'SAN CALIXTO', 0, 7),
(54673, 'SAN CAYETANO', 0, 7),
(54680, 'SANTIAGO', 0, 7),
(54720, 'SARDINATA', 0, 7),
(54743, 'SILOS', 0, 7),
(54800, 'TEORAMA', 0, 7),
(54810, 'TIBÚ', 0, 7),
(54820, 'TOLEDO', 0, 7),
(54871, 'VILLA CARO', 0, 7),
(54874, 'VILLA DEL ROSARIO', 0, 7),
(63001, 'ARMENIA', 0, 7),
(63111, 'BUENAVISTA', 0, 7),
(63130, 'CALARCA', 0, 7),
(63190, 'CIRCASIA', 0, 7),
(63212, 'CÓRDOBA', 0, 7),
(63272, 'FILANDIA', 0, 7),
(63302, 'GÉNOVA', 0, 7),
(63401, 'LA TEBAIDA', 0, 7),
(63470, 'MONTENEGRO', 0, 7),
(63548, 'PIJAO', 0, 7),
(63594, 'QUIMBAYA', 0, 7),
(63690, 'SALENTO', 0, 7),
(66001, 'PEREIRA', 0, 7),
(66045, 'APÍA', 0, 7),
(66075, 'BALBOA', 0, 7),
(66088, 'BELÉN DE UMBRÍA', 0, 7),
(66170, 'DOSQUEBRADAS', 0, 7),
(66318, 'GUÁTICA', 0, 7),
(66383, 'LA CELIA', 0, 7),
(66400, 'LA VIRGINIA', 0, 7),
(66440, 'MARSELLA', 0, 7),
(66456, 'MISTRATÓ', 0, 7),
(66572, 'PUEBLO RICO', 0, 7),
(66594, 'QUINCHÍA', 0, 7),
(66682, 'SANTA ROSA DE CABAL', 0, 7),
(66687, 'SANTUARIO', 0, 7),
(68001, 'BUCARAMANGA', 0, 7),
(68013, 'AGUADA', 0, 7),
(68020, 'ALBANIA', 0, 7),
(68051, 'ARATOCA', 0, 7),
(68077, 'BARBOSA', 0, 7),
(68079, 'BARICHARA', 0, 7),
(68081, 'BARRANCABERMEJA', 0, 7),
(68092, 'BETULIA', 0, 7),
(68101, 'BOLÍVAR', 0, 7),
(68121, 'CABRERA', 0, 7),
(68132, 'CALIFORNIA', 0, 7),
(68147, 'CAPITANEJO', 0, 7),
(68152, 'CARCASÍ', 0, 7),
(68160, 'CEPITÁ', 0, 7),
(68162, 'CERRITO', 0, 7),
(68167, 'CHARALÁ', 0, 7),
(68169, 'CHARTA', 0, 7),
(68176, 'CHIMA', 0, 7),
(68179, 'CHIPATÁ', 0, 7),
(68190, 'CIMITARRA', 0, 7),
(68207, 'CONCEPCIÓN', 0, 7),
(68209, 'CONFINES', 0, 7),
(68211, 'CONTRATACIÓN', 0, 7),
(68217, 'COROMORO', 0, 7),
(68229, 'CURITÍ', 0, 7),
(68235, 'EL CARMEN DE CHUCURÍ', 0, 7),
(68245, 'EL GUACAMAYO', 0, 7),
(68250, 'EL PEÑÓN', 0, 7),
(68255, 'EL PLAYÓN', 0, 7),
(68264, 'ENCINO', 0, 7),
(68266, 'ENCISO', 0, 7),
(68271, 'FLORIÁN', 0, 7),
(68276, 'FLORIDABLANCA', 0, 7),
(68296, 'GALÁN', 0, 7),
(68298, 'GAMBITA', 0, 7),
(68307, 'GIRÓN', 0, 7),
(68318, 'GUACA', 0, 7),
(68320, 'GUADALUPE', 0, 7),
(68322, 'GUAPOTÁ', 0, 7),
(68324, 'GUAVATÁ', 0, 7),
(68327, 'GÜEPSA', 0, 7),
(68344, 'HATO', 0, 7),
(68368, 'JESÚS MARÍA', 0, 7),
(68370, 'JORDÁN', 0, 7),
(68377, 'LA BELLEZA', 0, 7),
(68385, 'LANDÁZURI', 0, 7),
(68397, 'LA PAZ', 0, 7),
(68406, 'LEBRIJA', 0, 7),
(68418, 'LOS SANTOS', 0, 7),
(68425, 'MACARAVITA', 0, 7),
(68432, 'MÁLAGA', 0, 7),
(68444, 'MATANZA', 0, 7),
(68464, 'MOGOTES', 0, 7),
(68468, 'MOLAGAVITA', 0, 7),
(68498, 'OCAMONTE', 0, 7),
(68500, 'OIBA', 0, 7),
(68502, 'ONZAGA', 0, 7),
(68522, 'PALMAR', 0, 7),
(68524, 'PALMAS DEL SOCORRO', 0, 7),
(68533, 'PÁRAMO', 0, 7),
(68547, 'PIEDECUESTA', 0, 7),
(68549, 'PINCHOTE', 0, 7),
(68572, 'PUENTE NACIONAL', 0, 7),
(68573, 'PUERTO PARRA', 0, 7),
(68575, 'PUERTO WILCHES', 0, 7),
(68615, 'RIONEGRO', 0, 7),
(68655, 'SABANA DE TORRES', 0, 7),
(68669, 'SAN ANDRÉS', 0, 7),
(68673, 'SAN BENITO', 0, 7),
(68679, 'SAN GIL', 0, 7),
(68682, 'SAN JOAQUÍN', 0, 7),
(68684, 'SAN JOSÉ DE MIRANDA', 0, 7),
(68686, 'SAN MIGUEL', 0, 7),
(68689, 'SAN VICENTE DE CHUCURÍ', 0, 7),
(68705, 'SANTA BÁRBARA', 0, 7),
(68720, 'SANTA HELENA DEL OPÓN', 0, 7),
(68745, 'SIMACOTA', 0, 7),
(68755, 'SOCORRO', 0, 7),
(68770, 'SUAITA', 0, 7),
(68773, 'SUCRE', 0, 7),
(68780, 'SURATÁ', 0, 7),
(68820, 'TONA', 0, 7),
(68855, 'VALLE DE SAN JOSÉ', 0, 7),
(68861, 'VÉLEZ', 0, 7),
(68867, 'VETAS', 0, 7),
(68872, 'VILLANUEVA', 0, 7),
(68895, 'ZAPATOCA', 0, 7),
(70001, 'SINCELEJO', 0, 7),
(70110, 'BUENAVISTA', 0, 7),
(70124, 'CAIMITO', 0, 7),
(70204, 'COLOSO', 0, 7),
(70215, 'COROZAL', 0, 7),
(70221, 'COVEÑAS', 0, 7),
(70230, 'CHALÁN', 0, 7),
(70233, 'EL ROBLE', 0, 7),
(70235, 'GALERAS', 0, 7),
(70265, 'GUARANDA', 0, 7),
(70400, 'LA UNIÓN', 0, 7),
(70418, 'LOS PALMITOS', 0, 7),
(70429, 'MAJAGUAL', 0, 7),
(70473, 'MORROA', 0, 7),
(70508, 'OVEJAS', 0, 7),
(70523, 'PALMITO', 0, 7),
(70670, 'SAMPUÉS', 0, 7),
(70678, 'SAN BENITO ABAD', 0, 7),
(70702, 'SAN JUAN DE BETULIA', 0, 7),
(70708, 'SAN MARCOS', 0, 7),
(70713, 'SAN ONOFRE', 0, 7),
(70717, 'SAN PEDRO', 0, 7),
(70742, 'SAN LUIS DE SINCÉ', 0, 7),
(70771, 'SUCRE', 0, 7),
(70820, 'SANTIAGO DE TOLÚ', 0, 7),
(70823, 'TOLÚ VIEJO', 0, 7),
(73001, 'IBAGUÉ', 0, 7),
(73024, 'ALPUJARRA', 0, 7),
(73026, 'ALVARADO', 0, 7),
(73030, 'AMBALEMA', 0, 7),
(73043, 'ANZOÁTEGUI', 0, 7),
(73055, 'ARMERO', 0, 7),
(73067, 'ATACO', 0, 7),
(73124, 'CAJAMARCA', 0, 7),
(73148, 'CARMEN DE APICALÁ', 0, 7),
(73152, 'CASABIANCA', 0, 7),
(73168, 'CHAPARRAL', 0, 7),
(73200, 'COELLO', 0, 7),
(73217, 'COYAIMA', 0, 7),
(73226, 'CUNDAY', 0, 7),
(73236, 'DOLORES', 0, 7),
(73268, 'ESPINAL', 0, 7),
(73270, 'FALAN', 0, 7),
(73275, 'FLANDES', 0, 7),
(73283, 'FRESNO', 0, 7),
(73319, 'GUAMO', 0, 7),
(73347, 'HERVEO', 0, 7),
(73349, 'HONDA', 0, 7),
(73352, 'ICONONZO', 0, 7),
(73408, 'LÉRIDA', 0, 7),
(73411, 'LÍBANO', 0, 7),
(73443, 'SAN SEBASTIÁN DE MARIQUIT', 0, 7),
(73449, 'MELGAR', 0, 7),
(73461, 'MURILLO', 0, 7),
(73483, 'NATAGAIMA', 0, 7),
(73504, 'ORTEGA', 0, 7),
(73520, 'PALOCABILDO', 0, 7),
(73547, 'PIEDRAS', 0, 7),
(73555, 'PLANADAS', 0, 7),
(73563, 'PRADO', 0, 7),
(73585, 'PURIFICACIÓN', 0, 7),
(73616, 'RIOBLANCO', 0, 7),
(73622, 'RONCESVALLES', 0, 7),
(73624, 'ROVIRA', 0, 7),
(73671, 'SALDAÑA', 0, 7),
(73675, 'SAN ANTONIO', 0, 7),
(73678, 'SAN LUIS', 0, 7),
(73686, 'SANTA ISABEL', 0, 7),
(73770, 'SUÁREZ', 0, 7),
(73854, 'VALLE DE SAN JUAN', 0, 7),
(73861, 'VENADILLO', 0, 7),
(73870, 'VILLAHERMOSA', 0, 7),
(73873, 'VILLARRICA', 0, 7),
(76001, 'CALI', 0, 7),
(76020, 'ALCALÁ', 0, 7),
(76036, 'ANDALUCÍA', 0, 7),
(76041, 'ANSERMANUEVO', 0, 7),
(76054, 'ARGELIA', 0, 7),
(76100, 'BOLÍVAR', 0, 7),
(76109, 'BUENAVENTURA', 0, 7),
(76111, 'GUADALAJARA DE BUGA', 0, 7),
(76113, 'BUGALAGRANDE', 0, 7),
(76122, 'CAICEDONIA', 0, 7),
(76126, 'CALIMA', 0, 7),
(76130, 'CANDELARIA', 0, 7),
(76147, 'CARTAGO', 0, 7),
(76233, 'DAGUA', 0, 7),
(76243, 'EL ÁGUILA', 0, 7),
(76246, 'EL CAIRO', 0, 7),
(76248, 'EL CERRITO', 0, 7),
(76250, 'EL DOVIO', 0, 7),
(76275, 'FLORIDA', 0, 7),
(76306, 'GINEBRA', 0, 7),
(76318, 'GUACARÍ', 0, 7),
(76364, 'JAMUNDÍ', 0, 7),
(76377, 'LA CUMBRE', 0, 7),
(76400, 'LA UNIÓN', 0, 7),
(76403, 'LA VICTORIA', 0, 7),
(76497, 'OBANDO', 0, 7),
(76520, 'PALMIRA', 0, 7),
(76563, 'PRADERA', 0, 7),
(76606, 'RESTREPO', 0, 7),
(76616, 'RIOFRÍO', 0, 7),
(76622, 'ROLDANILLO', 0, 7),
(76670, 'SAN PEDRO', 0, 7),
(76736, 'SEVILLA', 0, 7),
(76823, 'TORO', 0, 7),
(76828, 'TRUJILLO', 0, 7),
(76834, 'TULUÁ', 0, 7),
(76845, 'ULLOA', 0, 7),
(76863, 'VERSALLES', 0, 7),
(76869, 'VIJES', 0, 7),
(76890, 'YOTOCO', 0, 7),
(76892, 'YUMBO', 0, 7),
(76895, 'ZARZAL', 0, 7),
(81001, 'ARAUCA', 0, 7),
(81065, 'ARAUQUITA', 0, 7),
(81220, 'CRAVO NORTE', 0, 7),
(81300, 'FORTUL', 0, 7),
(81591, 'PUERTO RONDÓN', 0, 7),
(81736, 'SARAVENA', 0, 7),
(81794, 'TAME', 0, 7),
(85001, 'YOPAL', 0, 7),
(85010, 'AGUAZUL', 0, 7),
(85015, 'CHAMEZA', 0, 7),
(85125, 'HATO COROZAL', 0, 7),
(85136, 'LA SALINA', 0, 7),
(85139, 'MANÍ', 0, 7),
(85162, 'MONTERREY', 0, 7),
(85225, 'NUNCHÍA', 0, 7),
(85230, 'OROCUÉ', 0, 7),
(85250, 'PAZ DE ARIPORO', 0, 7),
(85263, 'PORE', 0, 7),
(85279, 'RECETOR', 0, 7),
(85300, 'SABANALARGA', 0, 7),
(85315, 'SÁCAMA', 0, 7),
(85325, 'SAN LUIS DE PALENQUE', 0, 7),
(85400, 'TÁMARA', 0, 7),
(85410, 'TAURAMENA', 0, 7),
(85430, 'TRINIDAD', 0, 7),
(85440, 'VILLANUEVA', 0, 7),
(86001, 'MOCOA', 0, 7),
(86219, 'COLÓN', 0, 7),
(86320, 'ORITO', 0, 7),
(86568, 'PUERTO ASÍS', 0, 7),
(86569, 'PUERTO CAICEDO', 0, 7),
(86571, 'PUERTO GUZMÁN', 0, 7),
(86573, 'PUERTO LEGUÍZAMO', 0, 7),
(86749, 'SIBUNDOY', 0, 7),
(86755, 'SAN FRANCISCO', 0, 7),
(86757, 'SAN MIGUEL', 0, 7),
(86760, 'SANTIAGO', 0, 7),
(86865, 'VALLE DEL GUAMUEZ', 0, 7),
(86885, 'VILLAGARZÓN', 0, 7),
(88001, 'SAN ANDRÉS', 0, 7),
(88564, 'PROVIDENCIA', 0, 7),
(91001, 'LETICIA', 0, 7),
(91263, 'EL ENCANTO', 0, 7),
(91405, 'LA CHORRERA', 0, 7),
(91407, 'LA PEDRERA', 0, 7),
(91430, 'LA VICTORIA', 0, 7),
(91460, 'MIRITI – PARANÁ', 0, 7),
(91530, 'PUERTO ALEGRÍA', 0, 7),
(91536, 'PUERTO ARICA', 0, 7),
(91540, 'PUERTO NARIÑO', 0, 7),
(91669, 'PUERTO SANTANDER', 0, 7),
(91798, 'TARAPACÁ', 0, 7),
(94001, 'INÍRIDA', 0, 7),
(94343, 'BARRANCO MINAS', 0, 7),
(94663, 'MAPIRIPANA', 0, 7),
(94883, 'SAN FELIPE', 0, 7),
(94884, 'PUERTO COLOMBIA', 0, 7),
(94885, 'LA GUADALUPE', 0, 7),
(94886, 'CACAHUAL', 0, 7),
(94887, 'PANA PANA', 0, 7),
(94888, 'MORICHAL', 0, 7),
(95001, 'SAN JOSÉ DEL GUAVIARE', 0, 7),
(95015, 'CALAMAR', 0, 7),
(95025, 'EL RETORNO', 0, 7),
(95200, 'MIRAFLORES', 0, 7),
(97001, 'MITÚ', 0, 7),
(97161, 'CARURU', 0, 7),
(97511, 'PACOA', 0, 7),
(97666, 'TARAIRA', 0, 7),
(97777, 'PAPUNAUA', 0, 7),
(97889, 'YAVARATÉ', 0, 7),
(99001, 'PUERTO CARREÑO', 0, 7),
(99524, 'LA PRIMAVERA', 0, 7),
(99624, 'SANTA ROSALÍA', 0, 7),
(99773, 'CUMARIBO', 0, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_continen`
--

CREATE TABLE `np_continen` (
  `id_continen` int(11) NOT NULL DEFAULT 0 COMMENT 'Id',
  `nom_conti` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nombre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Continentes';

--
-- Volcado de datos para la tabla `np_continen`
--

INSERT INTO `np_continen` (`id_continen`, `nom_conti`) VALUES
(1, 'AMERICA'),
(2, 'ASIA'),
(3, 'AFRICA'),
(4, 'EUROPA'),
(5, 'OCEANIA'),
(6, 'ANTARTIDA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_deptos`
--

CREATE TABLE `np_deptos` (
  `id_dpto` int(11) NOT NULL COMMENT 'Código',
  `nom_dpto` varchar(150) NOT NULL COMMENT 'Nombre',
  `id_pais` int(11) NOT NULL COMMENT 'Código País'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Departamentos';

--
-- Volcado de datos para la tabla `np_deptos`
--

INSERT INTO `np_deptos` (`id_dpto`, `nom_dpto`, `id_pais`) VALUES
(5, 'Antioquia', 7),
(8, 'Atlántico', 7),
(11, 'Bogotá', 7),
(13, 'Bolívar', 7),
(15, 'Boyacá', 7),
(17, 'Caldas', 7),
(18, 'Caquetá', 7),
(19, 'Cauca', 7),
(20, 'Cesar', 7),
(23, 'Córdoba', 7),
(25, 'Cundinamarca', 7),
(27, 'Chocó', 7),
(41, 'Huila', 7),
(44, 'La Guajira', 7),
(47, 'Magdalena', 7),
(50, 'Meta', 7),
(52, 'Nariño', 7),
(54, 'Norte de Santander', 7),
(63, 'Quindío', 7),
(66, 'Risaralda', 7),
(68, 'Santander', 7),
(70, 'Sucre', 7),
(73, 'Tolima', 7),
(76, 'Valle del Cauca', 7),
(81, 'Arauca', 7),
(85, 'Casanare', 7),
(86, 'Putumayo', 7),
(88, 'San Andres', 7),
(91, 'Amazonas', 7),
(94, 'Guainía', 7),
(95, 'Guaviare', 7),
(97, 'Vaupés', 7),
(99, 'Vichada', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_paises`
--

CREATE TABLE `np_paises` (
  `id_pais` int(11) NOT NULL DEFAULT 0 COMMENT 'Id',
  `nom_pais` varchar(30) NOT NULL COMMENT 'Nombre del País',
  `id_continen` int(11) DEFAULT NULL COMMENT 'Id Continente',
  `id_moneda` int(11) NOT NULL COMMENT 'Id Moneda'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Países';

--
-- Volcado de datos para la tabla `np_paises`
--

INSERT INTO `np_paises` (`id_pais`, `nom_pais`, `id_continen`, `id_moneda`) VALUES
(1, 'ARGENTINA', 1, 0),
(2, 'BELGIUM', 4, 0),
(3, 'BOLIVIA', 1, 0),
(4, 'BRAZIL', 1, 0),
(5, 'CHILE', 1, 0),
(6, 'CHINA', 2, 0),
(7, 'COLOMBIA', 1, 0),
(8, 'COSTA RICA', 1, 0),
(9, 'EGYPT', 1, 0),
(10, 'FRANCE', 3, 0),
(11, 'GERMANY ', 4, 0),
(12, 'GUATEMALA', 4, 0),
(13, 'INDIA', 1, 0),
(14, 'INDONESIA', 1, 0),
(15, 'KOREA', 2, 0),
(16, 'MALAYSIA', 2, 0),
(17, 'MALTA', 2, 0),
(18, 'MEXICO', 2, 0),
(19, 'NETHERLANDS ', 4, 0),
(20, 'PANAMA', 4, 0),
(21, 'PARAGUAY ', 1, 0),
(22, 'PERU', 4, 0),
(23, 'PUERTO RICO', 1, 0),
(24, 'RUSSIA', 1, 0),
(25, 'SAUDI ARABIA', 1, 0),
(26, 'SOUTH AFRICA', 1, 0),
(27, 'TAIWAN ', 2, 0),
(28, 'THAILAND', 2, 0),
(29, 'USA', 3, 0),
(30, 'VENEZUELA', 2, 0),
(31, 'ECUADOR', 2, 0),
(32, 'HONDURAS', 1, 0),
(33, 'LIBANO', 1, 0),
(34, 'AFGHANISTAN', 2, 0),
(35, 'ALBANIA', 4, 0),
(36, 'ANDORRA', 4, 0),
(37, 'ANGOLA', 3, 0),
(38, 'OLD AND BEARDED', 1, 0),
(39, 'ALGERIA', 3, 0),
(40, 'ARMENIA', 4, 0),
(41, 'AUSTRALIA', 5, 0),
(42, 'AUSTRIA', 4, 0),
(43, 'AZERBAIJAN', 4, 0),
(44, 'BAHAMAS', 1, 0),
(45, 'BANGLADESH', 2, 0),
(46, 'BARBADOS', 1, 0),
(47, 'BAHARAIN', 2, 0),
(48, 'BELIZE', 1, 0),
(49, 'BENIN', 3, 0),
(50, 'BELARUS', 4, 0),
(51, 'BOSNIA AND HERZEGOVINA', 4, 0),
(52, 'BOTSWANA', 3, 0),
(53, 'BRUNEI', 2, 0),
(54, 'BULGARIA', 4, 0),
(55, 'BURKINA FASO', 3, 0),
(56, 'BURUNDI', 3, 0),
(57, 'BUTAN', 2, 0),
(58, 'CAPE VERDE', 3, 0),
(59, 'CAMBODIA', 2, 0),
(60, 'CAMEROON', 3, 0),
(61, 'CANADA', 1, 0),
(62, 'KATAR', 2, 0),
(63, 'CHAD', 3, 0),
(64, 'CYPRUS', 2, 0),
(65, 'COMOROS', 3, 0),
(66, 'NORTH KOREA', 2, 0),
(67, 'IVORY COAST', 3, 0),
(68, 'CROATIA', 4, 0),
(69, 'CUBA', 1, 0),
(70, 'DENMARK', 4, 0),
(71, 'DOMINICA', 1, 0),
(72, 'THE SAVIOR', 1, 0),
(73, 'UNITED ARAB EMIRATES', 2, 0),
(74, 'ERITREA', 3, 0),
(75, 'SLOVAKIA', 4, 0),
(76, 'SLOVENIA', 4, 0),
(77, 'SPAIN', 4, 0),
(78, 'ESTONIA', 4, 0),
(79, 'ETHIOPIA', 3, 0),
(80, 'PHILIPPINES', 2, 0),
(81, 'FINLAND', 4, 0),
(82, 'FIJI', 5, 0),
(83, 'GABON', 3, 0),
(84, 'GAMBIA', 3, 0),
(85, 'GEORGIA', 4, 0),
(86, 'GHANA', 3, 0),
(87, 'GRENADE', 1, 0),
(88, 'GREECE', 4, 0),
(89, 'GUINEA', 3, 0),
(90, 'EQUATORIAL GUINEA', 3, 0),
(91, 'GUINEA-BISSAU', 3, 0),
(92, 'GUYANA', 1, 0),
(93, 'HAITI', 1, 0),
(95, 'HUNGARY', 4, 0),
(96, 'IRAN', 2, 0),
(97, 'IRAQ', 2, 0),
(98, 'IRELAND', 4, 0),
(99, 'ICELAND', 4, 0),
(100, 'MARSHALL ISLANDS', 5, 0),
(101, 'SOLOMON ISLANDS', 5, 0),
(102, 'ISRAEL', 2, 0),
(103, 'ITALY', 4, 0),
(104, 'JAMAICA', 1, 0),
(105, 'JAPAN', 2, 0),
(106, 'JORDAN', 2, 0),
(107, 'KAZAKHSTAN', 2, 0),
(108, 'KENYA', 3, 0),
(109, 'KYRGYZSTAN', 2, 0),
(110, 'KIRIBATI', 5, 0),
(111, 'KUWAIT', 2, 0),
(112, 'LAOS', 2, 0),
(113, 'LESOTHO', 3, 0),
(114, 'LATVIA', 4, 0),
(115, 'LIBERIA', 3, 0),
(116, 'LIBYA', 3, 0),
(117, 'LIECHTENSTEIN', 4, 0),
(118, 'LITHUANIA', 4, 0),
(119, 'LUXEMBOURG', 4, 0),
(120, 'MADAGASCAR', 3, 0),
(121, 'MALAUI', 3, 0),
(122, 'MALDIVES', 2, 0),
(123, 'MALI', 3, 0),
(124, 'MOROCCO', 3, 0),
(125, 'MAURICIO', 3, 0),
(126, 'MAURITANIA', 3, 0),
(127, 'MICRONESIA', 5, 0),
(128, 'MOLDOVA', 4, 0),
(129, 'MONACO', 4, 0),
(130, 'MONGOLIA', 2, 0),
(131, 'MONTENEGRO', 4, 0),
(132, 'MOZAMBIQUE', 3, 0),
(133, 'MYANMAR (BURMA)', 2, 0),
(134, 'NAMIBIA', 3, 0),
(135, 'NAURU', 5, 0),
(136, 'NEPAL', 2, 0),
(137, 'NICARAGUA', 1, 0),
(139, 'NIGERIA', 3, 0),
(140, 'NORWAY', 4, 0),
(141, 'NEW ZEALAND', 5, 0),
(142, 'OMAN', 2, 0),
(144, 'PAKISTAN', 2, 0),
(145, 'Shovels', 5, 0),
(146, 'PALESTINE', 2, 0),
(147, 'PAPUA NEW GUINEA', 5, 0),
(148, 'POLAND', 4, 0),
(149, 'PORTUGAL', 4, 0),
(150, 'UK', 4, 0),
(151, 'CENTRAL AFRICAN REPUBLIC', 3, 0),
(152, 'CZECH REPUBLIC', 4, 0),
(153, 'REPUBLIC OF MACEDONIA', 4, 0),
(154, 'REPUBLIC OF CONGO', 3, 0),
(155, 'DEMOCRATIC REPUBLIC OF CONGO', 3, 0),
(156, 'DOMINICAN REPUBLIC', 1, 0),
(157, 'SAHARAUI REPUBLIC', 3, 0),
(158, 'RWANDA', 3, 0),
(159, 'ROMANIA', 4, 0),
(160, 'SAMOA', 5, 0),
(161, 'SAINT KITTS AND NEVIS', 1, 0),
(162, 'SAN MARINO', 4, 0),
(163, 'ST. VINCENT AND THE GRENADINES', 1, 0),
(164, 'ST. LUCIA', 1, 0),
(165, 'SAINT THOMETHE AND PRINCE', 3, 0),
(166, 'SENEGAL', 3, 0),
(167, 'SERBIA', 4, 0),
(168, 'SEYCHELLES', 3, 0),
(169, 'SIERRA LEONE', 3, 0),
(170, 'SINGAPORE', 2, 0),
(171, 'SYRIA', 2, 0),
(172, 'SOMALIA', 3, 0),
(173, 'SRI LANKA', 2, 0),
(174, 'SWAZILAND', 3, 0),
(175, 'NORTH SUDAN', 3, 0),
(176, 'SOUTH SUDAN', 3, 0),
(177, 'SWEDEN', 4, 0),
(178, 'SWISS', 4, 0),
(179, 'SURINAM', 1, 0),
(180, 'TANZANIA', 3, 0),
(181, 'TAJIKISTAN', 2, 0),
(182, 'EAST TIMOR', 2, 0),
(183, 'TOGO', 3, 0),
(184, 'TONGA', 5, 0),
(185, 'TRINIDAD AND TOBAGO', 1, 0),
(186, 'TUNISIA', 3, 0),
(187, 'TURKMENISTAN', 2, 0),
(188, 'TURKEY', 2, 0),
(189, 'TUVALU', 5, 0),
(190, 'UKRAINE', 4, 0),
(191, 'UGANDA', 3, 0),
(192, 'URUGUAY', 1, 0),
(193, 'UZBEKISTAN', 2, 0),
(194, 'VANUATU', 5, 0),
(195, 'VATICAN', 4, 0),
(196, 'VIETNAM', 2, 0),
(197, 'YEMEN', 2, 0),
(198, 'DJIBOUTI', 3, 0),
(199, 'ZAMBIA', 3, 0),
(200, 'ZIMBABWE', 3, 0),
(201, 'GENERIC', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `np_tiponit`
--

CREATE TABLE `np_tiponit` (
  `idclase` int(11) NOT NULL COMMENT 'Id',
  `clsnit` varchar(1) NOT NULL COMMENT 'Clase de NIT',
  `nomclase` varchar(30) NOT NULL COMMENT 'Nombre de la Clase',
  `tipoper` int(11) NOT NULL COMMENT 'Tipo de Persona'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de NIT';

--
-- Volcado de datos para la tabla `np_tiponit`
--

INSERT INTO `np_tiponit` (`idclase`, `clsnit`, `nomclase`, `tipoper`) VALUES
(12, 'T', 'Tarjeta Identidad', 1),
(13, 'C', 'Cedula Ciudadania', 1),
(21, 'E', 'cedula Extranjeria', 1),
(31, 'N', 'Nit', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_activid`
--

CREATE TABLE `sp_activid` (
  `codactiv` int(11) NOT NULL COMMENT 'Código',
  `area` int(11) NOT NULL COMMENT 'Area',
  `descactiv` varchar(150) NOT NULL COMMENT 'Descripción',
  `id_tipoactiv` int(11) NOT NULL COMMENT 'Id Tipo Actividad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Actividades';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_concepviaje`
--

CREATE TABLE `sp_concepviaje` (
  `id_concep` int(11) NOT NULL COMMENT 'Id',
  `nom_concep` varchar(30) NOT NULL COMMENT 'Nombre',
  `id_tipo` int(11) NOT NULL COMMENT 'Id Tipo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Conceptos de Viaje';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_estado_man`
--

CREATE TABLE `sp_estado_man` (
  `id_estado` int(11) NOT NULL COMMENT 'Id',
  `descr_estado` varchar(20) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Estados de Mantenimiento';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_novedades`
--

CREATE TABLE `sp_novedades` (
  `cod_nove` varchar(5) NOT NULL COMMENT 'Código',
  `nom_nove` varchar(30) NOT NULL COMMENT 'Nombre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Novedades de Técnicos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_tiempos`
--

CREATE TABLE `sp_tiempos` (
  `cod_tiempo` varchar(3) NOT NULL COMMENT 'Código',
  `descr_tiempo` varchar(20) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tiempos Horas Extra';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_tipoactiv`
--

CREATE TABLE `sp_tipoactiv` (
  `id_tipoact` int(11) NOT NULL COMMENT 'Id',
  `descripact` varchar(80) NOT NULL COMMENT 'Descripción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Actividad';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sp_tipoconcep`
--

CREATE TABLE `sp_tipoconcep` (
  `id_tipo` int(11) NOT NULL COMMENT 'Id',
  `nom_tipo` varchar(30) NOT NULL COMMENT 'Nombre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Concepto de Viaje';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_ctr_tecnicos`
--

CREATE TABLE `sr_ctr_tecnicos` (
  `cod_emple` varchar(15) NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `orden_serv` varchar(10) NOT NULL,
  `ctro_costo` varchar(10) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `fechora_ini` datetime NOT NULL,
  `codactiv` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `hr_empleado` decimal(5,2) NOT NULL,
  `cod_nove` varchar(5) NOT NULL,
  `fechora_fin` datetime NOT NULL,
  `observs` text NOT NULL,
  `lat_gps` float(10,6) NOT NULL COMMENT 'Latitud',
  `lng_gps` float(10,6) NOT NULL COMMENT 'Longitud'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Control de Tecnicos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_gastosviaje`
--

CREATE TABLE `sr_gastosviaje` (
  `id_consec` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cod_ermple` varchar(15) NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `orden_serv` varchar(10) NOT NULL,
  `ctro_costo` varchar(10) NOT NULL,
  `id_concep` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `detalle` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Relación Gastos de Viaje';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_infortec`
--

CREATE TABLE `sr_infortec` (
  `id_consec` int(11) NOT NULL,
  `fechora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suc_cliente` int(11) NOT NULL,
  `orden_sev` varchar(10) NOT NULL,
  `codactiv` int(11) NOT NULL,
  `observs` text NOT NULL,
  `grabador` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Informes Tecnicos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_prog_mant`
--

CREATE TABLE `sr_prog_mant` (
  `id_prog` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `equipo` varchar(30) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `nro_parte` varchar(30) NOT NULL,
  `codactiv` int(11) NOT NULL,
  `fec_ult_mant` date NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `fec_prox_mant` date NOT NULL COMMENT 'Fecha Prox Mantto',
  `fec_modif` datetime NOT NULL,
  `nro_serie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Programacion de Mantenimientos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_prog_vis`
--

CREATE TABLE `sr_prog_vis` (
  `id_consec` int(11) NOT NULL,
  `fecha_prob` date NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `equipo` varchar(80) NOT NULL,
  `parte` varchar(40) NOT NULL,
  `cod_emple` varchar(15) NOT NULL,
  `fecha_ini` date NOT NULL,
  `estado` int(11) NOT NULL,
  `orden_serv` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Programacion ]Visitas Tecnicas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vh_cotizapdf`
--

CREATE TABLE `vh_cotizapdf` (
  `nro_cot` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `fechora_pdf` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Control pdf-s de cotizaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vm_clientesprov`
--

CREATE TABLE `vm_clientesprov` (
  `id_provis` int(11) NOT NULL,
  `nit_cliente` varchar(15) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `contacto` varchar(40) NOT NULL,
  `grabador` varchar(15) NOT NULL,
  `fechora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Maestra Clientes Provisionales';

--
-- Volcado de datos para la tabla `vm_clientesprov`
--

INSERT INTO `vm_clientesprov` (`id_provis`, `nit_cliente`, `nombre`, `direccion`, `telefono`, `email`, `contacto`, `grabador`, `fechora`) VALUES
(1, '', 'MATILDE LINA', '', '3112552211', '', '', 'usr4', '2023-09-11 23:13:27'),
(2, '', 'MARTINEZ MANUEL IDELFONSO', 'CALLE 1 CARRERA 2', '', '', 'MARTINEZ MANUEL', 'usr4', '2023-09-11 23:13:31'),
(3, '', 'MARTINEZ BOBADILLA HILDA', '', '', '', '', 'usr4', '2023-09-11 23:24:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vm_dsctos_especiales`
--

CREATE TABLE `vm_dsctos_especiales` (
  `cliente` decimal(15,0) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `dscto_%` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Descuentos a Clientes Especiales';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_dscto_vol`
--

CREATE TABLE `vp_dscto_vol` (
  `id_rol` int(11) NOT NULL COMMENT 'Id Rol',
  `id_moneda` int(11) NOT NULL COMMENT 'Id Moneda',
  `tope` int(11) NOT NULL COMMENT 'Tope',
  `margen_dscto` decimal(5,2) NOT NULL COMMENT 'Margen de descuento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Descto Autor. por Vol. de Venta';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_financia`
--

CREATE TABLE `vp_financia` (
  `id_financia` int(11) NOT NULL COMMENT 'Id',
  `descr_tope` varchar(40) NOT NULL COMMENT 'Descripción del Tope',
  `id_moneda` int(11) NOT NULL COMMENT 'Id Moneda',
  `margen` int(11) NOT NULL COMMENT 'Porcentaje de Desfase del Tope'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Margen de Financiación';

--
-- Volcado de datos para la tabla `vp_financia`
--

INSERT INTO `vp_financia` (`id_financia`, `descr_tope`, `id_moneda`, `margen`) VALUES
(0, 'Sin Cupo ni Financiacion', 34, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_limites`
--

CREATE TABLE `vp_limites` (
  `id_rol` int(11) NOT NULL COMMENT 'Id Rol',
  `minimo` decimal(4,2) NOT NULL COMMENT 'Mínimo',
  `maximo` decimal(4,2) NOT NULL COMMENT 'Máximo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Descuento Autorizado';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_terminospago`
--

CREATE TABLE `vp_terminospago` (
  `id_termino` int(11) NOT NULL,
  `descrip` varchar(40) NOT NULL COMMENT 'Descripción',
  `dias` int(11) NOT NULL COMMENT 'Días'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Terminos de Pago';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vr_cotiza`
--

CREATE TABLE `vr_cotiza` (
  `id_consecot` int(11) NOT NULL,
  `nro_cot` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL,
  `fecha_vence` date NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `descuento` decimal(4,2) NOT NULL,
  `termn_pago` int(11) NOT NULL,
  `autoriza` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL,
  `cod_grabador` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Principal de Cotizaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vr_cotizadet`
--

CREATE TABLE `vr_cotizadet` (
  `id_consecot` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `opcion` int(11) NOT NULL,
  `cod_item` varchar(15) NOT NULL,
  `descrip` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valor_unit` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Detalle de Cotizaciones';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vr_requerim`
--

CREATE TABLE `vr_requerim` (
  `id_fuente` int(11) NOT NULL COMMENT 'Fuente',
  `fechora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nom_cliente` varchar(80) NOT NULL,
  `nit_cliente` decimal(15,0) NOT NULL,
  `suc_cliente` int(11) NOT NULL,
  `id_contacto` int(11) NOT NULL,
  `observs` text NOT NULL,
  `cod_grabador` varchar(15) NOT NULL,
  `area` int(11) NOT NULL,
  `id_requerim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vr_requerimdet`
--

CREATE TABLE `vr_requerimdet` (
  `id_requerim` int(11) DEFAULT NULL,
  `cod_item` varchar(15) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `am_alertas`
--
ALTER TABLE `am_alertas`
  ADD KEY `fk_alerta` (`id_tipoalerta`);

--
-- Indices de la tabla `am_usuarios`
--
ALTER TABLE `am_usuarios`
  ADD PRIMARY KEY (`codusr`),
  ADD KEY `fk_rolusu` (`id_rol`),
  ADD KEY `fk_numidu` (`numid`);

--
-- Indices de la tabla `ap_ctros_costo`
--
ALTER TABLE `ap_ctros_costo`
  ADD PRIMARY KEY (`cod_centro`);

--
-- Indices de la tabla `ap_grupos`
--
ALTER TABLE `ap_grupos`
  ADD PRIMARY KEY (`cod_grupo`);

--
-- Indices de la tabla `ap_interface`
--
ALTER TABLE `ap_interface`
  ADD PRIMARY KEY (`id_codigo`);

--
-- Indices de la tabla `ap_opc_permi`
--
ALTER TABLE `ap_opc_permi`
  ADD PRIMARY KEY (`cod_opcion`);

--
-- Indices de la tabla `ap_param`
--
ALTER TABLE `ap_param`
  ADD PRIMARY KEY (`variable`);

--
-- Indices de la tabla `ap_permpro`
--
ALTER TABLE `ap_permpro`
  ADD PRIMARY KEY (`id_permpro`),
  ADD KEY `codpro` (`codprog`),
  ADD KEY `fk_per_opc` (`permpro`);

--
-- Indices de la tabla `ap_programs`
--
ALTER TABLE `ap_programs`
  ADD PRIMARY KEY (`codprog`),
  ADD KEY `fk_grupo` (`grupo`);

--
-- Indices de la tabla `ap_roles`
--
ALTER TABLE `ap_roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD KEY `fk_cargorol` (`id_cargo`);

--
-- Indices de la tabla `ap_tipoalerta`
--
ALTER TABLE `ap_tipoalerta`
  ADD PRIMARY KEY (`id_tipoalerta`);

--
-- Indices de la tabla `ar_bloqueo`
--
ALTER TABLE `ar_bloqueo`
  ADD PRIMARY KEY (`id_bloqueo`);

--
-- Indices de la tabla `ar_roles`
--
ALTER TABLE `ar_roles`
  ADD PRIMARY KEY (`id_rrol`),
  ADD KEY `fk_permpro` (`id_permpro`),
  ADD KEY `fk_rol` (`id_rol`);

--
-- Indices de la tabla `cp_arancel`
--
ALTER TABLE `cp_arancel`
  ADD PRIMARY KEY (`cod_arancel`);

--
-- Indices de la tabla `cp_contened`
--
ALTER TABLE `cp_contened`
  ADD PRIMARY KEY (`id_contene`),
  ADD KEY `fk_tipocontened` (`tipo`);

--
-- Indices de la tabla `cp_dsctos_prov`
--
ALTER TABLE `cp_dsctos_prov`
  ADD PRIMARY KEY (`id_dscto`),
  ADD KEY `fk_proveecs` (`id_proveedor`),
  ADD KEY `fk_marcacs` (`id_marca`),
  ADD KEY `fk_itemcs` (`cod_item`);

--
-- Indices de la tabla `cp_empaque`
--
ALTER TABLE `cp_empaque`
  ADD PRIMARY KEY (`id_empaque`);

--
-- Indices de la tabla `cp_etapas_imp`
--
ALTER TABLE `cp_etapas_imp`
  ADD PRIMARY KEY (`id_etapa`);

--
-- Indices de la tabla `cp_incoterm`
--
ALTER TABLE `cp_incoterm`
  ADD PRIMARY KEY (`id_incoterm`);

--
-- Indices de la tabla `cp_puertos`
--
ALTER TABLE `cp_puertos`
  ADD PRIMARY KEY (`id_puerto`),
  ADD KEY `fk_ciudadpto` (`ciudad`),
  ADD KEY `fk_paispto` (`pais`);

--
-- Indices de la tabla `cp_tipocontenedor`
--
ALTER TABLE `cp_tipocontenedor`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `cp_tipo_transporte`
--
ALTER TABLE `cp_tipo_transporte`
  ADD PRIMARY KEY (`id_tipotrans`);

--
-- Indices de la tabla `cr_costos_imprt`
--
ALTER TABLE `cr_costos_imprt`
  ADD KEY `fk_pocst` (`id_po`);

--
-- Indices de la tabla `cr_cotprov`
--
ALTER TABLE `cr_cotprov`
  ADD PRIMARY KEY (`id_cotprov`);

--
-- Indices de la tabla `cr_cotprovdet`
--
ALTER TABLE `cr_cotprovdet`
  ADD KEY `fk_idcotdet` (`id_cotprov`);

--
-- Indices de la tabla `cr_importacio`
--
ALTER TABLE `cr_importacio`
  ADD PRIMARY KEY (`id_po`),
  ADD KEY `fk_empleimprt` (`codemple`),
  ADD KEY `fk_ctrocostoimprt` (`ctro_costo`),
  ADD KEY `fk_clienteimprt` (`cliente`),
  ADD KEY `fk_proveeimprt` (`proveedor`),
  ADD KEY `fk_forwarderimport` (`forwarder`),
  ADD KEY `fk_paisoriimport` (`pais_origen`),
  ADD KEY `fk_ciudestimport` (`ciudad_destino`),
  ADD KEY `fk_tipotransimport` (`modo_transprt`),
  ADD KEY `fk_arancelimport` (`partida_arancel`),
  ADD KEY `fk_cia_import` (`agencia_aduanas`);

--
-- Indices de la tabla `cr_seg_imprt`
--
ALTER TABLE `cr_seg_imprt`
  ADD KEY `fk_etapaseg` (`id_etapa`),
  ADD KEY `fk_poseg` (`id_po`);

--
-- Indices de la tabla `im_bodeg`
--
ALTER TABLE `im_bodeg`
  ADD PRIMARY KEY (`cod_bodega`);

--
-- Indices de la tabla `im_equivalen`
--
ALTER TABLE `im_equivalen`
  ADD KEY `fk_itemi` (`coditem`);

--
-- Indices de la tabla `im_items`
--
ALTER TABLE `im_items`
  ADD PRIMARY KEY (`cod_item`),
  ADD KEY `fk_unidadi` (`unidad`),
  ADD KEY `fk_grupoi` (`grup_item`),
  ADD KEY `fk_sucuri` (`id_proveedor`),
  ADD KEY `fk_marcasi` (`id_marca`),
  ADD KEY `fk_modeloi` (`modelo`),
  ADD KEY `fk_artit` (`articulo`),
  ADD KEY `fk_tipoit` (`tipo_item`),
  ADD KEY `fk_lineait` (`linea`);

--
-- Indices de la tabla `im_relaciones`
--
ALTER TABLE `im_relaciones`
  ADD KEY `fk_itemr` (`codrefpal`);

--
-- Indices de la tabla `im_seriales`
--
ALTER TABLE `im_seriales`
  ADD PRIMARY KEY (`nro_serie`),
  ADD KEY `fk_itemsr` (`cod_item`),
  ADD KEY `fk_clientesr` (`id_cliente`);

--
-- Indices de la tabla `im_trans`
--
ALTER TABLE `im_trans`
  ADD PRIMARY KEY (`cod_trans`);

--
-- Indices de la tabla `ip_articulos`
--
ALTER TABLE `ip_articulos`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `ip_basicos`
--
ALTER TABLE `ip_basicos`
  ADD PRIMARY KEY (`id_basico`);

--
-- Indices de la tabla `ip_caracte`
--
ALTER TABLE `ip_caracte`
  ADD PRIMARY KEY (`codcarac`),
  ADD KEY `fk_unidadc` (`cod_unidad`);

--
-- Indices de la tabla `ip_dtbasicos`
--
ALTER TABLE `ip_dtbasicos`
  ADD PRIMARY KEY (`sec_basico`),
  ADD KEY `fk_basico` (`id_basico`);

--
-- Indices de la tabla `ip_grupos`
--
ALTER TABLE `ip_grupos`
  ADD PRIMARY KEY (`cod_grupo`);

--
-- Indices de la tabla `ip_lineas`
--
ALTER TABLE `ip_lineas`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `ip_lubricantes`
--
ALTER TABLE `ip_lubricantes`
  ADD PRIMARY KEY (`cod_lubricante`),
  ADD KEY `fk_proveedorlub` (`id_proveedor`);

--
-- Indices de la tabla `ip_marcas`
--
ALTER TABLE `ip_marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `ip_modelos`
--
ALTER TABLE `ip_modelos`
  ADD PRIMARY KEY (`id_modelo`),
  ADD KEY `fk_modelot` (`id_tipomodelo`);

--
-- Indices de la tabla `ip_tipomodelo`
--
ALTER TABLE `ip_tipomodelo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `ip_tipos`
--
ALTER TABLE `ip_tipos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `ip_ubica`
--
ALTER TABLE `ip_ubica`
  ADD UNIQUE KEY `u_ubiitem` (`cod_item`,`cod_bodeg`),
  ADD KEY `fk_bodegau` (`cod_bodeg`);

--
-- Indices de la tabla `ip_unidades`
--
ALTER TABLE `ip_unidades`
  ADD PRIMARY KEY (`cod_unidad`);

--
-- Indices de la tabla `ir_caracte`
--
ALTER TABLE `ir_caracte`
  ADD KEY `fk_grupc` (`codgrup`),
  ADD KEY `fk_caracc` (`codcarac`);

--
-- Indices de la tabla `ir_detalle_oper`
--
ALTER TABLE `ir_detalle_oper`
  ADD KEY `fk_idopdet` (`id_operacion`),
  ADD KEY `fk_itemdet` (`cod_item`);

--
-- Indices de la tabla `ir_operaciones`
--
ALTER TABLE `ir_operaciones`
  ADD PRIMARY KEY (`id_operacion`),
  ADD KEY `fk_transop` (`cod_trans`);

--
-- Indices de la tabla `ir_salinve`
--
ALTER TABLE `ir_salinve`
  ADD KEY `fk_items` (`cod_item`),
  ADD KEY `fk_bodegs` (`codbodeg`);

--
-- Indices de la tabla `nm_contactos`
--
ALTER TABLE `nm_contactos`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `fk_idsucursalc` (`id_sucursal`);

--
-- Indices de la tabla `nm_empleados`
--
ALTER TABLE `nm_empleados`
  ADD PRIMARY KEY (`codemple`),
  ADD KEY `fk_cargoe` (`id_cargo`),
  ADD KEY `fk_numide` (`numid`);

--
-- Indices de la tabla `nm_juridicas`
--
ALTER TABLE `nm_juridicas`
  ADD KEY `fk_numidj` (`numid`);

--
-- Indices de la tabla `nm_nits`
--
ALTER TABLE `nm_nits`
  ADD PRIMARY KEY (`numid`),
  ADD KEY `fk_clase` (`idclase`),
  ADD KEY `fk_activecon` (`actividad`);

--
-- Indices de la tabla `nm_personas`
--
ALTER TABLE `nm_personas`
  ADD KEY `fk_numidp` (`numid`);

--
-- Indices de la tabla `nm_sucursal`
--
ALTER TABLE `nm_sucursal`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `fk_idciudads` (`ciudad`),
  ADD KEY `fk_idpaiss` (`pais`),
  ADD KEY `fk_numids` (`numid`);

--
-- Indices de la tabla `np_activeco`
--
ALTER TABLE `np_activeco`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `np_cargos`
--
ALTER TABLE `np_cargos`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `np_ciudades`
--
ALTER TABLE `np_ciudades`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indices de la tabla `np_continen`
--
ALTER TABLE `np_continen`
  ADD PRIMARY KEY (`id_continen`);

--
-- Indices de la tabla `np_deptos`
--
ALTER TABLE `np_deptos`
  ADD PRIMARY KEY (`id_dpto`),
  ADD KEY `fk_pais` (`id_pais`);

--
-- Indices de la tabla `np_paises`
--
ALTER TABLE `np_paises`
  ADD PRIMARY KEY (`id_pais`),
  ADD KEY `fk_idcontinenp` (`id_continen`);

--
-- Indices de la tabla `np_tiponit`
--
ALTER TABLE `np_tiponit`
  ADD PRIMARY KEY (`idclase`);

--
-- Indices de la tabla `sp_concepviaje`
--
ALTER TABLE `sp_concepviaje`
  ADD PRIMARY KEY (`id_concep`);

--
-- Indices de la tabla `sp_tipoconcep`
--
ALTER TABLE `sp_tipoconcep`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `sr_gastosviaje`
--
ALTER TABLE `sr_gastosviaje`
  ADD PRIMARY KEY (`id_consec`);

--
-- Indices de la tabla `sr_infortec`
--
ALTER TABLE `sr_infortec`
  ADD PRIMARY KEY (`id_consec`);

--
-- Indices de la tabla `vm_clientesprov`
--
ALTER TABLE `vm_clientesprov`
  ADD PRIMARY KEY (`id_provis`);

--
-- Indices de la tabla `vm_dsctos_especiales`
--
ALTER TABLE `vm_dsctos_especiales`
  ADD KEY `fk_itemdscto` (`cliente`);

--
-- Indices de la tabla `vp_dscto_vol`
--
ALTER TABLE `vp_dscto_vol`
  ADD KEY `fk_roldsct` (`id_rol`);

--
-- Indices de la tabla `vp_financia`
--
ALTER TABLE `vp_financia`
  ADD PRIMARY KEY (`id_financia`);

--
-- Indices de la tabla `vp_limites`
--
ALTER TABLE `vp_limites`
  ADD KEY `fk_rollim` (`id_rol`);

--
-- Indices de la tabla `vp_terminospago`
--
ALTER TABLE `vp_terminospago`
  ADD PRIMARY KEY (`id_termino`);

--
-- Indices de la tabla `vr_cotiza`
--
ALTER TABLE `vr_cotiza`
  ADD PRIMARY KEY (`id_consecot`),
  ADD KEY `fk_termn_pagocot` (`termn_pago`);

--
-- Indices de la tabla `vr_cotizadet`
--
ALTER TABLE `vr_cotizadet`
  ADD KEY `fk_cotizadet` (`id_consecot`),
  ADD KEY `fk_itemcotdet` (`cod_item`);

--
-- Indices de la tabla `vr_requerim`
--
ALTER TABLE `vr_requerim`
  ADD PRIMARY KEY (`id_requerim`),
  ADD KEY `fk_nitreq` (`nit_cliente`),
  ADD KEY `fk_sucreq` (`suc_cliente`);

--
-- Indices de la tabla `vr_requerimdet`
--
ALTER TABLE `vr_requerimdet`
  ADD KEY `fk_itemrq` (`cod_item`),
  ADD KEY `fk_reqdet` (`id_requerim`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ap_permpro`
--
ALTER TABLE `ap_permpro`
  MODIFY `id_permpro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT de la tabla `ap_roles`
--
ALTER TABLE `ap_roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ar_bloqueo`
--
ALTER TABLE `ar_bloqueo`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ar_roles`
--
ALTER TABLE `ar_roles`
  MODIFY `id_rrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2065;

--
-- AUTO_INCREMENT de la tabla `cp_contened`
--
ALTER TABLE `cp_contened`
  MODIFY `id_contene` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cp_empaque`
--
ALTER TABLE `cp_empaque`
  MODIFY `id_empaque` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cp_etapas_imp`
--
ALTER TABLE `cp_etapas_imp`
  MODIFY `id_etapa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cp_incoterm`
--
ALTER TABLE `cp_incoterm`
  MODIFY `id_incoterm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cp_puertos`
--
ALTER TABLE `cp_puertos`
  MODIFY `id_puerto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cp_tipo_transporte`
--
ALTER TABLE `cp_tipo_transporte`
  MODIFY `id_tipotrans` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_articulos`
--
ALTER TABLE `ip_articulos`
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_basicos`
--
ALTER TABLE `ip_basicos`
  MODIFY `id_basico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ip_dtbasicos`
--
ALTER TABLE `ip_dtbasicos`
  MODIFY `sec_basico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `ip_lineas`
--
ALTER TABLE `ip_lineas`
  MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_tipos`
--
ALTER TABLE `ip_tipos`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ir_operaciones`
--
ALTER TABLE `ir_operaciones`
  MODIFY `id_operacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nm_contactos`
--
ALTER TABLE `nm_contactos`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nm_sucursal`
--
ALTER TABLE `nm_sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sr_gastosviaje`
--
ALTER TABLE `sr_gastosviaje`
  MODIFY `id_consec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sr_infortec`
--
ALTER TABLE `sr_infortec`
  MODIFY `id_consec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vm_clientesprov`
--
ALTER TABLE `vm_clientesprov`
  MODIFY `id_provis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vp_terminospago`
--
ALTER TABLE `vp_terminospago`
  MODIFY `id_termino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vr_cotiza`
--
ALTER TABLE `vr_cotiza`
  MODIFY `id_consecot` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vr_requerim`
--
ALTER TABLE `vr_requerim`
  MODIFY `id_requerim` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `am_alertas`
--
ALTER TABLE `am_alertas`
  ADD CONSTRAINT `fk_alerta` FOREIGN KEY (`id_tipoalerta`) REFERENCES `ap_tipoalerta` (`id_tipoalerta`);

--
-- Filtros para la tabla `am_usuarios`
--
ALTER TABLE `am_usuarios`
  ADD CONSTRAINT `fk_numidu` FOREIGN KEY (`numid`) REFERENCES `nm_nits` (`numid`),
  ADD CONSTRAINT `fk_rolusu` FOREIGN KEY (`id_rol`) REFERENCES `ap_roles` (`id_rol`);

--
-- Filtros para la tabla `ap_permpro`
--
ALTER TABLE `ap_permpro`
  ADD CONSTRAINT `fk_per_opc` FOREIGN KEY (`permpro`) REFERENCES `ap_opc_permi` (`cod_opcion`),
  ADD CONSTRAINT `fk_prog_per` FOREIGN KEY (`codprog`) REFERENCES `ap_programs` (`codprog`);

--
-- Filtros para la tabla `ap_programs`
--
ALTER TABLE `ap_programs`
  ADD CONSTRAINT `fk_grupo` FOREIGN KEY (`grupo`) REFERENCES `ap_grupos` (`cod_grupo`);

--
-- Filtros para la tabla `ap_roles`
--
ALTER TABLE `ap_roles`
  ADD CONSTRAINT `fk_cargorol` FOREIGN KEY (`id_cargo`) REFERENCES `np_cargos` (`id_cargo`);

--
-- Filtros para la tabla `ar_roles`
--
ALTER TABLE `ar_roles`
  ADD CONSTRAINT `fk_permpro` FOREIGN KEY (`id_permpro`) REFERENCES `ap_permpro` (`id_permpro`),
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`id_rol`) REFERENCES `ap_roles` (`id_rol`);

--
-- Filtros para la tabla `cp_contened`
--
ALTER TABLE `cp_contened`
  ADD CONSTRAINT `fk_tipocontened` FOREIGN KEY (`tipo`) REFERENCES `cp_tipocontenedor` (`id_tipo`);

--
-- Filtros para la tabla `cp_dsctos_prov`
--
ALTER TABLE `cp_dsctos_prov`
  ADD CONSTRAINT `fk_itemcs` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`),
  ADD CONSTRAINT `fk_marcacs` FOREIGN KEY (`id_marca`) REFERENCES `ip_marcas` (`id_marca`),
  ADD CONSTRAINT `fk_proveecs` FOREIGN KEY (`id_proveedor`) REFERENCES `nm_sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `cp_puertos`
--
ALTER TABLE `cp_puertos`
  ADD CONSTRAINT `fk_ciudadpto` FOREIGN KEY (`ciudad`) REFERENCES `np_ciudades` (`id_ciudad`),
  ADD CONSTRAINT `fk_paispto` FOREIGN KEY (`pais`) REFERENCES `np_paises` (`id_pais`);

--
-- Filtros para la tabla `cr_costos_imprt`
--
ALTER TABLE `cr_costos_imprt`
  ADD CONSTRAINT `fk_pocst` FOREIGN KEY (`id_po`) REFERENCES `cr_importacio` (`id_po`);

--
-- Filtros para la tabla `cr_cotprovdet`
--
ALTER TABLE `cr_cotprovdet`
  ADD CONSTRAINT `fk_idcotdet` FOREIGN KEY (`id_cotprov`) REFERENCES `cr_cotprov` (`id_cotprov`);

--
-- Filtros para la tabla `cr_importacio`
--
ALTER TABLE `cr_importacio`
  ADD CONSTRAINT `fk_arancelimport` FOREIGN KEY (`partida_arancel`) REFERENCES `cp_arancel` (`cod_arancel`),
  ADD CONSTRAINT `fk_cia_import` FOREIGN KEY (`agencia_aduanas`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_ciudestimport` FOREIGN KEY (`ciudad_destino`) REFERENCES `np_ciudades` (`id_ciudad`),
  ADD CONSTRAINT `fk_clienteimprt` FOREIGN KEY (`cliente`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_ctrocostoimprt` FOREIGN KEY (`ctro_costo`) REFERENCES `ap_ctros_costo` (`cod_centro`),
  ADD CONSTRAINT `fk_empleimprt` FOREIGN KEY (`codemple`) REFERENCES `nm_empleados` (`codemple`),
  ADD CONSTRAINT `fk_forwarderimport` FOREIGN KEY (`forwarder`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_paisoriimport` FOREIGN KEY (`pais_origen`) REFERENCES `np_paises` (`id_pais`),
  ADD CONSTRAINT `fk_proveeimprt` FOREIGN KEY (`proveedor`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_tipotransimport` FOREIGN KEY (`modo_transprt`) REFERENCES `cp_tipo_transporte` (`id_tipotrans`);

--
-- Filtros para la tabla `cr_seg_imprt`
--
ALTER TABLE `cr_seg_imprt`
  ADD CONSTRAINT `fk_etapaseg` FOREIGN KEY (`id_etapa`) REFERENCES `cp_etapas_imp` (`id_etapa`),
  ADD CONSTRAINT `fk_poseg` FOREIGN KEY (`id_po`) REFERENCES `cr_importacio` (`id_po`);

--
-- Filtros para la tabla `im_equivalen`
--
ALTER TABLE `im_equivalen`
  ADD CONSTRAINT `fk_itemi` FOREIGN KEY (`coditem`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `im_items`
--
ALTER TABLE `im_items`
  ADD CONSTRAINT `fk_artit` FOREIGN KEY (`articulo`) REFERENCES `ip_articulos` (`id_articulo`),
  ADD CONSTRAINT `fk_grupoi` FOREIGN KEY (`grup_item`) REFERENCES `ip_grupos` (`cod_grupo`),
  ADD CONSTRAINT `fk_lineait` FOREIGN KEY (`linea`) REFERENCES `ip_lineas` (`id_linea`),
  ADD CONSTRAINT `fk_marcasi` FOREIGN KEY (`id_marca`) REFERENCES `ip_marcas` (`id_marca`),
  ADD CONSTRAINT `fk_modeloi` FOREIGN KEY (`modelo`) REFERENCES `ip_modelos` (`id_modelo`),
  ADD CONSTRAINT `fk_sucuri` FOREIGN KEY (`id_proveedor`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_tipoit` FOREIGN KEY (`tipo_item`) REFERENCES `ip_tipos` (`id_tipo`),
  ADD CONSTRAINT `fk_unidadi` FOREIGN KEY (`unidad`) REFERENCES `ip_unidades` (`cod_unidad`);

--
-- Filtros para la tabla `im_relaciones`
--
ALTER TABLE `im_relaciones`
  ADD CONSTRAINT `fk_itemr` FOREIGN KEY (`codrefpal`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `im_seriales`
--
ALTER TABLE `im_seriales`
  ADD CONSTRAINT `fk_clientesr` FOREIGN KEY (`id_cliente`) REFERENCES `nm_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `fk_itemsr` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `ip_caracte`
--
ALTER TABLE `ip_caracte`
  ADD CONSTRAINT `fk_unidadc` FOREIGN KEY (`cod_unidad`) REFERENCES `ip_unidades` (`cod_unidad`);

--
-- Filtros para la tabla `ip_dtbasicos`
--
ALTER TABLE `ip_dtbasicos`
  ADD CONSTRAINT `fk_basico` FOREIGN KEY (`id_basico`) REFERENCES `ip_basicos` (`id_basico`);

--
-- Filtros para la tabla `ip_lubricantes`
--
ALTER TABLE `ip_lubricantes`
  ADD CONSTRAINT `fk_proveedorlub` FOREIGN KEY (`id_proveedor`) REFERENCES `nm_sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `ip_modelos`
--
ALTER TABLE `ip_modelos`
  ADD CONSTRAINT `fk_modelot` FOREIGN KEY (`id_tipomodelo`) REFERENCES `ip_tipomodelo` (`id_tipo`);

--
-- Filtros para la tabla `ip_ubica`
--
ALTER TABLE `ip_ubica`
  ADD CONSTRAINT `fk_bodegau` FOREIGN KEY (`cod_bodeg`) REFERENCES `im_bodeg` (`cod_bodega`),
  ADD CONSTRAINT `fk_itemu` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `ir_caracte`
--
ALTER TABLE `ir_caracte`
  ADD CONSTRAINT `fk_caracc` FOREIGN KEY (`codcarac`) REFERENCES `ip_caracte` (`codcarac`),
  ADD CONSTRAINT `fk_grupc` FOREIGN KEY (`codgrup`) REFERENCES `ip_grupos` (`cod_grupo`);

--
-- Filtros para la tabla `ir_detalle_oper`
--
ALTER TABLE `ir_detalle_oper`
  ADD CONSTRAINT `fk_idopdet` FOREIGN KEY (`id_operacion`) REFERENCES `ir_operaciones` (`id_operacion`),
  ADD CONSTRAINT `fk_itemdet` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `ir_operaciones`
--
ALTER TABLE `ir_operaciones`
  ADD CONSTRAINT `fk_transop` FOREIGN KEY (`cod_trans`) REFERENCES `im_trans` (`cod_trans`);

--
-- Filtros para la tabla `ir_salinve`
--
ALTER TABLE `ir_salinve`
  ADD CONSTRAINT `fk_bodegs` FOREIGN KEY (`codbodeg`) REFERENCES `im_bodeg` (`cod_bodega`),
  ADD CONSTRAINT `fk_items` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `nm_contactos`
--
ALTER TABLE `nm_contactos`
  ADD CONSTRAINT `fk_idsucursalc` FOREIGN KEY (`id_sucursal`) REFERENCES `nm_sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `nm_empleados`
--
ALTER TABLE `nm_empleados`
  ADD CONSTRAINT `fk_cargoe` FOREIGN KEY (`id_cargo`) REFERENCES `np_cargos` (`id_cargo`),
  ADD CONSTRAINT `fk_numide` FOREIGN KEY (`numid`) REFERENCES `nm_nits` (`numid`);

--
-- Filtros para la tabla `nm_juridicas`
--
ALTER TABLE `nm_juridicas`
  ADD CONSTRAINT `fk_numidj` FOREIGN KEY (`numid`) REFERENCES `nm_nits` (`numid`);

--
-- Filtros para la tabla `nm_nits`
--
ALTER TABLE `nm_nits`
  ADD CONSTRAINT `fk_activecon` FOREIGN KEY (`actividad`) REFERENCES `np_activeco` (`codigo`),
  ADD CONSTRAINT `fk_clase` FOREIGN KEY (`idclase`) REFERENCES `np_tiponit` (`idclase`);

--
-- Filtros para la tabla `nm_personas`
--
ALTER TABLE `nm_personas`
  ADD CONSTRAINT `fk_numidp` FOREIGN KEY (`numid`) REFERENCES `nm_nits` (`numid`);

--
-- Filtros para la tabla `nm_sucursal`
--
ALTER TABLE `nm_sucursal`
  ADD CONSTRAINT `fk_idciudads` FOREIGN KEY (`ciudad`) REFERENCES `np_ciudades` (`id_ciudad`),
  ADD CONSTRAINT `fk_idpaiss` FOREIGN KEY (`pais`) REFERENCES `np_paises` (`id_pais`),
  ADD CONSTRAINT `fk_numids` FOREIGN KEY (`numid`) REFERENCES `nm_nits` (`numid`);

--
-- Filtros para la tabla `np_deptos`
--
ALTER TABLE `np_deptos`
  ADD CONSTRAINT `fk_pais` FOREIGN KEY (`id_pais`) REFERENCES `np_paises` (`id_pais`);

--
-- Filtros para la tabla `np_paises`
--
ALTER TABLE `np_paises`
  ADD CONSTRAINT `fk_idcontinenp` FOREIGN KEY (`id_continen`) REFERENCES `np_continen` (`id_continen`);

--
-- Filtros para la tabla `vp_dscto_vol`
--
ALTER TABLE `vp_dscto_vol`
  ADD CONSTRAINT `fk_roldsct` FOREIGN KEY (`id_rol`) REFERENCES `ap_roles` (`id_rol`);

--
-- Filtros para la tabla `vp_limites`
--
ALTER TABLE `vp_limites`
  ADD CONSTRAINT `fk_rollim` FOREIGN KEY (`id_rol`) REFERENCES `ap_roles` (`id_rol`);

--
-- Filtros para la tabla `vr_cotiza`
--
ALTER TABLE `vr_cotiza`
  ADD CONSTRAINT `fk_termn_pagocot` FOREIGN KEY (`termn_pago`) REFERENCES `vp_terminospago` (`id_termino`);

--
-- Filtros para la tabla `vr_cotizadet`
--
ALTER TABLE `vr_cotizadet`
  ADD CONSTRAINT `fk_cotizadet` FOREIGN KEY (`id_consecot`) REFERENCES `vr_cotiza` (`id_consecot`),
  ADD CONSTRAINT `fk_itemcotdet` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`);

--
-- Filtros para la tabla `vr_requerimdet`
--
ALTER TABLE `vr_requerimdet`
  ADD CONSTRAINT `fk_itemrq` FOREIGN KEY (`cod_item`) REFERENCES `im_items` (`cod_item`),
  ADD CONSTRAINT `fk_reqdet` FOREIGN KEY (`id_requerim`) REFERENCES `vr_requerim` (`id_requerim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
