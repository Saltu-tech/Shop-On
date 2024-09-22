

--
-- Database: `shopon2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `mobile`, `email`, `password`) VALUES
(1, 'Saltu Kumar', 7301030400, 'saltu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `attrib_list`
--

CREATE TABLE IF NOT EXISTS `attrib_list` (
  `attrib_id` int(11) NOT NULL,
  `attrib_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attrib_list`
--

INSERT INTO `attrib_list` (`attrib_id`, `attrib_name`) VALUES
(1, 'length'),
(2, 'colour'),
(3, 'size'),
(4, 'Language'),
(5, 'publisher'),
(6, 'Published date'),
(7, 'weight'),
(8, 'Author'),
(9, 'Material'),
(10, 'brand'),
(11, 'Flavour'),
(12, 'Age Range'),
(13, 'Scent'),
(14, 'Item form'),
(15, 'volume');

-- --------------------------------------------------------

--
-- Table structure for table `attrib_val_list`
--

CREATE TABLE IF NOT EXISTS `attrib_val_list` (
  `attrib_val_id` int(11) NOT NULL,
  `attrib_id` int(11) NOT NULL,
  `attrib_val` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attrib_val_list`
--

INSERT INTO `attrib_val_list` (`attrib_val_id`, `attrib_id`, `attrib_val`) VALUES
(1, 2, 'blue'),
(2, 2, 'red'),
(3, 4, 'English'),
(4, 5, 'Rupa publication'),
(5, 6, '1 may 2004'),
(6, 7, '295 g'),
(7, 8, 'Chetan Bhagat'),
(8, 8, 'Khuswant singh'),
(9, 6, '2 february 2016'),
(10, 5, 'Penguin'),
(11, 7, '130 g'),
(12, 8, 'RD Sharma'),
(13, 6, '1 jan 2021'),
(14, 5, 'Dhanpat Rai Publication'),
(15, 7, '1.490 Kg'),
(16, 6, '13 Aug 2014'),
(17, 8, 'APJ Abdul Kalam, YS Rajan'),
(18, 7, '280 g'),
(19, 2, 'Indigo blue'),
(20, 3, '30'),
(21, 9, 'Denim'),
(22, 7, '600 g'),
(23, 3, 'XL'),
(24, 3, 'M'),
(25, 3, '6 UK'),
(26, 2, 'brown'),
(27, 3, '8'),
(28, 2, 'black and navy'),
(29, 9, 'Popular willow'),
(30, 10, 'steller'),
(31, 10, 'Nivia'),
(32, 2, 'Yellow'),
(33, 9, 'rubber'),
(34, 7, '1 Kg'),
(35, 10, 'Colgate'),
(36, 11, 'Mint'),
(37, 12, 'Adult'),
(38, 13, 'Rosemary'),
(39, 10, 'Navratna'),
(40, 14, 'Hair oil'),
(41, 15, '500 ml'),
(42, 10, 'Aashirvaad'),
(43, 7, '5 Kg'),
(44, 1, '90 Centimeter'),
(45, 9, 'Fiberglass');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Stationary'),
(2, 'Sports'),
(3, 'cloth'),
(4, 'Book'),
(5, 'Footwear');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` mediumint(9) NOT NULL,
  `prod_desc` varchar(2000) DEFAULT NULL,
  `keyword` varchar(800) DEFAULT NULL,
  `mfrs` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_price`, `prod_desc`, `keyword`, `mfrs`, `type`) VALUES
(1, 'Flair Writo Meter', 20, 'Blue pen', 'Writo meter blue pen ball point pen longest writing pen', 1, 1),
(2, 'Hair cutting ', 40, 'Hair Cutting Normal', 'hair cut, bal kat', NULL, 0),
(3, 'Plumber', 200, 'Plumbing pipe fitting works e.t.c, plumber', 'plumber ', NULL, 0),
(4, 'Natraj Pencil', 5, NULL, 'Natraj Pencil', NULL, 1),
(5, 'facial', 200, 'complete facial', 'facial', NULL, 0),
(6, 'Threading', 50, 'Complete threading package', 'threading', NULL, 0),
(7, 'Bleach', 200, 'bleaching of complete face.', 'bleaching', NULL, 0),
(8, 'hair coloring', 100, 'colouring of hair', 'colour hair', NULL, 0),
(9, 'Camlin Kokuyo Geometry Box', 90, 'geometry box with all geometry instrument', 'geometry box', NULL, 1),
(10, 'Five point someone', 95, 'Set in IIT, in the early 90''s, Five Point Someone portrays the lives of the protagonist Hari and his two friends Ryan and Alok. It explores the darker side of IIT, one in which students having worked for years to make it into the institute - struggle to maintain their grades, keep their friends and ', 'five point someone, chetan bhagat', NULL, 1),
(11, 'Train to Pakistan', 197, 'The partition of India was one of the most dreadful times in the recent Indian history. Since 1950s, it has time and again been depicted in various media. However, while most of those focussed mainly on the socio-political causes and effects, the Train to Pakistan is a novel which has captured the e', 'train to pakistan, khuswant singh', NULL, 1),
(12, 'RD Sharma Class X Math Book', 452, 'This textbook of Mathematics will be of great help for those students who will be appearing for their Class 10 Examinations. Difficult sums have been explained in the simplest way so that students can grasp the same easily. The revised edition is based on the guidelines provided by the Central Board', 'RD Sharma Class X Math Book', NULL, 1),
(13, 'India 2020 : A Vision For New Millenium', 268, 'In this ground-breaking vision document, first published in 1998, Dr A.P.J. Abdul Kalam and Y.S. Rajan offer a blueprint for India to be counted among the world''s top five economic powers by the year 2020. They cite growth rates and development trends to show that the goal is not unrealistic. Past s', 'India 2020, APJ Abdul Kalam', NULL, 1),
(14, 'Electrician', 500, 'Electrical Service', 'Electrical fitting, wiring e.t.c', NULL, 0),
(15, 'Rajmistri', 600, 'Rajmistri for any kind of construction activity', 'Rajmistri, ', NULL, 0),
(16, 'Wrangler Men''s Skinny fit Jeans', 1222, NULL, 'Mens Jeans blue jeans', NULL, 1),
(17, 'United Colors of Benetton Men''s Slim Shirt', 1549, 'Full Sleeve WATERCOLOR STRIPE LINEN SHIRT', 'Shirt men shirt', NULL, 1),
(18, 'Puma Men''s Regular T-Shirt', 531, NULL, 'Tshirt, Mens tshirt', NULL, 1),
(19, 'Flosive Bandhani Mysore Silk Saree With Blouse Piece(FL- silk Maroon bandhani)', 444, NULL, 'saree women saree', NULL, 1),
(20, 'Campus Men''s Jasper Running Shoes', 1079, NULL, 'sport shoe, campus shoe,', NULL, 1),
(21, 'Centrino Men''s 9383 Formal Shoes', 549, 'Centrino is a value footwear brand for men. Our range consists of basic and updated basic products across both formal and casual footwear. We offer the right blend of quality, style and value aimed to delight our customers.', 'Formal shoe for interview or official work', NULL, 1),
(22, 'Sparx Men''s Navy Blue Casual Shoes ', 499, NULL, 'Casual Shoe', NULL, 1),
(23, 'Sparx Men''s Black and Navy Flip-Flops and House Slipper', 328, NULL, 'slipper chappal', NULL, 1),
(24, 'Cricket bat and ball', 479, 'Tennis Ball Cricket Bat Handcrafted using reinforced wood for long-term strength, this is the perfect bat for home or club play. It features an excellent handle, reinforced with firmly wound string and a rubber sleeve for increased durability, and is made for use with tennis balls only. Great for beginners, this bat will give those just starting to play the game a good feel and performance level. Weighs Only 1100 g. Each full size bat is lightweight at only 1100-1150 g, allowing you to hit the ball with both speed and power. The right weight, you will be able to time the ball better and ultimately make more runs. Superb Pick-up. Each Cricket Bat gives a precise design and shape for the best performance. This unique shape gives superb pick-up, making the bat feel lighter than it actually is and making it easy to control when swinging and hitting the ball. Easy Grip. Outfitted with a rubber sleeve for extra comfort, the Cricket Bat is easy to grip and hold for lengthy periods of time. ', 'Cricket bat and ball', NULL, 1),
(25, 'BAS Vampire Brig Fiber Glass Hockey Stick with Leather Grip Junior Size', 300, 'Leather Grip - Junior Size - Righty Edge Hockey Stick for Practice Level Made up with Reinforcement:- Glass Fiber Size :- 33 Inch , Suitable for Juniors Boy & Girls Weight Vary 450 - 475Gms Depending their availability', 'hocket stick sport', NULL, 1),
(26, 'Nivia Rotator Moulded Rubber Volleyball, Adult Size 4', 376, 'Volley ball', 'volley ball', NULL, 1),
(27, 'APPS Sports Football ', 199, 'Included Components : 1 Football | Color : White/Black Suitable For: All Conditions | Ideal For: Training/Match. The football offers amazing grip which translates into a playing great experience. Hard Ground without Grass, Wet & Grassy Ground, Artificail Turf. Best Football Sport Toys The Ultimate S', 'football', NULL, 1),
(28, 'Aashirvaad Select Premium Sharbati Atta, 5kg', 300, 'Aashirvaad Select is made with 100% MP Sharbati wheat which is harvested from the Sehore region of Madhya Pradesh', 'Aashirvad atta flour', NULL, 1),
(29, 'Navratna Ayurvedic cool hair oil with 9 herbal ingredients, 500ml', 256, 'An ayurvedic oil made from a unique blend of nine ayurvedic herbs delivers superlatively desired benefits of relaxation and rejuvenation', 'navratna oil thanda thanda cool cool', NULL, 1),
(30, 'Colgate Active Salt Toothpaste  (600 g, Pack of 2)', 214, 'Colgate Active Salt is an anti-cavity toothpaste with the goodness of salt and minerals which help fight germs. Refreshing minty flavour gives fresher breath when used as directed for oral hygiene.  Colgate Active Saltâ€™s unique formula helps fight germs and provide you with healthier and cleaner teeth. Brush twice a day with Colgate Active Salt toothpaste as recommended by dentists.  Colgate is Indiaâ€™s No. 1 brand recommended by Dentists and offers unique oral hygiene solutions to ensure complete protection against germs and plague build-up.', 'coalgate toothpaste', NULL, 1),
(31, 'Tide Plus Detergent Washing Powder with double Power Lemon and Mint Pack - 1 kg', 90, 'New Tide plus with extra power detergent, now with the added Power of Bar, has been developed to bring you brilliant whiteness on your clothes. It removes dirt even from washed clothes to give you even better cleaning. The enzyme formula in the washing powder helps in washing away the toughest stains on the clothes, thus making them look bright and fresh. Kids often soil their clothes, especially school uniforms, with tough-to-remove stains and dirt. Tide plus with extra power is a fine detergent powder which dissolves easily in water and quickly generates foam. The superior formulation can remove dirt even from difficult-to-clean areas like collars and cuffs, and leaves behind a wonderful fragrance. The product works on both white and coloured clothes. extra power refers to vs previous Tide Plus. Tide, a unit of Procter and Gamble, is the Worldâ€™s Oldest and Most Trusted Detergent brand and is the Market Leader in 23 Countries around the world.', 'tide detergent', NULL, 1),
(32, 'Beard shaving', 50, 'beard shaving', 'beard shaving', NULL, 0),
(33, 'Car On Rent', 800, 'Swift Dezire', 'swift dezire on rent', NULL, 0),
(34, 'Auto on rent', 500, 'auto on rent for day', 'auto on rent', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prod_attrib`
--

CREATE TABLE IF NOT EXISTS `prod_attrib` (
  `prod_attrib_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `attrib_val_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_attrib`
--

INSERT INTO `prod_attrib` (`prod_attrib_id`, `prod_id`, `attrib_val_id`) VALUES
(41, 1, 1),
(5, 10, 3),
(6, 10, 4),
(7, 10, 5),
(8, 10, 6),
(9, 10, 7),
(11, 11, 3),
(10, 11, 8),
(13, 11, 9),
(12, 11, 10),
(14, 11, 11),
(17, 12, 3),
(15, 12, 12),
(18, 12, 13),
(19, 12, 14),
(16, 12, 15),
(20, 13, 3),
(21, 13, 10),
(22, 13, 16),
(23, 13, 17),
(24, 13, 18),
(26, 16, 19),
(25, 16, 20),
(27, 16, 22),
(28, 17, 23),
(30, 18, 1),
(29, 18, 24),
(31, 20, 25),
(32, 21, 25),
(33, 21, 26),
(34, 22, 27),
(35, 23, 27),
(36, 23, 28),
(38, 24, 29),
(37, 24, 30),
(59, 25, 44),
(60, 25, 45),
(57, 26, 31),
(43, 26, 32),
(40, 26, 33),
(58, 26, 37),
(56, 28, 42),
(55, 28, 43),
(51, 29, 38),
(52, 29, 39),
(53, 29, 40),
(54, 29, 41),
(50, 30, 22),
(48, 30, 35),
(47, 30, 36),
(49, 30, 37),
(46, 31, 34),
(45, 34, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prod_feat`
--

CREATE TABLE IF NOT EXISTS `prod_feat` (
  `feat_id` int(9) NOT NULL,
  `prod_id` int(9) NOT NULL,
  `feature` varchar(600) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_feat`
--

INSERT INTO `prod_feat` (`feat_id`, `prod_id`, `feature`) VALUES
(2, 34, 'Online Payment accepted'),
(3, 32, 'Trimming facility by trimmer available.'),
(4, 31, 'Removes dirt from even washed clothes to give you brilliant whiteness'),
(5, 31, 'Has built in "power of bar"'),
(6, 31, 'Gives you brighter whiteness in only half the dosage vs that of ordinary detergents'),
(7, 31, 'Easily dissolves in water and quickly generates foam to give you brilliant whiteness'),
(8, 30, 'Anti-cavity toothpaste with goodness of salt for healthy gums and teeth'),
(9, 30, 'Refreshing minty flavour gives fresher breathe, when used as per directions'),
(10, 30, 'Colgate Active Saltâ€™s unique formula helps fight hidden germs'),
(11, 30, 'Always 100% Vegetarian'),
(12, 29, 'An ayurvedic oil made from a unique blend of nine ayurvedic herbs delivers superlatively desired benefits of relaxation and rejuvenation'),
(13, 29, 'Contains the goodness of Sesame oil, Japa, Bringhraj, Bharmi, Amla, Thyme and Rosemary Oil.'),
(14, 29, 'Helps to relieve headache, fatigue, tension and sleeplessness'),
(15, 29, 'Gives relief from specific hair and body related ailments'),
(16, 29, 'Ideal for everyday relaxing head massages. Sulfate Free : Yes'),
(17, 28, 'Aashirvaad Select is made with 100% MP Sharbati wheat which is harvested from the Sehore region of Madhya Pradesh'),
(18, 28, 'Aashirvaad Select is a premium quality atta made from the King of Wheat â€“ Sharbati wheat which is bigger in size and has a golden sheen'),
(19, 28, 'Rotis made with Aashirvaad Select Sharbati atta are sweet in taste and softer in texture'),
(20, 28, 'This premium quality wheat flour has been made with Aashirvaadâ€™s process to lock in nutrition which ensures that you and your family receive the taste as well as nutrition'),
(21, 26, 'Butyl bladder ensures shape retention and longevity while providing optimal performance, durability and air retention'),
(22, 26, 'Molded, composite rubber cover withstands high-speed serves.'),
(23, 26, 'Material: Rubber and Construction: Rubberized Molded.'),
(24, 25, 'Leather Grip - Junior Size - Righty'),
(25, 25, 'Edge Hockey Stick for Practice Level'),
(26, 25, 'Made up with Reinforcement:- Glass Fiber'),
(27, 25, 'Size :- 33 Inch , Suitable for Juniors Boy & Girls'),
(28, 25, 'Weight Vary 450 - 475Gms Depending their availability'),
(29, 24, 'POPULAR WILLOW CRICKET BAT MEANT FOR PLAYING BY ONLY 13+ Years BOYS and GIRLS. Used to hit a Tennis ball, this cricket bat is expertly crafted using Popular willow to provide long-lasting performance on the pitch.'),
(30, 24, 'LIGHTWEIGHT DESIGN and Full Size. Weighing in at only 1100 gm, this Cricket Bat is lightweight yet durable. The bat come in a full adult size, making it perfect for club usage or individual practice.'),
(31, 23, 'MADE OF: High Quality Fabric as upper material and EVA as sole material.'),
(32, 23, 'KEY FEATURES: Made to Last Long, Elegant Packaging, Perfect Gifting Option, Zero compromise on quality'),
(33, 23, 'CARE INSTRUCTIONS: Soaking in water may damage the product. For cleaning just wipe dirt or mud off with a soft moist cloth. Do not use any hard bristles brush for cleaning. Do not bleach or use harsh cleaning agents. Do not machine wash or machine dry. Just dry in shade. Do not use any heating equip'),
(34, 22, 'Closure: slip on'),
(35, 22, 'Shoe Width: Medium'),
(36, 22, 'Casual Shoes'),
(37, 22, 'Casual shoes with cotton canvas as upper material and pre moulded rubber as sole material'),
(38, 21, 'Closure: Pull On'),
(39, 21, 'Shoe Width: Medium'),
(40, 21, 'Outer Material: Synthetic'),
(41, 21, 'Product Type: Men''s Formal Shoes'),
(42, 21, 'Shoe Width: Medium'),
(43, 21, 'Closure Type: Slip On'),
(44, 21, 'Toe Style: Closed Toe'),
(45, 20, 'Sole: Phylon'),
(46, 20, 'Closure: Lace-Up'),
(47, 20, 'Shoe Width: Medium'),
(48, 20, 'Material Type: Mesh'),
(49, 20, 'Lifestyle: Sports'),
(50, 19, 'Care Instructions: Dry Clean Only'),
(51, 19, 'Saree Material: Mysore Silk'),
(52, 19, 'Occasion : casual wear and for upcoming social event'),
(53, 19, 'Dimension:- Length:- 5.5Mtr. + 0.8Mtr. = 6.3Mtr.'),
(54, 19, 'Total number of items sold : two item saree with unstitched blouse'),
(55, 19, 'Care instructions: Wash separately in cold water,do not bleach,dry in shade,medium to hot iron.'),
(56, 18, 'Care Instructions: Machine Wash'),
(57, 18, 'Fit Type: Regular'),
(58, 18, 'Style Name :- Tshirts'),
(59, 18, 'Model Name :- SS Graphic Tee'),
(60, 18, 'Neck Type :- Round Neck'),
(61, 18, 'Sleeve Type :- Short Sleeves'),
(62, 18, 'Pattern :- Graphic Print'),
(63, 17, 'Care Instructions: Machine Wash'),
(64, 17, 'Fit Type: Slim'),
(65, 17, 'F/S DOBBY SLUB LINEN CHECK SHIRT'),
(66, 16, 'Care Instructions: Machine Wash'),
(67, 16, 'Fit Type: skinny fit'),
(68, 16, 'Color:JSW-INDIGO'),
(69, 16, 'Material: Denim'),
(70, 16, 'Skinny Fit'),
(71, 16, 'Zip fly with button closure'),
(72, 14, 'All kind of electrical works'),
(73, 9, 'Specially designed self centering compass, for ease and accuracy while drawing circles & angles.'),
(74, 9, 'Both divider and compass are made with non-rusting strong material to last long and remain in shape and shine.'),
(75, 9, 'The plastic used in ruler, protractor and set square are made of high transparency plasticand comes with precise marking for easy reading and accurate drawings.'),
(76, 9, 'The special technique of marking ensures that the marking are clearly visible after extensive use.'),
(77, 1, 'World longest writing pen');

-- --------------------------------------------------------

--
-- Table structure for table `prod_image`
--

CREATE TABLE IF NOT EXISTS `prod_image` (
  `img_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `img_path` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_image`
--

INSERT INTO `prod_image` (`img_id`, `prod_id`, `img_path`) VALUES
(2, 10, '60a5fc1734b28.jpg'),
(3, 11, '60a5fe7c2604e.jpg'),
(4, 12, '60a6004066a30.jpg'),
(5, 13, '60a6018d9d901.jpg'),
(6, 5, '60a601eb3cbcb.jpg'),
(7, 6, '60a6021b21d01.jpg'),
(8, 7, '60a60256c5dff.jpg'),
(9, 8, '60a60299a074b.jpg'),
(10, 14, '60a603182d053.jpg'),
(11, 15, '60a6037ce20f3.jpg'),
(12, 16, '60a6056fbad2c.jpg'),
(13, 16, '60a6057c7f44f.jpg'),
(14, 16, '60a605827c5bf.jpg'),
(15, 17, '60a607edacc18.jpg'),
(16, 17, '60a607f48c88e.jpg'),
(17, 17, '60a607fa0cbb7.jpg'),
(18, 18, '60a6096405c92.jpg'),
(19, 18, '60a60969bf1f5.jpg'),
(20, 18, '60a60971a3401.jpg'),
(21, 19, '60a60a3db061e.jpg'),
(22, 19, '60a60a4406c33.jpg'),
(23, 19, '60a60a49e2173.jpg'),
(24, 19, '60a60a50aafa5.jpg'),
(25, 20, '60a60c08663f9.jpg'),
(26, 20, '60a60c0faa035.jpg'),
(27, 20, '60a60c16261c8.jpg'),
(28, 20, '60a60c1c2b51c.jpg'),
(29, 21, '60a60cf011849.jpg'),
(30, 21, '60a60cf7a8ab2.jpg'),
(31, 21, '60a60cfde5b9f.jpg'),
(32, 21, '60a60d03c3b34.jpg'),
(33, 22, '60a60dfc5d871.jpg'),
(34, 22, '60a60e034a7f1.jpg'),
(35, 23, '60a60f0b392b9.jpg'),
(36, 23, '60a60f10bd766.jpg'),
(37, 23, '60a60f1603f34.jpg'),
(38, 24, '60a60fb7f08bd.jpg'),
(39, 24, '60a60fbd50190.jpg'),
(40, 24, '60a60fc3232b4.jpg'),
(41, 25, '60a611e7bfc98.jpg'),
(42, 25, '60a611edb927d.jpg'),
(43, 25, '60a611f371831.jpg'),
(44, 26, '60a613d0b82bb.jpg'),
(45, 26, '60a613da8bd0d.jpg'),
(46, 26, '60a613e2a70a9.jpg'),
(47, 2, '60a614e833efa.jpg'),
(48, 27, '60a617b0025e6.jpg'),
(49, 28, '60a61902d340b.jpg'),
(50, 28, '60a6190b754e9.jpg'),
(51, 28, '60a6191174d77.jpg'),
(52, 29, '60a61a2ab9dde.jpg'),
(53, 29, '60a61a31d6af1.jpg'),
(54, 29, '60a61a38e061f.jpg'),
(55, 30, '60a61dd40969e.jpeg'),
(56, 1, '60a61ebcc5c1d.jpg'),
(57, 1, '60a61ec5b8889.jpg'),
(58, 31, '60a61f6de4c06.jpg'),
(59, 31, '60a61f75d118b.jpg'),
(60, 31, '60a61f84788b9.jpg'),
(61, 4, '60a6215b75aec.jpg'),
(62, 9, '60a621f3424ab.jpg'),
(63, 9, '60a621f98ce8f.jpg'),
(64, 32, '60a62336bc607.jpg'),
(65, 34, '60a7a82ce67e0.jpg'),
(66, 33, '60a7ae2aae309.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prod_mfrs`
--

CREATE TABLE IF NOT EXISTS `prod_mfrs` (
  `mfrs_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_mfrs`
--

INSERT INTO `prod_mfrs` (`mfrs_id`, `name`, `address`, `mobile`, `email`, `password`) VALUES
(1, 'United Spirits Limited', 'UB Tower, 24, Vittal Mallya Road, Bengaluru', 9872005959, 'punjlandgroup@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `name`, `mobile`, `email`, `password`) VALUES
(1, 'Sapna Kumari', 8765432101, 'sapna1@gmail.com', 'a1Bz20ydqelm8m1wql222f0693fcf0a4cdbb3c67550bb82e77'),
(2, 'Mohan Kumar', 8765432102, 'mohan2@gmail.com', 'a1Bz20ydqelm8m1wql7a9b0577caa57139e152e5c0f0049977'),
(3, 'Rajesh Kumar', 8765432103, 'rajesh3@gmail.com', 'a1Bz20ydqelm8m1wql4cece8f3eb866d9394955ec5534ddd89'),
(4, 'Rampal Prasad', 8765432104, 'rampal4@gmail.com', 'a1Bz20ydqelm8m1wql5e9514ced3b5cadade0f597231d877e2'),
(5, 'Raj Singh', 8765432105, 'raj5@gmail.com', 'a1Bz20ydqelm8m1wql24d67fb6fba63350d006471ff951e6df'),
(6, 'Mahesh pal', 8765432106, 'mahesh6@gmail.com', 'a1Bz20ydqelm8m1wqle9217980968db55ed854c842609acc06'),
(7, 'Sohan Kulshreshtha', 8765432107, 'sohan7@gmail.com', 'a1Bz20ydqelm8m1wqlf800c43bef9d03bd447489438a72ec74'),
(8, 'Aman chhimpa', 8765432108, 'aman8@gmail.com', 'a1Bz20ydqelm8m1wqlc38be00c3a73bf44a9e3119d5e299362'),
(9, 'Jay mehta', 8765432109, 'jay9@gmail.com', 'a1Bz20ydqelm8m1wql2396bc502ee6bfa394be3538e4467175'),
(10, 'Vikas Gupta', 8765432110, 'vikas10@gmail.com', 'a1Bz20ydqelm8m1wqlb04409f317936466861fc6820972f9d8');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `shop_id` int(11) NOT NULL,
  `shop_cat_id` int(11) NOT NULL,
  `shop_type` tinyint(4) NOT NULL,
  `shop_name` varchar(300) NOT NULL,
  `building` varchar(200) NOT NULL,
  `locality` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin` mediumint(9) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `longt` float(10,6) NOT NULL,
  `ranged` tinyint(4) DEFAULT NULL,
  `provider_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shop_id`, `shop_cat_id`, `shop_type`, `shop_name`, `building`, `locality`, `city`, `state`, `pin`, `lat`, `longt`, `ranged`, `provider_id`) VALUES
(5, 10, 0, 'Sapna Beauty Parlour', 'Grant Trunk Road, ', 'Sant Pura Miller Ganj', 'Ludhiana', 'Punjab', 141016, 30.903536, 75.854584, 20, 1),
(6, 5, 0, 'Mohan Book Store', 'Bhagwan nagar', 'Industrial Area A', 'Ludhiana', 'Punjab', 141003, 30.893211, 75.870155, 15, 2),
(7, 2, 0, 'Rajesh Clothing Store', 'Jammu Delhi Road', 'Sherpur', 'Ludhiana', 'Punjab', 141014, 30.885143, 75.885864, 20, 3),
(8, 9, 1, 'Rampal Prasad Electrician', 'A', 'A', 'A', 'A', 141010, 30.900972, 75.857292, 20, 4),
(9, 4, 0, 'Raj boot house', 'Basant Singh Khalsa rd, Stadium rd', 'Nr Jagraon Pull, Gandhi Nagar, Koh- E- Fiza', 'Ludhiana', 'Punjab', 141001, 30.907528, 75.846565, 20, 5),
(10, 1, 0, 'Mahesh Karyana Store', 'B-13-209 st no 16', 'old jail rd fieldganj', 'Ludhiana', 'Punjab', 141008, 30.907589, 75.857338, 20, 6),
(11, 8, 1, 'Sohan Kumar Rajmistri', '33 feet road', 'giaspura', 'ludhiana', 'Punjab', 141016, 30.864178, 75.895691, 20, 7),
(12, 6, 0, 'Aman hair Saloon', '73, gill roads, santpura', 'near vishwakarma chowk millerganj', 'ludhiana', 'Punjab', 141003, 30.899136, 75.858055, 20, 8),
(13, 3, 0, 'Jay Stationary Store', '594, model town rd, pritam nagar', 'model town', 'Ludhiana', 'Punjab', 141002, 30.892654, 75.844978, 20, 9),
(14, 11, 0, 'Gupta Travels', 'model town rd,', 'jawahar nagar', 'Ludhiana', 'Punjab', 141002, 30.897198, 75.844696, 20, 10);

-- --------------------------------------------------------

--
-- Table structure for table `shop_cat`
--

CREATE TABLE IF NOT EXISTS `shop_cat` (
  `shop_cat_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `descp` varchar(300) NOT NULL,
  `keyword` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_cat`
--

INSERT INTO `shop_cat` (`shop_cat_id`, `name`, `descp`, `keyword`) VALUES
(1, 'Karyana Store', 'Shop sell general karyana item', 'kirana store, karyana store'),
(2, 'Clothing Shop', 'All type of cloth', 'cloth jeans shirt'),
(3, 'Stationary Store', 'Stationary shop selling all item.', 'stationary '),
(4, 'Footwear shop', 'Footwear shop selling all kind of slipper, shoe and other footwear', 'footwear shoe slipper'),
(5, 'Book Store', 'Selling all book copy and other stationary', 'book shop'),
(6, 'saloon', 'hair cutting and other hair related service', 'hair cut'),
(7, 'photography', 'photography shop', 'marriage photography, videography'),
(8, 'Rajmistri', 'rajmistri building construction', 'rajmistri, '),
(9, 'Electrician', 'All electrical related service', 'electrical fitting wiring '),
(10, 'Beauty parlour', 'beauty parlour and bridal makeup service', 'beauty parlour'),
(11, 'Vehicle on rent', 'Vehicle is provided on rent', 'car rent, auto rent, 3 wheeler, 4 wheeler'),
(12, 'Sport shop', 'Sell All kind of all Sport iotem', 'sport shop');

-- --------------------------------------------------------

--
-- Table structure for table `shop_img`
--

CREATE TABLE IF NOT EXISTS `shop_img` (
  `img_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `img_path` varchar(200) NOT NULL,
  `img_type` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_img`
--

INSERT INTO `shop_img` (`img_id`, `shop_id`, `img_path`, `img_type`) VALUES
(14, 5, '60a63334120d2.jpg', 0),
(15, 6, '60a642576f079.jpg', 0),
(16, 7, '60a643fa981f7.png', 0),
(17, 8, '60a645b18574c.png', 0),
(18, 9, '60a647cdc0b4f.png', 0),
(19, 10, '60a6494dc4148.png', 0),
(20, 11, '60a658119742f.png', 0),
(21, 12, '60a659c05da28.png', 0),
(22, 13, '60a65b3029ed1.png', 0),
(23, 14, '60a65c65454b6.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_product`
--

CREATE TABLE IF NOT EXISTS `shop_product` (
  `sp_pid` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `price` mediumint(9) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_product`
--

INSERT INTO `shop_product` (`sp_pid`, `shop_id`, `prod_id`, `price`, `status`) VALUES
(5, 5, 5, 100, 0),
(6, 5, 6, 40, 0),
(7, 5, 7, 180, 0),
(8, 5, 8, 80, 0),
(9, 6, 10, 92, 0),
(10, 6, 11, 190, 0),
(11, 6, 12, 440, 0),
(12, 6, 13, 270, 0),
(13, 7, 16, 1250, 0),
(14, 7, 17, 1550, 0),
(15, 7, 18, 550, 0),
(16, 7, 19, 440, 0),
(17, 8, 14, 600, 0),
(18, 9, 20, 1100, 0),
(19, 9, 21, 550, 0),
(20, 9, 22, 480, 0),
(21, 9, 23, 340, 0),
(22, 10, 28, 300, 0),
(23, 10, 29, 250, 0),
(24, 10, 30, 214, 0),
(25, 10, 31, 80, 0),
(26, 11, 15, 700, 0),
(27, 12, 2, 40, 0),
(28, 12, 32, 45, 0),
(29, 13, 1, 20, 0),
(30, 13, 4, 5, 0),
(31, 13, 9, 95, 0),
(32, 14, 33, 800, 0),
(33, 14, 34, 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_prod_img`
--

CREATE TABLE IF NOT EXISTS `shop_prod_img` (
  `sp_img_id` int(11) NOT NULL,
  `sp_pid` int(11) NOT NULL,
  `img_path` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `srch_hist`
--

CREATE TABLE IF NOT EXISTS `srch_hist` (
  `srch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `longt` float(10,6) NOT NULL,
  `keyword` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcat_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_name` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcat_id`, `cat_id`, `subcat_name`) VALUES
(1, 1, 'Pencil'),
(2, 1, 'Pen'),
(3, 1, 'geometry box'),
(4, 2, 'cricket'),
(5, 2, 'volleyball'),
(6, 2, 'football'),
(7, 3, 'Jeans'),
(8, 3, 'Shirt'),
(9, 3, 'Tshirt'),
(10, 3, 'Saree'),
(11, 5, 'Sport Shoe'),
(12, 5, 'formal shoe'),
(13, 5, 'casual shoe'),
(14, 5, 'slipper');

-- --------------------------------------------------------

--
-- Table structure for table `subcat_prod`
--

CREATE TABLE IF NOT EXISTS `subcat_prod` (
  `subcatp_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcat_prod`
--

INSERT INTO `subcat_prod` (`subcatp_id`, `subcat_id`, `prod_id`) VALUES
(5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `longt` float(10,6) DEFAULT NULL,
  `ranged` float(4,1) DEFAULT '5.0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `mobile`, `email`, `password`, `gender`, `dob`, `lat`, `longt`, `ranged`) VALUES
(1, 'Rakesh Kumar', 9653545943, 'rakesh141010@gmail.com', 'a1Bz20ydqelm8m1wqlc33367701511b4f6020ec61ded352059', 'Male', '1996-11-11', 30.865772, 75.903656, 50.0),
(2, 'Ravi Kumar', 7986522422, 'ravi141010@gmail.com', 'a1Bz20ydqelm8m1wqlc33367701511b4f6020ec61ded352059', NULL, NULL, NULL, NULL, 5.0);

-- --------------------------------------------------------

--
-- Table structure for table `user_loc_hist`
--

CREATE TABLE IF NOT EXISTS `user_loc_hist` (
  `loc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `longt` float(10,6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_loc_hist`
--

INSERT INTO `user_loc_hist` (`loc_id`, `user_id`, `lat`, `longt`, `time`) VALUES
(1, 1, 30.900089, 75.857208, '2021-05-22 20:08:22'),
(4, 1, 30.757879, 75.949974, '2021-05-25 12:33:47'),
(5, 1, 30.903845, 75.854240, '2021-05-25 12:41:58'),
(6, 1, 30.866043, 75.904152, '2021-05-25 12:44:53'),
(7, 1, 30.737926, 75.972992, '2021-05-25 13:10:58'),
(8, 1, 30.865772, 75.903656, '2021-05-25 13:11:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attrib_list`
--
ALTER TABLE `attrib_list`
  ADD PRIMARY KEY (`attrib_id`);

--
-- Indexes for table `attrib_val_list`
--
ALTER TABLE `attrib_val_list`
  ADD PRIMARY KEY (`attrib_val_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `prod_attrib`
--
ALTER TABLE `prod_attrib`
  ADD PRIMARY KEY (`prod_attrib_id`), ADD UNIQUE KEY `prod_id` (`prod_id`,`attrib_val_id`);

--
-- Indexes for table `prod_feat`
--
ALTER TABLE `prod_feat`
  ADD PRIMARY KEY (`feat_id`);

--
-- Indexes for table `prod_image`
--
ALTER TABLE `prod_image`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `prod_mfrs`
--
ALTER TABLE `prod_mfrs`
  ADD PRIMARY KEY (`mfrs_id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `shop_cat`
--
ALTER TABLE `shop_cat`
  ADD PRIMARY KEY (`shop_cat_id`);

--
-- Indexes for table `shop_img`
--
ALTER TABLE `shop_img`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `shop_product`
--
ALTER TABLE `shop_product`
  ADD PRIMARY KEY (`sp_pid`);

--
-- Indexes for table `shop_prod_img`
--
ALTER TABLE `shop_prod_img`
  ADD PRIMARY KEY (`sp_img_id`);

--
-- Indexes for table `srch_hist`
--
ALTER TABLE `srch_hist`
  ADD PRIMARY KEY (`srch_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcat_id`);

--
-- Indexes for table `subcat_prod`
--
ALTER TABLE `subcat_prod`
  ADD PRIMARY KEY (`subcatp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_loc_hist`
--
ALTER TABLE `user_loc_hist`
  ADD PRIMARY KEY (`loc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `attrib_list`
--
ALTER TABLE `attrib_list`
  MODIFY `attrib_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `attrib_val_list`
--
ALTER TABLE `attrib_val_list`
  MODIFY `attrib_val_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `prod_attrib`
--
ALTER TABLE `prod_attrib`
  MODIFY `prod_attrib_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `prod_feat`
--
ALTER TABLE `prod_feat`
  MODIFY `feat_id` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `prod_image`
--
ALTER TABLE `prod_image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `prod_mfrs`
--
ALTER TABLE `prod_mfrs`
  MODIFY `mfrs_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `shop_cat`
--
ALTER TABLE `shop_cat`
  MODIFY `shop_cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `shop_img`
--
ALTER TABLE `shop_img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `shop_product`
--
ALTER TABLE `shop_product`
  MODIFY `sp_pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `shop_prod_img`
--
ALTER TABLE `shop_prod_img`
  MODIFY `sp_img_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `srch_hist`
--
ALTER TABLE `srch_hist`
  MODIFY `srch_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `subcat_prod`
--
ALTER TABLE `subcat_prod`
  MODIFY `subcatp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_loc_hist`
--
ALTER TABLE `user_loc_hist`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
