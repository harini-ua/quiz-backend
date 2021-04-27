#Admin Panel HomeQuiz
## Introduction
TBD
## Getting started
### Requirements
* php ^7.3
* composer
* node 14
* npm 6
* Pusher
### Installation
* Clone this repository.
  ```shell
  git clone ...
  ```
* Go to folder application.
* Create environment file.
  ```shell
  cp .env.example .env
  ```
* Make sure there are important variables in the **.env** file.
  **required**
  ```dotenv
  PUSHER_APP_ID=
  PUSHER_APP_KEY=
  PUSHER_APP_SECRET=
  PUSHER_APP_CLUSTER=
  ```
* Add database connection credentials parameters in the **.env** file.
* Install framework dependencies.
  ```shell 
  php composer.phar install
  ```
* If necessary, generate a new one app key.
  ```shell
  php artisan key:generate
  ```
* Run database migration command.
  ```shell
  php artisan migrate
  ```
* Run command to seed database.
  ```shell
  php artisan db:seed
  ```
* Create the encryption keys needed to generate secure access tokens.
  ```shell
  php artisan passport:install
  ```
* Create the symbolic link.
  ```shell
  php artisan storage:link
  ```
* Install package dependencies.
  ```shell
  npm i
  ```
* Build application.
  ```shell
  npm run dev
  ```