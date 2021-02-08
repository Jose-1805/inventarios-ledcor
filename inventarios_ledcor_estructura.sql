-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2018 a las 16:20:45
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventarios_ledcor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` text NOT NULL,
  `ubicacion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calculos`
--

CREATE TABLE `calculos` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` text,
  `ensamble` enum('Fondo','Tanque','Tk Exp.','Tapa','Prensa','Gabinete','Radiador','Mecanizado','Adicional') DEFAULT NULL,
  `fert` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_diario_lamina`
--

CREATE TABLE `consumo_diario_lamina` (
  `id` int(10) UNSIGNED NOT NULL,
  `maquina` enum('Fasti','Müller','Durma','Forming Roll') DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `ensamble` enum('Fondo','Tanque','Tk Exp.','Tapa','Prensa','Gabinete','Radiador','Mecanizado','Adicional') DEFAULT NULL,
  `consumo` double DEFAULT NULL,
  `desperdicio` double DEFAULT NULL,
  `consecutivo_retal` int(11) DEFAULT NULL,
  `observacion` text,
  `entrada_lamina_almacen_id` int(10) UNSIGNED NOT NULL,
  `corte_id` int(10) UNSIGNED NOT NULL,
  `operario_id` int(10) UNSIGNED NOT NULL,
  `kardex_retal_lamina_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_lamina`
--

CREATE TABLE `consumo_lamina` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `peso_laimna` double DEFAULT NULL,
  `entrada_lamina_almacen_id` int(10) UNSIGNED NOT NULL,
  `corte_id` int(10) UNSIGNED NOT NULL,
  `operario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_perfileria`
--

CREATE TABLE `consumo_perfileria` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `medida` double DEFAULT NULL,
  `ensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB','Daño de máquina') DEFAULT NULL,
  `observacion` text,
  `quien_entrego` int(10) UNSIGNED NOT NULL,
  `quien_solicito` int(10) UNSIGNED NOT NULL,
  `corte_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo` enum('programado','prioritario') NOT NULL DEFAULT 'prioritario',
  `fecha_programada` date DEFAULT NULL,
  `estado` enum('pendiente','enviado','cancelado') NOT NULL DEFAULT 'pendiente',
  `asunto` varchar(250) DEFAULT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `mensaje` text,
  `boton` enum('si','no') NOT NULL DEFAULT 'no',
  `texto_boton` varchar(50) DEFAULT NULL,
  `url_boton` text,
  `correos_destinatarios` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos_users`
--

CREATE TABLE `correos_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cortes`
--

CREATE TABLE `cortes` (
  `id` int(10) UNSIGNED NOT NULL,
  `ensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB','Daño de máquina') DEFAULT NULL,
  `no_fabricacion_inicial` varchar(150) DEFAULT NULL,
  `no_fabricacion_final` varchar(150) DEFAULT NULL,
  `cantidad_tk` int(11) DEFAULT NULL,
  `fecha_listado` date DEFAULT NULL,
  `peso_tanque` double DEFAULT NULL,
  `peso_prensa` double DEFAULT NULL,
  `peso_caja` double DEFAULT NULL,
  `peso_otro_item` double DEFAULT NULL,
  `observacion` text,
  `verificacion_calidad` enum('si','no') NOT NULL DEFAULT 'no',
  `calculo_id` int(10) UNSIGNED NOT NULL,
  `proyecto_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_lamina_placas`
--

CREATE TABLE `corte_lamina_placas` (
  `id` int(10) UNSIGNED NOT NULL,
  `maquina` enum('Fasti','Müller','Durma','Forming Roll') DEFAULT NULL,
  `ensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB','Daño de máquina') DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `medida` int(11) DEFAULT NULL,
  `maquina_destino` enum('Trumpf','Arima','Edel','Dobladora','Otra') DEFAULT NULL,
  `observacion` text,
  `inventario_lamina_rollo_id` int(10) UNSIGNED NOT NULL,
  `corte_id` int(10) UNSIGNED NOT NULL,
  `quien_corta` int(10) UNSIGNED NOT NULL,
  `quien_recibe` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_calculos`
--

CREATE TABLE `detalles_calculos` (
  `id` int(10) UNSIGNED NOT NULL,
  `posicion` int(11) DEFAULT NULL,
  `plano` text,
  `ensamble` enum('Fondo','Tanque','Tk Exp.','Tapa','Prensa','Gabinete','Radiador','Mecanizado','Adicional') DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `longitud_1` double DEFAULT NULL,
  `longitud_2` double DEFAULT NULL,
  `masa` double DEFAULT NULL,
  `peso_neto` double DEFAULT NULL,
  `observaciones` text,
  `centro_corte` enum('Fasti','GK','Trumpf','Trumpf 1000','Durma','CNC') DEFAULT NULL,
  `proceso` enum('T','D') DEFAULT NULL,
  `calculo_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_cortes`
--

CREATE TABLE `detalles_cortes` (
  `id` int(10) UNSIGNED NOT NULL,
  `posicion` int(11) DEFAULT NULL,
  `plano` varchar(100) DEFAULT NULL,
  `ensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB','Daño de máquina') DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `longitud_1` double DEFAULT NULL,
  `longitud_2` double DEFAULT NULL,
  `centro_corte` varchar(150) DEFAULT NULL,
  `peso_neto` double DEFAULT NULL,
  `masa` double DEFAULT NULL,
  `proceso` enum('T','D','NULL') DEFAULT NULL,
  `observaciones` text,
  `creado_por_relacion` enum('si','no') DEFAULT 'no',
  `corte_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_lamina_almacen`
--

CREATE TABLE `entrada_lamina_almacen` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `consecutivo_lamina` varchar(150) DEFAULT NULL,
  `espesor_lote` varchar(150) DEFAULT NULL,
  `peso_lamina_validado` double DEFAULT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `precedencia` int(11) NOT NULL,
  `linea` enum('LDT','MDT','SDT','Adicionales','Mecanizados') DEFAULT NULL,
  `tipo_item` enum('Corte','Radiadores','Adicionales','Mecanizados') DEFAULT NULL,
  `subensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB') DEFAULT NULL,
  `tipo_tk` enum('MON','PM','TRI','TRI ESP','PERF','PRENSA','ADIC','MEC') DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones`
--

CREATE TABLE `funciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `identificador` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_kardex_perfileria`
--

CREATE TABLE `inventario_kardex_perfileria` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` text,
  `material_id` int(10) UNSIGNED NOT NULL,
  `entrega_a` int(10) UNSIGNED NOT NULL,
  `recibe_a` int(10) UNSIGNED NOT NULL,
  `proveedor_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_lamina_rollo`
--

CREATE TABLE `inventario_lamina_rollo` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `espesor_validado` double DEFAULT NULL,
  `peso_sin_validar` double DEFAULT NULL,
  `peso_validado` double DEFAULT NULL,
  `lote` varchar(150) DEFAULT NULL,
  `no_identificacion_rollo` varchar(150) DEFAULT NULL,
  `fecha_rollo` date DEFAULT NULL,
  `norma` varchar(150) DEFAULT NULL,
  `ancho_rollo` int(11) DEFAULT NULL,
  `consecutivo_rollo` varchar(150) DEFAULT NULL,
  `observacion` text,
  `proveedor_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `orden_compra_id` int(10) UNSIGNED NOT NULL,
  `operario_id` int(10) UNSIGNED NOT NULL,
  `solicitud_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex_retal_lamina`
--

CREATE TABLE `kardex_retal_lamina` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `largo` int(11) DEFAULT NULL,
  `ancho` int(11) DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `consecutivo_retal` int(10) UNSIGNED DEFAULT NULL,
  `entrada_lamina_almacen_id` int(10) UNSIGNED NOT NULL,
  `quien_genera` int(10) UNSIGNED NOT NULL,
  `quien_gasta` int(10) UNSIGNED NOT NULL,
  `forma_retal_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_cantidad`
--

CREATE TABLE `log_cantidad` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_anterior` double NOT NULL,
  `cantidad_nueva` double NOT NULL,
  `solicitud_material_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(10) UNSIGNED NOT NULL,
  `familia` varchar(250) DEFAULT NULL,
  `unidad_medida` varchar(150) DEFAULT NULL,
  `presentacion` varchar(250) DEFAULT NULL,
  `especificacion` varchar(250) DEFAULT NULL,
  `codigo` varchar(150) DEFAULT NULL,
  `texto_breve` varchar(150) DEFAULT NULL,
  `codigo_plano` varchar(150) DEFAULT NULL,
  `valor_unidad` double DEFAULT NULL,
  `espesor_mm` double DEFAULT NULL,
  `unidad_solicitud` enum('Rollo','Guacal','Pieza','mts','lámina') DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `identificador` int(11) NOT NULL,
  `etiqueta` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_funciones`
--

CREATE TABLE `modulos_funciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `modulo_id` int(10) UNSIGNED NOT NULL,
  `funcion_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compras`
--

CREATE TABLE `ordenes_compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `posicion` varchar(50) DEFAULT NULL,
  `codigo_mecanizado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `cantidad_requerida` double DEFAULT NULL,
  `fecha_entrega_requerida` date DEFAULT NULL,
  `observacion` text,
  `proyecto_id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programaciones`
--

CREATE TABLE `programaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `linea` enum('LDT','MDT','SDT','Adicionales','Mecanizados','Daño de máquina') DEFAULT NULL,
  `tipo_item` enum('Corte','Radiadores','Adicionales','Mecanizados') DEFAULT NULL,
  `subensamble` enum('Tanque','Prensa','Perfileria','Adicional','Mecanizado','Rad MZ','Rad TB','Daño de máquina') DEFAULT NULL,
  `tipo_tk` enum('MON','PM','TRI','TRI ESP','PERF','PRENSA','ADIC','MEC') DEFAULT NULL,
  `no_preliminar_inicial` varchar(150) DEFAULT NULL,
  `no_preliminar_final` varchar(150) DEFAULT NULL,
  `no_fabricacion_inicial` varchar(150) DEFAULT NULL,
  `no_fabricacion_final` varchar(150) DEFAULT NULL,
  `calculo_fert` varchar(150) DEFAULT NULL,
  `orden_fabricacion_trafo` varchar(150) DEFAULT NULL,
  `cantidad_tk` int(11) DEFAULT NULL,
  `KVA` int(11) DEFAULT NULL,
  `baterias_tk` int(11) DEFAULT NULL,
  `no_elem` int(11) DEFAULT NULL,
  `ancho_rad` varchar(5) DEFAULT NULL COMMENT 'ENUM(''326'', ''52'')',
  `longitud_rad` int(11) DEFAULT NULL,
  `fecha_plan_formado_radiador` date DEFAULT NULL,
  `fecha_entrega_formado` date DEFAULT NULL,
  `fecha_liberacion_planos` date DEFAULT NULL,
  `fecha_entrega_material` date DEFAULT NULL,
  `fecha_plan` date DEFAULT NULL,
  `confirmacion_inicial` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `peso_teorico_prensas` double DEFAULT NULL,
  `peso_teorico_tk` double DEFAULT NULL,
  `peso_teorico_cajas` double DEFAULT NULL,
  `peso_teorico_radiadores` double DEFAULT NULL,
  `progreso` double DEFAULT NULL,
  `reproceso` enum('si','no') NOT NULL DEFAULT 'no',
  `proyecto_id` int(10) UNSIGNED NOT NULL,
  `estado_id` int(10) UNSIGNED NOT NULL,
  `proveedor_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_lamina_antes_procesar`
--

CREATE TABLE `recepcion_lamina_antes_procesar` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `espesor_mm` double DEFAULT NULL,
  `peso_por_lamina` double DEFAULT NULL,
  `lote` double DEFAULT NULL,
  `peso_guacal` double DEFAULT NULL,
  `largo` double DEFAULT NULL,
  `ancho` double DEFAULT NULL,
  `observacion` text,
  `material_id` int(10) UNSIGNED NOT NULL,
  `orden_compra_id` int(10) UNSIGNED NOT NULL,
  `operario_id` int(10) UNSIGNED NOT NULL,
  `solicitud_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `superadministrador` enum('si','no') NOT NULL DEFAULT 'no',
  `nombre` varchar(100) NOT NULL,
  `privilegios` text,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operarios` enum('si','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nota` text NOT NULL,
  `programacion_id` int(10) UNSIGNED NOT NULL,
  `estado_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_materiales`
--

CREATE TABLE `solicitudes_materiales` (
  `id` int(10) UNSIGNED NOT NULL,
  `um` enum('Kg','m') DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `cantidad_entregada` double DEFAULT '0',
  `lote` varchar(150) DEFAULT NULL,
  `observaciones` text,
  `material_id` int(10) UNSIGNED NOT NULL,
  `solicitud_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo_identificacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombres` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('masculino','femenino') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `funcion` enum('corte','tubos','radiadores') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archivo_id` int(10) UNSIGNED DEFAULT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calculos`
--
ALTER TABLE `calculos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clientes_users1_idx` (`user_id`);

--
-- Indices de la tabla `consumo_diario_lamina`
--
ALTER TABLE `consumo_diario_lamina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumo_diario_lamina_entrada_lamina_almacen1_idx` (`entrada_lamina_almacen_id`),
  ADD KEY `fk_consumo_diario_lamina_cortes1_idx` (`corte_id`),
  ADD KEY `fk_consumo_diario_lamina_users1_idx` (`operario_id`),
  ADD KEY `fk_consumo_diario_lamina_kardex_retal_lamina1_idx` (`kardex_retal_lamina_id`);

--
-- Indices de la tabla `consumo_lamina`
--
ALTER TABLE `consumo_lamina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumo_lamina_entrada_lamina_almacen1_idx` (`entrada_lamina_almacen_id`),
  ADD KEY `fk_consumo_lamina_cortes1_idx` (`corte_id`),
  ADD KEY `fk_consumo_lamina_users1_idx` (`operario_id`);

--
-- Indices de la tabla `consumo_perfileria`
--
ALTER TABLE `consumo_perfileria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumo_perfileria_users1_idx` (`quien_entrego`),
  ADD KEY `fk_consumo_perfileria_users2_idx` (`quien_solicito`),
  ADD KEY `fk_consumo_perfileria_cortes1_idx` (`corte_id`),
  ADD KEY `fk_consumo_perfileria_materiales1_idx` (`material_id`),
  ADD KEY `fk_consumo_perfileria_clientes1_idx` (`cliente_id`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `correos_users`
--
ALTER TABLE `correos_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_correos_has_users_users1_idx` (`user_id`),
  ADD KEY `fk_correos_has_users_correos1_idx` (`correo_id`);

--
-- Indices de la tabla `cortes`
--
ALTER TABLE `cortes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cortes_proyectos1_idx` (`proyecto_id`),
  ADD KEY `fk_cortes_users1_idx` (`user_id`),
  ADD KEY `fk_cortes_calculos1_idx` (`calculo_id`);

--
-- Indices de la tabla `corte_lamina_placas`
--
ALTER TABLE `corte_lamina_placas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_corte_lamina_placas_inventario_lamina_rollo1_idx` (`inventario_lamina_rollo_id`),
  ADD KEY `fk_corte_lamina_placas_cortes1_idx` (`corte_id`),
  ADD KEY `fk_corte_lamina_placas_users1_idx` (`quien_corta`),
  ADD KEY `fk_corte_lamina_placas_users2_idx` (`quien_recibe`);

--
-- Indices de la tabla `detalles_calculos`
--
ALTER TABLE `detalles_calculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalles_calculos_calculos1_idx` (`calculo_id`),
  ADD KEY `fk_detalles_calculos_materiales1_idx` (`material_id`);

--
-- Indices de la tabla `detalles_cortes`
--
ALTER TABLE `detalles_cortes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalles_cortes_cortes1_idx` (`corte_id`),
  ADD KEY `fk_detalles_cortes_materiales1_idx` (`material_id`);

--
-- Indices de la tabla `entrada_lamina_almacen`
--
ALTER TABLE `entrada_lamina_almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entrada_lamina_almacen_materiales1_idx` (`material_id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `precedencia_UNIQUE` (`precedencia`);

--
-- Indices de la tabla `funciones`
--
ALTER TABLE `funciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_kardex_perfileria`
--
ALTER TABLE `inventario_kardex_perfileria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventario_kardex_perfileria_materiales1_idx` (`material_id`),
  ADD KEY `fk_inventario_kardex_perfileria_users1_idx` (`entrega_a`),
  ADD KEY `fk_inventario_kardex_perfileria_users2_idx` (`recibe_a`),
  ADD KEY `fk_inventario_kardex_perfileria_proveedores1_idx` (`proveedor_id`);

--
-- Indices de la tabla `inventario_lamina_rollo`
--
ALTER TABLE `inventario_lamina_rollo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventario_lamina_rollo_materiales1_idx` (`material_id`),
  ADD KEY `fk_inventario_lamina_rollo_ordenes_compras1_idx` (`orden_compra_id`),
  ADD KEY `fk_inventario_lamina_rollo_users1_idx` (`operario_id`),
  ADD KEY `fk_inventario_lamina_rollo_proveedores1_idx` (`proveedor_id`),
  ADD KEY `fk_inventario_lamina_rollo_solicitudes1_idx` (`solicitud_id`);

--
-- Indices de la tabla `kardex_retal_lamina`
--
ALTER TABLE `kardex_retal_lamina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kardex_retal_lamina_entrada_lamina_almacen1_idx` (`entrada_lamina_almacen_id`),
  ADD KEY `fk_kardex_retal_lamina_users1_idx` (`quien_genera`),
  ADD KEY `fk_kardex_retal_lamina_users2_idx` (`quien_gasta`),
  ADD KEY `fk_kardex_retal_lamina_archivos1_idx` (`forma_retal_id`);

--
-- Indices de la tabla `log_cantidad`
--
ALTER TABLE `log_cantidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_cantidad_solicitudes_materiales1_idx` (`solicitud_material_id`),
  ADD KEY `fk_log_cantidad_users1_idx` (`user_id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos_funciones`
--
ALTER TABLE `modulos_funciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulos_has_funciones_funciones1_idx` (`funcion_id`),
  ADD KEY `fk_modulos_has_funciones_modulos1_idx` (`modulo_id`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indices de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordenes_compras_proyectos1_idx` (`proyecto_id`),
  ADD KEY `fk_ordenes_compras_clientes1_idx` (`cliente_id`),
  ADD KEY `fk_ordenes_compras_users1_idx` (`user_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `programaciones`
--
ALTER TABLE `programaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_programaciones_proyectos1_idx` (`proyecto_id`),
  ADD KEY `fk_programaciones_estados1_idx` (`estado_id`),
  ADD KEY `fk_programaciones_proveedores1_idx` (`proveedor_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedores_users1_idx` (`user_id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proyectos_users1_idx` (`user_id`),
  ADD KEY `fk_proyectos_clientes1_idx` (`cliente_id`);

--
-- Indices de la tabla `recepcion_lamina_antes_procesar`
--
ALTER TABLE `recepcion_lamina_antes_procesar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recepcion_lamina_antes_procesar_materiales1_idx` (`material_id`),
  ADD KEY `fk_recepcion_lamina_antes_procesar_ordenes_compras1_idx` (`orden_compra_id`),
  ADD KEY `fk_recepcion_lamina_antes_procesar_users1_idx` (`operario_id`),
  ADD KEY `fk_recepcion_lamina_antes_procesar_solicitudes1_idx` (`solicitud_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_roles_users1_idx` (`user_id`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seguimientos_programaciones1_idx` (`programacion_id`),
  ADD KEY `fk_seguimientos_estados1_idx` (`estado_id`),
  ADD KEY `fk_seguimientos_users1_idx` (`user_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes_materiales`
--
ALTER TABLE `solicitudes_materiales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_solicitudes_materiales_materiales1_idx` (`material_id`),
  ADD KEY `fk_solicitudes_materiales_solicitudes1_idx` (`solicitud_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_identificacion_unique` (`identificacion`),
  ADD KEY `fk_users_roles1_idx` (`rol_id`),
  ADD KEY `fk_users_users1_idx` (`user_id`),
  ADD KEY `fk_users_archivos1_idx` (`archivo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `calculos`
--
ALTER TABLE `calculos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `consumo_diario_lamina`
--
ALTER TABLE `consumo_diario_lamina`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `consumo_lamina`
--
ALTER TABLE `consumo_lamina`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `consumo_perfileria`
--
ALTER TABLE `consumo_perfileria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `correos_users`
--
ALTER TABLE `correos_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cortes`
--
ALTER TABLE `cortes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `corte_lamina_placas`
--
ALTER TABLE `corte_lamina_placas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalles_calculos`
--
ALTER TABLE `detalles_calculos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalles_cortes`
--
ALTER TABLE `detalles_cortes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `entrada_lamina_almacen`
--
ALTER TABLE `entrada_lamina_almacen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `funciones`
--
ALTER TABLE `funciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `inventario_kardex_perfileria`
--
ALTER TABLE `inventario_kardex_perfileria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inventario_lamina_rollo`
--
ALTER TABLE `inventario_lamina_rollo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `kardex_retal_lamina`
--
ALTER TABLE `kardex_retal_lamina`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `log_cantidad`
--
ALTER TABLE `log_cantidad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `modulos_funciones`
--
ALTER TABLE `modulos_funciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `programaciones`
--
ALTER TABLE `programaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recepcion_lamina_antes_procesar`
--
ALTER TABLE `recepcion_lamina_antes_procesar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `solicitudes_materiales`
--
ALTER TABLE `solicitudes_materiales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consumo_diario_lamina`
--
ALTER TABLE `consumo_diario_lamina`
  ADD CONSTRAINT `fk_consumo_diario_lamina_cortes1` FOREIGN KEY (`corte_id`) REFERENCES `cortes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_diario_lamina_entrada_lamina_almacen1` FOREIGN KEY (`entrada_lamina_almacen_id`) REFERENCES `entrada_lamina_almacen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_diario_lamina_kardex_retal_lamina1` FOREIGN KEY (`kardex_retal_lamina_id`) REFERENCES `kardex_retal_lamina` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consumo_diario_lamina_users1` FOREIGN KEY (`operario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consumo_lamina`
--
ALTER TABLE `consumo_lamina`
  ADD CONSTRAINT `fk_consumo_lamina_cortes1` FOREIGN KEY (`corte_id`) REFERENCES `cortes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_lamina_entrada_lamina_almacen1` FOREIGN KEY (`entrada_lamina_almacen_id`) REFERENCES `entrada_lamina_almacen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_lamina_users1` FOREIGN KEY (`operario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consumo_perfileria`
--
ALTER TABLE `consumo_perfileria`
  ADD CONSTRAINT `fk_consumo_perfileria_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_perfileria_cortes1` FOREIGN KEY (`corte_id`) REFERENCES `cortes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_perfileria_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_perfileria_users1` FOREIGN KEY (`quien_entrego`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumo_perfileria_users2` FOREIGN KEY (`quien_solicito`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correos_users`
--
ALTER TABLE `correos_users`
  ADD CONSTRAINT `fk_correos_has_users_correos1` FOREIGN KEY (`correo_id`) REFERENCES `correos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_correos_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cortes`
--
ALTER TABLE `cortes`
  ADD CONSTRAINT `fk_cortes_calculos1` FOREIGN KEY (`calculo_id`) REFERENCES `calculos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cortes_proyectos1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cortes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `corte_lamina_placas`
--
ALTER TABLE `corte_lamina_placas`
  ADD CONSTRAINT `fk_corte_lamina_placas_cortes1` FOREIGN KEY (`corte_id`) REFERENCES `cortes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_corte_lamina_placas_inventario_lamina_rollo1` FOREIGN KEY (`inventario_lamina_rollo_id`) REFERENCES `inventario_lamina_rollo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_corte_lamina_placas_users1` FOREIGN KEY (`quien_corta`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_corte_lamina_placas_users2` FOREIGN KEY (`quien_recibe`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_calculos`
--
ALTER TABLE `detalles_calculos`
  ADD CONSTRAINT `fk_detalles_calculos_calculos1` FOREIGN KEY (`calculo_id`) REFERENCES `calculos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_calculos_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_cortes`
--
ALTER TABLE `detalles_cortes`
  ADD CONSTRAINT `fk_detalles_cortes_cortes1` FOREIGN KEY (`corte_id`) REFERENCES `cortes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_cortes_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrada_lamina_almacen`
--
ALTER TABLE `entrada_lamina_almacen`
  ADD CONSTRAINT `fk_entrada_lamina_almacen_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario_kardex_perfileria`
--
ALTER TABLE `inventario_kardex_perfileria`
  ADD CONSTRAINT `fk_inventario_kardex_perfileria_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_kardex_perfileria_proveedores1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_kardex_perfileria_users1` FOREIGN KEY (`entrega_a`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_kardex_perfileria_users2` FOREIGN KEY (`recibe_a`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario_lamina_rollo`
--
ALTER TABLE `inventario_lamina_rollo`
  ADD CONSTRAINT `fk_inventario_lamina_rollo_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_lamina_rollo_ordenes_compras1` FOREIGN KEY (`orden_compra_id`) REFERENCES `ordenes_compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_lamina_rollo_proveedores1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_lamina_rollo_solicitudes1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_lamina_rollo_users1` FOREIGN KEY (`operario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `kardex_retal_lamina`
--
ALTER TABLE `kardex_retal_lamina`
  ADD CONSTRAINT `fk_kardex_retal_lamina_archivos1` FOREIGN KEY (`forma_retal_id`) REFERENCES `archivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kardex_retal_lamina_entrada_lamina_almacen1` FOREIGN KEY (`entrada_lamina_almacen_id`) REFERENCES `entrada_lamina_almacen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kardex_retal_lamina_users1` FOREIGN KEY (`quien_genera`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kardex_retal_lamina_users2` FOREIGN KEY (`quien_gasta`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `log_cantidad`
--
ALTER TABLE `log_cantidad`
  ADD CONSTRAINT `fk_log_cantidad_solicitudes_materiales1` FOREIGN KEY (`solicitud_material_id`) REFERENCES `solicitudes_materiales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_cantidad_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulos_funciones`
--
ALTER TABLE `modulos_funciones`
  ADD CONSTRAINT `fk_modulos_has_funciones_funciones1` FOREIGN KEY (`funcion_id`) REFERENCES `funciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_modulos_has_funciones_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD CONSTRAINT `fk_ordenes_compras_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordenes_compras_proyectos1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordenes_compras_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `programaciones`
--
ALTER TABLE `programaciones`
  ADD CONSTRAINT `fk_programaciones_estados1` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programaciones_proveedores1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programaciones_proyectos1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_proyectos_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_proyectos_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recepcion_lamina_antes_procesar`
--
ALTER TABLE `recepcion_lamina_antes_procesar`
  ADD CONSTRAINT `fk_recepcion_lamina_antes_procesar_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recepcion_lamina_antes_procesar_ordenes_compras1` FOREIGN KEY (`orden_compra_id`) REFERENCES `ordenes_compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recepcion_lamina_antes_procesar_solicitudes1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recepcion_lamina_antes_procesar_users1` FOREIGN KEY (`operario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `fk_seguimientos_estados1` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seguimientos_programaciones1` FOREIGN KEY (`programacion_id`) REFERENCES `programaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seguimientos_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes_materiales`
--
ALTER TABLE `solicitudes_materiales`
  ADD CONSTRAINT `fk_solicitudes_materiales_materiales1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitudes_materiales_solicitudes1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_archivos1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
