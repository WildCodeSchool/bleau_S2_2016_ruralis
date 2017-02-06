ruralis
=======

#### Pré-requis
- composer ==> https://getcomposer.org/doc/00-intro.md

#### Use
- Symfony 2.8
- Compass

#### Initialisation du projet

1. **SSH** git@github.com:WildCodeSchool/bleau_S2_2016_ruralis.git
2. **HTTPS** https://github.com/WildCodeSchool/bleau_S2_2016_ruralis.git
3. cd bleau_S2_2016_ruralis
4. composer install
5. php app/console doctrine:database:create
6. php app/console doctrine:schema:update --force
7. php app/console asset:install
8. mkdir -p web/uploads/images
9. chmod -R 777 web/uploads

A Symfony project created on November 22, 2016, 2:36 pm.


