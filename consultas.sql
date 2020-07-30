/* Consulata para ver los materiles de cada bodega hija (tienes que pasar el id de la bodega hija de la cual deseas ver su lista de materiales)*/

SELECT  i.id_m_i as id, m.descr as nombre,i.s_total as stock, c.descr as categoria
FROM  material m, categorias c, inventario i
WHERE m.id_c_m = c.id_c and i.id_m_i = m.id_m and i.id_b_i = 13
