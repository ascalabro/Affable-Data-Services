
--
-- Database: `affable_listings`
--

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE IF NOT EXISTS `listing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_img` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  `price` decimal(6,2) DEFAULT NULL,
  `discount` decimal(4,2) DEFAULT NULL,
  `last_change_date` date DEFAULT NULL,
  `hit_count` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `listing_category`
--

CREATE TABLE IF NOT EXISTS `listing_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `listing_image`
--

CREATE TABLE IF NOT EXISTS `listing_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(256) NOT NULL,
  `listing_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `listing_id_fk_1` (`listing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `listing_subcategory`
--

CREATE TABLE IF NOT EXISTS `listing_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `parent_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cat2parent` (`parent_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `listing_subcategory`
--

INSERT INTO `listing_subcategory` (`id`, `name`, `slug`, `parent_category_id`) VALUES
(1, 'Laptops', 'laptops', 1),
(3, 'Desktops', 'desktops', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listing_image`
--
ALTER TABLE `listing_image`
  ADD CONSTRAINT `listing_id_fk_1` FOREIGN KEY (`listing_id`) REFERENCES `listing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `listing_subcategory`
--
ALTER TABLE `listing_subcategory`
  ADD CONSTRAINT `fk_cat2parent` FOREIGN KEY (`parent_category_id`) REFERENCES `listing_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
