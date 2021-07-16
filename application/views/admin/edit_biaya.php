<?php
echo heading('Ubah Data Biaya Pengiriman', 3);
if (count($biaya) > 0) {
	foreach ($biaya as $data) {
		$id = $data['id_biaya'];
		$asal = $data['id_kota_asal'];
		$tujuan = $data['id_kota_tujuan'];
		$berat = $data['total_berat'];
		$jarak = $data['jarak'];
		$biaya = $data['biaya'];
	}
?>
<div class="well well-small">
	<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/biaya/update">
		<input type="hidden" name="txtIdBiaya" value="<?php echo $data['id_biaya']; ?>">
		<div class="control-group">
			<label class="control-label" for="inputKotaAsal">Kota Asal</label>
			<div class="controls">
				<select id="inputKotaAsal" name="cbKotaAsal" disabled>
					<option value='<?php echo $data['id_kota_asal'] ?>'><?php echo $data['nama_kota_asal'] ?></option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputKotaTujuan">Kota Tujuan</label>
			<div class="controls">
			<select id="inputKotaAsal" name="cbKotaAsal" disabled>
					<option value='<?php echo $data['id_kota_tujuan'] ?>'><?php echo $data['nama_kota_tujuan'] ?></option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputBerat">Total Berat</label>
			<div class="controls">
				<input type="number" id="inputBerat" name="txtTotalBerat" placeholder="Berat" 
					value="<?php echo $berat; ?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputBerat">Jarak (km)</label>
			<div class="controls">
				<input type="number" id="inputBerat" name="txtJarak" placeholder="Berat" 
					value="<?php echo $jarak; ?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputBiaya">Biaya Pengiriman (Rp)</label>
			<div class="controls">
				<input type="number" id="inputBiaya" name="txtBiaya" placeholder="Biaya" 
					value="<?php echo $biaya; ?>" required>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		</div>
	</form>
</div>
<?php
} else {
	echo "<div class='well well-small'>Terjadi kesalahan saat mengambil data.</div>";
}
?>