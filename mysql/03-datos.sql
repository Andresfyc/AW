-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2021 a las 17:26:53
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `film_swap_2`
--

--
-- Volcado de datos para la tabla `actores_directores`
--

INSERT INTO `actores_directores` (`id`, `actor_director`, `name`, `description`, `birth_date`, `nationality`, `image`) VALUES
(1, 0, 'actor1', 'actor1 description', '2013-05-21', 'nationality1', NULL),
(2, 0, 'actor2', 'actor2 description', '2013-05-21', 'nationality2', NULL),
(3, 0, 'actor3', 'actor3 description', '2013-05-21', 'nationality3', NULL),
(4, 0, 'actor4', 'actor4 description', '2013-05-21', 'nationality4', NULL),
(5, 0, 'actor5', 'actor5 description', '2013-05-21', 'nationality5', NULL),
(6, 1, 'director1', 'director1 description', '2013-05-21', 'nationality1', NULL),
(7, 1, 'director2', 'director2 description', '2013-05-21', 'nationality2', NULL),
(8, 1, 'director3', 'director3 description', '2013-05-21', 'nationality3', NULL),
(9, 1, 'director4', 'director4 description', '2013-05-21', 'nationality4', NULL),
(10, 1, 'director5', 'director5 description', '2013-05-21', 'nationality5', NULL);

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id`, `user`, `friend`, `time_created`) VALUES
(11, 'user1', 'usuario', '2021-04-28 21:33:44'),
(13, 'user1', 'usuario2', '2021-04-28 21:34:06');

--
-- Volcado de datos para la tabla `foro_eventos_temas`
--

INSERT INTO `foro_eventos_temas` (`id`, `name`, `description`, `time`, `time_created`, `num_messages`) VALUES
(1, 'evento1', 'evento1 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 3),
(2, 'evento2', 'evento2 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 0),
(3, 'evento3', 'evento3 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 0),
(4, 'evento4', 'evento4 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 0),
(5, 'evento5', 'evento5 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 0),
(6, 'tema1', 'tema1 description', NULL, '2021-04-12 20:51:45', 0),
(7, 'tema2', 'tema2 description', NULL, '2021-04-12 20:51:45', 0),
(8, 'tema3', 'tema3 description', NULL, '2021-04-12 20:51:45', 0),
(9, 'tema4', 'tema4 description', NULL, '2021-04-12 20:51:45', 0),
(10, 'tema5', 'tema5 description', NULL, '2021-04-12 20:51:45', 0);

--
-- Volcado de datos para la tabla `foro_mensajes`
--

INSERT INTO `foro_mensajes` (`id`, `evento_tema`, `user`, `text`, `time_created`) VALUES
(1, 1, 'user1', 'text1', '2021-04-11 22:00:00'),
(2, 1, 'user1', 'text2', '2021-04-11 22:00:00');

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `title`, `image`, `date_released`, `duration`, `country`, `plot`, `rating`) VALUES
(1, 'peli1', 'peli-1.jpg', '2013-05-21', 120, 'country1', 'peli1 plot', '1.00'),
(2, 'Titanic', 'peli-2.jpg', '2013-05-21', 210, 'Estados Unidos', 'Jack (DiCaprio), un joven artista, gana en una partida de cartas un pasaje para viajar a América en el Titanic, el transatlántico más grande y seguro jamás construido. A bordo conoce a Rose (Kate Winslet), una joven de una buena familia venida a menos que va a contraer un matrimonio de conveniencia con Cal (Billy Zane), un millonario engreído a quien sólo interesa el prestigioso apellido de su prometida. Jack y Rose se enamoran, pero el prometido y la madre de ella ponen todo tipo de trabas a su relación. Mientras, el gigantesco y lujoso transatlántico se aproxima hacia un inmenso iceberg.(FILMAFFINITY)', '3.33'),
(3, 'Nosotros(Us)', 'peli-3.jpg', '2019-03-20', 121, 'Estados Unidos', 'Adelaide Wilson es una mujer que vuelve al hogar de su infancia en la costa junto a su marido, Gabe, y sus dos hijos, para una idílica escapada veraniega. Después de un tenso día en la playa con sus amigos, Adelaide y su familia vuelven a la casa donde están pasando las vacaciones. Cuando cae la noche, los Wilson descubren la silueta de cuatro figuras cogidas de la mano y en pie delante de la vivienda. \"Nosotros\" enfrenta a una entrañable familia estadounidense a un enemigo tan insólito como aterrador. (FILMAFFINITY)', '4.00'),
(6, 'Tyler Rake', 'TylerRake.jpg', '2020-04-24', 117, 'Estados Unidos', 'Tyler Rake (Hemsworth) es un mercenario que ofrece sus servicios en el mercado negro, y al que contratan para una peligrosa misión: rescatar al hijo secuestrado del príncipe jefe de la mafia india que se encuentra en prisión. Secuestrado por un capo de la mafia tailandesa, una misión que se preveía suicida se convierte en un desafío casi imposible que cambiará para siempre las vidas de Tyler y el chico. (FILMAFFINITY)', '0.00'),
(7, 'A ciegas', 'Aciegas.jpg', '2018-12-14', 124, 'Estados Unidos', 'Un lustro después de que una misteriosa presencia sobrenatural llevara al suicidio a una gran parte de la sociedad, una de las supervivientes, Malorie Hayes (Sandra Bullock), y sus dos hijos, buscan desesperadamente el modo de salvarse río abajo, en una pequeña barca, hacia un lugar seguro. (FILMAFFINITY)', '0.00'),
(8, 'Spenser:Confidencial', 'Spenser.jpg', '2020-03-06', 110, 'Estados Unidos', 'El exagente de policía Spenser (Mark Wahlberg) regresa a los bajos fondos de Boston cuando destapa la conspiración causante de un asesinato muy mediático. A pesar de las constantes amenazas, Spenser decide tomarse la justicia por su mano para demostrar que nadie está por encima de la ley.', '0.00'),
(9, '6 en la sombra', '6enlasombra.jpg', '2019-12-13', 128, 'Estados Unidos', 'Conoce a un nuevo tipo de héroe de acción. Seis agentes imposibles de rastrear, totalmente fuera de la red. Han enterrado su pasado para poder cambiar el futuro.', '0.00'),
(10, 'Criminales en el mar.', 'Criminalesenelmar.jpg', '2019-08-28', 97, 'Estados Unidos', 'Nick Spitz (Adam Sandler), un oficial de policía de Nueva York, finalmente lleva a su esposa Audrey (Jennifer Aniston) a un viaje por Europa largamente prometido. En el vuelo, se relacionan casualmente con un hombre misterioso (Luke Evans) que los invita a una reunión íntima en el yate de un anciano multimillonario. Cuando el hombre rico es asesinado, se convierten en los principales sospechosos. (FILMAFFINITY)', '0.00');

--
-- Volcado de datos para la tabla `peliculas_actores_directores`
--

INSERT INTO `peliculas_actores_directores` (`id`, `film_id`, `actor_director_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 6),
(5, 1, 7),
(6, 1, 8),
(7, 2, 4),
(8, 5, 9),
(9, 3, 10),
(10, 4, 5);

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user`, `film_id`, `review`, `stars`, `time_created`) VALUES
(1, 'user1', 1, 'review1', 1, '2021-04-12 21:36:13');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user`, `password`, `name`, `image`, `date_joined`, `watching`, `admin`, `content_manager`, `moderator`) VALUES
('prueb', '$2y$10$dA0PS/iNcrlua.37OmeATuZUSbjzyKNTbsm36u9VMTXDJpldPoaY2', 'prueba', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0),
('prueba14', '$2y$10$0JmiC7x6KE7BWsSzKsSfAu71YOiHe/yceSmH2MJRm/tgmxdKXoQWK', 'prueba14 name', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0),
('user1', '$2y$10$nkhPkXCRh7CURO0s2eQAkeHx5s3vSJiviDgbhi/FwqWzc3YZ37Ayy', 'user1 name', 'andresimage.jpg', '2021-04-12', 1, 0, 0, 0),
('usuario', '$2y$10$yAw3n1GYdGCRnCbOOkl.geXkst4m07Bmhhf5YGSfMKOyLxRNHqNCS', 'usuario user', 'user_logged.png', '2021-04-28', 2, 0, 0, 0),
('usuario2', '$2y$10$BiHz6rkbwoOfPcw4Pmg/zekJJBodBAdw22f2F8eBymX9WknIjuj4i', 'usuario2', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0);

--
-- Volcado de datos para la tabla `usuarios_actores_directores`
--

INSERT INTO `usuarios_actores_directores` (`id`, `user`, `actores_directores_id`) VALUES
(1, 'user1', 1),
(2, 'user1', 2),
(3, 'user1', 3),
(4, 'user1', 6),
(5, 'user1', 7),
(6, 'user1', 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
