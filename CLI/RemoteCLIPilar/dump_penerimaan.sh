# !/bin/bash
USER=root
PASSWORD=Adminkrw15
DATABASE=db_atisisbada_2019
DB_FILE=db_atisisbada_2019.penerimaan.sql
EXCLUDED_TABLES=(
buku_induk
bi_kib_a_tmp
bi_kib_b_tmp
bi_kib_c_tmp
bi_kib_d_tmp
bi_kib_e_tmp
bi_kib_f_tmp
bi_kib_g_tmp
barang_tidak_tercatat
bast_mutasi
bi_susut_tmp
buku_induk_del
buku_induk_grp
buku_induk_id
buku_induk_tes
buku_induk_thn
gantirugi
pemindahtanganan
pemeliharaan
pemusnahan_det
pemusnahan
penghapusan
penyusutan
penyusutan_log
penyusutan_koreksi
t_cek_bi
t_cek_bi_tmp
t_closing_hist
t_history
t_history_aset
t_jurnal_aset
t_jurnal_aset_rekap
t_kapitalisasi
t_kondisi
t_koreksi
t_koreksi_penyusutan
t_transaksi
kib_a
kib_b
kib_c
kib_d
kib_e
kib_f
kib_g
)
IGNORED_TABLES_STRING=''
for TABLE in "${EXCLUDED_TABLES[@]}"
do :
   IGNORED_TABLES_STRING+=" --ignore-table=${DATABASE}.${TABLE}"
done

# echo "Dump structure"
# mysqldump --user=${USER} --password=${PASSWORD} --no-data --skip-events --skip-routines --skip-triggers ${IGNORED_TABLES_STRING} ${DATABASE} > ${DB_FILE}
echo "Dump content"
mysqldump --user=${USER} --password=${PASSWORD} ${DATABASE} --complete-insert --no-create-db --no-create-info --skip-events --skip-routines --skip-triggers ${IGNORED_TABLES_STRING} >> ${DB_FILE}

