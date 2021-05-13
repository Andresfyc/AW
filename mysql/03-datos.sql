-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2021 a las 14:36:53
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
(32, 0, 'Jordan Peele', '', '1979-02-21', 'Estadounidense', 'jordanpeele.jpg'),
(33, 0, 'PEPEPPE', 'evento1 descripción', '2021-05-19', 'Francesa', 'endgame.jpg'),
(34, 1, 'Lavavajillas', 'evento1 descripción', '2021-05-21', 'lala', 'endgame.jpg');

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id`, `user`, `friend`, `time_created`) VALUES
(14, 'userPrueba', 'Paco123', '2021-05-13 12:06:32'),
(15, 'userPrueba', 'Lolita', '2021-05-13 12:06:42'),
(16, 'userPrueba', 'María', '2021-05-13 12:06:52');

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
(9, 1, 'Lolita', 'Está guay este evento', '2021-05-13 12:16:39'),
(10, 1, 'Paco123', 'Buenas!!!', '2021-05-13 12:16:52'),
(12, 1, 'userPrueba', 'Vale, ya lo he entendido!', '2021-05-13 12:19:42');

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
(13, 'Histórico'),
(14, 'Pruebilla'),
(15, 'la');

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `title`, `image`, `date_released`, `duration`, `country`, `plot`, `rating`) VALUES
(2, 'Titanic', 'peli-2.jpg', '2013-05-21', 210, 'Estados Unidos', 'Jack (DiCaprio), un joven artista, gana en una partida de cartas un pasaje para viajar a América en el Titanic, el transatlántico más grande y seguro jamás construido. A bordo conoce a Rose (Kate Winslet), una joven de una buena familia venida a menos que va a contraer un matrimonio de conveniencia con Cal (Billy Zane), un millonario engreído a quien sólo interesa el prestigioso apellido de su prometida. Jack y Rose se enamoran, pero el prometido y la madre de ella ponen todo tipo de trabas a su relación. Mientras, el gigantesco y lujoso transatlántico se aproxima hacia un inmenso iceberg.(FILMAFFINITY)', '4.33'),
(3, 'Nosotros(Us)', 'peli-3.jpg', '2019-03-20', 121, 'Estados Unidos', 'Adelaide Wilson es una mujer que vuelve al hogar de su infancia en la costa junto a su marido, Gabe, y sus dos hijos, para una idílica escapada veraniega. Después de un tenso día en la playa con sus amigos, Adelaide y su familia vuelven a la casa donde están pasando las vacaciones. Cuando cae la noche, los Wilson descubren la silueta de cuatro figuras cogidas de la mano y en pie delante de la vivienda. \"Nosotros\" enfrenta a una entrañable familia estadounidense a un enemigo tan insólito como aterrador. (FILMAFFINITY)', '0.00'),
(6, 'Tyler Rake', 'TylerRake.jpg', '2020-04-24', 117, 'Estados Unidos', 'Tyler Rake (Hemsworth) es un mercenario que ofrece sus servicios en el mercado negro, y al que contratan para una peligrosa misión: rescatar al hijo secuestrado del príncipe jefe de la mafia india que se encuentra en prisión. Secuestrado por un capo de la mafia tailandesa, una misión que se preveía suicida se convierte en un desafío casi imposible que cambiará para siempre las vidas de Tyler y el chico. (FILMAFFINITY)', '0.00'),
(7, 'A ciegas', 'Aciegas.jpg', '2018-12-14', 124, 'Estados Unidos', 'Un lustro después de que una misteriosa presencia sobrenatural llevara al suicidio a una gran parte de la sociedad, una de las supervivientes, Malorie Hayes (Sandra Bullock), y sus dos hijos, buscan desesperadamente el modo de salvarse río abajo, en una pequeña barca, hacia un lugar seguro. (FILMAFFINITY)', '0.00'),
(8, 'Spenser: Confidencial', 'Spenser.jpg', '2020-03-06', 110, 'Estados Unidos', 'El exagente de policía Spenser (Mark Wahlberg) regresa a los bajos fondos de Boston cuando destapa la conspiración causante de un asesinato muy mediático. A pesar de las constantes amenazas, Spenser decide tomarse la justicia por su mano para demostrar que nadie está por encima de la ley.', '0.00'),
(10, 'Criminales en el mar2', 'Criminalesenelmar.jpg', '2019-08-28', 97, 'Estados Unidos', 'Nick Spitz (Adam Sandler), un oficial de policía de Nueva York, finalmente lleva a su esposa Audrey (Jennifer Aniston) a un viaje por Europa largamente prometido. En el vuelo, se relacionan casualmente con un hombre misterioso (Luke Evans) que los invita a una reunión íntima en el yate de un anciano multimillonario. Cuando el hombre rico es asesinado, se convierten en los principales sospechosos. (FILMAFFINITY)', '0.00'),
(11, 'Deadpool', 'deadpool.jpg', '2016-01-21', 106, 'Estados Unidos', 'Basado en el anti-héroe menos convencional de la Marvel, Deadpool narra el origen de un ex-operativo de la fuerzas especiales llamado Wade Wilson, reconvertido a mercenario, y que tras ser sometido a un cruel experimento adquiere poderes de curación rápida, adoptando Wade entonces el alter ego de Deadpool. Armado con sus nuevas habilidades y un oscuro y retorcido sentido del humor, Deadpool intentará dar caza al hombre que casi destruye su vida. (FILMAFFINITY)', '0.00'),
(12, 'El lobo de Wall Street', 'ellobodewallstreet.jpg', '2014-01-17', 179, 'Estados Unidos', 'Película basada en hechos reales del corredor de bolsa neoyorquino Jordan Belfort (Leonardo DiCaprio). A mediados de los años 80, Belfort era un joven honrado que perseguía el sueño americano, pero pronto en la agencia de valores aprendió que lo más importante no era hacer ganar a sus clientes, sino ser ambicioso y ganar una buena comisión. Su enorme éxito y fortuna le valió el mote de “El lobo de Wall Street”. Dinero. Poder. Mujeres. Drogas. Las tentaciones abundaban y el temor a la ley era irrelevante. Jordan y su manada de lobos consideraban que la discreción era una cualidad anticuada; nunca se conformaban con lo que tenían. (FILMAFFINITY)', '0.00'),
(13, 'Sígueme el rollo', 'siguemeelrollo.jpg', '2011-02-25', 116, 'Estados Unidos', 'Danny Maccabee (Adam Sandler) es un cirujano plástico que siempre finge estar casado para no comprometerse con ninguna mujer. Pero un día conoce a la despampanante Palmer (Brooklyn Decker), una joven con la que quiere algo más serio. El problema es que cuando Palmer descubre su anillo de casado, piensa que lo está, así que Danny decide contratar a su ayudante Katherine (Jennifer Aniston), una madre soltera con hijos, para que finjan ser su familia. Su intención es demostrarle a Palmer que su amor por ella es tan grande que está a punto de divorciarse de su mujer... Remake de \"Flor de cactus\" (Cactus Flower, 1969), interpretada entonces por Walter Matthau, Ingrid Bergman y Goldie Hawn. (FILMAFFINITY)', '0.00'),
(14, 'Vengadores: Endgame', 'endgame.jpg', '2019-04-26', 181, 'Estados Unidos', 'Después de los eventos devastadores de \'Avengers: Infinity War\', el universo está en ruinas debido a las acciones de Thanos, el Titán Loco. Con la ayuda de los aliados que quedaron, los Vengadores deberán reunirse una vez más para intentar deshacer sus acciones y restaurar el orden en el universo de una vez por todas, sin importar cuáles son las consecuencias... Cuarta y última entrega de la saga \"Vengadores\". (FILMAFFINITY)', '0.00'),
(15, 'Campeones', 'campeones.jpg', '2018-04-06', 124, 'España', 'Marco, un entrenador profesional de baloncesto, se encuentra un día, en medio de una crisis personal, entrenando a un equipo compuesto por personas con discapacidad intelectual. Lo que comienza como un problema se acaba convirtiendo en una lección de vida. (FILMAFFINITY)', '0.00'),
(16, 'Ocho apellidos vascos', 'ocho_apellidos_vascos.jpg', '2014-03-14', 98, 'España', 'Rafa (Dani Rovira) es un joven señorito andaluz que no ha tenido que salir jamás de su Sevilla natal para conseguir lo único que le importa en la vida: el fino, la gomina, el Betis y las mujeres. Todo cambia cuando conoce una mujer que se resiste a sus encantos: es Amaia (Clara Lago), una chica vasca. Decidido a conquistarla, se traslada a un pueblo de las Vascongadas, donde se hace pasar por vasco para vencer su resistencia. Adopta el nombre de Antxon y varios apellidos vascos: Arguiñano, Igartiburu, Erentxun, Gabilondo, Urdangarín, Otegi, Zubizarreta... y Clemente. (FILMAFFINITY)', '0.00');

--
-- Volcado de datos para la tabla `peliculas_actores_directores`
--

INSERT INTO `peliculas_actores_directores` (`id`, `film_id`, `actor_director_id`) VALUES
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
(39, 14, 16),
(47, 7, 26),
(48, 15, 14),
(49, 15, 23),
(59, 10, 12),
(60, 10, 16),
(61, 10, 13),
(62, 10, 28),
(63, 10, 19);

--
-- Volcado de datos para la tabla `peliculas_generos`
--

INSERT INTO `peliculas_generos` (`id`, `film_id`, `genre_id`) VALUES
(1, 3, 3),
(2, 3, 1),
(10, 13, 11),
(15, 12, 2),
(16, 12, 7),
(17, 11, 2),
(18, 11, 5),
(19, 11, 8),
(20, 16, 2),
(21, 16, 11),
(23, 14, 6),
(24, 14, 8),
(25, 14, 5),
(26, 8, 5),
(27, 8, 2),
(28, 13, 2),
(30, 2, 11),
(31, 2, 7),
(32, 6, 5),
(33, 6, 1),
(46, 7, 7),
(47, 7, 8),
(48, 7, 3),
(49, 7, 1),
(50, 15, 2),
(51, 15, 7),
(62, 10, 5),
(63, 10, 2),
(64, 10, 7);

--
-- Volcado de datos para la tabla `peliculas_plataformas`
--

INSERT INTO `peliculas_plataformas` (`id`, `film_id`, `platform_id`, `link`) VALUES
(36, 7, 1, 'https://www.netflix.com/es/'),
(38, 15, 2, 'https://www.disneyplus.com/en-es'),
(39, 15, 3, 'https://www.primevideo.com/'),
(40, 10, 1, 'https://www.netflix.com/es/'),
(41, 11, 2, 'https://www.disneyplus.com/en-es'),
(42, 12, 1, 'https://www.netflix.com/es/'),
(43, 12, 3, 'https://www.primevideo.com/'),
(44, 16, 1, 'https://www.netflix.com/es/'),
(45, 16, 3, 'https://www.primevideo.com/'),
(46, 8, 1, 'https://www.netflix.com/es/'),
(47, 13, 1, 'https://www.netflix.com/es/'),
(48, 2, 2, 'https://www.disneyplus.com/en-es'),
(49, 6, 1, 'https://www.netflix.com/es/'),
(50, 14, 2, 'https://www.disneyplus.com/en-es'),
(51, 3, 4, 'https://www.youtube.com/movies'),
(52, 2, 5, 'https://es.hboespana.com/'),
(53, 12, 5, 'https://es.hboespana.com/');

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`id`, `name`, `image`) VALUES
(1, 'Netflix', 'netflix.jpg'),
(2, 'Disney+', 'dinsey.jpg'),
(3, 'PrimeVideo', 'primevideo.jpg'),
(4, 'Youtube-movies', 'youtube.jpg'),
(5, 'HBO', 'hbo.jpg');

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user`, `film_id`, `review`, `stars`, `time_created`) VALUES
(6, 'userPrueba', 2, 'You can watch this movie in 1997, you can watch it again in 2004 or 2009 or you can watch it in 2015 or 2020, and this movie will get you EVERY TIME. Titanic has made itself FOREVER a timeless classic! I just saw it today (2015) and I was crying my eyeballs out JUST like the first time I saw it back in 1998. This is a movie that is SO touching, SO precise in the making of the boat, the acting and the storyline is BRILLIANT! And the preciseness of the ship makes it even more outstanding!\r\n\r\nKate Winslet and Leonardo Dicaprio definitely created a timeless classic that can be watched time and time again and will never get old. This movie will always continue to be a beautiful, painful & tragic movie. 10/10 stars for this masterpiece!', 5, '2021-05-13 12:10:22'),
(7, 'Lolita', 2, 'There is no movie which made a bigger emotional impact on me than Titanic. And even in 2020, 23 years later, it has lost none of its magic.', 4, '2021-05-13 12:10:44'),
(8, 'Paco123', 2, 'People are crazy. They rate Avengers so high and they rate this masterpiece low? This is beyond absurd. You guys should encourage great filmmakers like this one not stupid ones like the super hero franchises. For the love of god.', 4, '2021-05-13 12:11:07');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user`, `password`, `name`, `image`, `date_joined`, `watching`, `admin`, `content_manager`, `moderator`) VALUES
('Lolita', '$2y$10$l4MxYoqJlwKKBSF.Ef4/K.UCjmXMBB6Kz2Dj7NtSOuhUW1wGNtAha', 'Lolita Davis', 'user_logged.png', '2021-05-13', NULL, 0, 0, 0),
('María', '$2y$10$s6EphqO5qS5Lrda0EXwnPuNjjlSIIk3DOgYW5QDJXvPtRw1C2FAlm', 'María Sánchez', 'user_logged.png', '2021-05-13', 2, 0, 0, 0),
('Paco123', '$2y$10$9B3hkr7QvzjoHSyKEaH1D.vO7TJPa2jX7WTnGDofBNNxOnyZEG6Bm', 'Paco López', 'user_logged.png', '2021-05-13', NULL, 0, 0, 0),
('userAdmin', '$2y$10$4XWfC7h2/m74aIi.iPdMFeciNcat0sGQxa7o2ZFQ2uCHpavX67r2O', 'userAdmin', 'user_logged.png', '2021-05-13', NULL, 1, 0, 0),
('userGestor', '$2y$10$DUtfatkTvdvWXLbnZmV7Eux7OvDUp7c/Xhyy7tAjMhtp8qZPw0OTy', 'userGestor', 'user_logged.png', '2021-05-13', NULL, 0, 1, 0),
('userModerador', '$2y$10$OZttXem0XvM006BJ/gzeDOcIS7URd1GIZyj.G5njaOkeiHoxcj8Oi', 'userModerador', 'user_logged.png', '2021-05-13', NULL, 0, 0, 1),
('userPrueba', '$2y$10$chV7iF0WazYj.hrPr0opaud2F8AzbTFF52.IHAwO3pk/yyvNuINaK', 'Nombre de Usuario', 'andresimage.jpg', '2021-05-13', NULL, 0, 0, 0);

--
-- Volcado de datos para la tabla `usuarios_actores_directores`
--

INSERT INTO `usuarios_actores_directores` (`id`, `user`, `actores_directores_id`) VALUES
(4, 'userPrueba', 12),
(5, 'userPrueba', 25),
(6, 'userPrueba', 16);

--
-- Volcado de datos para la tabla `usuarios_peliculas_vistas`
--

INSERT INTO `usuarios_peliculas_vistas` (`id`, `user`, `film_id`, `rating`, `time_created`) VALUES
(8, 'María', 2, 0, '2021-05-13 12:07:09'),
(9, 'userPrueba', 2, 5, '2021-05-13 12:10:22'),
(10, 'Lolita', 2, 4, '2021-05-13 12:10:44'),
(11, 'Paco123', 2, 4, '2021-05-13 12:11:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
