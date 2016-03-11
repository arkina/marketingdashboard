/*
SQLyog Community v12.2.1 (64 bit)
MySQL - 10.1.9-MariaDB : Database - runrate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`runrate` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `runrate`;

/*Table structure for table `runrate_nodes` */

DROP TABLE IF EXISTS `runrate_nodes`;

CREATE TABLE `runrate_nodes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sid` int(10) DEFAULT NULL,
  `pid` int(10) DEFAULT NULL,
  `level` decimal(10,0) DEFAULT NULL,
  `ctype` smallint(6) DEFAULT '0',
  `sumIds` text,
  `divisorId` int(10) DEFAULT NULL,
  `depth` int(2) DEFAULT '0',
  `reporttype` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;

/*Data for the table `runrate_nodes` */

insert  into `runrate_nodes`(`id`,`sid`,`pid`,`level`,`ctype`,`sumIds`,`divisorId`,`depth`,`reporttype`) values 
(1,1,0,'2',1,'2,3,4',NULL,0,0),
(2,4,1,'3',1,'5,6,7,70',NULL,1,0),
(3,5,1,'75',2,'133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150',NULL,1,0),
(4,6,1,'94',2,'164,165,166,167,168,169,170,171,172,173,174,175,176,177,178',NULL,1,0),
(5,7,2,'4',2,'8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24',NULL,2,0),
(6,8,2,'22',2,'39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55',NULL,2,0),
(7,9,2,'40',2,'71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87',NULL,2,0),
(8,11,5,'5',0,NULL,NULL,3,0),
(9,12,5,'6',0,NULL,NULL,3,0),
(10,13,5,'7',0,NULL,NULL,3,0),
(11,14,5,'8',0,NULL,NULL,3,0),
(12,15,5,'9',0,NULL,NULL,3,0),
(13,16,5,'10',0,NULL,NULL,3,0),
(14,17,5,'11',0,NULL,NULL,3,0),
(15,18,5,'12',0,NULL,NULL,3,0),
(16,19,5,'13',0,NULL,NULL,3,0),
(17,20,5,'14',0,NULL,NULL,3,0),
(18,21,5,'15',0,NULL,NULL,3,0),
(19,22,5,'16',0,NULL,NULL,3,0),
(20,23,5,'17',0,NULL,NULL,3,0),
(21,24,5,'18',0,NULL,NULL,3,0),
(22,25,5,'19',0,NULL,NULL,3,0),
(23,26,5,'20',0,NULL,NULL,3,0),
(24,27,5,'21',0,NULL,NULL,3,0),
(39,11,6,'23',0,NULL,NULL,3,0),
(40,12,6,'24',0,NULL,NULL,3,0),
(41,13,6,'25',0,NULL,NULL,3,0),
(42,14,6,'26',0,NULL,NULL,3,0),
(43,15,6,'27',0,NULL,NULL,3,0),
(44,16,6,'28',0,NULL,NULL,3,0),
(45,17,6,'29',0,NULL,NULL,3,0),
(46,18,6,'30',0,NULL,NULL,3,0),
(47,19,6,'31',0,NULL,NULL,3,0),
(48,20,6,'32',0,NULL,NULL,3,0),
(49,21,6,'33',0,NULL,NULL,3,0),
(50,22,6,'34',0,NULL,NULL,3,0),
(51,23,6,'35',0,NULL,NULL,3,0),
(52,24,6,'36',0,NULL,NULL,3,0),
(53,25,6,'37',0,NULL,NULL,3,0),
(54,26,6,'38',0,NULL,NULL,3,0),
(55,27,6,'39',0,NULL,NULL,3,0),
(70,10,2,'58',2,'102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117',NULL,2,0),
(71,11,7,'41',0,NULL,NULL,3,0),
(72,12,7,'42',0,NULL,NULL,3,0),
(73,13,7,'43',0,NULL,NULL,3,0),
(74,14,7,'44',0,NULL,NULL,3,0),
(75,15,7,'45',0,NULL,NULL,3,0),
(76,16,7,'46',0,NULL,NULL,3,0),
(77,17,7,'47',0,NULL,NULL,3,0),
(78,18,7,'48',0,NULL,NULL,3,0),
(79,19,7,'49',0,NULL,NULL,3,0),
(80,20,7,'50',0,NULL,NULL,3,0),
(81,21,7,'51',0,NULL,NULL,3,0),
(82,22,7,'52',0,NULL,NULL,3,0),
(83,23,7,'53',0,NULL,NULL,3,0),
(84,24,7,'54',0,NULL,NULL,3,0),
(85,25,7,'55',0,NULL,NULL,3,0),
(86,26,7,'56',0,NULL,NULL,3,0),
(87,27,7,'57',0,NULL,NULL,3,0),
(102,11,70,'59',0,NULL,NULL,3,0),
(103,12,70,'60',0,NULL,NULL,3,0),
(104,13,70,'61',0,NULL,NULL,3,0),
(105,14,70,'62',0,NULL,NULL,3,0),
(106,15,70,'63',0,NULL,NULL,3,0),
(107,16,70,'64',0,NULL,NULL,3,0),
(108,17,70,'65',0,NULL,NULL,3,0),
(109,18,70,'66',0,NULL,NULL,3,0),
(110,19,70,'67',0,NULL,NULL,3,0),
(111,20,70,'68',0,NULL,NULL,3,0),
(112,21,70,'69',0,NULL,NULL,3,0),
(113,22,70,'70',0,NULL,NULL,3,0),
(114,23,70,'71',0,NULL,NULL,3,0),
(115,24,70,'72',0,NULL,NULL,3,0),
(116,26,70,'73',0,NULL,NULL,3,0),
(117,27,70,'74',0,NULL,NULL,3,0),
(133,12,3,'76',0,NULL,NULL,3,0),
(134,13,3,'77',0,NULL,NULL,3,0),
(135,14,3,'78',0,NULL,NULL,3,0),
(136,15,3,'79',0,NULL,NULL,3,0),
(137,16,3,'80',0,NULL,NULL,3,0),
(138,17,3,'81',0,NULL,NULL,3,0),
(139,18,3,'82',0,NULL,NULL,3,0),
(140,19,3,'83',0,NULL,NULL,3,0),
(141,20,3,'84',0,NULL,NULL,3,0),
(142,21,3,'85',0,NULL,NULL,3,0),
(143,22,3,'86',0,NULL,NULL,3,0),
(144,23,3,'87',0,NULL,NULL,3,0),
(145,24,3,'88',0,NULL,NULL,3,0),
(146,26,3,'89',0,NULL,NULL,3,0),
(147,27,3,'90',0,NULL,NULL,3,0),
(148,28,3,'91',0,NULL,NULL,3,0),
(149,29,3,'92',0,NULL,NULL,3,0),
(150,30,3,'93',0,NULL,NULL,3,0),
(164,11,4,'95',0,NULL,NULL,3,0),
(165,12,4,'96',0,NULL,NULL,3,0),
(166,13,4,'97',0,NULL,NULL,3,0),
(167,14,4,'98',0,NULL,NULL,3,0),
(168,15,4,'99',0,NULL,NULL,3,0),
(169,16,4,'100',0,NULL,NULL,3,0),
(170,17,4,'101',0,NULL,NULL,3,0),
(171,18,4,'102',0,NULL,NULL,3,0),
(172,19,4,'103',0,NULL,NULL,3,0),
(173,20,4,'104',0,NULL,NULL,3,0),
(174,22,4,'105',0,NULL,NULL,3,0),
(175,23,4,'106',0,NULL,NULL,3,0),
(176,24,4,'107',0,NULL,NULL,3,0),
(177,27,4,'108',0,NULL,NULL,3,0),
(178,31,4,'109',0,NULL,NULL,3,0),
(179,2,0,'110',2,'180,181',NULL,0,0),
(180,32,179,'111',0,NULL,NULL,3,0),
(181,33,179,'112',0,NULL,NULL,3,0),
(182,3,0,'113',2,'183,184,185,186,187,188',NULL,0,0),
(183,34,182,'114',0,NULL,NULL,3,0),
(184,35,182,'115',0,NULL,NULL,3,0),
(185,36,182,'116',0,NULL,NULL,3,0),
(186,37,182,'117',0,NULL,NULL,3,0),
(187,38,182,'118',0,NULL,NULL,3,0),
(188,39,182,'119',0,NULL,NULL,3,0),
(189,4,0,'123',2,'190,191,192',NULL,0,1),
(190,40,189,'124',0,NULL,NULL,3,1),
(191,41,189,'125',0,NULL,NULL,3,1),
(192,42,189,'126',0,NULL,NULL,3,1),
(193,5,0,'127',0,NULL,NULL,0,1),
(194,43,0,'128',0,NULL,NULL,0,1),
(195,44,194,'129',2,'193,194',NULL,3,1),
(196,45,0,'130',0,NULL,NULL,0,1),
(197,46,0,'133',2,NULL,NULL,0,2),
(198,47,197,'134',0,NULL,NULL,3,2),
(199,48,197,'135',0,NULL,NULL,3,2),
(200,49,197,'136',0,NULL,NULL,3,2),
(201,50,0,'137',0,NULL,NULL,0,2),
(202,45,0,'138',0,NULL,NULL,0,2);

/*Table structure for table `runrate_revenues` */

DROP TABLE IF EXISTS `runrate_revenues`;

CREATE TABLE `runrate_revenues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nid` int(10) DEFAULT NULL,
  `janRev` varchar(255) DEFAULT '0',
  `janBud` varchar(255) DEFAULT '0',
  `janVar` varchar(255) DEFAULT '0',
  `janPer` varchar(255) DEFAULT '0',
  `febRev` varchar(255) DEFAULT '0',
  `febBud` varchar(255) DEFAULT '0',
  `febVar` varchar(255) DEFAULT '0',
  `febPer` varchar(255) DEFAULT '0',
  `marRev` varchar(255) DEFAULT '0',
  `marBud` varchar(255) DEFAULT '0',
  `marVar` varchar(255) DEFAULT '0',
  `marPer` varchar(255) DEFAULT '0',
  `aprRev` varchar(255) DEFAULT '0',
  `aprBud` varchar(255) DEFAULT '0',
  `aprVar` varchar(255) DEFAULT '0',
  `aprPer` varchar(255) DEFAULT '0',
  `mayRev` varchar(255) DEFAULT '0',
  `mayBud` varchar(255) DEFAULT '0',
  `mayVar` varchar(255) DEFAULT '0',
  `mayPer` varchar(255) DEFAULT '0',
  `junRev` varchar(255) DEFAULT '0',
  `junBud` varchar(255) DEFAULT '0',
  `junVar` varchar(255) DEFAULT '0',
  `junPer` varchar(255) DEFAULT '0',
  `julRev` varchar(255) DEFAULT '0',
  `julBud` varchar(255) DEFAULT '0',
  `julVar` varchar(255) DEFAULT '0',
  `julPer` varchar(255) DEFAULT '0',
  `augRev` varchar(255) DEFAULT '0',
  `augBud` varchar(255) DEFAULT '0',
  `augVar` varchar(255) DEFAULT '0',
  `augPer` varchar(255) DEFAULT '0',
  `sepRev` varchar(255) DEFAULT '0',
  `sepBud` varchar(255) DEFAULT '0',
  `sepVar` varchar(255) DEFAULT '0',
  `sepPer` varchar(255) DEFAULT '0',
  `octRev` varchar(225) DEFAULT '0',
  `octBud` varchar(255) DEFAULT '0',
  `octVar` varchar(255) DEFAULT '0',
  `octPer` varchar(255) DEFAULT '0',
  `novRev` varchar(255) DEFAULT '0',
  `novBud` varchar(255) DEFAULT '0',
  `novVar` varchar(255) DEFAULT '0',
  `novPer` varchar(255) DEFAULT '0',
  `decRev` varchar(255) DEFAULT '0',
  `decBud` varchar(255) DEFAULT '0',
  `decVar` varchar(255) DEFAULT '0',
  `decPer` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `service_id` (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

/*Data for the table `runrate_revenues` */

insert  into `runrate_revenues`(`id`,`nid`,`janRev`,`janBud`,`janVar`,`janPer`,`febRev`,`febBud`,`febVar`,`febPer`,`marRev`,`marBud`,`marVar`,`marPer`,`aprRev`,`aprBud`,`aprVar`,`aprPer`,`mayRev`,`mayBud`,`mayVar`,`mayPer`,`junRev`,`junBud`,`junVar`,`junPer`,`julRev`,`julBud`,`julVar`,`julPer`,`augRev`,`augBud`,`augVar`,`augPer`,`sepRev`,`sepBud`,`sepVar`,`sepPer`,`octRev`,`octBud`,`octVar`,`octPer`,`novRev`,`novBud`,`novVar`,`novPer`,`decRev`,`decBud`,`decVar`,`decPer`) values 
(1,8,'0','2000','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(2,9,'0','0','0','0','0','500','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(3,10,'0','0','0','0','0','0','0','0','0','1000','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(4,11,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(5,12,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(6,13,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(7,14,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(8,15,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(9,16,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(10,17,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(11,18,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(12,19,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(13,20,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(14,21,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(15,22,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(16,23,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(17,24,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(18,39,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(19,40,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(20,41,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(21,42,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(22,43,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(23,44,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(24,45,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(25,46,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(26,47,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(27,48,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(28,49,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(29,50,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(30,51,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(31,52,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(32,53,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(33,54,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(34,55,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(35,71,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(36,72,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(37,73,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(38,74,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(39,75,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(40,76,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(41,77,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(42,78,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(43,79,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(44,80,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(45,81,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(46,82,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(47,83,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(48,84,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(49,85,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(50,86,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(51,87,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(52,102,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(53,103,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(54,104,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(55,105,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(56,106,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(57,107,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(58,108,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(59,109,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(60,110,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(61,111,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(62,112,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(63,113,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(64,114,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(65,115,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(66,116,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(67,117,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(68,133,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(69,134,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(70,135,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(71,136,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(72,137,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(73,138,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(74,139,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(75,140,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(76,141,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(77,142,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(78,143,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(79,144,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(80,145,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(81,146,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(82,147,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(83,148,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(84,149,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(85,150,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(86,164,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(87,165,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(88,166,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(89,167,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(90,168,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(91,169,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(92,170,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(93,171,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(94,172,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(95,173,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(96,174,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(97,175,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(98,176,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(99,177,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(100,178,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(101,180,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(102,181,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(103,183,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(104,184,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(105,185,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(106,186,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(107,187,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(108,188,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(109,190,'0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(110,191,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(111,192,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(112,193,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(113,194,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(114,196,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(115,198,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(116,199,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(117,200,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(118,201,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),
(119,202,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');

/*Table structure for table `runrate_services` */

DROP TABLE IF EXISTS `runrate_services`;

CREATE TABLE `runrate_services` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Data for the table `runrate_services` */

insert  into `runrate_services`(`id`,`name`) values 
(1,'Issuer Revenues:'),
(2,'Merch Acqui:'),
(3,'Other Revenues:'),
(4,'Powerpay+ Subs'),
(5,'Regular Subs'),
(6,'Partners'),
(7,'Payroll'),
(8,'Loans'),
(9,'Allowance'),
(10,'Xpress / Grassroots'),
(11,'Funds Disbursement'),
(12,'Cash In'),
(13,'Cash Out'),
(14,'ATM Withdraw'),
(15,'G2L'),
(16,'P2P'),
(17,'CPU'),
(18,'Bill Pay'),
(19,'Web Payments'),
(20,'Lotto Ticketing'),
(21,'MC/Megalink POS & Online'),
(22,'Card Issuance'),
(23,'AMEX Purchase'),
(24,'Load2Others'),
(25,'BanKo Loan Collections'),
(26,'Dormancy'),
(27,'Others'),
(28,'AMEX Subscription'),
(29,'GCASH 2 Sancus'),
(30,'GCASH 2 Starbucks'),
(31,'F2F Payments'),
(32,'MPOS'),
(33,'IPG'),
(34,'Remittance'),
(35,'Government'),
(36,'Banko'),
(37,'Mobile Banking'),
(38,'Interest'),
(39,'Other Non-Core'),
(40,'PAYROLL Acquisitions'),
(41,'LOANS Acquisitions'),
(42,'ALLOWANCE Acquisitions'),
(43,'NORMANDY Acquisitions'),
(44,'Non-Normandy Activations'),
(45,'GLOBE CHARGE Dongles'),
(46,'POWERPAY+'),
(47,'PAYROLL Active Subs'),
(48,'LOANS Active Subs'),
(49,'ALLOWANCE Active Subs'),
(50,'REGULAR Active Subs');

/*Table structure for table `acqui_view` */

DROP TABLE IF EXISTS `acqui_view`;

/*!50001 DROP VIEW IF EXISTS `acqui_view` */;
/*!50001 DROP TABLE IF EXISTS `acqui_view` */;

/*!50001 CREATE TABLE  `acqui_view`(
 `level` decimal(10,0) ,
 `depth` int(2) ,
 `ctype` smallint(6) ,
 `id` int(10) ,
 `pid` int(10) ,
 `name` varchar(255) ,
 `sumIds` text ,
 `divisorId` int(10) ,
 `janRev` varchar(255) ,
 `febRev` varchar(255) ,
 `marRev` varchar(255) ,
 `aprRev` varchar(255) ,
 `mayRev` varchar(255) ,
 `junRev` varchar(255) ,
 `julRev` varchar(255) ,
 `augRev` varchar(255) ,
 `sepRev` varchar(255) ,
 `octRev` varchar(225) ,
 `novRev` varchar(255) ,
 `decRev` varchar(255) ,
 `janBud` varchar(255) ,
 `febBud` varchar(255) ,
 `marBud` varchar(255) ,
 `aprBud` varchar(255) ,
 `mayBud` varchar(255) ,
 `junBud` varchar(255) ,
 `julBud` varchar(255) ,
 `augBud` varchar(255) ,
 `sepBud` varchar(255) ,
 `octBud` varchar(255) ,
 `novBud` varchar(255) ,
 `decBud` varchar(255) 
)*/;

/*Table structure for table `runrate_view` */

DROP TABLE IF EXISTS `runrate_view`;

/*!50001 DROP VIEW IF EXISTS `runrate_view` */;
/*!50001 DROP TABLE IF EXISTS `runrate_view` */;

/*!50001 CREATE TABLE  `runrate_view`(
 `level` decimal(10,0) ,
 `depth` int(2) ,
 `ctype` smallint(6) ,
 `id` int(10) ,
 `pid` int(10) ,
 `name` varchar(255) ,
 `sumIds` text ,
 `divisorId` int(10) ,
 `janRev` varchar(255) ,
 `febRev` varchar(255) ,
 `marRev` varchar(255) ,
 `aprRev` varchar(255) ,
 `mayRev` varchar(255) ,
 `junRev` varchar(255) ,
 `julRev` varchar(255) ,
 `augRev` varchar(255) ,
 `sepRev` varchar(255) ,
 `octRev` varchar(225) ,
 `novRev` varchar(255) ,
 `decRev` varchar(255) ,
 `janBud` varchar(255) ,
 `febBud` varchar(255) ,
 `marBud` varchar(255) ,
 `aprBud` varchar(255) ,
 `mayBud` varchar(255) ,
 `junBud` varchar(255) ,
 `julBud` varchar(255) ,
 `augBud` varchar(255) ,
 `sepBud` varchar(255) ,
 `octBud` varchar(255) ,
 `novBud` varchar(255) ,
 `decBud` varchar(255) 
)*/;

/*View structure for view acqui_view */

/*!50001 DROP TABLE IF EXISTS `acqui_view` */;
/*!50001 DROP VIEW IF EXISTS `acqui_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acqui_view` AS (select `a`.`level` AS `level`,`a`.`depth` AS `depth`,`a`.`ctype` AS `ctype`,`a`.`id` AS `id`,`a`.`pid` AS `pid`,`b`.`name` AS `name`,`a`.`sumIds` AS `sumIds`,`a`.`divisorId` AS `divisorId`,`c`.`janRev` AS `janRev`,`c`.`febRev` AS `febRev`,`c`.`marRev` AS `marRev`,`c`.`aprRev` AS `aprRev`,`c`.`mayRev` AS `mayRev`,`c`.`junRev` AS `junRev`,`c`.`julRev` AS `julRev`,`c`.`augRev` AS `augRev`,`c`.`sepRev` AS `sepRev`,`c`.`octRev` AS `octRev`,`c`.`novRev` AS `novRev`,`c`.`decRev` AS `decRev`,`c`.`janBud` AS `janBud`,`c`.`febBud` AS `febBud`,`c`.`marBud` AS `marBud`,`c`.`aprBud` AS `aprBud`,`c`.`mayBud` AS `mayBud`,`c`.`junBud` AS `junBud`,`c`.`julBud` AS `julBud`,`c`.`augBud` AS `augBud`,`c`.`sepBud` AS `sepBud`,`c`.`octBud` AS `octBud`,`c`.`novBud` AS `novBud`,`c`.`decBud` AS `decBud` from ((`runrate_nodes` `a` join `runrate_services` `b` on((`a`.`sid` = `b`.`id`))) left join `runrate_revenues` `c` on((`a`.`id` = `c`.`nid`))) where (`a`.`reporttype` = 1) order by `a`.`level`) */;

/*View structure for view runrate_view */

/*!50001 DROP TABLE IF EXISTS `runrate_view` */;
/*!50001 DROP VIEW IF EXISTS `runrate_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `runrate_view` AS (select `a`.`level` AS `level`,`a`.`depth` AS `depth`,`a`.`ctype` AS `ctype`,`a`.`id` AS `id`,`a`.`pid` AS `pid`,`b`.`name` AS `name`,`a`.`sumIds` AS `sumIds`,`a`.`divisorId` AS `divisorId`,`c`.`janRev` AS `janRev`,`c`.`febRev` AS `febRev`,`c`.`marRev` AS `marRev`,`c`.`aprRev` AS `aprRev`,`c`.`mayRev` AS `mayRev`,`c`.`junRev` AS `junRev`,`c`.`julRev` AS `julRev`,`c`.`augRev` AS `augRev`,`c`.`sepRev` AS `sepRev`,`c`.`octRev` AS `octRev`,`c`.`novRev` AS `novRev`,`c`.`decRev` AS `decRev`,`c`.`janBud` AS `janBud`,`c`.`febBud` AS `febBud`,`c`.`marBud` AS `marBud`,`c`.`aprBud` AS `aprBud`,`c`.`mayBud` AS `mayBud`,`c`.`junBud` AS `junBud`,`c`.`julBud` AS `julBud`,`c`.`augBud` AS `augBud`,`c`.`sepBud` AS `sepBud`,`c`.`octBud` AS `octBud`,`c`.`novBud` AS `novBud`,`c`.`decBud` AS `decBud` from ((`runrate_nodes` `a` join `runrate_services` `b` on((`a`.`sid` = `b`.`id`))) left join `runrate_revenues` `c` on((`a`.`id` = `c`.`nid`))) where (`a`.`reporttype` = 0) order by `a`.`level`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
