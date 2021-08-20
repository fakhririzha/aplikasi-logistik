<?php
echo heading($judul, 3);

echo "<p>";
echo "Halaman ini adalah halaman untuk mengubah informasi akun dari <strong>Halaman <i>Forwarder</i></strong>.";
echo br();
echo "Anda dapat mengubah <i>E-Mail</i> dan <i>Password</i> dari forwarder yang anda pilih.";
echo "</p>";
echo "<hr>";

?>

<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/forwarder/edit_forwarder">
    <input type="hidden" id="inputIdForwarder" name="idForwarder" value="<?= $forwarder[0]['FORWARDER_ID'] ?>">
    <div class="control-group">
        <label class="control-label" for="inputNamaForwarder">Nama Forwarder</label>
        <div class="controls">
            <input type="text" id="inputNamaForwarder" name="namaForwarder" value="<?= $forwarder[0]['FORWARDER_NAMA'] ?>" class="input-large" required>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputEmailForwarder">E-Mail</label>
        <div class="controls">
            <input type="email" id="inputEmailForwarder" name="emailForwarder" value="<?= $forwarder[0]['FORWARDER_EMAIL'] ?>" class="input-large" required>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputPasswordForwarder">Password</label>
        <div class="controls">
            <input type="password" id="inputPasswordForwarder" name="passwordForwarder" value="<?= $forwarder[0]['FORWARDER_PASSWORD'] ?>" class="input-large" minlength="4" maxlength="16" required>
        </div>
    </div>
    <div class="control-group">
        <label for="" class="control-label">Kota Asal</label>
        <div class="controls">
            <select name="cbKotaAsal">
                <option selected value="<?= $forwarder[0]['FORWARDER_ID_KOTA_ASAL'] ?>"><?= $forwarder[0]['FORWARDER_NAMA_KOTA_ASAL'] ?></option>
                <?php
                foreach ($kota_asal_kecuali as $data) {
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
                <option selected value="<?= $forwarder[0]['FORWARDER_ID_KOTA_TUJUAN'] ?>"><?= $forwarder[0]['FORWARDER_NAMA_KOTA_TUJUAN'] ?></option>
                <?php
                foreach ($kota_tujuan_kecuali as $data) {
                    echo "<option value='" . $data['id_kota'] . "'>" . $data['nama_kota'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>