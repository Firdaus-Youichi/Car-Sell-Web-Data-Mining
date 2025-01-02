import sys

# Ambil argumen dari command-line
jenis_mobil = sys.argv[1]
tahun = int(sys.argv[2])
kilometer = int(sys.argv[3])

# Logika estimasi harga (contoh sederhana)
harga_dasar = 200_000_000  # Harga dasar
penurunan_tahun = (2024 - tahun) * 10_000_000
penurunan_kilometer = (kilometer // 10_000) * 5_000_000

# Hitung estimasi harga
estimasi_harga = harga_dasar - penurunan_tahun - penurunan_kilometer

# Cetak hasil untuk dikembalikan ke PHP
print(f"Rp {estimasi_harga:,}")
