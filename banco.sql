CREATE DATABASE IF NOT EXISTS copa_arena
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE copa_arena;

CREATE TABLE IF NOT EXISTS jogadores (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  nickname      VARCHAR(50)  NOT NULL,
  nome_completo VARCHAR(120) NOT NULL,
  email         VARCHAR(120) NOT NULL,
  telefone      VARCHAR(20)  NOT NULL,
  discord       VARCHAR(50)  NOT NULL,
  cidade        VARCHAR(80)  NOT NULL,
  plataforma    VARCHAR(20)  NOT NULL,
  jogo          VARCHAR(30)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
