<h3>Kelola Forwarder</h3>
<p>Berikut adalah daftar forwarder yang tersedia:</p>
<form method="post" class="form-seacrh">
	<legend>Operasi</legend>
	<div class="input-append">
		<a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">
			<i class="icon-plus-sign icon-white"></i>&nbsp;Tambah Data
		</a>
	</div>
</form>
<div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nama Forwarder</th>
				<th>E-Mail Forwarder</th>
				<th>Password Forwarder</th>
				<th>Asal Forwarder</th>
				<th>Tujuan Forwarder</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (count($forwarder) > 0) {
				$idx = 1;
				foreach ($forwarder as $list) {
					echo "<tr>";
					echo "<td>" . $list['FORWARDER_ID'] . "</td>";
					echo "<td>" . $list['FORWARDER_NAMA'] . "</td>";
					echo "<td>" . $list['FORWARDER_EMAIL'] . "</td>";
					echo "<td>" . $list['FORWARDER_PASSWORD'] . "</td>";
					echo "<td>" . $list['FORWARDER_NAMA_KOTA_ASAL'] . "</td>";
					echo "<td>" . $list['FORWARDER_NAMA_KOTA_TUJUAN'] . "</td>";
					echo "<td>";
					echo anchor('forwarder/edit/' . $list['FORWARDER_ID'], 'Ubah', '');
					echo nbs(2) . "/" . nbs(2);
					echo anchor('forwarder/remove/' . $list['FORWARDER_ID'], 'Hapus', '');
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
<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/forwarder/add">
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Tambah Data Forwarder</h3>
		</div>
		<div class="modal-body">
			<p>Silahkan isi data forwarder yang ingin ditambahkan.</p>
			<div class="control-group">
				<label class="control-label" for="inputNamaForwarder">Nama Forwarder</label>
				<div class="controls">
					<input type="text" id="inputNamaForwarder" name="namaForwarder" placeholder="Nama" class="input-large" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmailForwarder">E-Mail</label>
				<div class="controls">
					<input type="email" id="inputEmailForwarder" name="emailForwarder" placeholder="E-Mail" class="input-large" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPasswordForwarder">Password</label>
				<div class="controls">
					<input type="password" id="inputPasswordForwarder" name="passwordForwarder" placeholder="Password" class="input-large" minlength="4" maxlength="16" required>
				</div>
			</div>
			<div class="control-group">
				<label for="" class="control-label">Kota Asal</label>
				<div class="controls">
					<select name="cbKotaAsal">
						<?php
						foreach ($list_kota as $data) {
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
						foreach ($list_kota as $data) {
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