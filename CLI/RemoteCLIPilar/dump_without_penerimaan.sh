# !/bin/bash
USER=root
PASSWORD=rf09thebye
DATABASE=db_atisisbada_2018
DB_FILE=db_atisisbada_2018.data.sql
EXCLUDED_TABLES=(
t_jurnal_aset
t_jurnal_aset_rekap
t_transaksi
t_atribusi
t_atribusi_dokumen
t_atribusi_rincian
t_atribusi_rincian_hist
t_distribusi
t_penerimaan_barang
t_penerimaan_barang_det
t_penerimaan_postbi_idbi
t_penerimaan_postbi_temp
t_penerimaan_rek_biaya
t_penerimaan_rekening
t_penerimaan_rekening_det
t_penerimaan_retensi
t_penerimaan_retensi_det
t_penerimaan_retensi_rekening
ref_dokumensumber
ref_jenis_pemeliharaan
ref_penerimaan_barang_info
ref_penerimaan_tandatangan
ref_penyedia
ref_rincian_template
ref_template
ref_templatebarang
ref_templatebarang_det
ref_program
ref_rekening
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

