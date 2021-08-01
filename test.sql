CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `view_pengiriman_sedang_diproses` AS
select `t`.`ID_PENGIRIMAN` AS `id_pengiriman`,
    `t`.`NO_RESI` AS `no_resi`,
    `b`.`ID_BIAYA` AS `id_biaya`,
    `b`.`ID_KOTA_ASAL` AS `id_kota_asal`,
    `b`.`ID_KOTA_TUJUAN` AS `id_kota_tujuan`,
    `k1`.`NAMA_KOTA` AS `nama_kota_asal`,
    `k2`.`NAMA_KOTA` AS `nama_kota_tujuan`,
    `b`.`JARAK` AS `jarak`
from (
        (
            (
                (
                    `pengiriman` `p`
                    join `tracking` `t`
                )
                join `biaya_pengiriman` `b`
            )
            join `kota` `k1`
        )
        join `kota` `k2`
    )
where (
        (`p`.`ID_PENGIRIMAN` = `t`.`ID_PENGIRIMAN`)
        and (`p`.`ID_BIAYA` = `b`.`ID_BIAYA`)
        and (`b`.`ID_KOTA_ASAL` = `k1`.`ID_KOTA`)
        and (`b`.`ID_KOTA_TUJUAN` = `k2`.`ID_KOTA`)
    )
group by `t`.`ID_PENGIRIMAN`
having (count(`t`.`STATUS_PENGIRIMAN`) < 2);
SELECT t.ID_PENGIRIMAN AS id_pengiriman,
    t.NO_RESI AS no_resi,
    b.ID_BIAYA AS id_biaya,
    b.ID_KOTA_ASAL AS id_kota_asal,
    b.ID_KOTA_TUJUAN AS id_kota_tujuan,
    k1.NAMA_KOTA AS nama_kota_asal,
    k2.NAMA_KOTA AS nama_kota_tujuan,
    b.JARAK AS jarak,
    COUNT(t.STATUS_PENGIRIMAN) AS bacot
FROM pengiriman p,
    tracking t,
    biaya_pengiriman b,
    kota k1,
    kota k2,
    detil_pengiriman dt,
    barang br
WHERE p.ID_PENGIRIMAN = t.ID_PENGIRIMAN
    AND p.ID_BIAYA = b.ID_BIAYA
    AND b.ID_KOTA_ASAL = k1.ID_KOTA
    AND b.ID_KOTA_TUJUAN = k2.ID_KOTA
    AND p.ID_PENGIRIMAN = dt.ID_PENGIRIMAN
    AND br.ID_BARANG = dt.ID_BARANG
GROUP BY t.ID_PENGIRIMAN;
select `c`.`ID_CUST` AS `id_cust`,
    `p`.`ID_PENGIRIMAN` AS `id_pengiriman`,
    `b`.`ID_BARANG` AS `id_barang`,
    `b`.`NAMA_BARANG` AS `nama_barang`,
    `b`.`BERAT_BARANG` AS `berat_barang`
from (
        (
            (
                (
                    `pengiriman` `p`
                    join `detil_pengiriman` `d`
                )
                join `barang` `b`
            )
            join `customer` `c`
        )
        join `tracking` `t`
    )
where (
        (`p`.`ID_PENGIRIMAN` = `d`.`ID_PENGIRIMAN`)
        and (`d`.`ID_BARANG` = `b`.`ID_BARANG`)
        and (`c`.`ID_CUST` = `t`.`ID_CUST`)
        and (`t`.`ID_PENGIRIMAN` = `p`.`ID_PENGIRIMAN`)
    );