USE ecos_arquitectura;

-- Crea la tabla de artículos del blog
CREATE TABLE blog_articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  categoria VARCHAR(50) NOT NULL,   
  fecha_publicacion DATE NULL,     
  slug VARCHAR(100) NOT NULL,            
  fecha_visible VARCHAR(50) NOT NULL,    
  resumen TEXT NOT NULL,                 
  contenido_html LONGTEXT NOT NULL,      
  imagen_portada VARCHAR(255) NOT NULL, 
  es_destacado TINYINT(1) NOT NULL DEFAULT 0 
) 

INSERT INTO blog_articulos
(titulo, categoria, fecha_publicacion, slug, fecha_visible, resumen, contenido_html, imagen_portada, es_destacado)
VALUES
-- 1. Arquitectura Sostenible 
(
  'Arquitectura Sostenible',
  'Sostenibilidad',
  '2025-09-23',
  'arquitectura-sostenible',
  '23 de Septiembre, 2025',
  'Exploramos tendencias en arquitectura sostenible y como integrar eficiencia y estetica en los proyectos.',
  '<p>Diseniar de forma sostenible no es solo una estetica: es optimizar recursos, reducir emisiones y crear edificios saludables que duren mas. La clave esta en decidir bien desde el inicio.</p>
   <h3>Estrategias simples que suman</h3>
   <ul>
     <li><strong>Implantacion y clima:</strong> orientar bien, proteger del sol y aprovechar la ventilacion cruzada.</li>
     <li><strong>Envolvente eficiente:</strong> mas aislacion donde rinde (cubierta y muros).</li>
     <li><strong>Materialidad consciente:</strong> madera certificada, hormigones de bajas emisiones, reciclados locales.</li>
     <li><strong>Agua y energia:</strong> colectores solares, luminarias LED, sanitarios eficientes y recoleccion de lluvia.</li>
     <li><strong>Operacion:</strong> facil mantenimiento, repuestos accesibles y manual de uso del edificio.</li>
   </ul>
   <blockquote>Diseniar para el futuro es asumir que eficiencia y estetica van de la mano.</blockquote>
   <h3>Que puede hacer el cliente</h3>
   <ul>
     <li>Definir prioridades (confort, consumo, huella) y presupuesto.</li>
     <li>Elegir menos materiales, pero mejores y durables.</li>
     <li>Pensar el crecimiento futuro para evitar obras repetidas.</li>
   </ul>',
  'imagenes/arquitectura_sostenible.jpg',
  1
),

-- 2. El Minimalismo
(
  'El Minimalismo',
  'Tendencias',
  '2025-09-23',
  'el-minimalismo',
  '23 de Septiembre, 2025',
  'El minimalismo arquitectonico evoluciona hacia nuevas formas que combinan simplicidad con confort.',
  '<p>El minimalismo actual es mas calido: menos objetos, mas luz, textura y confort.</p>
   <h3>Claves de 2025</h3>
   <ul>
     <li><strong>Paletas neutras</strong> con acentos naturales: madera, piedra, fibras.</li>
     <li><strong>Texturas visibles</strong>: revoques finos, textiles con trama, microcemento mate.</li>
     <li><strong>Almacenamiento oculto</strong> y muebles a medida que despejan visuales.</li>
     <li><strong>Luz protagonista</strong>: aperturas bien ubicadas y capas de iluminacion artificial.</li>
   </ul>
   <h3>Como empezar</h3>
   <ul>
     <li>Despejar superficies y agrupar funciones.</li>
     <li>Reducir la paleta a 2–3 materiales base.</li>
     <li>Invertir en una buena lampara y una pieza protagonista.</li>
   </ul>',
  'imagenes/arquitectura_minimalista.jpg',
  0
),

-- 3. Maximizando Espacios Pequenos
(
  'Maximizando Espacios Pequenos: 10 Estrategias',
  'Diseno',
  '2024-11-28',
  'maximizando-espacios-pequenos',
  '28 de Noviembre, 2024',
  'Tecnicas profesionales para que los espacios pequenos se sientan amplios y funcionales.',
  '<p>Con decisiones puntuales, un ambiente chico puede sentirse amplio, luminoso y flexible.</p>
   <ol>
     <li><strong>Espejos bien ubicados:</strong> frente a luz natural o a 45 grados para duplicar profundidad.</li>
     <li><strong>Puertas corredizas</strong> y mover tabiques cuando 60–80 cm cambian todo.</li>
     <li><strong>Muebles multifuncion:</strong> cama con cajones, mesa extensible, bancos con guardado.</li>
     <li><strong>Almacenamiento vertical:</strong> hasta techo, con modulos de 30–40 cm de fondo.</li>
     <li><strong>Paleta corta:</strong> base clara mas un acento; menos cortes visuales.</li>
     <li><strong>Pisos continuos:</strong> mismo material para unificar y agrandar.</li>
     <li><strong>Cortinas a techo:</strong> elevan visualmente la altura.</li>
     <li><strong>Iluminacion en capas:</strong> general, puntual y de ambiente.</li>
     <li><strong>Electrodomesticos compactos</strong> y ocultar cables.</li>
     <li><strong>Orden realista:</strong> cada cosa con direccion; menos, pero mejor.</li>
   </ol>',
  'imagenes/espacios_pequenos.jpg',
  0
),

-- 4. Materiales Ecologicos
(
  'Materiales Ecologicos',
  'Sostenibilidad',
  '2024-11-22',
  'materiales-ecologicos',
  '22 de Noviembre, 2024',
  'Guia introductoria sobre materiales de construccion sostenibles y su impacto.',
  '<p>No existe un material perfecto: importa el ciclo de vida, el transporte y el uso real.</p>
   <h3>Opciones a considerar</h3>
   <ul>
     <li><strong>Madera certificada</strong> con buen comportamiento termico.</li>
     <li><strong>CLT y paneles estructurales de madera</strong> para obra rapida y limpia.</li>
     <li><strong>Hormigones de bajas emisiones</strong> y cementos con adiciones.</li>
     <li><strong>Acero reciclado</strong> y perfiles reutilizables.</li>
     <li><strong>Tierra cruda</strong> (adobe y tapia) con muy baja energia incorporada.</li>
     <li><strong>Aislantes naturales</strong> de celulosa, corcho o lana.</li>
   </ul>
   <h3>Como elegir bien</h3>
   <ul>
     <li>Pedir fichas tecnicas y garantia, comparar mantenimiento.</li>
     <li>Priorizar proveedores cercanos y logistica corta.</li>
     <li>Mirar el costo total de vida util, no solo el precio inicial.</li>
   </ul>',
  'imagenes/materiales_ecologicos.jpg',
  0
);

