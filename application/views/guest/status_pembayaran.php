<?php
echo heading('Status Pembayaran Pengiriman', 3);
?>
<legend>Riwayat Pengiriman</legend>
<?php

if (!$this->session->userdata('error') && $this->session->userdata('message') != '') {
    echo '<div class="alert alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '<strong>' . $this->session->userdata('message') . '</strong>';
    echo '</div>';
} elseif ($this->session->userdata('error') != '') {
    echo '<div class="alert alert-error">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '<strong>' . $this->session->userdata('error') . '</strong>';
    echo '</div>';
}

?>
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
                echo "<form method='post' action='page/bayar/ " . $s['ID_PENGIRIMAN'] . "' enctype='multipart/form-data'>";
                echo "<input type='file' id='inputFoto' name='inputFoto' accept='image/*' required>";
                echo "<button type='submit' class='btn btn-success'>Bayar</button>";
                echo "</form>";
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