USE ecos_arquitectura;

-- Crea la tabla de proyectos que se muestran en el sitio
CREATE TABLE proyectos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  categoria VARCHAR(50) NOT NULL,
  tipo VARCHAR(50) NOT NULL DEFAULT 'Otro',      
  tipo_slug VARCHAR(50) NOT NULL,      
  ubicacion VARCHAR(100) NOT NULL,
  superficie VARCHAR(50) NOT NULL,    
  anio INT NOT NULL,
  resumen TEXT NOT NULL,               
  descripcion_detallada TEXT NOT NULL, 
  imagen_listado VARCHAR(255) NOT NULL, 
  imagen_detalle1 VARCHAR(255) NOT NULL, 
  imagen_detalle2 VARCHAR(255) NOT NULL  
) 

INSERT INTO proyectos
(titulo, categoria, tipo_slug, ubicacion, superficie, anio, resumen,
 descripcion_detallada, imagen_listado, imagen_detalle1, imagen_detalle2)
VALUES
-- 1. Casa Moderna Minimalista
(
  'Casa Moderna Minimalista',
  'Residencial',
  'residencial',
  'Buenos Aires',
  '320m²',
  2023,
  'Diseño contemporáneo con espacios abiertos que se integran con el jardín.',
  'Diseño contemporáneo con líneas limpias, espacios abiertos y una fuerte integración con el jardín. Se priorizan visuales, luz natural y materialidad cálida.',
  'imagenes/casa.jpg',
  'imagenes/casa.jpg',
  'imagenes/casa_proyecto.jpg'
),

-- 2. Oficinas Corporativas
(
  'Oficinas Corporativas',
  'Comercial',
  'comercial',
  'Puerto Madero',
  '1200m²',
  2024,
  'Complejo de oficinas que prioriza el estilo minimalista y el bienestar.',
  'Complejo de oficinas con un enfoque minimalista, bienestar y eficiencia. Espacios flexibles, confort acústico y luminotécnico.',
  'imagenes/oficina.jpg',
  'imagenes/oficina.jpg',
  'imagenes/oficina_proyecto.jpg'
),

-- 3. Restaurante
(
  'Restaurante',
  'Comercial',
  'comercial',
  'Palermo',
  '250m²',
  2025,
  'Diseño de interior que combina tradición culinaria con arquitectura innovadora.',
  'Interiorismo que combina tradición culinaria con una arquitectura innovadora. Materiales nobles y atmósferas cálidas.',
  'imagenes/restaurante.jpg',
  'imagenes/restaurante.jpg',
  'imagenes/restaurante_proyecto.jpg'
),

-- 4. Casa del Lago
(
  'Casa del Lago',
  'Paisajismo',
  'paisajismo',
  'Recoleta',
  '1500m²',
  2023,
  'Transformación de espacio urbano en oasis verde con especies nativas y senderos.',
  'Transformación de exteriores con especies nativas, recorridos, microclimas y vistas enmarcadas hacia el agua.',
  'imagenes/casa_lago.jpg',
  'imagenes/casa_lago.jpg',
  'imagenes/casa_lago_proyecto.jpg'
),

-- 5. Hotel
(
  'Hotel',
  'Comercial',
  'comercial',
  'Córdoba',
  '600m²',
  2025,
  'Renovación completa de edificio convertido en hotel.',
  'Renovación completa de edificio preexistente, incorporando identidad local y confort contemporáneo.',
  'imagenes/hotel.jpg',
  'imagenes/hotel.jpg',
  'imagenes/hotel_proyecto.jpg'
),

-- 6. Biblioteca Pública
(
  'Biblioteca Pública',
  'Institucional',
  'institucional',
  'Mendoza',
  '400m²',
  2024,
  'Diseño de biblioteca con espacios libres para diferentes actividades educativas.',
  'Espacio educativo flexible con áreas de estudio, lectura y actividades comunitarias.',
  'imagenes/biblioteca.jpg',
  'imagenes/biblioteca.jpg',
  'imagenes/biblioteca_proyecto.jpg'
);
