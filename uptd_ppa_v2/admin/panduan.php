<?php
require_once __DIR__.'/../includes/config.php';
require_once 'auth.php';
$admin_page='panduan'; $page_title='Kelola Panduan';

$action=$_GET['action']??'list';
$edit_id=isset($_GET['id'])?(int)$_GET['id']:0;
$msg=''; $msg_type='';

function sanitize_konten(string $h):string{
  return strip_tags($h,'<h2><h3><h4><p><strong><em><ul><ol><li><br><a>');
}

// POST
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $judul=trim($_POST['judul']??'');
  $deskripsi=trim($_POST['deskripsi']??'');
  $konten=sanitize_konten($_POST['konten']??'');
  $urutan=(int)($_POST['urutan']??1);
  $aktif=isset($_POST['aktif'])?1:0;
  $post_id=(int)($_POST['edit_id']??0);

  if($judul===''||$konten===''){$msg='Judul dan konten tidak boleh kosong.';$msg_type='error';}
  else{
    try{
      if($post_id>0){
        $pdo->prepare("UPDATE panduan SET judul=?,deskripsi=?,konten=?,urutan=?,aktif=? WHERE id=?")->execute([$judul,$deskripsi,$konten,$urutan,$aktif,$post_id]);
        $msg='Panduan berhasil diperbarui.';
      } else {
        $slug=strtolower(preg_replace('/[^a-z0-9]+/i','-',$judul));
        $slug=trim($slug,'-');
        if($pdo->prepare("SELECT id FROM panduan WHERE slug=?")->execute([$slug])&&$pdo->prepare("SELECT id FROM panduan WHERE slug=?")){
          $chk=$pdo->prepare("SELECT id FROM panduan WHERE slug=?");$chk->execute([$slug]);
          if($chk->fetch()) $slug.='-'.time();
        }
        $pdo->prepare("INSERT INTO panduan(slug,judul,deskripsi,konten,urutan,aktif) VALUES(?,?,?,?,?,?)")->execute([$slug,$judul,$deskripsi,$konten,$urutan,$aktif]);
        $msg='Panduan baru berhasil ditambahkan.';
      }
      $msg_type='success'; $action='list';
    }catch(Exception $e){$msg='Kesalahan saat menyimpan.';$msg_type='error';}
  }
}

// DELETE
if(isset($_GET['delete'])&&(int)$_GET['delete']>0){
  try{$pdo->prepare("DELETE FROM panduan WHERE id=?")->execute([(int)$_GET['delete']]);$msg='Panduan berhasil dihapus.';$msg_type='success';}
  catch(Exception $e){$msg='Gagal menghapus.';$msg_type='error';}
  $action='list';
}

// Data
$rows=[]; $edit_row=null;
try{
  if($action==='list') $rows=$pdo->query("SELECT * FROM panduan ORDER BY urutan ASC")->fetchAll();
  elseif($action==='edit'&&$edit_id>0){
    $s=$pdo->prepare("SELECT * FROM panduan WHERE id=?");$s->execute([$edit_id]);
    $edit_row=$s->fetch(); if(!$edit_row)$action='list';
  }
}catch(Exception $e){}

include 'admin_layout.php';
?>

<?php if($msg): ?>
<div class="alert-<?php echo $msg_type; ?>"><?php echo $msg_type==='success'?'✅':'⚠️'; ?> <?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<!-- LIST -->
<?php if($action==='list'): ?>
<div class="crud-header">
  <h2>📋 Panduan Layanan</h2>
  <a href="panduan.php?action=add" class="btn-add">+ Tambah Panduan</a>
</div>
<div class="crud-table-wrap"><table class="crud-table">
  <thead><tr><th>#</th><th>Judul</th><th>Slug</th><th style="text-align:center;">Urutan</th><th style="text-align:center;">Status</th><th style="text-align:center;">Aksi</th></tr></thead>
  <tbody>
    <?php foreach($rows as $i=>$r): ?>
    <tr>
      <td><?php echo $i+1; ?></td>
      <td><strong><?php echo htmlspecialchars($r['judul']); ?></strong></td>
      <td style="color:var(--text-light);font-size:13px;"><?php echo htmlspecialchars($r['slug']); ?></td>
      <td style="text-align:center;"><?php echo $r['urutan']; ?></td>
      <td style="text-align:center;"><span class="badge badge-<?php echo $r['aktif']?'aktif':'nonaktif'; ?>"><?php echo $r['aktif']?'Aktif':'Nonaktif'; ?></span></td>
      <td><div class="td-actions">
        <a href="panduan.php?action=edit&id=<?php echo $r['id']; ?>" class="btn-edit">✏️ Edit</a>
        <a href="panduan.php?delete=<?php echo $r['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus panduan ini?');">🗑️ Hapus</a>
      </div></td>
    </tr>
    <?php endforeach; ?>
    <?php if(empty($rows)): ?><tr><td colspan="6" style="text-align:center;color:var(--text-light);padding:22px;">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table></div>

<!-- FORM -->
<?php else:
  $d=$edit_row??['judul'=>'','deskripsi'=>'','konten'=>'','urutan'=>1,'aktif'=>1];
  $is_edit=($action==='edit'&&$edit_row);
?>
<div class="crud-header">
  <h2><?php echo $is_edit?'✏️ Edit':'➕ Tambah'; ?> Panduan</h2>
  <a href="panduan.php" class="btn-cancel">← Kembali</a>
</div>
<div class="form-wrap"><form method="POST">
  <?php if($is_edit): ?><input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
    <div class="form-group"><label>Slug (URL) — tidak dapat diubah</label><input type="text" value="<?php echo htmlspecialchars($edit_row['slug']); ?>" disabled style="opacity:.5;cursor:not-allowed;"></div>
  <?php endif; ?>

  <div class="form-row">
    <div class="form-group"><label>Judul Panduan *</label><input type="text" name="judul" value="<?php echo htmlspecialchars($d['judul']); ?>" placeholder="Misal: Panduan Tata Cara Pelaporan" required></div>
    <div class="form-group" style="flex:0 0 90px;"><label>Urutan</label><input type="number" name="urutan" value="<?php echo $d['urutan']; ?>" min="1" max="99"></div>
  </div>
  <div class="form-group"><label>Deskripsi Singkat</label><input type="text" name="deskripsi" value="<?php echo htmlspecialchars($d['deskripsi']??''); ?>" placeholder="Sub-judul di bawah judul utama"></div>
  <div class="form-group">
    <label>Konten Panduan *</label>
    <textarea name="konten" required placeholder="Tulis konten. Gunakan &lt;h3&gt;, &lt;p&gt;, &lt;ol&gt;, &lt;ul&gt;, &lt;strong&gt; untuk formatting."><?php echo htmlspecialchars($d['konten']); ?></textarea>
    <div class="fg-note">Tag HTML yang diizinkan: &lt;h3&gt;, &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ol&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;br&gt;</div>
  </div>
  <div class="form-group"><label class="label-inline"><input type="checkbox" name="aktif" <?php echo $d['aktif']?'checked':''; ?>> Tampilkan di website publik (Aktif)</label></div>
  <div class="form-actions"><button type="submit" class="btn-save">💾 Simpan</button><a href="panduan.php" class="btn-cancel">Batalkan</a></div>
</form></div>
<?php endif; ?>

  </div></div></body></html>
