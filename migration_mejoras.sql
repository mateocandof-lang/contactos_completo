CREATE TABLE IF NOT EXISTS categorias (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_categorias_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categorias (id, nombre) VALUES
    (1, 'Familia'),
    (2, 'Amigos'),
    (3, 'Trabajo'),
    (4, 'Universidad'),
    (5, 'Otro')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

ALTER TABLE contactos
    ADD COLUMN id_categoria INT UNSIGNED NULL AFTER id_usuario,
    ADD COLUMN favorito TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

UPDATE contactos
SET id_categoria = (SELECT id FROM categorias WHERE nombre = 'Otro')
WHERE id_categoria IS NULL;

ALTER TABLE contactos
    MODIFY COLUMN id_categoria INT UNSIGNED NOT NULL,
    ADD KEY idx_contactos_categoria (id_categoria),
    ADD CONSTRAINT fk_contactos_categoria
        FOREIGN KEY (id_categoria) REFERENCES categorias (id);
