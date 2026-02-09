Bitacora de cambios importantes


-- Agregue esto en mix order 
ALTER TABLE materials
ADD COLUMN almacen FLOAT NULL AFTER stock;

-- Actualización de menu
UPDATE menus 
SET menu = 'Autorizar mezcla' 
WHERE id = 107;

-- Fechas de pesaje
ALTER TABLE mix_orders
ADD COLUMN pesaje_inicio DATETIME NULL AFTER datetime_end,
ADD COLUMN pesaje_fin DATETIME NULL AFTER pesaje_inicio;


-- 18/09/2025
DELETE FROM menus WHERE id = 107;


-- 08/09/2025
ALTER TABLE packings
  ADD COLUMN `verificacion_lote` TINYINT(1) NOT NULL DEFAULT 0 AFTER `lot_num`;

ALTER TABLE packings
  ADD COLUMN `user_verifico` VARCHAR(150) NULL AFTER `verificacion_lote`;

-- 16/10/2025
ALTER TABLE inspecciones
ADD COLUMN capacidad DECIMAL(10,2) NULL AFTER ptotal;

-- 31/10/2025
ALTER TABLE mix_orders 
ADD COLUMN user_entrega_mp VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- 22/11/2025 
ALTER TABLE mix_orders
ADD COLUMN analisis_agua JSON NULL AFTER revisiones;

-- 02/12/2025

- Crear el permiso nuevo
INSERT INTO permissions (id, name, guard_name, description, created_at, updated_at)
VALUES (
    18,
    'cap-muestreo',
    'web',
    'Capacidad destinada específicamente para el rol Muestreo',
    NOW(),
    NOW()
);

-- Crear el rol nuevo
INSERT INTO roles (id, name, guard_name, created_at, updated_at)
VALUES (13, 'Muestreo', 'web', NOW(), NOW());

-- Unir el rol con el permiso (darle ese permiso a ese rol)
INSERT INTO role_has_permissions (permission_id, role_id)
VALUES (18, 13);

-- Asignar el rol Muestreo a un usuario (Opcional)
INSERT INTO model_has_roles (role_id, model_type, model_id)
VALUES (13, 'App\\User', 5);

- Menus
INSERT INTO menus (id, menu, role_id, path, icon, parent)
SELECT 143, menu, 13, path, icon, parent FROM menus WHERE id = 100
UNION ALL
SELECT 144, menu, 13, path, icon, parent FROM menus WHERE id = 106
UNION ALL
SELECT 145, menu, 13, path, icon, parent FROM menus WHERE id = 103
UNION ALL
SELECT 146, menu, 13, path, icon, parent FROM menus WHERE id = 135;

-- Inserciones adicionales de menus 

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (147, 'Control de Agua', 11, 'admin.anagua', 'bi bi-droplet-half', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (148, 'Aprobar Pesaje', 13, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (149, 'Revisar orden Mezcla', 13, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (150, 'Aprobar Pesaje', 5, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (151, 'Aprobar Pesaje', 10, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (152, 'Revisar orden Mezcla', 10, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (153, 'Revisar orden Mezcla', 11, 'peso.approve', 'bi bi-calendar2-check', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (154, 'Granel', 11, 'admin.addgranel', 'bi bi-box', NULL);

INSERT INTO menus(id, menu, role_id, path, icon, parent)
VALUES (155, 'Granel', 10, 'admin.addgranel', 'bi bi-box', NULL);

-- Actualizaciones de menus

UPDATE menus
SET 
    icon = 'bi bi-droplet-half'
WHERE id = 105;

--14/12/2025
ALTER TABLE users ADD COLUMN rol_alternativo VARCHAR(255) NULL;


 