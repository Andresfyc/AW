CREATE USER 'film_swap'@'%' IDENTIFIED BY 'film_swap';
GRANT ALL PRIVILEGES ON `film_swap_2`.* TO 'film_swap'@'%';

CREATE USER 'film_swap'@'localhost' IDENTIFIED BY 'film_swap';
GRANT ALL PRIVILEGES ON `film_swap_2`.* TO 'film_swap'@'localhost';