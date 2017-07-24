-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 02 Novembre 2016 à 20:21
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pokemon_placement`
--

drop table if exists Devis;

drop table if exists Facture;

drop table if exists Personne;

drop table if exists Pokemon;

drop table if exists PokemonDevis;

drop table if exists PokemonFacture;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `deId` int(11) NOT NULL,
  `peId` int(11) NOT NULL,
  `deAdresse` varchar(254) DEFAULT NULL,
  `dePrix` int(11) DEFAULT NULL,
  `deDate` datetime DEFAULT NULL,
  `deEtat` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `devis`
--

INSERT INTO `devis` (`deId`, `peId`, `deAdresse`, `dePrix`, `deDate`, `deEtat`) VALUES
(13, 2, 'Bourg', 30, '2016-11-02 21:19:14', 1),
(14, 2, 'Bourg', 260, '2016-11-02 21:19:27', 1);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `faId` int(11) NOT NULL,
  `deId` int(11) NOT NULL,
  `peId` int(11) NOT NULL,
  `faAdresse` varchar(254) DEFAULT NULL,
  `faPrix` int(11) DEFAULT NULL,
  `faDate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`faId`, `deId`, `peId`, `faAdresse`, `faPrix`, `faDate`) VALUES
(31, 14, 2, 'Bourg', 260, '2016-11-02 21:19:58'),
(30, 13, 2, 'Bourg', 30, '2016-11-02 21:19:16');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `peId` int(11) NOT NULL,
  `peNom` varchar(254) DEFAULT NULL,
  `pePrenom` varchar(254) DEFAULT NULL,
  `peMail` varchar(254) DEFAULT NULL,
  `peAdresse` varchar(254) DEFAULT NULL,
  `peMdp` varchar(254) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`peId`, `peNom`, `pePrenom`, `peMail`, `peAdresse`, `peMdp`) VALUES
(1, 'DEJ', 'Elodie', 'edej@orange.fr', 'Villars', 'e3afed0047b08059d0fada10f400c1e5'),
(2, 'PLAZA', 'Bastien', 'bastien.plaza@free.fr', 'Bourg', 'aefd79b2b907ed8afb05c83ce656aca0'),
(3, 'MARTINS', 'Kévin', 'kevin.martins@me.com', 'Mâcon', 'f1cd318e412b5f7226e5f377a9544ff7'),
(4, 'DUCHEMIN', 'Louis', 'louis.duchemin@yahoo.com', 'Breteuil', '67524210524b62ad06b8fc7c6dc7135e'),
(5, 'DUPOND', 'Jacques', 'jacques.dupond@gmail.com', 'Nantes', 'f294202db7c97514d4db2b4d41728e1f'),
(6, 'PIERRE', 'Elouan', 'elouan.pierre@orange.fr', 'Paris', 'ab2fa9b37515f94bc40919cbb9d02b45'),
(7, 'CROCHEMONT', 'Isabelle', 'isabelle.crochemont@gmail.com', 'Nancy', 'b6834171c8a539de15d7955c53364f19'),
(8, 'PRIO', 'Dominique', 'dominique.prio@free.fr', 'Bordeaux', '8eeaced1f2e0dfc753cc11e63b5abc12'),
(9, 'MARTIN', 'Chantale', 'chantale.martin@me.com', 'Bressuire', '5f2b4697da02488e143e75118f998514'),
(10, 'AIR', 'Georges', 'georges.air@free.fr', 'Montpellier', '5e1f765e3af5f7042b31c81ca07a280d'),
(11, 'BERNARD', 'Emma', 'emma.bernard@yahoo.com', 'Villeurbanne', '4535367f2f39b5a2ebaee0092f184a79'),
(12, 'ROUX', 'Thomas', 'thomas.roux@gmail.com', 'Lancelebourg', '2042101ac1f6e7741bfe43f3672e6d7c'),
(13, 'THOMAS', 'Léa', 'lea.thomas@gmail.com', 'Chamonix', '18b6d3cfca6bec531d7a521d43a38d06'),
(14, 'DURAND', 'Amandine', 'amandine.durand@free.fr', 'Grenoble', '4a084008ae194f27537e5b961c1495bb'),
(15, 'PETIT', 'Julie', 'julie.petit@orange.fr', 'Carcassone', '2964815d03a032c8ca37ac5d557647dd'),
(16, 'DUBOIS', 'Loïc', 'loic.dubois@yahoo.com', 'Toulouse', '8f29d46f8d31021b2f56763e8346db25'),
(17, 'BLANC', 'Marie', 'marie.blanc@orange.fr', 'Lille', '879eb8aa505a968b831812aeb836c2a9'),
(18, 'VALETTE', 'Franck', 'franck.valette@free.fr', 'Dunkerque', 'f4a77acf03e969bbb2b99fee35d137fb');

-- --------------------------------------------------------

--
-- Structure de la table `pokemon`
--

CREATE TABLE `pokemon` (
  `poId` int(11) NOT NULL,
  `poNom` varchar(254) DEFAULT NULL,
  `poDescription` varchar(254) DEFAULT NULL,
  `poImage` varchar(254) DEFAULT NULL,
  `poPrix` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pokemon`
--

INSERT INTO `pokemon` (`poId`, `poNom`, `poDescription`, `poImage`, `poPrix`) VALUES
(1, 'Bulbizarre', NULL, 'img/1.png', 20),
(2, 'Herbizarre', NULL, 'img/2.png', 30),
(3, 'Florizarre', NULL, 'img/3.png', 10),
(4, 'Salamèche', NULL, 'img/4.png', 10),
(5, 'Reptincel', NULL, 'img/5.png', 10),
(6, 'Dracaufeu', NULL, 'img/6.png', 10),
(7, 'Carapuce', NULL, 'img/7.png', 10),
(8, 'Carabaffe', NULL, 'img/8.png', 10),
(9, 'Tortank', NULL, 'img/9.png', 10),
(10, 'Chenipan', NULL, 'img/10.png', 10),
(11, 'Chrysacier', NULL, 'img/11.png', 10),
(12, 'Papilusion', NULL, 'img/12.png', 10),
(13, 'Aspicot', NULL, 'img/13.png', 10),
(14, 'Coconfort', NULL, 'img/14.png', 10),
(15, 'Dardargnan', NULL, 'img/15.png', 10),
(16, 'Roucool', NULL, 'img/16.png', 10),
(17, 'Roucoups', NULL, 'img/17.png', 10),
(18, 'Roucarnage', NULL, 'img/18.png', 10),
(19, 'Rattata', NULL, 'img/19.png', 10),
(20, 'Rattatac', NULL, 'img/20.png', 10),
(21, 'Piafabec', NULL, 'img/21.png', 10),
(22, 'Rapasdepic', NULL, 'img/22.png', 10),
(23, 'Abo', NULL, 'img/23.png', 10),
(24, 'Arbok', NULL, 'img/24.png', 10),
(25, 'Pikachu', NULL, 'img/25.png', 10),
(26, 'Raichu', NULL, 'img/26.png', 10),
(27, 'Sabelette', NULL, 'img/27.png', 10),
(28, 'Sablaireau', NULL, 'img/28.png', 10),
(29, 'Nidoran Femelle', NULL, 'img/29.png', 10),
(30, 'Nidorina', NULL, 'img/30.png', 10),
(31, 'Nidoqueen', NULL, 'img/31.png', 10),
(32, 'Nidoran Male', NULL, 'img/32.png', 10),
(33, 'Nidorino', NULL, 'img/33.png', 10),
(34, 'Nidoking', NULL, 'img/34.png', 10),
(35, 'Mélofée', NULL, 'img/35.png', 10),
(36, 'Mélodelfe', NULL, 'img/36.png', 10),
(37, 'Goupix', NULL, 'img/37.png', 10),
(38, 'Feunard', NULL, 'img/38.png', 10),
(39, 'Rondoudou', NULL, 'img/39.png', 10),
(40, 'Grodoudou', NULL, 'img/40.png', 10),
(41, 'Nosferapti', NULL, 'img/41.png', 10),
(42, 'Nosferalto', NULL, 'img/42.png', 10),
(43, 'Mystherbe', NULL, 'img/43.png', 10),
(44, 'Ortide', NULL, 'img/44.png', 10),
(45, 'Rafflesia', NULL, 'img/45.png', 10),
(46, 'Paras', NULL, 'img/46.png', 10),
(47, 'Parasect', NULL, 'img/47.png', 10),
(48, 'Mimitoss', NULL, 'img/48.png', 10),
(49, 'Aéromite', NULL, 'img/49.png', 10),
(50, 'Taupiqueur', NULL, 'img/50.png', 10),
(51, 'Triopikeur', NULL, 'img/51.png', 10),
(52, 'Miaouss', NULL, 'img/52.png', 10),
(53, 'Persian', NULL, 'img/53.png', 10),
(54, 'Psykokwak', NULL, 'img/54.png', 10),
(55, 'Akwakwak', NULL, 'img/55.png', 10),
(56, 'Férosinge', NULL, 'img/56.png', 10),
(57, 'Colossinge', NULL, 'img/57.png', 10),
(58, 'Caninos', NULL, 'img/58.png', 10),
(59, 'Arcanin', NULL, 'img/59.png', 10),
(60, 'Ptitard', NULL, 'img/60.png', 10),
(61, 'Têtarte', NULL, 'img/61.png', 10),
(62, 'Tartard', NULL, 'img/62.png', 10),
(63, 'Abra', NULL, 'img/63.png', 10),
(64, 'Kadabra', NULL, 'img/64.png', 10),
(65, 'Alakazam', NULL, 'img/65.png', 10),
(66, 'Machoc', NULL, 'img/66.png', 10),
(67, 'Machopeur', NULL, 'img/67.png', 10),
(68, 'Mackogneur', NULL, 'img/68.png', 10),
(69, 'Chétiflor', NULL, 'img/69.png', 10),
(70, 'Boustiflor', NULL, 'img/70.png', 10),
(71, 'Empiflor', NULL, 'img/71.png', 10),
(72, 'Tentacool', NULL, 'img/72.png', 10),
(73, 'Tentacruel', NULL, 'img/73.png', 10),
(74, 'Racaillou', NULL, 'img/74.png', 10),
(75, 'Gravalanch', NULL, 'img/75.png', 10),
(76, 'Grolem', NULL, 'img/76.png', 10),
(77, 'Ponyta', NULL, 'img/77.png', 10),
(78, 'Galopa', NULL, 'img/78.png', 10),
(79, 'Ramoloss', NULL, 'img/79.png', 10),
(80, 'Flagadoss', NULL, 'img/80.png', 10),
(81, 'Magnéti', NULL, 'img/81.png', 10),
(82, 'Magnéton', NULL, 'img/82.png', 10),
(83, 'Canarticho', NULL, 'img/83.png', 10),
(84, 'Doduo', NULL, 'img/84.png', 10),
(85, 'Dodrio', NULL, 'img/85.png', 10),
(86, 'Otaria', NULL, 'img/86.png', 10),
(87, 'Lamantine', NULL, 'img/87.png', 10),
(88, 'Tadmorv', NULL, 'img/88.png', 10),
(89, 'Grotadmorv', NULL, 'img/89.png', 10),
(90, 'Kokiyas', NULL, 'img/90.png', 10),
(91, 'Crustabri', NULL, 'img/91.png', 10),
(92, 'Fantominus', NULL, 'img/92.png', 10),
(93, 'Spectrum', NULL, 'img/93.png', 10),
(94, 'Ectoplasma', NULL, 'img/94.png', 10),
(95, 'Onix', NULL, 'img/95.png', 10),
(96, 'Soporifik', NULL, 'img/96.png', 10),
(97, 'Hypnomade', NULL, 'img/97.png', 10),
(98, 'Krabby', NULL, 'img/98.png', 10),
(99, 'Krabboss', NULL, 'img/99.png', 10),
(100, 'Voltorbe', NULL, 'img/100.png', 10),
(101, 'Electrode', NULL, 'img/101.png', 10),
(102, 'Noeunoeuf', NULL, 'img/102.png', 10),
(103, 'Noadkoko', NULL, 'img/103.png', 10),
(104, 'Osselait', NULL, 'img/104.png', 10),
(105, 'Ossatueur', NULL, 'img/105.png', 10),
(106, 'Kicklee', NULL, 'img/106.png', 10),
(107, 'Tygnon', NULL, 'img/107.png', 10),
(108, 'Excelangue', NULL, 'img/108.png', 10),
(109, 'Smogo', NULL, 'img/109.png', 10),
(110, 'Smogogo', NULL, 'img/110.png', 10),
(111, 'Rhinocorne', NULL, 'img/111.png', 10),
(112, 'Rhinoféros', NULL, 'img/112.png', 10),
(113, 'Leveinard', NULL, 'img/113.png', 10),
(114, 'Saquedeneu', NULL, 'img/114.png', 10),
(115, 'Kanougrex', NULL, 'img/115.png', 10),
(116, 'Hypotrempe', NULL, 'img/116.png', 10),
(117, 'Hypocéan', NULL, 'img/117.png', 10),
(118, 'Poissirène', NULL, 'img/118.png', 10),
(119, 'Poissoroy', NULL, 'img/119.png', 10),
(120, 'Stari', NULL, 'img/120.png', 10),
(121, 'Staross', NULL, 'img/121.png', 10),
(122, 'M.Mime', NULL, 'img/122.png', 10),
(123, 'Insécateur', NULL, 'img/123.png', 10),
(124, 'Lippoutou', NULL, 'img/124.png', 10),
(125, 'Elektek', NULL, 'img/125.png', 10),
(126, 'Magmar', NULL, 'img/126.png', 10),
(127, 'Scarabrute', NULL, 'img/127.png', 10),
(128, 'Tauros', NULL, 'img/128.png', 10),
(129, 'Magicarpe', NULL, 'img/129.png', 10),
(130, 'Leviator', NULL, 'img/130.png', 10),
(131, 'Lokhlass', NULL, 'img/131.png', 10),
(132, 'Métamorph', NULL, 'img/132.png', 10),
(133, 'Evoli', NULL, 'img/133.png', 10),
(134, 'Aquali', NULL, 'img/134.png', 10),
(135, 'Voltali', NULL, 'img/135.png', 10),
(136, 'Pyroli', NULL, 'img/136.png', 10),
(137, 'Porygon', NULL, 'img/137.png', 10),
(138, 'Amonita', NULL, 'img/138.png', 10),
(139, 'Amonistar', NULL, 'img/139.png', 10),
(140, 'Kabuto', NULL, 'img/140.png', 10),
(141, 'Kabutops', NULL, 'img/141.png', 10),
(142, 'Ptéra', NULL, 'img/142.png', 10),
(143, 'Ronflex', NULL, 'img/143.png', 10),
(144, 'Artikodin', NULL, 'img/144.png', 10),
(145, 'Electhor', NULL, 'img/145.png', 10),
(146, 'Sulfura', NULL, 'img/146.png', 10),
(147, 'Minidraco', NULL, 'img/147.png', 10),
(148, 'Draco', NULL, 'img/148.png', 10),
(149, 'Dracolosse', NULL, 'img/149.png', 10),
(150, 'Mewtwo', NULL, 'img/150.png', 10),
(151, 'Mew', NULL, 'img/151.png', 10);

-- --------------------------------------------------------

--
-- Structure de la table `pokemondevis`
--

CREATE TABLE `pokemondevis` (
  `deId` int(11) NOT NULL,
  `poId` int(11) NOT NULL,
  `pdQuantite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pokemondevis`
--

INSERT INTO `pokemondevis` (`deId`, `poId`, `pdQuantite`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 1),
(4, 2, 1),
(4, 3, 1),
(5, 1, 2),
(9, 2, 1),
(10, 3, 1),
(10, 4, 5),
(13, 2, 1),
(14, 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `pokemonfacture`
--

CREATE TABLE `pokemonfacture` (
  `faId` int(11) NOT NULL,
  `poId` int(11) NOT NULL,
  `pfQuantite` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pokemonfacture`
--

INSERT INTO `pokemonfacture` (`faId`, `poId`, `pfQuantite`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 1),
(4, 2, 1),
(5, 2, 1),
(6, 2, 1),
(7, 2, 1),
(8, 2, 1),
(9, 2, 1),
(10, 2, 1),
(11, 2, 1),
(12, 2, 1),
(13, 2, 1),
(14, 2, 1),
(15, 2, 1),
(16, 2, 1),
(17, 2, 1),
(18, 2, 1),
(19, 2, 1),
(20, 2, 1),
(21, 2, 1),
(22, 2, 1),
(23, 2, 1),
(24, 2, 1),
(24, 3, 1),
(25, 1, 2),
(26, 1, 1),
(27, 1, 2),
(28, 2, 1),
(29, 3, 1),
(29, 4, 5),
(30, 2, 1),
(31, 1, 13);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`deId`),
  ADD KEY `FK_estConcerne` (`peId`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`faId`),
  ADD KEY `FK_devient` (`deId`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`peId`);

--
-- Index pour la table `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`poId`);

--
-- Index pour la table `pokemondevis`
--
ALTER TABLE `pokemondevis`
  ADD PRIMARY KEY (`deId`,`poId`),
  ADD KEY `FK_associeA` (`poId`);

--
-- Index pour la table `pokemonfacture`
--
ALTER TABLE `pokemonfacture`
  ADD PRIMARY KEY (`faId`,`poId`),
  ADD KEY `FK_associeA` (`poId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `deId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `faId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `peId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `poId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
