-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           8.4.4 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para booksystem
CREATE DATABASE IF NOT EXISTS `booksystem` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `booksystem`;

-- Copiando estrutura para tabela booksystem.assunto
CREATE TABLE IF NOT EXISTS `assunto` (
  `codAs` int NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`codAs`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela booksystem.autor
CREATE TABLE IF NOT EXISTS `autor` (
  `CodAu` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`CodAu`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela booksystem.livro
CREATE TABLE IF NOT EXISTS `livro` (
  `Codl` int NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Editora` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Edicao` int NOT NULL,
  `AnoPublicacao` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Codl`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela booksystem.livro_assunto
CREATE TABLE IF NOT EXISTS `livro_assunto` (
  `Livro_Codl` int NOT NULL,
  `Assunto_codAs` int NOT NULL,
  PRIMARY KEY (`Livro_Codl`,`Assunto_codAs`),
  KEY `IDX_2F01B7434A5AFC39` (`Livro_Codl`),
  KEY `IDX_2F01B743A5E1B302` (`Assunto_codAs`),
  CONSTRAINT `FK_2F01B7434A5AFC39` FOREIGN KEY (`Livro_Codl`) REFERENCES `livro` (`Codl`) ON DELETE CASCADE,
  CONSTRAINT `FK_2F01B743A5E1B302` FOREIGN KEY (`Assunto_codAs`) REFERENCES `assunto` (`codAs`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela booksystem.livro_autor
CREATE TABLE IF NOT EXISTS `livro_autor` (
  `Livro_Codl` int NOT NULL,
  `Autor_CodAu` int NOT NULL,
  PRIMARY KEY (`Livro_Codl`,`Autor_CodAu`),
  KEY `IDX_412939414A5AFC39` (`Livro_Codl`),
  KEY `IDX_41293941B44F3F36` (`Autor_CodAu`),
  CONSTRAINT `FK_412939414A5AFC39` FOREIGN KEY (`Livro_Codl`) REFERENCES `livro` (`Codl`) ON DELETE CASCADE,
  CONSTRAINT `FK_41293941B44F3F36` FOREIGN KEY (`Autor_CodAu`) REFERENCES `autor` (`CodAu`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
