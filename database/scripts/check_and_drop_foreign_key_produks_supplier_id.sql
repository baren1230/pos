-- Cek apakah foreign key 'produks_supplier_id_foreign' ada di tabel 'produks'
SELECT CONSTRAINT_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'produks'
  AND CONSTRAINT_NAME = 'produks_supplier_id_foreign';

-- Jika ada, hapus foreign key tersebut
ALTER TABLE produks DROP FOREIGN KEY produks_supplier_id_foreign;
