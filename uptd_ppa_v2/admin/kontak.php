<?php
require_once __DIR__.'/../includes/config.php';
require_once 'auth.php';
$admin_page='kontak'; $page_title='Kelola Kontak Darurat';
$action=$_GET['action']??'list'; $edit_id=isset($_GET['id'])?(int)$_GET['id']:0;
$msg=''; $msg_type='';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $nama=trim($_POST['nama']??''); $nomor=trim($_POST['nomor']??'');
  $keterangan=trim($_POST['keterangan']??''); $is_utama=isset($_POST['is_utama'])?1:0;
  $urutan=(int)($_POST['urutan']??1); $aktif=isset($_POST['aktif'])?1:0;
  $post_id=(int)($_POST['edit_id']??0);
  if($nama===''||$nomor===''){$msg='Nama dan nomor tidak boleh kosong.';$msg_type='error';}
  else{
    try{
      if($post_id>0) $pdo->prepare("UPDATE kontak_darurat SET nama=?,nomor=?,keterangan=?,is_utama=?,urutan=?,aktif=? WHERE id=?")->execute([$nama,$nomor,$keterangan?:null,$is_utama,$urutan,$aktif,$post_id]);
      else $pdo->prepare("INSERT INTO kontak_darurat(nama,nomor,keterangan,is_utama,urutan,aktif) VALUES(?,?,?,?,?,?)")->execute([$nama,$nomor,$keterangan?:null,$is_utama,$urutan,$aktif]);
      $msg=$post_id>0?'Kontak berhasil diperbarui.':'Kontak baru berhasil ditambahkan.'; $msg_type='success'; $action='list';
    }catch(Exception $e){$msg='Kesalahan saat menyimpan.';$msg_type='error';}
  }
}
if(isset($_GET['delete'])&&(int)$_GET['delete']>0){
  try{$pdo->prepare("DELETE FROM kontak_darurat WHERE id=?")->execute([(int)$_GET['delete']]);$msg='Kontak berhasil dihapus.';$msg_type='success';}
  catch(Exception $e){$msg='Gagal menghapus.';$msg_type='error';} $action='list';
}

$rows=[]; $edit_row=null;
try{
  if($action==='list') $rows=$pdo->query("SELECT * FROM kontak_darurat ORDER BY urutan ASC")->fetchAll();
  elseif($action==='edit'&&$edit_id>0){$s=$pdo->prepare("SELECT * FROM kontak_darurat WHERE id=?");$s->execute([$edit_id]);$edit_row=$s->fetch();if(!$edit_row)$action='list';}
}catch(Exception $e){}

include 'admin_layout.php';
?>
<?php if($msg): ?><div class="alert-<?php echo $msg_type; ?>"><?php echo $msg_type==='success'?'✅':'⚠️'; ?> <?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<?php if($action==='list'): ?>
<div class="crud-header"><h2>📞 Kontak Darurat</h2><a href="kontak.php?action=add" class="btn-add">+ Tambah Kontak</a></div>
<div class="info-note">💡 Kontak yang ditandai <strong>Urgent (is_utama)</strong> akan ditampilkan dengan warna merah di modal darurat.</div>
<div class="crud-table-wrap"><table class="crud-table">
  <thead><tr><th>#</th><th>Nama Layanan</th><th>Nomor Telepon</th><th>Keterangan</th><th style="text-align:center;">Prioritas</th><th style="text-align:center;">Status</th><th style="text-align:center;">Aksi</th></tr></thead>
  <tbody>
    <?php foreach($rows as $i=>$r): ?>
    <tr>
      <td><?php echo $i+1; ?></td>
      <td><strong><?php echo htmlspecialchars($r['nama']); ?></strong></td>
      <td style="font-family:monospace;color:var(--grey-900);"><?php echo htmlspecialchars($r['nomor']); ?></td>
      <td style="color:var(--text-light);font-size:13px;"><?php echo htmlspecialchars($r['keterangan']??'-'); ?></td>
      <td style="text-align:center;"><?php if($r['is_utama']): ?><span class="badge badge-urgent">🚨 Urgent</span><?php else: ?>—<?php endif; ?></td>
      <td style="text-align:center;"><span class="badge badge-<?php echo $r['aktif']?'aktif':'nonaktif'; ?>"><?php echo $r['aktif']?'Aktif':'Nonaktif'; ?></span></td>
      <td><div class="td-actions">
        <a href="kontak.php?action=edit&id=<?php echo $r['id']; ?>" class="btn-edit">✏️ Edit</a>
        <a href="kontak.php?delete=<?php echo $r['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus kontak ini?');">🗑️ Hapus</a>
      </div></td>
    </tr>
    <?php endforeach; ?>
    <?php if(empty($rows)): ?><tr><td colspan="7" style="text-align:center;color:var(--text-light);padding:22px;">Belum ada kontak darurat.</td></tr><?php endif; ?>
  </tbody>
</table></div>

<?php else:
  $d=$edit_row??['nama'=>'','nomor'=>'','keterangan'=>'','is_utama'=>0,'urutan'=>1,'aktif'=>1];
  $is_edit=($action==='edit'&&$edit_row);
?>
<div class="crud-header"><h2><?php echo $is_edit?'✏️ Edit':'➕ Tambah'; ?> Kontak Darurat</h2><a href="kontak.php" class="btn-cancel">← Kembali</a></div>
<div class="form-wrap"><form method="POST">
  <?php if($is_edit): ?><input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>"><?php endif; ?>
  <div class="form-row">
    <div class="form-group"><label>Nama Layanan *</label><input type="text" name="nama" value="<?php echo htmlspecialchars($d['nama']); ?>" placeholder="Misal: UPTD PPA, Polisi 110" required></div>
    <div class="form-group"><label>Nomor Telepon *</label><input type="text" name="nomor" value="<?php echo htmlspecialchars($d['nomor']); ?>" placeholder="021-12345678 atau 0811-2345-6789" required></div>
  </div>
  <div class="form-group"><label>Keterangan</label><input type="text" name="keterangan" value="<?php echo htmlspecialchars($d['keterangan']??''); ?>" placeholder="Info tambahan (opsional)"></div>
    <div class="form-row align-center">
    <div class="form-group" style="flex:0 0 110px;"><label>Urutan</label><input type="number" name="urutan" value="<?php echo $d['urutan']; ?>" min="1"></div>
    <div class="form-group"><label class="label-inline"><input type="checkbox" name="is_utama" <?php echo $d['is_utama']?'checked':''; ?>> 🚨 Prioritas Urgent (tampil merah di modal)</label></div>
  </div>
  <div class="form-group"><label class="label-inline"><input type="checkbox" name="aktif" <?php echo $d['aktif']?'checked':''; ?>> Aktif</label></div>
  <div class="form-actions"><button type="submit" class="btn-save">💾 Simpan</button><a href="kontak.php" class="btn-cancel">Batalkan</a></div>
</form></div>
<?php endif; ?>
  </div></div></body></html>
