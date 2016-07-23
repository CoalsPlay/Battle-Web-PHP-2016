-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-07-2016 a las 16:51:27
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sod`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `id_a` int(11) UNSIGNED NOT NULL,
  `id_usuario_1` int(11) UNSIGNED NOT NULL,
  `id_usuario_2` int(11) UNSIGNED NOT NULL,
  `fecha_a` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arenas`
--

CREATE TABLE `arenas` (
  `id_arena` int(11) UNSIGNED NOT NULL,
  `id_usuario_arena1` int(11) UNSIGNED NOT NULL,
  `id_usuario_arena2` int(11) UNSIGNED NOT NULL,
  `atk_arena` int(11) UNSIGNED NOT NULL,
  `def_arena` int(11) UNSIGNED NOT NULL,
  `hp_arena` int(11) UNSIGNED NOT NULL,
  `max_hp_arena` int(11) UNSIGNED NOT NULL,
  `sp_arena` int(11) UNSIGNED NOT NULL,
  `max_sp_arena` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bugs`
--

CREATE TABLE `bugs` (
  `id_bug` mediumint(8) NOT NULL,
  `text_bug` varchar(20000) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(40) CHARACTER SET utf8 NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cementerio`
--

CREATE TABLE `cementerio` (
  `id_fallecido` int(11) UNSIGNED NOT NULL,
  `id_usuario_fallecido` int(11) UNSIGNED NOT NULL,
  `id_enemigo_asesino` int(11) UNSIGNED NOT NULL,
  `id_usuario_asesino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combates`
--

CREATE TABLE `combates` (
  `id_combate` int(11) UNSIGNED NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_enemigo` int(11) UNSIGNED NOT NULL,
  `hp_enemigo` int(11) UNSIGNED NOT NULL,
  `max_hp_enemigo` int(11) UNSIGNED NOT NULL,
  `atk_enemigo` int(11) UNSIGNED NOT NULL,
  `def_enemigo` int(11) UNSIGNED NOT NULL,
  `tiempo` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` mediumint(8) UNSIGNED NOT NULL,
  `text_coment` varchar(20000) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(40) CHARACTER SET utf8 NOT NULL,
  `fecha` date NOT NULL,
  `id_noticia` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `nombre_web` varchar(50) NOT NULL DEFAULT 'Título',
  `url_web` varchar(1000) NOT NULL DEFAULT 'http://ejemplo.com',
  `descripcion_web` varchar(5000) NOT NULL DEFAULT 'Descripcion bla bla...',
  `mantenimiento` enum('0','1') NOT NULL DEFAULT '0',
  `intervalo_exp` int(11) UNSIGNED NOT NULL DEFAULT '200',
  `nivel_maximo` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `precio_cementerio` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `pts_atributos_lvl` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `num_top` int(11) UNSIGNED NOT NULL DEFAULT '10',
  `int_lvl` int(11) UNSIGNED NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`nombre_web`, `url_web`, `descripcion_web`, `mantenimiento`, `intervalo_exp`, `nivel_maximo`, `precio_cementerio`, `pts_atributos_lvl`, `num_top`, `int_lvl`) VALUES
('Title', 'http://example.com', 'Description Web...', '0', 300, 100, 500, 3, 10, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id_inv` int(11) UNSIGNED NOT NULL,
  `id_usuario_inv` int(11) UNSIGNED NOT NULL,
  `id_item_inv` int(11) UNSIGNED NOT NULL,
  `cantidad_art_inv` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_privados`
--

CREATE TABLE `mensajes_privados` (
  `id_mp` int(11) UNSIGNED NOT NULL,
  `id_autor_mp` int(10) UNSIGNED NOT NULL,
  `id_receptor_mp` int(10) UNSIGNED NOT NULL,
  `nombre_receptor` varchar(255) NOT NULL,
  `titulo_mp` varchar(255) NOT NULL,
  `texto_mp` varchar(10000) NOT NULL,
  `fecha_mp` datetime NOT NULL,
  `estado_mp` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mobs`
--

CREATE TABLE `mobs` (
  `id_mob` int(11) UNSIGNED NOT NULL,
  `nombre_mob` varchar(50) NOT NULL,
  `descripcion_mob` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `ataque_mob` int(11) UNSIGNED NOT NULL,
  `salud_mob` int(11) UNSIGNED NOT NULL,
  `max_salud_mob` int(11) UNSIGNED NOT NULL,
  `def_mob` int(11) UNSIGNED NOT NULL,
  `exp_mob` int(11) UNSIGNED NOT NULL,
  `reputacion_mob` int(11) UNSIGNED NOT NULL,
  `oro_mob` int(11) UNSIGNED NOT NULL,
  `frecuencia_mob` int(11) UNSIGNED NOT NULL,
  `img_mob` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_articulo` mediumint(8) UNSIGNED NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` mediumtext CHARACTER SET utf8 NOT NULL,
  `fecha` date NOT NULL,
  `autor` varchar(40) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones_amistad`
--

CREATE TABLE `peticiones_amistad` (
  `id_p_a` int(11) UNSIGNED NOT NULL,
  `id_autor_pa` int(11) UNSIGNED NOT NULL,
  `id_receptor_pa` int(11) UNSIGNED NOT NULL,
  `fecha_pa` datetime NOT NULL,
  `estado_pa` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

CREATE TABLE `sugerencias` (
  `id_sugerencia` mediumint(8) UNSIGNED NOT NULL,
  `text_sug` varchar(20000) NOT NULL,
  `autor` varchar(40) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `id_articulo` int(11) UNSIGNED NOT NULL,
  `nombre_articulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `precio_articulo` int(11) UNSIGNED NOT NULL,
  `descripcion_articulo` varchar(10000) CHARACTER SET utf8 NOT NULL,
  `img_articulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `accion_articulo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `cantidad_accion` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `usuario` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `passw` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `pass_reset` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `rango` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) CHARACTER SET utf8 NOT NULL,
  `ult_acceso` datetime NOT NULL,
  `online` enum('0','1') NOT NULL,
  `autoplay` enum('0','1') NOT NULL DEFAULT '1',
  `theme` varchar(255) NOT NULL DEFAULT 'lumen.css',
  `genero` enum('0','1','2') NOT NULL,
  `sobre_mi` varchar(300) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fecha_registro` datetime NOT NULL,
  `cumpleaños` date NOT NULL DEFAULT '2001-01-01',
  `estado` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `twitter` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `facebook` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `youtube` varchar(255) NOT NULL DEFAULT '',
  `muertes` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `bajas` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reputacion` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `pts_atributos` int(11) UNSIGNED NOT NULL DEFAULT '5',
  `insignia` int(11) NOT NULL DEFAULT '1',
  `oro` int(11) UNSIGNED NOT NULL DEFAULT '500',
  `nivel` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `exp` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `max_exp` int(11) UNSIGNED NOT NULL DEFAULT '300',
  `energia` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `max_energia` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `ataque` int(11) UNSIGNED NOT NULL DEFAULT '8',
  `max_ataque` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `defensa` int(11) UNSIGNED NOT NULL DEFAULT '6',
  `max_defensa` int(11) UNSIGNED NOT NULL DEFAULT '6',
  `salud` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `max_salud` int(11) UNSIGNED NOT NULL DEFAULT '100',
  `time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id_a`);

--
-- Indices de la tabla `arenas`
--
ALTER TABLE `arenas`
  ADD PRIMARY KEY (`id_arena`);

--
-- Indices de la tabla `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id_bug`);

--
-- Indices de la tabla `cementerio`
--
ALTER TABLE `cementerio`
  ADD PRIMARY KEY (`id_fallecido`);

--
-- Indices de la tabla `combates`
--
ALTER TABLE `combates`
  ADD PRIMARY KEY (`id_combate`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id_inv`);

--
-- Indices de la tabla `mensajes_privados`
--
ALTER TABLE `mensajes_privados`
  ADD PRIMARY KEY (`id_mp`);

--
-- Indices de la tabla `mobs`
--
ALTER TABLE `mobs`
  ADD PRIMARY KEY (`id_mob`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `peticiones_amistad`
--
ALTER TABLE `peticiones_amistad`
  ADD PRIMARY KEY (`id_p_a`);

--
-- Indices de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD PRIMARY KEY (`id_sugerencia`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id_a` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `arenas`
--
ALTER TABLE `arenas`
  MODIFY `id_arena` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id_bug` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cementerio`
--
ALTER TABLE `cementerio`
  MODIFY `id_fallecido` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `combates`
--
ALTER TABLE `combates`
  MODIFY `id_combate` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id_inv` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mensajes_privados`
--
ALTER TABLE `mensajes_privados`
  MODIFY `id_mp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mobs`
--
ALTER TABLE `mobs`
  MODIFY `id_mob` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_articulo` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `peticiones_amistad`
--
ALTER TABLE `peticiones_amistad`
  MODIFY `id_p_a` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  MODIFY `id_sugerencia` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id_articulo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
