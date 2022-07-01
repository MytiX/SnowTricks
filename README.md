[![Codacy Badge](https://app.codacy.com/project/badge/Grade/405dd1bc0a8e4b638340a08c1da64395)](https://www.codacy.com/gh/MytiX/SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=MytiX/SnowTricks&amp;utm_campaign=Badge_Grade)

# About Snowtricks

Openclassroom's project number 6 is to make a snowboard tricks community site, coded only in PHP with the Symfony framework

# Requirements

To launch the project, you need Docker : https://docs.docker.com/get-docker/

# Get the repository

Clone repository
```
git clone https://github.com/MytiX/SnowTricks
```

# Start Application
Start all container :
```
docker-compose up -d
```
Create database :
```
docker-compose exec -u www-data www php bin/console doctrine:database:create
```
Install migration :
```
docker-compose exec -u www-data www php bin/console doctrine:migrations:migrate --no-interaction
```
Install fixtures :
```
docker-compose exec -u www-data www php bin/console doctrine:fixtures:load --no-interaction
```
## Localhost
App :
```
http://localhost:8741
```
phpMyAdmin :
```
http://localhost:8761/index.php
```
MailDev :
```
http://localhost:8751
```
## Login
Email :
```
test@test.fr
```
Password :
```
testtest
```

