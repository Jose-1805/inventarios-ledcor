-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2018 a las 16:21:19
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

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `nombre`, `ubicacion`, `created_at`, `updated_at`) VALUES
(1, 'importacion_programacionghg.xlsx', 'imagenes/consumo_kardex_retal_lamina/forma_retal/1', '2018-05-02 03:30:40', '2018-05-02 03:30:40');

--
-- Volcado de datos para la tabla `calculos`
--

INSERT INTO `calculos` (`id`, `numero`, `ensamble`, `fert`, `created_at`, `updated_at`) VALUES
(1, '1805', 'Fondo', '1805', '2018-05-02 02:54:41', '2018-05-02 02:54:41');

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `alias`, `direccion`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Prueba', 'Prueba', 'Prueba', 11, '2018-05-02 02:51:49', '2018-05-02 02:51:49');

--
-- Volcado de datos para la tabla `consumo_diario_lamina`
--

INSERT INTO `consumo_diario_lamina` (`id`, `maquina`, `fecha`, `ensamble`, `consumo`, `desperdicio`, `consecutivo_retal`, `observacion`, `entrada_lamina_almacen_id`, `corte_id`, `operario_id`, `kardex_retal_lamina_id`, `created_at`, `updated_at`) VALUES
(1, 'Fasti', '2018-05-01', 'Fondo', 10, 0, NULL, NULL, 1, 1, 13, 1, '2018-05-02 04:12:46', '2018-05-02 04:12:46');

--
-- Volcado de datos para la tabla `cortes`
--

INSERT INTO `cortes` (`id`, `ensamble`, `no_fabricacion_inicial`, `no_fabricacion_final`, `cantidad_tk`, `fecha_listado`, `peso_tanque`, `peso_prensa`, `peso_caja`, `peso_otro_item`, `observacion`, `verificacion_calidad`, `calculo_id`, `proyecto_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Tanque', '1805', '1806', 10, '2018-05-01', 18, 18, 18, 10, NULL, 'no', 1, 1, 13, '2018-05-02 02:55:59', '2018-05-02 02:55:59');

--
-- Volcado de datos para la tabla `entrada_lamina_almacen`
--

INSERT INTO `entrada_lamina_almacen` (`id`, `fecha_recibido`, `consecutivo_lamina`, `espesor_lote`, `peso_lamina_validado`, `material_id`, `created_at`, `updated_at`) VALUES
(1, '2018-05-01', '10651', '10', 0, 2, '2018-05-01 23:12:46', '2018-05-02 04:12:46');

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`, `precedencia`, `linea`, `tipo_item`, `subensamble`, `tipo_tk`, `email`, `created_at`, `updated_at`) VALUES
(2, 'Estado 1', 1, 'MDT', 'Radiadores', 'Prensa', 'PM', 'jkja@dsa.co', '2018-04-30 01:47:18', '2018-04-30 06:47:18'),
(3, 'Estado 2', 2, NULL, NULL, NULL, NULL, NULL, '2018-04-11 21:23:50', '2018-04-11 21:23:50'),
(4, 'Estado 3', 3, NULL, NULL, NULL, NULL, NULL, '2018-04-11 21:24:08', '2018-04-11 21:24:08'),
(5, 'Estado 4', 4, NULL, NULL, NULL, NULL, NULL, '2018-04-11 21:24:39', '2018-04-11 21:24:39');

--
-- Volcado de datos para la tabla `funciones`
--

INSERT INTO `funciones` (`id`, `nombre`, `identificador`, `created_at`, `updated_at`) VALUES
(3, 'Crear', 1, '2017-09-01 05:32:36', '2017-09-01 05:32:36'),
(4, 'Editar', 2, '2017-09-01 05:32:44', '2017-09-01 05:32:44'),
(5, 'Eliminar', 3, '2017-09-01 05:32:54', '2017-09-01 05:32:54'),
(6, 'Ver', 4, '2017-09-01 05:32:59', '2017-09-01 05:32:59');

--
-- Volcado de datos para la tabla `inventario_lamina_rollo`
--

INSERT INTO `inventario_lamina_rollo` (`id`, `fecha_recibido`, `espesor_validado`, `peso_sin_validar`, `peso_validado`, `lote`, `no_identificacion_rollo`, `fecha_rollo`, `norma`, `ancho_rollo`, `consecutivo_rollo`, `observacion`, `proveedor_id`, `material_id`, `orden_compra_id`, `operario_id`, `solicitud_id`) VALUES
(1, '2018-05-01', 10, 10, 10, '10', '10', '2018-05-01', '10', 10, '105', NULL, 1, 1, 1, 13, 1);

--
-- Volcado de datos para la tabla `kardex_retal_lamina`
--

INSERT INTO `kardex_retal_lamina` (`id`, `fecha`, `fecha_ingreso`, `cantidad`, `largo`, `ancho`, `peso`, `consecutivo_retal`, `entrada_lamina_almacen_id`, `quien_genera`, `quien_gasta`, `forma_retal_id`, `created_at`, `updated_at`) VALUES
(1, '2018-05-01', '2018-05-02', 10, 10, 10, 10, 1, 1, 11, 13, 1, '2018-05-02 03:30:40', '2018-05-02 03:30:41');

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `familia`, `unidad_medida`, `presentacion`, `especificacion`, `codigo`, `texto_breve`, `codigo_plano`, `valor_unidad`, `espesor_mm`, `unidad_solicitud`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 'ROLLO', 'KG', 'ROLLO', 'ROLLO', '02546', 'Rollo de lámina', '10089', 50000, 15, 'Rollo', 18, '2018-05-02 02:30:25', '2018-05-02 02:30:25'),
(2, 'Plancha', 'KG', 'Plancha', '10561', '1091', 'Plancha', '156', 10, 10, 'mts', 0, '2018-05-01 23:12:46', '2018-05-02 04:12:46');

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_09_11_155458_create_sessions_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(6, '2016_06_01_000004_create_oauth_clients_table', 2),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `nombre`, `identificador`, `etiqueta`, `url`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Módulos y funciones', 1, 'Módulos y funciones', '/modulos-funciones', 'Activo', '2017-08-31 20:02:23', '2017-09-01 01:02:23'),
(2, 'Roles', 2, 'Roles', '/rol', 'Activo', '2017-09-01 01:04:57', '2017-09-01 01:04:57'),
(3, 'Usuarios', 3, 'Usuarios', '/usuario', 'Activo', '2017-09-01 01:05:19', '2017-09-01 01:05:19'),
(4, 'Operarios', 4, 'Operarios', '/operario', 'Activo', '2018-02-08 19:01:27', '2018-02-08 19:01:27'),
(5, 'Clientes', 5, 'Clientes', '/cliente', 'Activo', '2018-02-08 23:29:46', '2018-02-08 23:29:46'),
(6, 'Proyectos', 6, 'Proyecto', '/proyecto', 'Activo', '2018-02-09 02:18:09', '2018-02-09 02:18:09'),
(7, 'Ordenes de compra', 7, 'Ordenes de compra', '/orden-compra', 'Activo', '2018-02-09 03:20:28', '2018-02-09 03:20:28'),
(8, 'Proveedores', 8, 'Proveedores', '/proveedor', 'Activo', '2018-02-09 19:37:03', '2018-02-09 19:37:03');

--
-- Volcado de datos para la tabla `modulos_funciones`
--

INSERT INTO `modulos_funciones` (`id`, `modulo_id`, `funcion_id`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 5),
(4, 1, 6),
(5, 2, 3),
(6, 2, 4),
(7, 2, 5),
(8, 2, 6),
(9, 3, 3),
(10, 3, 4),
(11, 3, 5),
(12, 3, 6),
(13, 5, 3),
(14, 5, 4),
(15, 5, 6),
(16, 4, 3),
(17, 4, 4),
(18, 4, 5),
(19, 4, 6),
(20, 7, 3),
(21, 7, 4),
(22, 7, 5),
(23, 7, 6),
(24, 8, 3),
(25, 8, 4),
(26, 8, 5),
(27, 8, 6),
(28, 6, 3),
(29, 6, 4),
(30, 6, 5),
(31, 6, 6);

--
-- Volcado de datos para la tabla `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(3, 11, 'Prueba api', 'ohGN3IuuyFa48zsP6SxKsECFEQhbi24eKNodtEa2', 'http://192.168.0.101', 0, 1, 1, '2017-10-08 03:02:51', '2017-10-08 03:35:15'),
(5, 11, 'Prueba', 'MbjVKDcYpaLZBg8r2lcoUJN7fvinr4N0uv58mgoP', 'http://192.168.0.18:8000', 0, 1, 0, '2017-10-13 22:56:26', '2017-10-13 22:56:26'),
(6, NULL, 'InventariosLedcor Personal Access Client', 'M9XCvVdGtJe0dinTOiXhpvt9a3ViZHEk8jp8SLBJ', 'http://localhost', 1, 0, 0, '2018-02-02 02:49:32', '2018-02-02 02:49:32'),
(7, NULL, 'InventariosLedcor Password Grant Client', '5jhUfwkdAUsvPo5fTG2J0IZi2QS2oC7995P56GPl', 'http://localhost', 0, 1, 0, '2018-02-02 02:49:32', '2018-02-02 02:49:32'),
(8, NULL, 'Laravel Personal Access Client', '8EdnuUzMEmNztr2Z1Z31Tre2gCvUAOBZhzg0Gias', 'http://localhost', 1, 0, 0, '2018-02-02 17:39:48', '2018-02-02 17:39:48'),
(9, NULL, 'Laravel Password Grant Client', 'FFpwhjFyYQEDgK1tBz2ewZT8hgxjRS6eLMrSi7m4', 'http://localhost', 0, 1, 0, '2018-02-02 17:39:48', '2018-02-02 17:39:48');

--
-- Volcado de datos para la tabla `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 3, '2017-10-07 23:58:07', '2017-10-07 23:58:07'),
(2, 6, '2018-02-02 02:49:32', '2018-02-02 02:49:32'),
(3, 8, '2018-02-02 17:39:48', '2018-02-02 17:39:48');

--
-- Volcado de datos para la tabla `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('026282e3d0787e22f060233c0fc408afa79cbdd6b8f2080bd4ea26f3a01e3f9f7541132859150870', '7e99b84147740dad2932b7fa2b6d956b926bb7bf5794f4fa648af347cd58169fa7d6579a6cc9cd37', 0, '2018-10-13 14:03:34'),
('0f23529bf459925b2b98f755bd62d7bd054f215d0793c508b64245c8b3755ece7398f04a80b96237', 'ef7793566350f8fc70623a3ea0528c31a9426c6a4bcff21f53d58979b946363be5e47898f7b21821', 0, '2018-10-07 17:34:02'),
('247dbe2d7a01755d9f59c5860af3c33d17c570a82490c5c7742a63df21f5268069824789b5397ff5', '561ee8f033b8f8ac2f6e7e89cdee93c37242592a7d3593de14556e1779895c8f5166f8a06e01b20e', 0, '2018-10-13 14:45:57'),
('2cd61b99327ed237ea9aa3187eb2d43e3a7e25738d67203972b4a2da06c638e83f11f30fbc932d52', '694d39991fa9d064336bc28c92fe5734bab4b89593eba91e8794239496cd17c138780366f22b1039', 0, '2018-10-13 14:09:09'),
('3b78c6cab0a1f56e21ab768495cf6503f440e61b7f14ce88001d1eb03e6561b5d77900c0f2eec4e9', '636cb849597dc0942957eb345f226feb5a5ba16ccdba24320e424ff8b29d8a02de761c2b8a6ffcb5', 0, '2018-10-13 14:17:27'),
('4207e9b58695eb6583bf3a94fbd08544f91ebc8ad696d1da296b99fd971936b227cc033adb3d94e6', 'e50df7a7981d0459d65973d8acbe991c9b561895ea161b58e89b0c4ed69b1d9112c042daa2c4b16d', 0, '2018-10-13 14:13:51'),
('4e73b03686d6e001fffb5b4b87cd10a30424ecb49ef875a3979d9662a90a66a8e86de2a193a5ccb3', 'eee57c5a454adf3593f9655fd40c35dfe80bb544413ad2a14eb108dcfa8a11839ec2bc7696887ba8', 0, '2018-10-13 14:02:53'),
('67cccf30a91a2018bba8a4c957c97cdcd8007b1f86453c637f1e288aac819c03b558d45fcf56e0c7', 'b437eef59f8df28dd602ebef74f0e98e78d8e9d3f47280fc45c3675aafafbd3bf7dd43ac55cf4260', 0, '2018-10-13 14:04:16'),
('82ce62970612f715813bc3864c9e4f8ffaabea1d3bc28c2359177e3f4ec9ffeec2b98d2ec9ad51e6', '86e2b6bda2da7520c965fb05b6eaf4a7f014371197c745572e17c74c1ec43ffafff0d5e0d979a2d2', 0, '2018-10-13 14:03:03'),
('89294cde069c1730b3932e3ea96cd7ed9915b1e13a935dbf81539b8914c854f00efc35d21201266e', '9f0f0f2ad2a46fed47db981033fb01da3a4251bac80141fb4ba55a6a1ebf1f029789173309b3d04f', 0, '2018-10-13 14:59:44'),
('931fe4e7dfff2fe1d034df2f40e93cbd5952c3e5d28e63a6f8a4d2b8284231ac691797eb59ce1364', '9fd518d5893db58924ba1669e832debebf5a07044cc7e913fb3298349bbf032974547af1e9f3b2b8', 0, '2018-10-13 14:14:00'),
('9615adaf1c37248be6b3d2cac771fae462bc9f256ead8a393b6e681e5ca830e86af5b54008094898', '01170dfd7055ef05bc4e96cfa188810d5b89fea814d2a41ba59d649c4a93baf1676940cc2750b854', 0, '2018-10-13 13:01:10'),
('9bd039e40744f79f6f587ea132f5bd4c8eb9266d1171109941a070e6c52aebcc6401017a76151242', '44bf8ee6d0c7e07e18f0c4b0456e6976bd22634ac2acf80602ec1c459ea5c13c997175f0afe94740', 0, '2018-10-13 13:45:10'),
('9d48072c1f471b9aa656c85bb968badc1add5f55bae1f7d78d5cc4c829b8bbb27a877c9a5e380c36', '998803fc979ac0b85188a65ffbfe1c84a800ac95ecdfe1abe9063ed31dd494715f14b5d58caaee7f', 0, '2018-10-07 17:22:29'),
('a294032efb6eaef10f086829c066e6b00fa189c4885f2fd18eedcc166982a18317480cfe84b93753', '72b132ca085e5088db7bd5b895fd7fa195174e54a26922b8340c4833d08fd85517d3a5c8ef9155c4', 0, '2018-10-13 13:00:17'),
('a561e8f359434b47d776f5fb9c6d9b079a6bc98b158cba40018277544d3d31355860f1bbfd61fa88', '9825c06d9349605def39ab1cb79afa83c56e819fc5e4e982ad431a1b2888bc0661b89f9e5fdf9608', 0, '2018-10-13 14:03:20'),
('ac5e6dbafb3302af5e1dd8c4267016535acae50dd0e797cdccdc867f22e08bc3aff660c9d47d1f7d', '62bd1c658a968b83e1a772892038b5fff430ee5aa260616f2b319e23b2196b2ed5037fb7eace54f6', 0, '2018-10-13 13:59:03'),
('c15f3c69e6330c548939b117e1747264649375688640f3df9159a774ced86c66ec1b9504eea9142d', '7ebb700a512f656e8a652b12cd62fb5900ef0d864dde8b917ec0d21f579e29e2374c8ef3d106278d', 0, '2018-10-13 14:03:42'),
('ca53f238823508cee736a86245d5f605c0aaf86ec802df0b78e11be0b398ad2da9d58c3e18fea842', '05e5c9831a15bacd6ff04653525aa0078f5883bbfccec50bb2b852e411028b9f669dea076680ce14', 0, '2018-10-13 14:56:28'),
('d1e8479bf1c11e8e9a4c13fd2ac3b1060ddc642654180376b0acb430112f9fa9b99aa9ff5648e7d4', '5dff0388b98a06077a23ab44b7bbde3d390226a1421b2b0eff4da6586efed51cdb0ae40a2ff030c5', 0, '2018-10-13 14:30:53'),
('df021050dce19301480d3015263b4421c4a3892a4ebd9631425263248f3fadae1daf0a0dfaf588dd', '7fae4eb338f4c0f17c26dfb60fa305fdcef240f6440154c7ed0c87377715e666be761e9ca8f254eb', 0, '2018-10-13 14:11:51'),
('f23a43caf04e039ba169def4b979c8ce5fe06f7ff8db127cef9ba02475822246e35c9814919deb0b', '2b04d2d21858c3d1ee0779f3dae218f277f60dd40ed419438d40db247ec4e7c82ae569c29e8dbc56', 0, '2018-10-13 14:11:26');

--
-- Volcado de datos para la tabla `ordenes_compras`
--

INSERT INTO `ordenes_compras` (`id`, `numero`, `fecha`, `posicion`, `codigo_mecanizado`, `descripcion`, `cantidad_requerida`, `fecha_entrega_requerida`, `observacion`, `proyecto_id`, `cliente_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '0614', '2018-05-01', '10', '10', '10', 10, '2018-05-07', NULL, 1, 1, 11, '2018-05-02 03:26:35', '2018-05-02 03:26:35');

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('jlcapote@misena.edu.co', '$2y$10$AZBH3QTpynq00iWeQSnypuOxOqSEFvPTYGCl2ZmJKw7OiBUcVtHMS', '2017-09-11 21:16:10');

--
-- Volcado de datos para la tabla `programaciones`
--

INSERT INTO `programaciones` (`id`, `linea`, `tipo_item`, `subensamble`, `tipo_tk`, `no_preliminar_inicial`, `no_preliminar_final`, `no_fabricacion_inicial`, `no_fabricacion_final`, `calculo_fert`, `orden_fabricacion_trafo`, `cantidad_tk`, `KVA`, `baterias_tk`, `no_elem`, `ancho_rad`, `longitud_rad`, `fecha_plan_formado_radiador`, `fecha_entrega_formado`, `fecha_liberacion_planos`, `fecha_entrega_material`, `fecha_plan`, `confirmacion_inicial`, `fecha_entrega`, `peso_teorico_prensas`, `peso_teorico_tk`, `peso_teorico_cajas`, `peso_teorico_radiadores`, `progreso`, `reproceso`, `proyecto_id`, `estado_id`, `proveedor_id`, `created_at`, `updated_at`) VALUES
(1, 'LDT', 'Corte', 'Tanque', 'MON', '1805', '1806', '1805', '1806', '1805', '1805', 10, 1805, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-01', '2018-05-01', '2018-05-01', '2018-05-01', '2018-05-01', NULL, 10, 10, NULL, 10, 'no', 1, 2, 1, '2018-05-02 02:54:21', '2018-05-02 02:54:21');

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `alias`, `direccion`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Prueba', 'Prueba', 'Prueba', 11, '2018-05-02 02:53:30', '2018-05-02 02:53:30');

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre`, `fecha_inicio`, `user_id`, `cliente_id`, `created_at`, `updated_at`) VALUES
(1, 'Prueba', '2018-05-01', 11, 1, '2018-05-02 02:51:59', '2018-05-02 02:51:59');

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `superadministrador`, `nombre`, `privilegios`, `user_id`, `created_at`, `updated_at`, `operarios`) VALUES
(1, 'si', 'Superadministrador', NULL, NULL, '2017-08-31 14:08:41', '2017-08-31 14:08:41', 'no'),
(2, 'no', 'Operario', '(7,4)', 11, '2018-02-22 19:31:37', '2018-02-22 19:31:37', 'si');

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `numero`, `fecha`, `created_at`, `updated_at`) VALUES
(1, '1', '2018-05-01', '2018-05-02 03:03:26', '2018-05-02 03:03:26');

--
-- Volcado de datos para la tabla `solicitudes_materiales`
--

INSERT INTO `solicitudes_materiales` (`id`, `um`, `cantidad`, `cantidad_entregada`, `lote`, `observaciones`, `material_id`, `solicitud_id`, `created_at`, `updated_at`) VALUES
(1, 'Kg', 100, 0, '80', NULL, 1, 1, '2018-05-02 03:03:54', '2018-05-02 03:03:54');

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `tipo_identificacion`, `identificacion`, `nombres`, `apellidos`, `telefono`, `fecha_nacimiento`, `email`, `genero`, `fecha_ingreso`, `funcion`, `password`, `remember_token`, `archivo_id`, `rol_id`, `user_id`, `created_at`, `updated_at`) VALUES
(11, NULL, NULL, 'Superadministrador', 'Initial Fire', NULL, NULL, 'superadmin@gmail.com', NULL, NULL, NULL, '$2y$10$jNv/bv/ZQC9H9TOAHY8Dq.Na3oO99cH5v/8Wy37MIrTPMUHCvVFue', 'h6bC2zzWDsR4e7vRsd7rY081CVZrs6p0AvIrtSwejCIYxleKZWQIWsbzrdsZ', NULL, 1, NULL, '2017-08-31 14:09:49', '2017-12-05 21:03:33'),
(13, 'C.C', '1069175512', 'Operario', 'N1', NULL, NULL, 'prueba@gmail.com', NULL, '1993-05-18', 'corte', NULL, NULL, NULL, 2, 11, '2018-04-11 21:07:54', '2018-04-11 21:07:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
