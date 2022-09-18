# Laravolt CRUD

## How to setup this library

### 1. Setup Laravel
https://laravel.com/docs/master

### 2. Install laravolt
https://laravolt.dev/docs/v5/installation/

### 3. Clone library
1. Dari dalam folder laravel, jalankan `git clone ssh://git@gitlab.javan.co.id:2229/alurkerja/laravolt-crud.git packages/laravolt/crud`
3. Jika butuh update library, masuk ke folder `packages/laravolt/crud` dan jalankan `git pull`
4. Jika mau berkontribusi, bisa langsung dilakukan di folder `packages/laravolt/crud`, lalu push atau MR seperti biasa.

### 4. Daftarkan PSR-4
```json
    "autoload": {
        "psr-4": {
            "Laravolt\\Crud\\": "packages/laravolt/crud/src"
        }
    },
```
Lalu jalankan `composer dump-autoload`

### Ikuti Petunjuk
Dokumentasi bisa dibaca di https://docs.google.com/document/u/2/d/1iE1O1CYWfgIqbqp5_FfYh3_ZObhR3zrI1nLDOzGBQNA
