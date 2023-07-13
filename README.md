
# Basic info checker

Aplicación creada para comprobar si la información que hemos recibido en Basic-info se ha volcado correctamente a la base de datos.
Su objetivo inicial fue comprobar el TG o Managment type, pero también comprueba la descripción y si la referencia existe en producción.

## 1 En local

- Crear en local una base de datos con nombre basic-info-checker y ejecutar migraciones.

## 2 Obtener datos desde producción

- Ejecutar la siguiente consulta en la base de datos de producción: 

select dp.reference as sale_reference, dp.management_type, dp.description, bp.principal_image
from products p
inner join department_product dp On p.id = dp.product_id 
inner join brand_product bp on p.id = bp.product_id
where p.deleted_at is null
- Exportar un .csv y guardarlo en nuestro proyecto local como grability.csv en storage/app/public/
- Ejecutar el siguiente endpoint para guardar los datos en la bd local: http://127.0.0.1:8000/import-from-prod

## 3  Obtener datos desde Azure

- Descargar los basic-info que se quieren comprobar y guardarlos en la carpeta storage/app/public/basic-info
- Ejecutar el siguiente endpoint para guardar los datos en la bd local: http://127.0.0.1:8000/import-from-basic-info

## 4 Ejecutar check

- Ejecutar http://127.0.0.1:8000/check para comprobar discrepancias en tg y descripción y buscar referencias que no se han cargado en la bd
- Paciencia...


# Notas

- Las comillas en la descripción provocan una diferencia entre producción y basic-info, por lo que se deben ignorar resultados como el siguiente:

0118285700102
Descripción Basic-info: lomos de bacalao \
0118285700102
Descripción Producción: lomos de bacalao "Oro" envase 400 g

- Cuando en el resultado del check hay una referencia que no existe en producción, comprobar primero si la referencia fue dada de baja en el último día. Podría ser el mismo basic-info que estamos comprobando el que la dio de baja. 

- Al no ser en tiempo real la comprobación, los resultados pueden no ser correctos si se reciben nuevos basic-info mientras se está ejecutando la aplicación.