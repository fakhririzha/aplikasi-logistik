SELECT t.NO_RESI AS no_resi,
    t.ID_CUST AS id_cust,
    t.ID_PENGIRIMAN AS id_pengiriman,
    b.ID_BARANG AS id_barang,
    b.NAMA_BARANG AS nama_barang,
    b.BERAT_BARANG AS berat_barang
FROM tracking t,
    detil_pengiriman d,
    barang b
WHERE t.ID_PENGIRIMAN = d.ID_PENGIRIMAN
    AND b.ID_BARANG = d.ID_BARANG
GROUP BY d.ID_BARANG