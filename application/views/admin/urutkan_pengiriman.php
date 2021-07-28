<h3>Urutkan Pengiriman</h3>
<p>Berikut adalah daftar pengiriman:</p>
<div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>No. Resi</th>
				<th>Kota Asal</th>
				<th>Kota Tujuan</th>
				<th>Jarak</th>
				<th>Berat Total</th>
				<th>Forwarder</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if (count($belum_urut) > 0) {
				$idx = 1;
				foreach ($belum_urut as $list) {
					echo "<tr>";
					echo "<td>".$list['id_pengiriman']."</td>";
					echo "<td>".$list['no_resi']."</td>";
					echo "<td>".$list['nama_kota_asal']."</td>";
					echo "<td>".$list['nama_kota_tujuan']."</td>";
					echo "<td>".$list['jarak']." km</td>";
					echo "<td>".intval($list['berat_total_pengiriman'])." kg</td>";
					echo "<form class=\"form-horizontal\" method=\"post\" action=\"".base_url()."index.php/pg_admin/pilih_forwarder_kiriman\">";
					echo "<td>";
					echo "<select name=\"idForwarder\" class=\"form-control\">";
					foreach ($forwarder as $data) {
						echo "<option value=\"". $data['FORWARDER_ID'] ."\">".$data['FORWARDER_NAMA']."</option>";
					}
					echo "</select>";
					echo "</td>";
					echo "<td>";
					echo "<button type=\"submit\" class=\"btn btn-primary\">Pilih Forwarder</button>";
					echo "</td>";
					echo "</form>";
					echo "</tr>";
					$idx++;
				}
			} else {
				echo "<tr><td colspan='6'>Tidak ada data yang bisa ditampilkan.</td></tr>";
			}
			?>
		</tbody>
	</table>
    <button type="button" class="btn btn-primary">Urutkan pengiriman</button>
</div>
<!-- Modal -->
<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/biaya/add">
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Tambah Data Biaya Pengiriman</h3>
		</div>
		<div class="modal-body">
			<p>Silahkan isi biaya pengiriman yang ingin ditambahkan.</p>
			<div class="control-group">
				<label class="control-label" for="inputKotaAsal">Kota Asal</label>
				<div class="controls">
					<select id="inputKotaAsal" name="cbKotaAsal">
						<?php
						foreach ($kota as $data) {
							echo "<option value='".$data['id_kota']."'>".$data['nama_kota']."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputKotaTujuan">Kota Tujuan</label>
				<div class="controls">
					<select id="inputKotaTujuan" name="cbKotaTujuan">
						<?php
						foreach ($kota as $data) {
							echo "<option value='".$data['id_kota']."'>".$data['nama_kota']."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputTotalBerat">Jarak</label>
				<div class="controls">
					<input type="number" id="inputTotalJarak" name="txtTotalJarak" placeholder="Jarak" class="input-small" required> Km
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputTotalBerat">Total Berat</label>
				<div class="controls">
					<input type="number" id="inputTotalBerat" name="txtTotalBerat" placeholder="Berat" class="input-small"> Kg
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputBiaya">Biaya Pengiriman</label>
				<div class="controls">
					Rp<input type="text" id="inputBiaya" name="txtBiaya" placeholder="Biaya" class="input-medium">,-
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Simpan</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		</div>
	</div>
</form>