<?php

require dir(__DIR__) . '/models/Database.php'


class CreateDatabase
{
	private static $query;


	public static function init() {

	}
}
/*
--
-- Database: `prometheus_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `hash` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `hash`) VALUES
(1, 'logiclogue', 'Jordan', 'Lord', '$2a$04$jsr.jrBgcwRoKUjsTU6lI.BRukCWW2ed6nJ.Q./SjrfvCe3s27I4O');

*/

?>