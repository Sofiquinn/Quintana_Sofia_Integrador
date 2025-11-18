-- Likes por artículo 
CREATE TABLE IF NOT EXISTS blog_likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  articulo_id INT NOT NULL,
  ip VARCHAR(45) NOT NULL,
  fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_like_articulo FOREIGN KEY (articulo_id)
    REFERENCES blog_articulos(id)
    ON DELETE CASCADE,
  CONSTRAINT uq_like_art_ip UNIQUE (articulo_id, ip)
) 

-- Comentarios
CREATE TABLE IF NOT EXISTS blog_comentarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  articulo_id INT NOT NULL,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150) DEFAULT NULL,
  mensaje TEXT NOT NULL,
  fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ip VARCHAR(45) DEFAULT NULL,
  aprobado TINYINT(1) NOT NULL DEFAULT 0,
  CONSTRAINT fk_com_articulo FOREIGN KEY (articulo_id)
    REFERENCES blog_articulos(id)
    ON DELETE CASCADE
)
