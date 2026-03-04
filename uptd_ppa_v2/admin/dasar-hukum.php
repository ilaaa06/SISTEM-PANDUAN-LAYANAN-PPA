<?php
require_once __DIR__.'/../includes/config.php';
require_once 'auth.php';
$admin_page='dasar'; $page_title='Kelola Dasar Hukum';
$action=$_GET['action']??'list'; $edit_id=isset($_GET['id'])?(int)$_GET['id']:0;
$msg=''; $msg_type='';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $nama_uu=trim($_POST['nama_uu']??''); $tentang=trim($_POST['tentang']??'');
  $ringkasan=trim($_POST['ringkasan']??''); $urutan=(int)($_POST['urutan']??1);
  $aktif=isset($_POST['aktif'])?1:0; $post_id=(int)($_POST['edit_id']??0);
  if($nama_uu===''||$tentang===''||$ringkasan===''){$msg='Semua field wajib diisi.';$msg_type='error';}
  else{
    try{
      if($post_id>0) $pdo->prepare("UPDATE dasar_hukum SET nama_uu=?,tentang=?,ringkasan=?,urutan=?,aktif=? WHERE id=?")->execute([$nama_uu,$tentang,$ringkasan,$urutan,$aktif,$post_id]);
      else $pdo->prepare("INSERT INTO dasar_hukum(nama_uu,tentang,ringkasan,urutan,aktif) VALUES(?,?,?,?,?)")->execute([$nama_uu,$tentang,$ringkasan,$urutan,$aktif]);
      $msg=$post_id>0?'Berhasil diperbarui.':'Berhasil ditambahkan.'; $msg_type='success'; $action='list';
    }catch(Exception $e){$msg='Kesalahan saat menyimpan.';$msg_type='error';}
  }
}
if(isset($_GET['delete'])&&(int)$_GET['delete']>0){
  try{$pdo->prepare("DELETE FROM dasar_hukum WHERE id=?")->execute([(int)$_GET['delete']]);$msg='Berhasil dihapus.';$msg_type='success';}
  catch(Exception $e){$msg='Gagal menghapus.';$msg_type='error';} $action='list';
}

$rows=[]; $edit_row=null;
try{
  if($action==='list') $rows=$pdo->query("SELECT * FROM dasar_hukum ORDER BY urutan ASC")->fetchAll();
  elseif($action==='edit'&&$edit_id>0){$s=$pdo->prepare("SELECT * FROM dasar_hukum WHERE id=?");$s->execute([$edit_id]);$edit_row=$s->fetch();if(!$edit_row)$action='list';}
}catch(Exception $e){}

include 'admin_layout.php';
?>
<?php if($msg): ?><div class="alert-<?php echo $msg_type; ?>"><?php echo $msg_type==='success'?'✅':'⚠️'; ?> <?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<?php if($action==='list'): ?>
<div class="crud-header"><h2>📚 Dasar Hukum</h2><a href="dasar-hukum.php?action=add" class="btn-add">+ Tambah Peraturan</a></div>
<div class="crud-table-wrap"><table class="crud-table">
  <thead><tr><th>#</th><th>Nama Peraturan</th><th>Tentang</th><th style="text-align:center;">Status</th><th style="text-align:center;">Aksi</th></tr></thead>
  <tbody>
    <?php foreach($rows as $i=>$r): ?>
    <tr>
      <td><?php echo $i+1; ?></td>
      <td><strong><?php echo htmlspecialchars($r['nama_uu']); ?></strong></td>
      <td style="color:var(--text-mid);"><?php echo htmlspecialchars($r['tentang']); ?></td>
      <td style="text-align:center;"><span class="badge badge-<?php echo $r['aktif']?'aktif':'nonaktif'; ?>"><?php echo $r['aktif']?'Aktif':'Nonaktif'; ?></span></td>
      <td><div class="td-actions">
        <a href="dasar-hukum.php?action=edit&id=<?php echo $r['id']; ?>" class="btn-edit">✏️ Edit</a>
        <a href="dasar-hukum.php?delete=<?php echo $r['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus?');">🗑️ Hapus</a>
      </div></td>
    </tr>
    <?php endforeach; ?>
    <?php if(empty($rows)): ?><tr><td colspan="5" style="text-align:center;color:var(--text-light);padding:22px;">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table></div>

<?php else:
  $d=$edit_row??['nama_uu'=>'','tentang'=>'','ringkasan'=>'','urutan'=>1,'aktif'=>1];
  $is_edit=($action==='edit'&&$edit_row);
?>
<div class="crud-header"><h2><?php echo $is_edit?'✏️ Edit':'➕ Tambah'; ?> Peraturan</h2><a href="dasar-hukum.php" class="btn-cancel">← Kembali</a></div>
<div class="form-wrap"><form method="POST">
  <?php if($is_edit): ?><input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>"><?php endif; ?>
  <div class="form-group"><label>Nama UU / Peraturan *</label><input type="text" name="nama_uu" value="<?php echo htmlspecialchars($d['nama_uu']); ?>" placeholder="Misal: UU No. 23 Tahun 2004" required></div>
  <div class="form-group"><label>Tentang *</label><input type="text" name="tentang" value="<?php echo htmlspecialchars($d['tentang']); ?>" placeholder="Judul resmi peraturan" required></div>
  <div class="form-group"><label>Ringkasan *</label><textarea name="ringkasan" required placeholder="Ringkasan pokok materi."><?php echo htmlspecialchars($d['ringkasan']); ?></textarea></div>
  <div class="form-row">
    <div class="form-group" style="flex:0 0 110px;"><label>Urutan</label><input type="number" name="urutan" value="<?php echo $d['urutan']; ?>" min="1"></div>
    <div class="form-group" style="flex:1;display:flex;align-items:flex-end;"><label><input type="checkbox" name="aktif" <?php echo $d['aktif']?'checked':''; ?> style="margin-right:6px;"> Aktif</label></div>
  </div>
  <div class="form-actions"><button type="submit" class="btn-save">💾 Simpan</button><a href="dasar-hukum.php" class="btn-cancel">Batalkan</a></div>
</form></div>
<?php endif; ?>
  </div></div></body></html>
