
# Basic info checker

## 1 Obtener datos desde producción

- Ejecutar la siguiente consulta en la base de datos: 

select dp.reference as sale_reference, dp.management_type, dp.description, bp.principal_image
from products p
inner join department_product dp On p.id = dp.product_id 
inner join brand_product bp on p.id = bp.product_id
where p.deleted_at is null
- Exportar un .csv y guardarlo como grability.csv en storage/app/public/
- Ejecutar el siguiente endpoint para guardar los datos en la bd: http://127.0.0.1:8000/import-from-prod

## 2  Obtener datos desde Azure

- Descargar los basic-info que se quieren comprobar y guardarlos en la carpeta storage/app/public/basic-info
- Ejecutar el siguiente endpoint para guardar los datos en la bd: http://127.0.0.1:8000/import-from-basic-info

## 3 Ejecutar check

- Ejecutar http://127.0.0.1:8000/check para comprobar discrepancias en tg y descripción y buscar referencias que no se han cargado en la bd
- Paciencia...
