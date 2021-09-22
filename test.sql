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

DROP VIEW view_pengiriman_sedang_diproses;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `view_pengiriman_sedang_diproses` AS SELECT
    `vid`.`ID_PENGIRIMAN` AS `ID_PENGIRIMAN`,
    `t`.`NO_RESI` AS `NO_RESI`,
    `p`.`TGL_PENGIRIMAN` AS `TGL_PENGIRIMAN`,
    `b`.`ID_BIAYA` AS `ID_BIAYA`,
    `b`.`ID_KOTA_ASAL` AS `ID_KOTA_ASAL`,
    `b`.`ID_KOTA_TUJUAN` AS `ID_KOTA_TUJUAN`,
    `k1`.`NAMA_KOTA` AS `NAMA_KOTA_ASAL`,
    `k2`.`NAMA_KOTA` AS `NAMA_KOTA_TUJUAN`,
    `b`.`JARAK` AS `JARAK`,
    `p`.`ID_ARMADA_PENGIRIMAN` AS `ID_ARMADA_PENGIRIMAN`,
    `p`.`ID_FORWARDER_PENGIRIMAN` AS `ID_FORWARDER_PENGIRIMAN`,
    `t`.`STATUS_PENGIRIMAN` AS `STATUS_PENGIRIMAN`,
    `p`.`STATUS_URUTAN` AS `STATUS_URUTAN`,
    SUM(`br`.`BERAT_BARANG`) AS `berat_total_pengiriman`
FROM
    (
        (
            (
                (
                    (
                        (
                            (
                                `view_id_pengiriman_sedang_diproses` `vid`
                            JOIN `pengiriman` `p`
                            )
                        JOIN `tracking` `t`
                        )
                    JOIN `biaya_pengiriman` `b`
                    )
                JOIN `kota` `k1`
                )
            JOIN `kota` `k2`
            )
        JOIN `detil_pengiriman` `dt`
        )
    JOIN `barang` `br`
    )
WHERE
    (
        (
            `p`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`
        ) AND ISNULL(`p`.`ID_ARMADA_PENGIRIMAN`) AND(
            `t`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`
        ) AND(`p`.`ID_BIAYA` = `b`.`ID_BIAYA`) AND(`b`.`ID_KOTA_ASAL` = `k1`.`ID_KOTA`) AND(`b`.`ID_KOTA_TUJUAN` = `k2`.`ID_KOTA`) AND(
            `p`.`ID_PENGIRIMAN` = `dt`.`ID_PENGIRIMAN`
        ) AND(`br`.`ID_BARANG` = `dt`.`ID_BARANG`) AND(`t`.`STATUS_PENGIRIMAN` != "Selesai")
    )
GROUP BY
    `vid`.`ID_PENGIRIMAN`;


DROP VIEW
    view_pengiriman_sudah_diproses;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `view_pengiriman_sudah_diproses` AS SELECT
    `vid`.`ID_PENGIRIMAN` AS `ID_PENGIRIMAN`,
    `t`.`NO_RESI` AS `NO_RESI`,
    `p`.`TGL_PENGIRIMAN` AS `TGL_PENGIRIMAN`,
    `b`.`ID_BIAYA` AS `ID_BIAYA`,
    `b`.`ID_KOTA_ASAL` AS `ID_KOTA_ASAL`,
    `b`.`ID_KOTA_TUJUAN` AS `ID_KOTA_TUJUAN`,
    `k1`.`NAMA_KOTA` AS `NAMA_KOTA_ASAL`,
    `k2`.`NAMA_KOTA` AS `NAMA_KOTA_TUJUAN`,
    `b`.`JARAK` AS `JARAK`,
    `p`.`ID_ARMADA_PENGIRIMAN` AS `ID_ARMADA_PENGIRIMAN`,
    `p`.`ID_FORWARDER_PENGIRIMAN` AS `ID_FORWARDER_PENGIRIMAN`,
    `t`.`STATUS_PENGIRIMAN` AS `STATUS_PENGIRIMAN`,
    `p`.`STATUS_URUTAN` AS `STATUS_URUTAN`,
    SUM(`br`.`BERAT_BARANG`) AS `berat_total_pengiriman`
FROM
    (
        (
            (
                (
                    (
                        (
                            (
                                `view_id_pengiriman_sedang_diproses` `vid`
                            JOIN `pengiriman` `p`
                            )
                        JOIN `tracking` `t`
                        )
                    JOIN `biaya_pengiriman` `b`
                    )
                JOIN `kota` `k1`
                )
            JOIN `kota` `k2`
            )
        JOIN `detil_pengiriman` `dt`
        )
    JOIN `barang` `br`
    )
WHERE
    (
        (`p`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`) 
        AND(`t`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`) 
        AND(`p`.`ID_BIAYA` = `b`.`ID_BIAYA`) 
        AND(`b`.`ID_KOTA_ASAL` = `k1`.`ID_KOTA`) 
        AND(`b`.`ID_KOTA_TUJUAN` = `k2`.`ID_KOTA`) 
        AND(`p`.`ID_PENGIRIMAN` = `dt`.`ID_PENGIRIMAN`) 
        AND(`br`.`ID_BARANG` = `dt`.`ID_BARANG`) 
        AND(`t`.`STATUS_PENGIRIMAN` != "Selesai")
    )
GROUP BY
    `vid`.`ID_PENGIRIMAN`;

-- ASLI DARI VIEW_PENGIRIMAN_SUDAH_DIPROSES
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `view_pengiriman_sudah_diproses` AS SELECT
    `vid`.`ID_PENGIRIMAN` AS `ID_PENGIRIMAN`,
    `t`.`NO_RESI` AS `NO_RESI`,
    `b`.`ID_BIAYA` AS `ID_BIAYA`,
    `b`.`ID_KOTA_ASAL` AS `ID_KOTA_ASAL`,
    `b`.`ID_KOTA_TUJUAN` AS `ID_KOTA_TUJUAN`,
    `k1`.`NAMA_KOTA` AS `NAMA_KOTA_ASAL`,
    `k2`.`NAMA_KOTA` AS `NAMA_KOTA_TUJUAN`,
    `b`.`JARAK` AS `JARAK`,
    `p`.`ID_ARMADA_PENGIRIMAN` AS `ID_ARMADA_PENGIRIMAN`,
    `p`.`ID_FORWARDER_PENGIRIMAN` AS `ID_FORWARDER_PENGIRIMAN`,
    `p`.`STATUS_URUTAN` AS `STATUS_URUTAN`,
    SUM(`br`.`BERAT_BARANG`) AS `berat_total_pengiriman`
FROM
    (
        (
            (
                (
                    (
                        (
                            (
                                `view_id_pengiriman_sedang_diproses` `vid`
                            JOIN `pengiriman` `p`
                            )
                        JOIN `tracking` `t`
                        )
                    JOIN `biaya_pengiriman` `b`
                    )
                JOIN `kota` `k1`
                )
            JOIN `kota` `k2`
            )
        JOIN `detil_pengiriman` `dt`
        )
    JOIN `barang` `br`
    )
WHERE
    (
        (
            `p`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`
        ) AND(
            `t`.`ID_PENGIRIMAN` = `vid`.`ID_PENGIRIMAN`
        ) AND(`p`.`ID_BIAYA` = `b`.`ID_BIAYA`) AND(`b`.`ID_KOTA_ASAL` = `k1`.`ID_KOTA`) AND(`b`.`ID_KOTA_TUJUAN` = `k2`.`ID_KOTA`) AND(
            `p`.`ID_PENGIRIMAN` = `dt`.`ID_PENGIRIMAN`
        ) AND(`br`.`ID_BARANG` = `dt`.`ID_BARANG`)
    )
GROUP BY
    `vid`.`ID_PENGIRIMAN`