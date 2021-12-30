1. git clone 
2. cd test2021
3. composer install
4. bin/console doctrine:migration:migrate
5. bin/console doctrine:fixtures:load (paso opcional, carga de datos de prueba)
6. symfony server:start -d
7. https://127.0.0.1:8000/projects
8. bin/console projects:info (comando que muestra el total de proyectos y el sumatorio de sus cantidades)

Adicionalmente, para ejecutar correctamente los tests:

1. bin/console --env=test doctrine:database:create
2. bin/console --env=test doctrine:schema:create
3. bin/console doctrine:fixtures:load --env=test
