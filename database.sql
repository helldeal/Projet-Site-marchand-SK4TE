-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 jan. 2023 à 18:02
-- Version du serveur :  10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `admin`
--
-- DROP TABLE User;
-- DROP TABLE Promotion;
-- DROP TABLE Livraison;
-- DROP TABLE Order;
-- DROP TABLE PasswordReset;
-- DROP TABLE Infos;
-- DROP TABLE Product;
-- DROP TABLE Brand;
-- DROP TABLE Category;

DELIMITER $$
--
-- Procédures
--
CREATE OR REPLACE PROCEDURE `brand_addBrand` (IN `_id` INT, IN `_name` TEXT)  NO SQL
BEGIN
	INSERT INTO Brand VALUES (_id, _name);
END$$

CREATE OR REPLACE PROCEDURE `brand_count` ()  NO SQL
BEGIN
	SELECT COUNT(*) FROM Brand;
END$$

CREATE OR REPLACE PROCEDURE `brand_deleteBrand` (IN `_id` INT)  NO SQL
BEGIN
	DELETE FROM Brand WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `brand_getAllBrands` ()  NO SQL
BEGIN
	SELECT * FROM Brand;
END$$

CREATE OR REPLACE PROCEDURE `category_addCategory` (IN `_id` INT, IN `_name` TEXT)  NO SQL
BEGIN
	INSERT INTO Category VALUES (_id, _name);
END$$

CREATE OR REPLACE PROCEDURE `category_deleteCategory` (IN `_id` INT)  NO SQL
BEGIN
	DELETE FROM Category WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `category_getAllCategories` ()  NO SQL
BEGIN
	SELECT * FROM Category;
END$$

CREATE OR REPLACE PROCEDURE `infos_addColor` (IN `_id` INT, IN `_productId` INT, IN `_color` TEXT, IN `_colorCode` TINYTEXT)  NO SQL
BEGIN
	INSERT INTO Infos(id, productId, color, colorCode) VALUES (_id, _productId, _color, _colorCode);
END$$

CREATE OR REPLACE PROCEDURE `infos_addSize` (IN `_id` INT, IN `_productId` INT, IN `_size` TEXT, IN `_qty` INT, IN `_color` TEXT, IN `_code` TINYTEXT)  NO SQL
BEGIN
	INSERT INTO Infos VALUES (_id, _productId, _size, _qty, _color, _code);
END$$

CREATE OR REPLACE PROCEDURE `infos_changeQuantity` (IN `_id` INT, IN `_quantity` INT)  NO SQL
BEGIN
	UPDATE Infos SET quantity=_quantity WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `infos_deleteColor` (IN `_productId` INT, IN `_color` TEXT)  NO SQL
BEGIN
	DELETE FROM Infos WHERE productId=_productId AND color=_color AND quantity IS NULL;
END$$

CREATE OR REPLACE PROCEDURE `infos_deleteSize` (IN `_id` INT)  NO SQL
BEGIN
	DELETE FROM Infos WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `infos_findInfoId` (IN `_id` INT, IN `_size` TEXT, IN `_color` TEXT)  NO SQL
BEGIN
	SELECT id FROM Infos WHERE size=_size AND color=_color AND _id=productId;
END$$

CREATE OR REPLACE PROCEDURE `infos_getAllInfos` ()  NO SQL
BEGIN
	SELECT * FROM Infos;
END$$

CREATE OR REPLACE PROCEDURE `infos_getInfoById` (IN `_id` INT)  NO SQL
BEGIN
	SELECT * FROM Infos WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `infos_getInfosById` (IN `_id` INT)  NO SQL
BEGIN
	SELECT * FROM Infos WHERE productId=_id;
END$$

CREATE OR REPLACE PROCEDURE `pass_addResetPassword` (IN `_passResetEmail` TEXT, IN `_passResetSelector` TEXT, IN `_passResetToken` LONGTEXT, IN `_passResetExpire` TEXT)  NO SQL
BEGIN
	INSERT INTO PasswordReset(passResetEmail, passResetSelector, passResetToken, passResetExpire) VALUES (_passResetEmail, _passResetSelector,_passResetToken, _passResetExpire );
END$$

CREATE OR REPLACE PROCEDURE `pass_checkSelectorAndExpire` (IN `_passResetSelector` TEXT, IN `_passResetExpire` TEXT)  NO SQL
BEGIN
	SELECT * FROM PasswordReset WHERE passResetSelector=_passResetSelector AND passResetExpire>=_passResetExpire;
END$$

CREATE OR REPLACE PROCEDURE `pass_deleteResetPassword` (IN `_passResetEmail` TEXT)  NO SQL
BEGIN
	DELETE FROM PasswordReset WHERE passResetEmail=_passResetEmail;
END$$

CREATE OR REPLACE PROCEDURE `product_addProduct` (IN `_id` INT(11), IN `_name` VARCHAR(150), IN `_brand` INT, IN `_category` INT, IN `_price` FLOAT, IN `_pictures` VARCHAR(10000), IN `_description` LONGTEXT)  NO SQL
BEGIN
	INSERT INTO Product VALUES (_id, _name, _brand, _category, _price, _pictures, _description);
END$$

CREATE OR REPLACE PROCEDURE `product_deleteProduct` (IN `_id` INT)  NO SQL
BEGIN
	DELETE FROM Product WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `product_findById` (IN `_id` INT(11))  NO SQL
BEGIN
SELECT * FROM Product WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `product_getAllProducts` ()  NO SQL
BEGIN
SELECT * FROM Product;
END$$

CREATE OR REPLACE PROCEDURE `product_updateProduct` (IN `_id` INT, IN `_name` TEXT, IN `_brand` INT, IN `_category` INT, IN `_price` FLOAT, IN `_picture` TEXT, IN `_description` TEXT)  NO SQL
BEGIN
	UPDATE Product
    SET name=_name,brand=_brand, 
    category=_category, price=_price, 	
    pictures=_picture, description=_description 
    WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `promo_addPromotion` (IN `_id` INT, IN `_promo` INT)  NO SQL
BEGIN
	INSERT INTO Promotion VALUES (_id, _promo);
END$$

CREATE OR REPLACE PROCEDURE `promo_deletePromo` (IN `_id` INT)  NO SQL
BEGIN
	DELETE FROM Promotion WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `promo_getAllPromos` ()  NO SQL
BEGIN
	SELECT * FROM Promotion;
END$$

CREATE OR REPLACE PROCEDURE `promo_getPromoById` (IN `_id` INT)  NO SQL
BEGIN
	SELECT * FROM Promotion WHERE id=_id;
END$$

CREATE OR REPLACE PROCEDURE `user_addUser` (IN `_email` VARCHAR(255), IN `_pseudo` VARCHAR(50), IN `_password` VARCHAR(255), IN `_status` VARCHAR(255))  NO SQL
BEGIN
INSERT INTO User (email, pseudo, password, status) 
VALUES (_email, _pseudo, _password, _status);
END$$

CREATE OR REPLACE PROCEDURE `user_deleteUser` (IN `_email` VARCHAR(255))  NO SQL
BEGIN
DELETE FROM User
    WHERE email = _email;
END$$

CREATE OR REPLACE PROCEDURE `user_findByEmail` (IN `_email` VARCHAR(255))  BEGIN
SELECT * FROM User
    WHERE email = _email;
END$$

CREATE OR REPLACE PROCEDURE `user_getAllUsers` ()  NO SQL
BEGIN
SELECT * FROM User ORDER BY STATUS;
END$$

CREATE OR REPLACE PROCEDURE `user_updateUser` (IN `_email` VARCHAR(255), IN `_pseudo` VARCHAR(50), IN `_password` VARCHAR(255), IN `_status` VARCHAR(255))  NO SQL
BEGIN
	UPDATE User set password=_password, 			status=_status, pseudo=_pseudo where email=_email;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Brand`
--

CREATE TABLE `Brand` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Brand`
--

INSERT INTO `Brand` (`id`, `name`) VALUES
(1, 'Nike'),
(2, 'Puma'),
(3, 'Carhartt'),
(4, 'Nike SB'),
(5, 'Thrasher'),
(6, 'Santa Cruz'),
(7, 'Dickers'),
(8, 'Nocta'),
(9, 'Nike x Nocta'),
(10, 'Yeezy'),
(11, 'Reebok'),
(12, 'Adidas'),
(13, 'Vans'),
(14, 'ANTIHERO'),
(15, 'ANTIX'),
(16, 'Carpet'),
(17, 'Converse'),
(18, 'Element'),
(19, 'Emerica'),
(20, 'Etnies'),
(21, 'Huf'),
(22, 'Last Resort AB'),
(23, 'New Balance'),
(24, 'Palace'),
(25, 'Patagonia'),
(26, 'Polar'),
(27, 'Sour'),
(28, 'Spitfire'),
(29, 'CR7'),
(30, 'Toymachine'),
(31, 'Venture'),
(32, 'Globe'),
(33, 'Bones'),
(34, 'Mob'),
(35, 'Mob x Thrasher'),
(36, 'Baker'),
(37, 'OJ'),
(38, 'Pizza Skateboard'),
(39, 'Bronson Speed Co.'),
(40, 'Powell-Peralta'),
(41, 'Magenta'),
(42, 'Tensor'),
(43, 'Independent'),
(44, 'Thunder'),
(45, 'Independent x Thrasher'),
(46, 'Carhartt'),
(47, 'Dickies'),
(48, 'Palace x Vans');

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'Chaussettes'),
(3, 'Chaussures'),
(7, 'T-Shirt'),
(10, 'Hoodie'),
(16, 'Pantalon'),
(17, 'Pantalon de Survêtement'),
(18, 'Short'),
(19, 'Skateboard'),
(21, 'Roues'),
(22, 'Roulements'),
(23, 'Trucks'),
(24, 'Planches'),
(25, 'Grip'),
(26, 'Stickers'),
(28, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la table `Infos`
--

CREATE TABLE `Infos` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `size` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `color` text NOT NULL,
  `colorCode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Infos`
--

INSERT INTO `Infos` (`id`, `productId`, `size`, `quantity`, `color`, `colorCode`) VALUES
(261, 3, '38', 30, 'Blanc', '#ffffff'),
(262, 3, '38', 60, 'Noir', '#000000'),
(263, 3, '41', 10, 'Multicolor', '#b45216'),
(264, 3, '37', 25, 'Rose', '#f9d0f4'),
(268, 3, '39', 20, 'Blanc', '#ffffff'),
(269, 3, '40', 10, 'Blanc', '#ffffff'),
(270, 3, '41', 22, 'Blanc', '#ffffff'),
(271, 3, '42', 13, 'Blanc', '#ffffff'),
(272, 3, '43', 15, 'Blanc', '#ffffff'),
(273, 3, '44', 5, 'Blanc', '#ffffff'),
(302, 6, '5.2in', 40, 'Argenté', '#818181'),
(312, 4, '8mm', 60, 'Rouge', '#ff0000'),
(325, 7, '8.375in', 40, 'Fond violet', '#481143'),
(326, 7, '8.5in', 45, 'Fond Bois', '#d06b28'),
(328, 5, '7.75in', 0, 'Rouge', '#ff0000'),
(334, 8, '43', 50, 'Blanc', '#ffffff'),
(338, 8, '41', 0, 'Noir', '#000000'),
(339, 8, '42', 3, 'Violet', '#74439c'),
(340, 8, '39', 5, 'Rouge', '#ff0000'),
(342, 9, '600mm', 80, 'Noir', '#000000'),
(364, 17, 'L', 5, 'Noir', '#000000'),
(365, 17, 'XL', 5, 'Noir', '#000000'),
(366, 17, 'S', 0, 'Noir', '#000000'),
(367, 17, 'M', 12, 'Noir', '#000000'),
(369, 17, 'XS', 2, 'Noir', '#000000'),
(374, 20, '8in', 100, 'Vert', '#00aa00'),
(376, 8, '42', 0, 'Jaune', '#ecaf33'),
(378, 21, '8mm', 30, 'Orange', '#ff4d00'),
(380, 22, 'XL', 15, 'Noir', '#000000'),
(382, 22, 'L', 3, 'Noir', '#000000'),
(383, 10, '600mm', 7, 'Beige', '#dfdcb3'),
(385, 11, '600mm', 10, 'Bleu', '#214ec5'),
(389, 16, '56mm', 34, 'Bleu', '#214ec5'),
(391, 19, '54mm', 7, 'Rouge', '#ff0000'),
(395, 13, '7.75in', 45, 'Bleu', '#214ec5'),
(397, 14, '9.5in', 13, 'Fond violet', '#481143'),
(399, 23, '8mm', 38, 'Jaune', '#ecaf33'),
(401, 3, '43', 24, 'Jaune', '#ecaf33'),
(403, 12, '600mm', 23, 'Jaune', '#ecaf33'),
(405, 8, '43', 53, 'Bleu foncé', '#101881'),
(407, 15, '8in', 23, 'Rouge', '#ff0000'),
(409, 2, '9.7in', 12, 'Noir', '#000000'),
(411, 18, '52mm', 34, 'Blanc', '#ffffff'),
(413, 24, '9.75in', 67, 'Rouge', '#ff0000'),
(415, 25, '8.5in', 10, 'Orange', '#ff4d00'),
(417, 26, '42', 9, 'Blanc', '#ffffff'),
(419, 26, '37', 23, 'Rouge', '#ff0000'),
(420, 26, '42', 12, 'Rouge', '#ff0000'),
(421, 26, '43', 0, 'Rouge', '#ff0000'),
(422, 26, '40', 3, 'Rouge', '#ff0000'),
(423, 26, '41', 6, 'Blanc', '#ffffff'),
(424, 26, '40', 3, 'Blanc', '#ffffff'),
(426, 27, '8mm', 47, 'Orange', '#ff4d00'),
(428, 28, '5.5in', 20, 'Argenté', '#818181'),
(430, 29, '5.3in', 13, 'Noir', '#000000'),
(432, 30, '5.3in', 34, 'Argenté', '#818181'),
(434, 31, 'L', 12, 'Blanc', '#ffffff'),
(435, 31, 'XL', 2, 'Blanc', '#ffffff'),
(436, 31, 'M', 34, 'Blanc', '#ffffff'),
(440, 32, 'L', 0, 'Marron', '#9c583a'),
(441, 32, 'XL', 0, 'Marron', '#9c583a'),
(442, 32, 'M', 3, 'Marron', '#9c583a'),
(444, 33, '42', 23, 'Blanc', '#ffffff'),
(445, 33, '43', 0, 'Blanc', '#ffffff'),
(446, 33, '41', 10, 'Blanc', '#ffffff'),
(448, 34, '42', 42, 'Noir', '#000000'),
(451, 35, '42', 30, 'Blanc', '#ffffff'),
(452, 35, '41', 15, 'Noir', '#000000'),
(454, 36, 'L', 30, 'Bleu', '#214ec5'),
(455, 36, 'XL', 0, 'Bleu', '#214ec5'),
(457, 36, 'S', 10, 'Bleu', '#214ec5'),
(458, 36, 'M', 34, 'Bleu', '#214ec5'),
(460, 38, 'M', 14, 'Blanc', '#ffffff'),
(464, 37, 'M', 25, 'Jaune', '#ecaf33'),
(466, 39, 'XL', 45, 'Bleu clair', '#00aaff'),
(467, 39, 'L', 15, 'Bleu clair', '#00aaff'),
(468, 39, 'M', 67, 'Bleu clair', '#00aaff'),
(469, 39, 'S', 7, 'Bleu clair', '#00aaff'),
(471, 40, 'M', 15, 'Beige', '#dfdcb3'),
(473, 41, '42', 14, 'Blanc', '#ffffff'),
(475, 42, 'M', 4, 'Noir', '#000000'),
(476, 42, 'L', 4, 'Noir', '#000000'),
(477, 42, 'XL', 4, 'Noir', '#000000'),
(498, 42, 'L', 0, 'Marron', '#9c583a'),
(509, 1, '44mm', 14, 'Rouge', '#ff0000'),
(510, 1, '42mm', 0, 'Rouge', '#ff0000'),
(512, 1, '44mm', 1, 'Rose', '#f9d0f4'),
(516, 1, '43mm', 100, 'Bleu clair', '#00aaff'),
(518, 1, '43mm', 10, 'Blanc', '#ffffff'),
(519, 1, '44mm', 10, 'Blanc', '#ffffff'),
(520, 1, '45mm', 10, 'Blanc', '#ffffff'),
(523, 43, 'XL', 0, 'Bleu clair', '#00aaff'),
(524, 43, 'M', 0, 'Bleu clair', '#00aaff'),
(525, 43, 'S', 0, 'Bleu clair', '#00aaff'),
(526, 43, 'L', 0, 'Bleu clair', '#00aaff'),
(530, 44, '42', 34, 'Jaune', '#ecaf33'),
(531, 44, '41', 43, 'Jaune', '#ecaf33'),
(532, 44, '40', 0, 'Jaune', '#ecaf33'),
(533, 44, '23', 0, 'Jaune', '#ecaf33'),
(535, 45, 'L', 43, 'Orange', '#ff4d00'),
(536, 45, 'M', 53, 'Orange', '#ff4d00'),
(537, 45, 'XL', 23, 'Orange', '#ff4d00'),
(539, 46, 'L', 34, 'Orange', '#ff4d00');

-- --------------------------------------------------------

--
-- Structure de la table `Livraison`
--

CREATE TABLE `Livraison` (
  `id` int(11) NOT NULL,
  `taxe` int(11) NOT NULL,
  `fdp` int(11) NOT NULL,
  `adresse` longtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Livraison`
--

INSERT INTO `Livraison` (`id`, `taxe`, `fdp`, `adresse`) VALUES
(1, 0, 0, 'a::a::a::44444::South-London::France'),
(2, 0, 0, 'Alexandre::Clenet::2 rue de lfsdf::44230::Saint Sébastien sur Loire::France'),
(3, 0, 10, 'dd::dd::dd::44444::iiii::Allemagne');

-- --------------------------------------------------------

--
-- Structure de la table `Order`
--

CREATE TABLE `Order` (
  `ID` int(11) NOT NULL,
  `LOGIN` varchar(155) NOT NULL,
  `REFPROD` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `PRICE` float NOT NULL,
  `TIME` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Order`
--

INSERT INTO `Order` (`ID`, `LOGIN`, `REFPROD`, `QUANTITY`, `PRICE`, `TIME`) VALUES
(1, 'dadmin', 509, 1, 65, '2023-01-12 15:08:16'),
(2, 'alexandreclenet@free.fr', 342, 5, 40, '2023-01-12 17:42:37'),
(3, 'nathan.marie030303@gmail.com', 312, 1, 40, '2023-01-12 17:54:16');

-- --------------------------------------------------------

--
-- Structure de la table `PasswordReset`
--

CREATE TABLE `PasswordReset` (
  `passResetId` int(11) NOT NULL,
  `passResetEmail` text NOT NULL,
  `passResetSelector` text NOT NULL,
  `passResetToken` longtext NOT NULL,
  `passResetExpire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `PasswordReset`
--

INSERT INTO `PasswordReset` (`passResetId`, `passResetEmail`, `passResetSelector`, `passResetToken`, `passResetExpire`) VALUES
(5, 'nathan', 'd8fa4dafd5fdbf5a', '$2y$10$5s6FCSu31kMCUEYg.zejhOUXgdOFVvdrigdhjKUptAfWEEbgF8p3m', '1670974067'),
(41, 'alexandreclenet@free.fr', '59d23a071c5f48bc', '$2y$10$eYAZR9/f.6ImlzQ4xDem6eW3r8DUDkTRMnVPFFhWFJZ.eLiw3N44W', '1672512485'),
(50, 'nathan.marie030303@gmail.com', '6c28ac9f33ee29f2', '$2y$10$Y9k0guN/bWCykHM/Fo63H..MdNuBcH/4FA39TNORufpclIvfP8bY6', '1673278641'),
(51, 'benjamin.couet41@gmail.com', '1f9950ace9cf51cf', '$2y$10$Xt.iGqCvlRILxZfmC70c0enX4KWTk5d7WX0cz/s/5jQxX.5LrYBLy', '1673423717');

-- --------------------------------------------------------

--
-- Structure de la table `Product`
--

CREATE TABLE `Product` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `brand` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `price` float NOT NULL,
  `pictures` varchar(10000) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Product`
--

INSERT INTO `Product` (`id`, `name`, `brand`, `category`, `price`, `pictures`, `description`) VALUES
(1, 'Formula Four Conical', 28, 21, 65, 'c5632a0bc053f2275186f2ce2f86c9e1.png, ab0cd7f89164fac7fcf759f7cb0380f2.png, 8980d4c97687b8c1c9682b73a091eee9.png, 7cdc83be5d239eb5ccd680c26b49ce07.png', 'Roue de skate de la marque Spitfire Wheels'),
(2, 'SANTA CRUZ Johnson Beach Wolf', 6, 24, 100, 'a0decda8f22f19635591227eef148e8f.jpg', ''),
(3, 'Nike SB ZOOM STEFAN JANOSKI', 1, 3, 75, '7a39ebd2004b12193d0278fc02df491a.jpg, 14c428e766f586c8f0a85f16ed3c2fec.jpg, ef00805c08c45d69e319abb707b807ac.jpg, 03bda9cc3ef1781fdf24334eaa249493.jpg, 212b032d01a5e7c2628961253a2b6948.jpg', 'Chaussures de skateboard'),
(4, 'Bones REDS', 33, 22, 40, '95c8ab4526707eb1c199e1fefa4aab2c.jpg', ''),
(5, 'Globe skateboard', 32, 19, 80, '6c9320d8a7eb69240d4d93052c2f16d4.png', 'Tricks: Tensor'),
(6, ' TRUCKS 5.2 POLISHED', 31, 23, 45, 'd8096024f8642cc32c4c5e2b64444ffd.jpg', ''),
(7, ' Johnson Beach Wolf Two Deck 8.375\"', 6, 24, 65, 'ec64b5ba0a69ebc77260ec69c1aeb243.png, 97239a0b07fca0d15db6baa214f18a5c.jpg', ''),
(8, 'Chaussettes Vans', 13, 1, 30, 'cd6ffd73df18201ff27f3860f0fd1f16.jpg, 6e00f86d4fe2be40a029789752fa8322.png', ''),
(9, 'Mob grip', 34, 25, 8, 'ece360d1c5ead6d60886c9764fd78463.jpg', ''),
(10, 'Santa Cruz griptape', 6, 25, 15, 'b4b469f56d5c392c4dd73632e9159ae1.png', ''),
(11, 'Mob x Thrasher griptape', 35, 25, 25, '3e91184e3becefd74da7002a0bc0928e.png', ''),
(12, 'Thrasher griptape', 5, 25, 30, '56d2caee4e454e8ead912336fc45c3fd.jpg', ''),
(13, 'ToyMachine skateboard', 30, 19, 99.99, 'd776da70b3d6ba684ffb40defdb512dd.png', 'Skaeboard de la marque ToyMachine.'),
(14, 'SantaCruz large skateboard', 6, 19, 169.99, '618bbbbb1ded24d57f3681ac01835ef6.png', ''),
(15, 'Baker skateboard', 36, 19, 99.99, '7e6b96038a484faeacb4558eef528594.png', ''),
(16, 'TEAM RIDER ROUES (WHITE BLUE) 95A', 37, 21, 50, 'b8b254f32616549638575463da67ee24.png', ''),
(17, 'AIRBRUSH SWEAT À CAPUCHE', 5, 10, 89.99, '713ebaa3342ddbbb044cebc60790cb3c.png, 55b716b45dc1bf02e61712d9b395d881.png, 090d85e11f2c6e06195f71d17827a8bf.png', 'Tissu d\'épaisseur, moyenne doublure douce, coupe droite, capuche double épaisseur avec œillets métalliques et cordon de serrage, poche kangourou sur le devant, poignets élastiques ourlet élastique, imprimé Thrasher sur la poitrine artwork de Phillip Santosuosso'),
(18, 'STF HERITAGE BONELESS V1 ROUES (WHITE)103A', 33, 21, 55, '244a4e1dbeced39022c5ab60f62cd7b6.png', ''),
(19, 'STF RETROS V4 ROUES (WHITE RED) 103A ', 33, 21, 55, 'db5334739c18357b1dc26039c89487e7.png', ''),
(20, 'Vincent Milou Board', 38, 24, 79.99, '4a113752bd4f6b2d62e7a3acfdd87347.jpg', ''),
(21, 'RAVV ROULEMENTS', 39, 22, 54.99, 'fd43b3809e5a5220b852e4e77d51868b.png', ''),
(22, 'THRASHER COP CAR T-SHIRT', 5, 7, 39.99, 'a2b7a0bc77626217affabd9d374509e5.png, c4c77d37918dbbf7a6be592f0973c502.png, f427c43e20daa7ec728cf5b649e13958.png', 'Tissu d\'épaisseur moyenne, coupe droite'),
(23, 'MOONEYES G3 ROULEMENTS (YELLOW)', 39, 22, 42.99, '8803a658327ec7c2468e939d1b6d12a9.png', ''),
(24, 'Gee Gah Ripper', 40, 24, 80.99, '72fa6972cc31dc4741497fc2748da0ee.png', ''),
(25, 'TEAM BIG BRUSH', 41, 24, 65, 'c3d578013b46b6b3f5eae13d7b39c073.png', ''),
(26, 'Slip on Pro', 1, 3, 85, '1c4bcf2fb3c1848161090b50aecc299c.png, 7ae5556b456e60870f56549c9027421e.png, e53964b1cb5693d72d2497cee85230f8.png, af495f9a8da322c6e69dd9276961a9ab.png, dd67aab3ee99c49a99166b7f0642c8d7.png, 5cd6aa0c23f668f36b5ada125b8d6a93.png, 20ab9fa5037432a76d8d89ec0b18ae86.png', ''),
(27, 'Kugellager-raw', 39, 22, 55, 'b2b41f068e527fd070d99addb64b3550.jpg', ''),
(28, 'Mag Light 5.5', 42, 23, 55, '4d30d4e434e053d8baea6eda33728c03.jpg', ''),
(29, '159 Stage 11 Bar Flat Black Standard', 43, 23, 58, '3bca58ea606e4fe6259ca3894bbfe503.png', ''),
(30, '148 Hi OG Grenade Team Edition', 44, 23, 39.99, '2b8635775fdf801873715d1ec04be534.jpg', ''),
(31, 'Hoodie ', 13, 10, 80, 'bb03b3e0cac5259482dae03c7f6a2529.png, 455f5959deab4c3c60043f3ecc43c1ba.png, d97ef20ba88cd58a491d28743dbcbe66.png', ''),
(32, 'Surchemise à carreau', 46, 7, 35, '4b81532addd29c669064142800b561c1.jpg', ''),
(33, 'chaussette mi-haute', 1, 1, 25, '01fa8f4dcab6ed42085b851b98667b55.png', ''),
(34, 'Chaussette noir mi-haute', 46, 1, 30, 'c963621b6e6193e2c9c8dcfd1af4fda3.png', ''),
(35, 'chaussettes', 6, 1, 20, 'dce8e060771cec5482bd6b6790b012e9.png', ''),
(36, 'Hoodie rose', 6, 10, 85, '29c7e3d274ea095acfd009ba4b22a86e.jpg, a8a1933d364f309b3753b2618e3c1abe.jpg', ''),
(37, 'FAUX DENIM CASQUETTE', 4, 1, 24.99, 'e3c98304d5302ae3c52cf1cde475c494.png, 5bad0df714ed4f0cfc40f8e171a950b1.png, 85d762b133faa51deff8668178d524d5.png', 'Casquette 6 panels, tissu résistant de style denim'),
(38, 'Hoodie Independent x Thrasher', 44, 10, 80, '54b76756d9097557c7b3cf91a8506bb6.jpg, b5fcdfb2bc93926da3bb2a213f2d34ed.jpg', ''),
(39, 'COPY SHOP HALF ZIP SWEATSHIRT', 4, 10, 69.99, '52085504dcc4372b91d7eb2284f5467c.png, 522c774acffa9c4dc362e39d35746ed5.png, 493d424ec3857d22e76db06a6aef9fe2.png, b336c278640eee8c1aef10a5121b727c.png', 'Tissu d\'épaisseur moyenne, doublure douce'),
(40, 'WIP BASIC SWEATSHIRT', 46, 10, 85.99, '98bdd283e51ecebeb3b6b9f2147e34a4.png, 46da1b2ac38750e4505869b99f2c2c4b.png, 427ec9aa2f3bc00d19048bac0c793dab.png', 'Épaisseur du tissu : 440 g/m², coupe ample'),
(41, 'MATCHBREAK', 12, 3, 52, 'd1cebfc1e637dca09f53922a8b9e469b.jpg', ''),
(42, 'HOSEN CLUB JOGGER', 1, 17, 45.99, '5ff525e8645addd9e2a4a99ad843b997.png, 1ed828a194d2602f53c20e19cc601b3f.png', 'Jogging de streatwear en coton'),
(43, 'C.P. Company Goggle hoodie blue', 24, 10, 260, 'c2c695c0adc18ec352a6941ae00ce98f.png, 4eb50495db9378da889d33d42d60d8da.png', ''),
(44, 'SKATE HALF CAB ’92 GTX BUTTERSCOTCH', 48, 3, 150, '6f63707d584fff83ed8fc13b3457c14e.png, 8b2427008aacf9d3895466556148670d.png, ae419bad188a72286d05a8c5ffe28bae.png', ''),
(45, 'POLARTEC LAZER OUTER 1/2 ZIP ORANGE', 24, 10, 178, '4f354506a6cdb558353ca47358eb6724.png, da6da605fdb1bd64914b7571ef2f2540.png', ''),
(46, 'Casquette Baseball Mount Vista', 47, 28, 18, '28a06c6e05ee18df7495a48529ef21aa.png, a71123e08bd2faaba51094091ff2afca.png, 4c590c2f6a653ea483832bc003e06f8d.png', '');

-- --------------------------------------------------------

--
-- Structure de la table `Promotion`
--

CREATE TABLE `Promotion` (
  `id` int(11) NOT NULL,
  `promo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `Promotion`
--

INSERT INTO `Promotion` (`id`, `promo`) VALUES
(17, 20),
(39, 15),
(42, 15);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL CHECK (`status` in ('Administrator','Customer','Visitor'))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`email`, `pseudo`, `password`, `status`) VALUES
('alexandreclenet@free.fr', 'Hell', '$2y$10$hdzg94pUH3QtXT8dIvZ.a.OaVjkaiWyUXJ7EEdfXteJEJjtMJ0CGq', 'Administrator'),
('benjamin.couet41@gmail.com', 'Nuuust', '$2y$10$LKcdvym.QZUwoi/QcQDnoOHgwg4z1e4aIDy9bHw/U9jbjF0EP5s9q', 'Administrator'),
('d', 'adminTest(ne pas supp)', '$2y$10$a91NfYT8vQWJSZ0lBIEn4utR38fIQiCiWMcatGpUVLzdyNz6TtFLC', 'Visitor'),
('dadmin', 'AdminTest/Ne pas supprimer', '$2y$10$f5WGSP8rNl17yyySs.7RouNoTW3AlC2B0le0p2ucsp1SJfONNzXO.', 'Administrator'),
('n.n@n.n', 'Nathan', '$2y$10$aquFWeDipXI4QklPkp7kw.c3a7sOqFSgjhUAe1TPoHIHq64dSvNTq', 'Visitor'),
('nathan.marie030303@gmail.com', 'STEP BRO', '$2y$10$c37cQcuX/w5KPU348LcRse5qc9IXU3tDz6iIgGyW..gvT8zWDuvpq', 'Administrator'),
('Xin@mail.com', 'Xin', '$2y$10$OILj5lcR9SPpmCV.eqVtpeVMvzrGUu4pUPMRGHXkikjgeomPwRB0q', 'Administrator');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Brand`
--
ALTER TABLE `Brand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_marque` (`id`);

--
-- Index pour la table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`id`);

--
-- Index pour la table `Infos`
--
ALTER TABLE `Infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit` (`productId`);

--
-- Index pour la table `Livraison`
--
ALTER TABLE `Livraison`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`ID`,`LOGIN`,`REFPROD`);

--
-- Index pour la table `PasswordReset`
--
ALTER TABLE `PasswordReset`
  ADD PRIMARY KEY (`passResetId`);

--
-- Index pour la table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catégorie` (`category`),
  ADD KEY `marque` (`brand`);

--
-- Index pour la table `Promotion`
--
ALTER TABLE `Promotion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Infos`
--
ALTER TABLE `Infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;

--
-- AUTO_INCREMENT pour la table `PasswordReset`
--
ALTER TABLE `PasswordReset`
  MODIFY `passResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `Promotion`
--
ALTER TABLE `Promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Infos`
--
ALTER TABLE `Infos`
  ADD CONSTRAINT `produit` FOREIGN KEY (`productId`) REFERENCES `Product` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `catégorie` FOREIGN KEY (`category`) REFERENCES `Category` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `marque` FOREIGN KEY (`brand`) REFERENCES `Brand` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Promotion`
--
ALTER TABLE `Promotion`
  ADD CONSTRAINT `Promotion_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
