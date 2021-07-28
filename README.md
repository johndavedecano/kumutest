## Installation

```
git clone git@github.com:johndavedecano/kumutest.git
cd kumutest
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

### List all endponits

```
php artisan route:list
```

### Run all tests

```
php artisan test
```
