## Tools needed before running this project
- **[Docker](https://docs.docker.com/get-docker/)**

## Step 1 - Clone Project 
- **[HTTP](https://github.com/hunk501/laravel02.git)**
- **[SSH](git@github.com:hunk501/laravel02.git)**

## Step 2 - Setup of environment variables
Create a copy of .env.example and name it .env

Example:
cp .env.example .env


## Step 3 - Install dependecies using Laravel Sail 
- **[laravel sail](https://laravel.com/docs/9.x/sail)**

cd laravel02/

./vendor/bin/sail up


## Step 4 - Run migration
Open CLI of laravel.test image in docker, In terminal typ bash hit enter
Example output: root@733e351906c7:/var/www/html#

inside that folder you now run the migration
Example: php artisan migrate


## Step 5 - Launch application
open browser then navigate to http://localhost:8012


## for Hamming Distance
open file in the browser

./hamming_distances.html