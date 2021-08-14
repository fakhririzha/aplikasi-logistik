<?php
echo heading('Status Pembayaran Pengiriman', 3);
?>
<fieldset>
    <legend>Riwayat Pengiriman</legend>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Resi</th>
                <th>Biaya Pengiriman</th>
                <th>Status Pembayaran</th>
                <th>Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($status_biaya) > 0) {
                $idx = 1;
                foreach ($status_biaya as $s) {
                    echo "<tr>";
                    echo "<td>" . $idx . "</td>";
                    echo "<td>" . anchor('tracking/detil/' . $s['NO_RESI'], $s['NO_RESI'], '') . "</td>";
                    echo "<td>Rp. " . number_format(floatval($s['BIAYA_PENGIRIMAN']), 2, ",", ".") . "</td>";
                    echo "<td>" . $s['STATUS_PEMBAYARAN'] . "</td>";
                    echo "<td>";
                    echo anchor('page/bayar/' . $s['ID_PENGIRIMAN'], 'Bayar', 'class="btn btn-success"');
                    echo "</td>";
                    echo "</tr>";
                    $idx++;
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data yang bisa ditampilkan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</fieldset>