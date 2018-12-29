## Ncatalog fájl archiváló alkalmazás telepítési útmutató

A telepítéshez az alábbi lépések szükségesek:

1. `composer install` futtatásával a külső függőségek töltődnek le
2. A `config/autoload/doctrine.mysql.local.php.dist` fájlt át kell másolni a `config/autoload/doctrine.local.php` helyre és szerkesztéssel bele kell írni a csatlakozási adatokat az adatbázishoz
3. `vendor/bin/doctrine-module orm:schema-tool:create` futtatásával létrejönnek az adatbázis táblák (windows-os rendszer esetén .bat kiterjesztést a module szó után kell írni)
4. `composer fixtures-load` végrehajtásakor teszt adatokkal töltődik fel az adatbázis
