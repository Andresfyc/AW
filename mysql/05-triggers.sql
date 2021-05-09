DELIMITER $$
CREATE TRIGGER `foro_mensajes_num_AFTER_DELETE` AFTER DELETE ON `foro_mensajes` FOR EACH ROW CALL updateNumMessagesForum(OLD.evento_tema)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `foro_mensajes_num_AFTER_INSERT` AFTER INSERT ON `foro_mensajes` FOR EACH ROW CALL updateNumMessagesForum(NEW.evento_tema)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `foro_mensajes_num_AFTER_UPDATE` AFTER UPDATE ON `foro_mensajes` FOR EACH ROW CALL updateNumMessagesForum(NEW.evento_tema)
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `film_reviewed_AFTER_DELETE` AFTER DELETE ON `reviews` FOR EACH ROW CALL deleteFilmWatched(OLD.film_id, OLD.user)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `film_reviewed_AFTER_INSERT` AFTER INSERT ON `reviews` FOR EACH ROW CALL insertFilmWatched(NEW.film_id, NEW.user, NEW.stars)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `film_reviewed_AFTER_UPDATE` AFTER UPDATE ON `reviews` FOR EACH ROW CALL updateFilmWatched(NEW.film_id, NEW.user, NEW.stars)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reviews_rate_AFTER_DELETE` AFTER DELETE ON `reviews` FOR EACH ROW CALL updateRating (OLD.film_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reviews_rate_AFTER_INSERT` AFTER INSERT ON `reviews` FOR EACH ROW CALL updateRating (NEW.film_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reviews_rate_AFTER_UPDATE` AFTER UPDATE ON `reviews` FOR EACH ROW CALL updateRating (NEW.film_id)
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `user_film_watched_AFTER_UPDATE` AFTER UPDATE ON `usuarios` FOR EACH ROW IF NEW.watching IS NOT NULL THEN
	CALL insertIgnoreFilmWatched(NEW.watching, NEW.user, 0);
END IF
$$
DELIMITER ;
