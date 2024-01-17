
# Laravel API
## Requipment
- Laravel 10.x
- jwt
- mysql / mariadb
- postman
- text editor (vscode, notepad++, etc)
- php 8.2.x
## How to start
### create basic erd
buat basic dari database yang akan digunakan, contoh kasus kali ini adalah rental mobil, dimana ada 5 entitas/table di dalam aplikasi ini. yaitu: users, cars, rents, returns, penalties. 
field dari table di atas sebagai berikut:
[](url_foto)

### create api structure
api struktur dari aplikasi ini adalah sebagai berikut:

> [!NOTE]  
> Note: a1 pengganti /api, jika menggunakan router api.php, ganti url /api di app/provider/RouteServiceProvider.php.

[domain]/a1/auth/*

- login -> login mengggunakan username & password
- register -> daftar user baru
- refresh -> refresh token
- logout -> menghapus akses token

[domain]/a1/rent

[domain]/a1/return

[domain]/a1/penalties

### token jwt
Auth mengggunakan middleware di laravel, jadi kita tinggal memanfaatkan yang sudah ada, kita tak perlu menambah kode untuk memverifikasi token yang user berikan lewat header 'Authorization'.
Untuk memanipulasi ketika user memberikan token yang invalid kita bisa ubah middleware api untuk mengembalikan:
```
return abort(response()->json(["error" => "Unauthorization], 401));
```
untuk konfigurasi jwt, jangan lupa ikuti dokumentasi resmi [di sini](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)
