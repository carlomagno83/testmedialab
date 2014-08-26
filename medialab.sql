/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : medialab

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-08-25 21:58:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario_twitter` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('9', 'mario', 'mario', 'mario@gmail.com', '$2y$05$bWVkaWFsYWJfdGVzdGluZuKQEZfPUwrl6DihQA7FmYhEI.1lLg1Ze');
INSERT INTO `usuario` VALUES ('10', 'pedro', 'pedrito', 'pedrito@gmail.com', '$2y$05$bWVkaWFsYWJfdGVzdGluZuxCSA1eGoXsE3hHLFgP2U466lPtXKIcu');
INSERT INTO `usuario` VALUES ('11', 'carlitos', 'carlitos', 'carlitos@gmail.com', '$2y$05$bWVkaWFsYWJfdGVzdGluZuVpfTTVlYoppyzCdVFxrtLUFFL/SjDUe');
INSERT INTO `usuario` VALUES ('12', 'javier', 'javier', 'javier@gmail.com', '$2y$05$bWVkaWFsYWJfdGVzdGluZuW8wupigibblhSf5jwa3ctUqegoVoHES');
INSERT INTO `usuario` VALUES ('13', 'lolo', 'lolo', 'lolo@gmail.com', '$2y$05$bWVkaWFsYWJfdGVzdGluZu7tEkIRY9xnHDK1HNvHvjmO8z6kheEp6');
