/* Consulata para ver los materiles de cada bodega hija (tienes que pasar el id de la bodega hija de la cual deseas ver su lista de materiales)*/

SELECT  i.id_m_i as id, m.descr as nombre,i.s_total as stock, c.descr as categoria
FROM  material m, categorias c, inventario i
WHERE m.id_c_m = c.id_c and i.id_m_i = m.id_m and i.id_b_i = 13

 /* Consulta para encontrar los datos de una bodega a partir del id de una solicitud*/
SELECT bo.nombre as nombre, bo.correo as correo, bo.tel as tel 
FROM solicitud_p  sp, bodegas  bo 
WHERE sp.id_b_sp =id_b and sp.id_s = 1  

 /* Consulta para encontrar el nombre del responsable de una solicitud a partidel del id de solicitud */
SELECT u.nombres as nombre, u.apellidos as apellido, sp.status as stauts, sp.fecha as fecha, sp.hora as hora
FROM solicitud_p  sp, usuarios u
WHERE sp.resp = u.username and sp.id_s = 1

 /* Consulta para encontrar los materiales de una solicitud a partir del id de la solicitud */
SELECT m.id_m as id, m.descr as material, ds.cant as cant
FROM solicitud_p  sp, detalle_solicitud ds, material m
WHERE m.id_m = ds.id_m_ds and sp.id_s = ds.id_s_ds and sp.id_s = 1

 /* Consulta para Sumar la cantidad total de materiales de una sola Solicitud*/
SELECT SUM(ds.cant) as cant
FROM solicitud_p  sp, detalle_solicitud ds, material m
WHERE m.id_m = ds.id_m_ds and sp.id_s = ds.id_s_ds and sp.id_s = 1

 /* Consulta para obtener el nombredel responsable de cada solicitud*/
SELECT sp.id_s as id, sp.fecha as fecha, sp.hora as hora, u.nombres as resp, sp.status 
FROM solicitud_p sp, usuarios u 
WHERE sp.resp = u.username and sp.id_b_sp = 1

SELECT id_s AS id FROM solicitud_p WHERE fecha BETWEEN "2020-07-07 " AND "2020-08-07 " AND id_b_sp = 1 ORDER BY fecha ASC 