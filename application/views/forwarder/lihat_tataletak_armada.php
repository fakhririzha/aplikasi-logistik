<h3>Lihat Kiriman Belum Disusun</h3>
<p>Berikut adalah daftar pengiriman yang belum disusun pada armada <?= $armada[0]['ARMADA_NAMA'] ?>:</p>
<div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>No. Resi</th>
                <th>Kota Asal</th>
                <th>Kota Tujuan</th>
                <th>Jarak</th>
                <th>Berat Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($kiriman_blm) > 0) {
                foreach ($kiriman_blm as $x) {
                    echo "<tr>";
                    echo "<td>" . $x['ID_PENGIRIMAN'] . "</td>";
                    echo "<td>" . $x['NO_RESI'] . "</td>";
                    echo "<td>" . $x['NAMA_KOTA_ASAL'] . "</td>";
                    echo "<td>" . $x['NAMA_KOTA_TUJUAN'] . "</td>";
                    echo "<td>" . $x['JARAK'] . " km</td>";
                    echo "<td>" . intval($x['berat_total_pengiriman']) . " kg</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data yang bisa ditampilkan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- <button type="button" class="btn btn-primary">Urutkan pengiriman</button> -->
</div>
<hr>
<hr>
<h3>Lihat Kiriman Sudah Disusun</h3>
<p>Berikut adalah daftar pengiriman yg sudah disusun pada armada <?= $armada[0]['ARMADA_NAMA'] ?>:</p>
<div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>No. Resi</th>
                <th>Kota Asal</th>
                <th>Kota Tujuan</th>
                <th>Jarak</th>
                <th>Berat Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($kiriman_sdh) > 0) {
                foreach ($kiriman_sdh as $x) {
                    echo "<tr>";
                    echo "<td>" . $x['ID_PENGIRIMAN'] . "</td>";
                    echo "<td>" . $x['NO_RESI'] . "</td>";
                    echo "<td>" . $x['NAMA_KOTA_ASAL'] . "</td>";
                    echo "<td>" . $x['NAMA_KOTA_TUJUAN'] . "</td>";
                    echo "<td>" . $x['JARAK'] . " km</td>";
                    echo "<td>" . intval($x['berat_total_pengiriman']) . " kg</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data yang bisa ditampilkan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- <button type="button" class="btn btn-primary">Urutkan pengiriman</button> -->
</div>
<hr>
<hr>
<h3>Lihat Slot Barang Armada</h3>
<p>Berikut adalah daftar slot barang pada armada <?= $armada[0]['ARMADA_NAMA'] ?>:</p>
<a href="<?= base_url('index.php/forwarder/sortir_isi_armada/' . $this->uri->segment(3)) ?>" class="btn btn-primary">
    <i class="icon-play-circle icon-white"></i>&nbsp;Sortir Posisi Barang
</a>
<br>
<br>
<div>
    <table class="table table-hover table-bordered" style="border-bottom: 2px solid black; border-top: 1px solid black;">
        <thead>
            <tr>
                <th>Slot</th>
                <th>ID Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $idx = 1;
            if (count($slot) > 0) {
                foreach ($slot as $value) {
                    echo "<tr>";
                    echo "<td>" . $value['MUATAN_SLOT_ID'] . "</td>";
                    if ($value['MUATAN_PENGIRIMAN_ID'] == 0) {
                        echo "<td>Kosong</td>";
                    } else {
                        echo "<td>" . $value['MUATAN_PENGIRIMAN_ID'] . "</td>";
                    }
                    echo "</tr>";
                    $idx++;
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data yang ditampilkan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div class="pagination" style="text-align: center;">
    Page: <?php echo $paging; ?>
</div>
<hr>
<hr>