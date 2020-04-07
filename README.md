# Overview

Crovid Module adalah sebuah package pendukung untuk mendapatkan data Corona Virus \(COVID-19\) secara real-time dengan menggunakan framework Laravel.

Crovid Module mengambil seluruh data dari API publik yang disediakan oleh [Kawal Corona](https://kawalcorona.com/api). Anda dapat menggunakan API ini dengan bebas, selama tidak diperuntukkan untuk kepentingan pribadi.

# Instalasi

Untuk menginstal crovid-module kalian bisa menjalankan perintah `composer require alfanjauhari/crovid` di terminal kalian masing-masing.

# Konfigurasi

Kalian hanya perlu menambahkan `Alfanjauhari\Crovid\Facades\Crovid` di dalam file config app.php.

# Tata Cara Penggunaan

Untuk menggunakan crovid-module, kalian bisa mencari data sesuai yang kalian butuhkan dengan beberapa fungsi di bawah ini :

1. `Crovid::getGlobalData(string $options = null, array $headers = [])`
2. `Crovid::getCountriesData(string $country = null, string $options = null, array $headers = [])`
3. `Crovid::getIndonesiaData(string $options = null, array $headers = [])`
4. `Crovid::getProvinsiData(string $provinsi = null, string $options = null, array $headers = [])`

Sedikit penjelasan mengenai fungsi-fungsi di atas.
1. Parameter `$options` bisa diisi dengan salah satu opsi berikut : 'positif', 'sembuh', 'meninggal'

2. Parameter `$country` bisa diisi dengan negara yang ingin didapatkan data COVID-19. (Negara wajib menggunakan huruf kapital)

3. Parameter `$provinsi` bisa diisi dengan provinsi di Indonesia yang ingin didapatkan data COVID-19. (Wajib juga menggunakan huruf
kapital dan perhatikan juga penempatan spasi dari provinsi tersebut. Misal : <Jawa Timur> harus ditulis seperti kata tersebut.)
  
4. Parameter `$headers` bisa diisi dengan headers dari response data. Misal : `$headers = ['Access-Control-Allow-Origin' => '*']`
  
## Enjoy
