-- Script para Debug: Verificar orden de empaque 12892-10
-- Ejecutar en tu base de datos (MySQL/MariaDB)

-- 1. Verificar que existe la orden en la tabla packings
SELECT * FROM packings WHERE num_id LIKE '%12892%10%';

-- 2. Contar materiales para esta orden
SELECT COUNT(*) as total_materials 
FROM empaque_materials em
INNER JOIN packings p ON em.packing_id = p.id
WHERE p.num_id LIKE '%12892%10%';

-- 3. Ver todos los materiales de esta orden
SELECT 
    em.id,
    em.code,
    em.description,
    em.process,
    em.required_amount,
    em.unit,
    em.stock,
    em.almacen,
    em.lot1,
    em.entrega1,
    em.entrega2,
    em.return,
    em.packing_id,
    p.num_id as order_num
FROM empaque_materials em
INNER JOIN packings p ON em.packing_id = p.id
WHERE p.num_id LIKE '%12892%10%';

-- 4. Verificar estructura de la tabla
DESCRIBE empaque_materials;
