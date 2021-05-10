-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2021 a las 15:25:36
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.5

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
(11, 0, 'Leonardo Di Caprio', '', '1974-11-11', 'Estadounidense', 'leonardodicaprio.jpg'),
(12, 0, 'Adam Sandler', '', '1966-09-09', 'Estadounidense', 'adamsandler.jpg'),
(13, 0, 'Jeniffer Aniston', '', '1969-02-11', 'Estadounidense', 'jennifferaniston.jpg'),
(14, 0, 'Javier Gutiérrez', '', '1971-01-17', 'Española', 'javiergutierrez.jpg'),
(15, 0, 'Ryan Reynolds', '', '1976-10-23', 'Canadiense', 'ryanreynolds.jpg'),
(16, 0, 'Chris Hemsworth', '', '1983-08-11', 'Australiano', 'chrishemsworth.jpg'),
(17, 0, 'Karra Elejalde', '', '1960-10-10', 'Española', 'karraelejalde.jpg'),
(18, 1, 'Joe Russo', '', '1971-07-18', 'Estadounidense', 'joerusso.jpg'),
(19, 1, 'Anthony Russo', '', '1970-02-03', 'Estadounidense', 'anthonyrusso.jpg'),
(20, 1, 'Emilio Martínez-Lázaro', '', '1945-11-30', 'Española', 'emiliomartinezlazaro.jpg'),
(21, 1, 'Lluís Quílez', '', '1978-12-08', 'Española', 'lluisquilez.jpg'),
(22, 1, 'Denis Dugan', '', '1946-09-05', 'Estadounidense', 'denisdugan.jpg'),
(23, 1, 'Javier Fesser', '', '1964-02-15', 'Española', 'javierfesser.jpg'),
(24, 1, 'Tim Miller', '', '1964-10-10', 'Estadounidense', 'timmiller.jpg'),
(25, 1, 'Michael Bay', '', '1965-02-17', 'Estadounidense', 'michaelbay.jpg'),
(26, 1, 'Susanne Bier', '', '1960-04-15', 'Danesa', 'sussanebier.jpg'),
(27, 1, 'James Cameron', '', '1954-09-16', 'Canadiense', 'jamescameron.jpg'),
(28, 0, 'Kyle Newacheck', '', '1984-01-23', 'Estadounidense', 'kylenewacheck.jpg'),
(29, 0, 'Peter Berg', '', '1964-03-11', 'Estadounidense', 'peterberg.jpg'),
(30, 0, 'Martin Scorsese', '', '1942-11-17', 'Estadounidense', 'martinscorsese.jpg'),
(31, 0, 'Sam Hargrave', '', '1977-12-03', 'Estadounidense', 'samhargrave.jpg'),
(32, 0, 'Jordan Peele', '', '1979-02-21', 'Estadounidense', 'jordanpeele.jpg');

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
(1, 'evento1', 'evento1 description', '2007-12-31 23:00:01', '2021-04-12 20:50:28', 2),
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
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `name`) VALUES
(1, 'Thriller'),
(2, 'Comedia'),
(3, 'Terror'),
(4, 'Suspense'),
(5, 'Acción'),
(6, 'Ciencia ficción'),
(7, 'Drama'),
(8, 'Fantasía'),
(9, 'Melodrama'),
(10, 'Musical'),
(11, 'Romance'),
(12, 'Documental'),
(13, 'Histórico');

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `title`, `image`, `date_released`, `duration`, `country`, `plot`, `rating`) VALUES
(1, 'peli1', 'peli-1.jpg', '2013-05-21', 120, 'country1', 'peli1 plot', '5.00'),
(2, 'Titanic', 'peli-2.jpg', '2013-05-21', 210, 'Estados Unidos', 'Jack (DiCaprio), un joven artista, gana en una partida de cartas un pasaje para viajar a América en el Titanic, el transatlántico más grande y seguro jamás construido. A bordo conoce a Rose (Kate Winslet), una joven de una buena familia venida a menos que va a contraer un matrimonio de conveniencia con Cal (Billy Zane), un millonario engreído a quien sólo interesa el prestigioso apellido de su prometida. Jack y Rose se enamoran, pero el prometido y la madre de ella ponen todo tipo de trabas a su relación. Mientras, el gigantesco y lujoso transatlántico se aproxima hacia un inmenso iceberg.(FILMAFFINITY)', '3.33'),
(3, 'Nosotros(Us)', 'peli-3.jpg', '2019-03-20', 121, 'Estados Unidos', 'Adelaide Wilson es una mujer que vuelve al hogar de su infancia en la costa junto a su marido, Gabe, y sus dos hijos, para una idílica escapada veraniega. Después de un tenso día en la playa con sus amigos, Adelaide y su familia vuelven a la casa donde están pasando las vacaciones. Cuando cae la noche, los Wilson descubren la silueta de cuatro figuras cogidas de la mano y en pie delante de la vivienda. \"Nosotros\" enfrenta a una entrañable familia estadounidense a un enemigo tan insólito como aterrador. (FILMAFFINITY)', '4.00'),
(6, 'Tyler Rake', 'TylerRake.jpg', '2020-04-24', 117, 'Estados Unidos', 'Tyler Rake (Hemsworth) es un mercenario que ofrece sus servicios en el mercado negro, y al que contratan para una peligrosa misión: rescatar al hijo secuestrado del príncipe jefe de la mafia india que se encuentra en prisión. Secuestrado por un capo de la mafia tailandesa, una misión que se preveía suicida se convierte en un desafío casi imposible que cambiará para siempre las vidas de Tyler y el chico. (FILMAFFINITY)', '0.00'),
(7, 'A ciegas', 'Aciegas.jpg', '2018-12-14', 124, 'Estados Unidos', 'Un lustro después de que una misteriosa presencia sobrenatural llevara al suicidio a una gran parte de la sociedad, una de las supervivientes, Malorie Hayes (Sandra Bullock), y sus dos hijos, buscan desesperadamente el modo de salvarse río abajo, en una pequeña barca, hacia un lugar seguro. (FILMAFFINITY)', '0.00'),
(8, 'Spenser: Confidencial', 'Spenser.jpg', '2020-03-06', 110, 'Estados Unidos', 'El exagente de policía Spenser (Mark Wahlberg) regresa a los bajos fondos de Boston cuando destapa la conspiración causante de un asesinato muy mediático. A pesar de las constantes amenazas, Spenser decide tomarse la justicia por su mano para demostrar que nadie está por encima de la ley.', '0.00'),
(9, '6 en la sombra', '6enlasombra.jpg', '2019-12-13', 128, 'Estados Unidos', 'Conoce a un nuevo tipo de héroe de acción. Seis agentes imposibles de rastrear, totalmente fuera de la red. Han enterrado su pasado para poder cambiar el futuro.', '0.00'),
(10, 'Criminales en el mar.', 'Criminalesenelmar.jpg', '2019-08-28', 97, 'Estados Unidos', 'Nick Spitz (Adam Sandler), un oficial de policía de Nueva York, finalmente lleva a su esposa Audrey (Jennifer Aniston) a un viaje por Europa largamente prometido. En el vuelo, se relacionan casualmente con un hombre misterioso (Luke Evans) que los invita a una reunión íntima en el yate de un anciano multimillonario. Cuando el hombre rico es asesinado, se convierten en los principales sospechosos. (FILMAFFINITY)', '0.00'),
(11, 'Deadpool', 'deadpool.jpg', '2016-01-21', 106, 'Estados Unidos', 'Basado en el anti-héroe menos convencional de la Marvel, Deadpool narra el origen de un ex-operativo de la fuerzas especiales llamado Wade Wilson, reconvertido a mercenario, y que tras ser sometido a un cruel experimento adquiere poderes de curación rápida, adoptando Wade entonces el alter ego de Deadpool. Armado con sus nuevas habilidades y un oscuro y retorcido sentido del humor, Deadpool intentará dar caza al hombre que casi destruye su vida. (FILMAFFINITY)', '0.00'),
(12, 'El lobo de Wall Street', 'ellobodewallstreet.jpg', '2014-01-17', 179, 'Estados Unidos', 'Película basada en hechos reales del corredor de bolsa neoyorquino Jordan Belfort (Leonardo DiCaprio). A mediados de los años 80, Belfort era un joven honrado que perseguía el sueño americano, pero pronto en la agencia de valores aprendió que lo más importante no era hacer ganar a sus clientes, sino ser ambicioso y ganar una buena comisión. Su enorme éxito y fortuna le valió el mote de “El lobo de Wall Street”. Dinero. Poder. Mujeres. Drogas. Las tentaciones abundaban y el temor a la ley era irrelevante. Jordan y su manada de lobos consideraban que la discreción era una cualidad anticuada; nunca se conformaban con lo que tenían. (FILMAFFINITY)', '0.00'),
(13, 'Sígueme el rollo', 'siguemeelrollo.jpg', '2011-02-25', 116, 'Estados Unidos', 'Danny Maccabee (Adam Sandler) es un cirujano plástico que siempre finge estar casado para no comprometerse con ninguna mujer. Pero un día conoce a la despampanante Palmer (Brooklyn Decker), una joven con la que quiere algo más serio. El problema es que cuando Palmer descubre su anillo de casado, piensa que lo está, así que Danny decide contratar a su ayudante Katherine (Jennifer Aniston), una madre soltera con hijos, para que finjan ser su familia. Su intención es demostrarle a Palmer que su amor por ella es tan grande que está a punto de divorciarse de su mujer... Remake de \"Flor de cactus\" (Cactus Flower, 1969), interpretada entonces por Walter Matthau, Ingrid Bergman y Goldie Hawn. (FILMAFFINITY)', '0.00'),
(14, 'Vengadores: Endgame', 'endgame.jpg', '2019-04-26', 181, 'Estados Unidos', 'Después de los eventos devastadores de \'Avengers: Infinity War\', el universo está en ruinas debido a las acciones de Thanos, el Titán Loco. Con la ayuda de los aliados que quedaron, los Vengadores deberán reunirse una vez más para intentar deshacer sus acciones y restaurar el orden en el universo de una vez por todas, sin importar cuáles son las consecuencias... Cuarta y última entrega de la saga \"Vengadores\". (FILMAFFINITY)', '0.00'),
(15, 'Campeones', 'campeones.jpg', '2018-04-06', 124, 'España', 'Marco, un entrenador profesional de baloncesto, se encuentra un día, en medio de una crisis personal, entrenando a un equipo compuesto por personas con discapacidad intelectual. Lo que comienza como un problema se acaba convirtiendo en una lección de vida. (FILMAFFINITY)', '0.00'),
(16, 'Ocho apellidos vascos', 'ocho_apellidos_vascos.jpg', '2014-03-14', 98, 'España', 'Rafa (Dani Rovira) es un joven señorito andaluz que no ha tenido que salir jamás de su Sevilla natal para conseguir lo único que le importa en la vida: el fino, la gomina, el Betis y las mujeres. Todo cambia cuando conoce una mujer que se resiste a sus encantos: es Amaia (Clara Lago), una chica vasca. Decidido a conquistarla, se traslada a un pueblo de las Vascongadas, donde se hace pasar por vasco para vencer su resistencia. Adopta el nombre de Antxon y varios apellidos vascos: Arguiñano, Igartiburu, Erentxun, Gabilondo, Urdangarín, Otegi, Zubizarreta... y Clemente. (FILMAFFINITY)', '0.00'),
(17, 'Bajo cero', 'bajocero.jpg', '2021-01-29', 106, 'España', 'En una fría noche cerrada de invierno, en mitad de una carretera despoblada, un furgón policial blindado es asaltado durante un traslado de presos. Alguien busca a alguien de su interior. Martín, el policía conductor del furgón, consigue atrincherarse dentro del cubículo blindado con los reclusos. Obligado a entenderse con sus enemigos naturales, Martín tratará de sobrevivir y cumplir con su deber en una larga noche de pesadilla en el que se pondrán a prueba incluso sus principios. (FILMAFFINITY)', '0.00');

--
-- Volcado de datos para la tabla `peliculas_actores_directores`
--

INSERT INTO `peliculas_actores_directores` (`id`, `film_id`, `actor_director_id`) VALUES
(11, 9, 25),
(12, 9, 15),
(13, 7, 26),
(14, 17, 21),
(15, 17, 17),
(16, 17, 14),
(17, 15, 14),
(18, 15, 23),
(19, 10, 28),
(20, 10, 12),
(21, 10, 13),
(22, 11, 15),
(23, 11, 24),
(24, 12, 11),
(25, 12, 30),
(26, 3, 32),
(27, 16, 17),
(28, 16, 20),
(29, 8, 29),
(30, 13, 13),
(31, 13, 12),
(32, 13, 22),
(33, 2, 27),
(34, 2, 11),
(35, 6, 16),
(36, 6, 31),
(37, 14, 18),
(38, 14, 19),
(39, 14, 16);

--
-- Volcado de datos para la tabla `peliculas_generos`
--

INSERT INTO `peliculas_generos` (`id`, `film_id`, `genre_id`) VALUES
(1, 3, 3),
(2, 3, 1),
(3, 9, 2),
(4, 7, 3),
(5, 7, 1),
(6, 7, 8),
(7, 7, 7),
(8, 17, 1),
(10, 13, 11),
(11, 15, 2),
(12, 10, 2),
(13, 10, 5),
(14, 10, 7),
(15, 12, 2),
(16, 12, 7),
(17, 11, 2),
(18, 11, 5),
(19, 11, 8),
(20, 16, 2),
(21, 16, 11),
(22, 15, 7),
(23, 14, 6),
(24, 14, 8),
(25, 14, 5),
(26, 8, 5),
(27, 8, 2),
(28, 13, 2),
(30, 2, 11),
(31, 2, 7),
(32, 6, 5),
(33, 6, 1);

--
-- Volcado de datos para la tabla `peliculas_plataformas`
--

INSERT INTO `peliculas_plataformas` (`id`, `pelicula`, `plataforma`) VALUES
(35, 9, 1),
(36, 7, 1),
(37, 17, 1),
(38, 15, 2),
(39, 15, 3),
(40, 10, 1),
(41, 11, 2),
(42, 12, 1),
(43, 12, 3),
(44, 16, 1),
(45, 16, 3),
(46, 8, 1),
(47, 13, 1),
(48, 2, 2),
(49, 6, 1),
(50, 14, 2),
(51, 3, 4),
(52, 2, 5),
(53, 12, 5);

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`id`, `nombre`, `image`) VALUES
(1, 'Netflix', 'netflix.jpg'),
(2, 'Disney+', 'dinsey.jpg'),
(3, 'PrimeVideo', 'primevideo.jpg'),
(4, 'Youtube-movies', 'youtube.jpg'),
(5, 'HBO', 'hbo.jpg');

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user`, `film_id`, `review`, `stars`, `time_created`) VALUES
(1, 'user1', 1, 'review1', 5, '2021-04-12 21:36:13');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user`, `password`, `name`, `image`, `date_joined`, `watching`, `admin`, `content_manager`, `moderator`) VALUES
('prueb', '$2y$10$dA0PS/iNcrlua.37OmeATuZUSbjzyKNTbsm36u9VMTXDJpldPoaY2', 'prueba', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0),
('prueba14', '$2y$10$0JmiC7x6KE7BWsSzKsSfAu71YOiHe/yceSmH2MJRm/tgmxdKXoQWK', 'prueba14 name', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0),
('user1', '$2y$10$nkhPkXCRh7CURO0s2eQAkeHx5s3vSJiviDgbhi/FwqWzc3YZ37Ayy', 'user1 name1', 'andresimage.jpg', '2021-04-12', 1, 0, 1, 0),
('usuario', '$2y$10$yAw3n1GYdGCRnCbOOkl.geXkst4m07Bmhhf5YGSfMKOyLxRNHqNCS', 'usuario user', 'user_logged.png', '2021-04-28', 2, 0, 0, 0),
('usuario2', '$2y$10$BiHz6rkbwoOfPcw4Pmg/zekJJBodBAdw22f2F8eBymX9WknIjuj4i', 'usuario2', 'user_logged.png', '2021-04-28', NULL, 0, 0, 0);

--
-- Volcado de datos para la tabla `usuarios_peliculas_vistas`
--

INSERT INTO `usuarios_peliculas_vistas` (`id`, `user`, `film_id`, `rating`, `time_created`) VALUES
(1, 'usuario', 2, 0, '2021-05-09 02:25:10'),
(2, 'user1', 1, 5, '2021-05-09 02:25:55');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
