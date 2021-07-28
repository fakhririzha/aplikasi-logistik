<h3>Ubah Informasi Armada</h3>
<p>Berikut adalah informasi armada yang akan dimodifikasi: </p>
<hr>
<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/forwarder/ubah_armada_action">
    <div class="control-group">
        <label class="control-label" for="inputNamaArmada">Nama Armada</label>
        <div class="controls">
            <input type="hidden" name="idArmada" value="<?= $armada[0]['ARMADA_ID'] ?>">
            <input type="text" id="inputNamaArmada" value="<?= $armada[0]['ARMADA_NAMA'] ?>" name="namaArmada" class="input-large" required>
        </div>
    </div>
    <input type="hidden" name="forwarderId" value="<?= $this->session->userdata('FORWARDER_ID') ?>">
    <div class="control-group">
        <label class="control-label" for="inputKapasitasArmada">Kapasitas Armada (Kg)</label>
        <div class="controls">
            <input type="number" id="inputKapasitasArmada" value="<?= $armada[0]['ARMADA_KAPASITAS'] ?>" name="kapasitasArmada" class="input-large" required>
        </div>
    </div>
    <div class="control-group">
        <label for="cbKotaAsal" class="control-label">Kota Asal</label>
        <div class="controls">
            <select name="cbKotaAsal">
                <option value="<?= $armada[0]['ID_KOTA_ASAL'] ?>" default><?= $armada[0]['NAMA_KOTA_ASAL'] ?></option>
                <?php
                foreach ($kota_asal as $data) {
                    echo "<option value='" . $data['id_kota'] . "'>" . $data['nama_kota'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label for="cbKotaTujuan" class="control-label">Kota Tujuan</label>
        <div class="controls">
            <select name="cbKotaTujuan">
                <option value="<?= $armada[0]['ID_KOTA_TUJUAN'] ?>" default><?= $armada[0]['NAMA_KOTA_TUJUAN'] ?></option>
                <?php
                foreach ($kota_tujuan as $data) {
                    echo "<option value='" . $data['id_kota'] . "'>" . $data['nama_kota'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="../kelola_armada" class="btn btn-white">Kembali</a>
</form>