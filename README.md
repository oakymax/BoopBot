## Подготовка системы

* git
* docker
    * [How To Install and Use Docker on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)
* docker-compose
    * [How To Install and Use Docker Compose on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04)
* для удобства работы с sail [добавить алиас](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias)
    * `alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'`

## Настройка и запуск

### Клонировать репозиторий

```bash
git clone git@github.com:oakymax/BoopBot.git
cd BoopBot
```

### Опубликовать конфиги

Для среды dev:

```bash
cp docker-compose.dev.yml docker-compose.yml
cp docker/dev.Dockerfile docker/Dockerfile
cp .env.example .env
cp .docker.env.example .docker.env  
```

Для среды prod:

```bash
cp docker-compose.prod.yml docker-compose.yml
cp docker/prod.Dockerfile docker/Dockerfile
cp .env.example .env
cp .docker.env.example .docker.env  
```

### Настроить конфиги

На что обратить внимание:
* .env
    * `APP_URL` (ручка, которая будет смотреть на внешний порт контейнера nginx)
    * `BOT_NAME` (имя бота)
    * `BOT_TOKEN` (токен бота)
    * `DB_DATABASE`
    * `DB_USERNAME`
    * `DB_PASS`
* .docker.env
    * `DB_DATABASE`
    * `DB_USERNAME`
    * `DB_PASS`
* docker/Dockerfile
    * для среды dev ID юзера sail должен совпадать с локальным `echo $UID` (по-умолчанию `1000`)
* docker-compose.yml
    * внешний порт контейнера nginx должен быть свободен (по-умолчанию `8531`)
    * для среды dev должен быть свободен также внешний порт контейнера db (по-умолчанию `65432`)

### Запустить контейнеры и выполнить setup

```bash
sail up -d
sail composer install
sail artisan migrate
sail artisan key:generate
sail artisan bot:setup
```


