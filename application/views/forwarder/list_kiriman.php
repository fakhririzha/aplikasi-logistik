<?php
echo heading($judul, 3);
?>
<form method="post" class="form-seacrh">
    <legend>Operasi</legend>
    <div class="input-append">
        <input type="text" placeholder="Cari data">
        <button type="submit" class="btn">
            <i class="icon-search"></i>&nbsp;Cari
        </button>
    </div>
</form>
<div>
    <table class="table table-hover" style="border-bottom: 2px solid black; border-top: 1px solid black;">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Resi</th>
                <th>No. Pengiriman</th>
                <th>Nama Pengirim</th>
                <th>Operasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $idx = 1;
            if (count($tracking) > 0) {
                foreach ($tracking as $value) {
                    echo "<tr>";
                    echo "<td>" . $idx . "</td>";
                    echo "<td>" . $value['NO_RESI'] . "</td>";
                    echo "<td>" . $value['ID_PENGIRIMAN'] . "</td>";
                    echo "<td>" . $value['NAMA_CUST'] . "</td>";
                    echo "<td>" . anchor(
                        'forwarder/detail_tracking/' . $value['NO_RESI'],
                        "<i class='icon-th-list icon-white'></i>&nbsp;Detil",
                        array('class' => 'btn btn-primary')
                    ) . "</td>";
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
    Halaman: <?php echo $paging; ?>
</div>