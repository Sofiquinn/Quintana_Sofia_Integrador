USE ecos_arquitectura;

-- Crea la tabla de contactos del formulario de la web
CREATE TABLE contactos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre   VARCHAR(150) NOT NULL,
  email    VARCHAR(150) NOT NULL,
  telefono VARCHAR(50)  NOT NULL,
  mensaje  TEXT         NOT NULL,
  fecha_envio DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ip       VARCHAR(45) DEFAULT NULL,
  leido    TINYINT(1) NOT NULL DEFAULT 0
) 
