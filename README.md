<h1><ins>e-osmrtnice</ins></h1>

## Tech stack
- [PHP 8.3](https://www.php.net/)
- [Laravel 10](https://laravel.com/docs/10.x)
- [MySQL 8.0](https://www.mysql.com/)
- [Laravel Sail (based on Docker Compose)](https://laravel.com/docs/10.x#docker-installation-using-sail)

## Running guide
1. Laravel Sail requires you to pre-install
   - docker
   - docker-compose

2. After you make sure you have it installed, clone the repository into your local environment.
    ```
    git clone git@github.com:lresetar/eosmrtnice.git
    ```
3. Next step is to install application's Composer dependencies, including Sail. Using terminal, navigate to the application's directory
and execute the following command:
    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```
4. To run the container, navigate to the application's directory (you should already be there), and run:


    ```./vendor/bin/sail up -d```

5. Your application is available at http://127.0.0.1





