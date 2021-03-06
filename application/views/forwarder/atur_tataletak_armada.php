<h3>Atur Tataletak Armada</h3>
<p>Berikut adalah daftar armada yang tersedia:</p>
<!-- <form method="post" class="form-search">
    <legend>Operasi</legend>
    <div class="input-append">
        <a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">
            <i class="icon-plus-sign icon-white"></i>&nbsp;Tambah Data
        </a>
    </div>
</form> -->
<div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kapasitas</th>
                <th>Kapasitas Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($armada) > 0) {
                $idx = 1;
                foreach ($armada as $list) {
                    echo "<tr>";
                    echo "<td>" . $list['ARMADA_ID'] . "</td>";
                    echo "<td>" . $list['ARMADA_NAMA'] . "</td>";
                    echo "<td>" . $list['ARMADA_KAPASITAS'] . " kg</td>";
                    echo "<td>" . $list['ARMADA_KAPASITAS_TERSEDIA'] . " kg</td>";
                    echo "<td>";
                    echo anchor('forwarder/lihat_tataletak_armada/' . $list['ARMADA_ID'], 'Lihat Kiriman', '');
                    // echo nbs(2) . "/" . nbs(2);
                    // echo anchor('forwarder/lihat_kiriman_armada/' . $list['ARMADA_ID'], 'Lihat Kiriman', '');
                    echo "</td>";
                    echo "</tr>";
                    $idx++;
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data yang bisa ditampilkan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Modal -->
<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/forwarder/tambah_armada">
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
            <h3 id="myModalLabel">Tambah Data Armada</h3>
        </div>
        <div class="modal-body">
            <p>Silahkan isi data forwarder yang ingin ditambahkan.</p>
            <div class="control-group">
                <label class="control-label" for="inputNamaArmada">Nama Armada</label>
                <div class="controls">
                    <input type="text" id="inputNamaArmada" name="namaArmada" placeholder="Nama" class="input-large" required>
                </div>
            </div>
            <input type="hidden" name="forwarderId" value="<?= $this->session->userdata('FORWARDER_ID') ?>">
            <div class="control-group">
                <label class="control-label" for="inputKapasitasArmada">Kapasitas Armada (Kg)</label>
                <div class="controls">
                    <input type="number" id="inputKapasitasArmada" name="kapasitasArmada" placeholder="Kapasitas" class="input-large" required min="1">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputVolumeArmada">Volume Armada (PxLxT)</label>
                <div class="controls">
                    <input type="number" id="inputVolumeArmada" name="volPanjangArmada" placeholder="Panjang" class="input-large" required min="1" max="50">
                    <input type="number" id="inputVolumeArmada" name="volLebarArmada" placeholder="Lebar" class="input-large" required min="1" max="50">
                    <input type="number" id="inputVolumeArmada" name="volTinggiArmada" placeholder="Tinggi" class="input-large" required min="1" max="50">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Kota Asal</label>
                <div class="controls">
                    <select name="cbKotaAsal">
                        <?php
                        foreach ($kota as $data) {
                            echo "<option value='" . $data['id_kota'] . "'>" . $data['nama_kota'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Kota Tujuan</label>
                <div class="controls">
                    <select name="cbKotaTujuan">
                        <?php
                        foreach ($kota as $data) {
                            echo "<option value='" . $data['id_kota'] . "'>" . $data['nama_kota'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
    </div>
</form>