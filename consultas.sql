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
 /* Consulta para encontrar Solicitudes en un Rango de fecha Especifico*/
SELECT id_s AS id FROM solicitud_p WHERE fecha BETWEEN "2020-07-07 " AND "2020-08-07 " AND id_b_sp = 1 ORDER BY fecha ASC
 /**/
 SELECT u.nombres as nombre, u.apellidos, ot.fecha, ot.hora
 FROM orden_trabajo ot, usuarios u
 WHERE ot.resp = u.username and id_b_ot = 1 AND num_orden = 01
 /* Consulta para Encontrar los Materiales de un Despacho a partir de id despacho y el id de la bodega*/
SELECT m.id_m as id, m.descr as material, do.cant as cant
FROM orden_trabajo ot, detalle_orden do, material m
WHERE m.id_m = do.id_m_do and do.num_orden_do = ot.num_orden and ot.id_b_ot = 1 and ot.num_orden = 02

/* Consulta para Sumar la cantiddad total de materiales de un despacho*/
SELECT SUM(do.cant) as cant
FROM orden_trabajo ot, detalle_orden do, material m
WHERE m.id_m = do.id_m_do and do.num_orden_do = ot.num_orden and ot.id_b_ot = 1 and ot.num_orden = 02

 /* Consulta para encontrar Despachos en un Rango de fecha Especifico*/
SELECT num_orden AS id, id_b_ot as id_b FROM orden_trabajo WHERE fecha BETWEEN "2020-07-07 " AND "2020-08-07 " AND id_b_ot = 1 ORDER BY fecha ASC

/* Consulta Para tener todos los Traslados a partidr de un id referente a la bodega*/
SELECT t.id_t as id, t.fecha, t.hora, u.nombres as resp, b.nombre, t.t_materiales as cant, t.te_traslado as total
FROM traslados t, usuarios u, bodegas b
WHERE t.resp = u.username and t.llego_a = b.id_b and t.salio_de = 1;

/* Consulta para obtener datos de un Traslado a partir de un id traslado*/
SELECT  t.fecha, t.hora, u.nombres as resp,u.apellidos, b.nombre as bodega
FROM traslados t, usuarios u, bodegas b
WHERE t.resp = u.username and t.llego_a = b.id_b and t.id_t = 2;

/* Consulta para obtener datos del detallede un traslado a partir de un id traslado*/
SELECT m.id_m, m.descr as nomM, dt.cant, dt.p_compra, dt.total, tu.descr as tipoU
FROM traslados t, material_traslado mt, detalle_traslado dt, material m, usuarios u, tipo_usuario tu
WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.resp = u.username and u.id_tu_u = tu.id_tu and t.resp = "user" and t.id_t = 2;

/* Consulta para obtener la suma total de todos los materiales a partir de un id traslado*/
SELECT SUM(dt.total)
FROM  material_traslado mt, detalle_traslado dt, material m
WHERE dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and mt.id_t_mt = 2;

/* consulta para obtener los id a partir de un rango de fecha eh id bodega */
SELECT id_t AS id FROM traslados WHERE fecha BETWEEN ? and ? and salio_de = ? ORDER BY fecha ASC

/* Consulta para Obtener el nombre completo del usuario desde su user y la bodega en la que esta*/
SELECT u.nombres, u.apellidos
FROM usuarios u, bod_usu bu
WHERE bu.username_bu = u.username and bu.id_b_bu = 1 and u.username = "user"

/* Consulta para obtener los materiales con stock bajo de una Bodega apartir de su mismo Id*/
SELECT m.id_m as id, m.descr as nombre, c.descr as categoria, i.s_total as stock, i.s_max as maxi, i.s_min as mini
FROM inventario i, material m, categorias c
WHERE i.id_m_i = m.id_m and m.id_c_m = c.id_c  and i.s_total <= i.s_min and i.id_b_i = 1

/* Consulta para obtener el historial de orden de compra con su respectivo usuario*/
SELECT oc.id_oc as id, oc.fecha, oc.hora, u.nombres as nombre, oc.status
FROM orden_compra oc,usuarios u
WHERE  oc.resp = u.username and oc.resp = "principal"

/* Consulta para obtener el detalle de orden de compra a partir de su mismo id*/
SELECT m.id_m as id, m.descr as nomM, doc.cant, doc.recibi, doc.p_compra, doc.te_producto as total
FROM  detalle_orden_compra doc, material m
WHERE doc.id_m_do = m.id_m and doc.id_oc_do = 1

/* Consulta para obtener la suma total de los productos y el dinero de una orden de compra*/
SELECT SUM(recibi) AS cant, SUM(te_producto) AS total
FROM detalle_orden_compra
WHERE id_oc_do = 1

/* Consulta para la trazabilidad de algun material , bodegas b, orden_trabajo ot,  traslados t, */ 
SELECT m.id_m as id, m.descr as nombre, oc.fecha as fechaOrdenCompra, doc.recibi as cantResibida, em.fecha as fechaEntrada, t.fecha as fechaTraslados, s.fecha as fechaSolicitud
FROM material m ,orden_compra oc, detalle_orden_compra doc, entrada_material em, traslados t, material_traslado mt,solicitud_p s, detalle_solicitud ds
WHERE em.id_oc_em = oc.id_oc and oc.id_oc = doc.id_oc_do and doc.id_m_do = m.id_m and mt.id_t_mt = t.id_t and mt.id_m_mt = m.id_m   and ds.id_s_ds = s.id_s 

 /* Consulta para la entrada y orden de conpras dependiendo de su entrada*/
SELECT m.id_m as id, m.descr as nombre, oc.fecha as fechaOrdenCompra, doc.recibi as cantResibida, em.fecha as fechaEntrada
FROM material m ,orden_compra oc, detalle_orden_compra doc, entrada_material em
WHERE em.id_oc_em = oc.id_oc and oc.id_oc = doc.id_oc_do and doc.id_m_do = m.id_m and em.id_em = 1    and em.id_em = 1

/* Prueba realizada*/
SELECT m.id_m as id, m.descr as nombre, oc.fecha as fechaOrdenCompra, doc.recibi as cantResibida, em.fecha as fechaEntrada, t.fecha as fechaTraslados, mt.cant as cantTraslado, s.fecha as fechaSolicitud, ds.cant as cantSolicitud,ot.fecha as fechaOrdenT, do.cant as cantOrdenT
FROM material m ,orden_compra oc, detalle_orden_compra doc, entrada_material em, traslados t, material_traslado mt,solicitud_p s, detalle_solicitud ds, orden_trabajo ot, detalle_orden do
WHERE em.id_oc_em = oc.id_oc and oc.id_oc = doc.id_oc_do and doc.id_m_do = m.id_m and mt.id_t_mt = t.id_t and mt.id_m_mt = m.id_m and ds.id_s_ds = s.id_s and ds.id_m_ds = m.id_m and do.num_orden_do = ot.num_orden and do.id_m_do = m.id_m and m.id_m = 1

-- consulta para obtener los usuarios por unidad que aun no tienes una sucursal establecida
SELECT username 
FROM usuarios, tipo_usuario 
WHERE status = 1 and username NOT IN(
    SELECT username_bu 
    FROM bod_usu
) and id_tu = id_tu_u and descr = "Almacenista Por Unidad"

/* Obtenemos las sucursales hijas*/
SELECT id_b, nombre
FROM bodegas
WHERE tipo = 0;
 
  /* Consulta para saber los materiales de una bodeja hija*/
SELECT m.id_m as id, m.descr as nombre, m.serial
FROM material m, inventario i
WHERE  i.id_m_i = m.id_m and i.id_b_i = 1;

    /* Consulta trazabilidad traslado de madres a hijas mediante un rango de fechas eh id del producto deseado*/
SELECT b.nombre as realizado,dt.cant, dt.p_compra, dt.total, u.nombres as resp, t.fecha
FROM traslados t, material_traslado mt, detalle_traslado dt, material m, usuarios u, bodegas b
WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.resp = u.username  and t.salio_de = b.id_b and t.llego_a = 2  and t.fecha BETWEEN "2020-08-15 " and "2020-08-19 " and m.id_m = 001 ORDER BY t.fecha ASC 

 /* Consulta Trazabilidad Despachos mediante un rango de fechas eh id del producto deseado*/
SELECT  dt.cant as cant, u.nombres as resp, ot.fecha
FROM orden_trabajo ot, detalle_orden dt, material m, usuarios u, bodegas b
WHERE m.id_m = dt.id_m_do and dt.num_orden_do = ot.num_orden and ot.resp = u.username and ot.id_b_ot = b.id_b and ot.id_b_ot = 2 and ot.fecha BETWEEN "2020-08-15 " and "2020-08-20 " and m.id_m = 001 ORDER BY ot.fecha ASC


SELECT dt.cant, dt.p_compra, dt.total, u.nombres as resp, t.fecha, b.nombre as Destino
FROM traslados t, material_traslado mt, detalle_traslado dt, material m, usuarios u, bodegas b
WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.resp = u.username  and t.llego_a = b.id_b and t.salio_de = 2 and t.fecha BETWEEN "2020-08-15 " and "2020-08-20 " and m.id_m = 001 ORDER BY t.fecha ASC
