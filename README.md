
Install laravel dependencies

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Create sail alias first if you haven't

```sh
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Create a .env file

```sh
cp .env.example .env
```

Run all container

```sh
sail up -d
```

Generate an application key in .env

```sh
sail artisan key:generate
```

Install node dependencies

```sh
sail yarn install
```

Run dev server

```sh
sail yarn dev
```

Run database migrations and seeders to set up the database

```sh
sail artisan migrate:fresh --seed
```

Link Storage

```sh
sail artisan storage:link
```