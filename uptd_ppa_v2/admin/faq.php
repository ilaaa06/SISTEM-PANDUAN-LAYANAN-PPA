<?php
require_once __DIR__.'/../includes/config.php';
require_once 'auth.php';
$admin_page='faq'; $page_title='Kelola FAQ';
$action=$_GET['action']??'list'; $edit_id=isset($_GET['id'])?(int)$_GET['id']:0;
$msg=''; $msg_type='';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $pertanyaan=trim($_POST['pertanyaan']??''); $jawaban=trim($_POST['jawaban']??'');
  $kategori=trim($_POST['kategori']??''); $urutan=(int)($_POST['urutan']??1);
  $aktif=isset($_POST['aktif'])?1:0; $post_id=(int)($_POST['edit_id']??0);
  if($pertanyaan===''||$jawaban===''){$msg='Pertanyaan dan jawaban tidak boleh kosong.';$msg_type='error';}
  else{
    try{
      if($post_id>0) $pdo->prepare("UPDATE faq SET pertanyaan=?,jawaban=?,kategori=?,urutan=?,aktif=? WHERE id=?")->execute([$pertanyaan,$jawaban,$kategori?:null,$urutan,$aktif,$post_id]);
      else $pdo->prepare("INSERT INTO faq(pertanyaan,jawaban,kategori,urutan,aktif) VALUES(?,?,?,?,?)")->execute([$pertanyaan,$jawaban,$kategori?:null,$urutan,$aktif]);
      $msg=$post_id>0?'FAQ berhasil diperbarui.':'FAQ baru berhasil ditambahkan.'; $msg_type='success'; $action='list';
    }catch(Exception $e){$msg='Kesalahan saat menyimpan.';$msg_type='error';}
  }
}
if(isset($_GET['delete'])&&(int)$_GET['delete']>0){
  try{$pdo->prepare("DELETE FROM faq WHERE id=?")->execute([(int)$_GET['delete']]);$msg='FAQ berhasil dihapus.';$msg_type='success';}
  catch(Exception $e){$msg='Gagal menghapus.';$msg_type='error';} $action='list';
}

$rows=[]; $edit_row=null;
try{
  if($action==='list') $rows=$pdo->query("SELECT * FROM faq ORDER BY kategori ASC, urutan ASC")->fetchAll();
  elseif($action==='edit'&&$edit_id>0){$s=$pdo->prepare("SELECT * FROM faq WHERE id=?");$s->execute([$edit_id]);$edit_row=$s->fetch();if(!$edit_row)$action='list';}
}catch(Exception $e){}

include 'admin_layout.php';
?>
<?php if($msg): ?><div class="alert-<?php echo $msg_type; ?>"><?php echo $msg_type==='success'?'✅':'⚠️'; ?> <?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<?php if($action==='list'): ?>
<div class="crud-header"><h2>❓ FAQ</h2><a href="faq.php?action=add" class="btn-add">+ Tambah FAQ</a></div>
<div class="crud-table-wrap"><table class="crud-table">
  <thead><tr><th>#</th><th>Pertanyaan</th><th>Kategori</th><th style="text-align:center;">Status</th><th style="text-align:center;">Aksi</th></tr></thead>
  <tbody>
    <?php foreach($rows as $i=>$r): ?>
    <tr>
      <td><?php echo $i+1; ?></td>
      <td><strong><?php echo htmlspecialchars($r['pertanyaan']); ?></strong><br><span style="font-size:13px;color:var(--text-light);"><?php echo htmlspecialchars(substr($r['jawaban'],0,65)); ?>…</span></td>
      <td><span class="badge badge-kat"><?php echo htmlspecialchars($r['kategori']??'Umum'); ?></span></td>
      <td style="text-align:center;"><span class="badge badge-<?php echo $r['aktif']?'aktif':'nonaktif'; ?>"><?php echo $r['aktif']?'Aktif':'Nonaktif'; ?></span></td>
      <td><div class="td-actions">
        <a href="faq.php?action=edit&id=<?php echo $r['id']; ?>" class="btn-edit">✏️ Edit</a>
        <a href="faq.php?delete=<?php echo $r['id']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus FAQ ini?');">🗑️ Hapus</a>
      </div></td>
    </tr>
    <?php endforeach; ?>
    <?php if(empty($rows)): ?><tr><td colspan="5" style="text-align:center;color:var(--text-light);padding:22px;">Belum ada FAQ.</td></tr><?php endif; ?>
  </tbody>
</table></div>

<?php else:
  $d=$edit_row??['pertanyaan'=>'','jawaban'=>'','kategori'=>'','urutan'=>1,'aktif'=>1];
  $is_edit=($action==='edit'&&$edit_row);
?>
<div class="crud-header"><h2><?php echo $is_edit?'✏️ Edit':'➕ Tambah'; ?> FAQ</h2><a href="faq.php" class="btn-cancel">← Kembali</a></div>
<div class="form-wrap"><form method="POST">
  <?php if($is_edit): ?><input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>"><?php endif; ?>
  <div class="form-group"><label>Pertanyaan *</label><input type="text" name="pertanyaan" value="<?php echo htmlspecialchars($d['pertanyaan']); ?>" placeholder="Misal: Apakah layanan pendampingan gratis?" required></div>
  <div class="form-group"><label>Jawaban *</label><textarea name="jawaban" required placeholder="Jawaban yang jelas dan mudah dipahami."><?php echo htmlspecialchars($d['jawaban']); ?></textarea></div>
  <div class="form-row">
    <div class="form-group"><label>Kategori</label><input type="text" name="kategori" value="<?php echo htmlspecialchars($d['kategori']??''); ?>" placeholder="Pelaporan, Hukum, Pendampingan, Umum"><div class="fg-note">Kategori untuk pengelompokan di halaman publik.</div></div>
    <div class="form-group" style="flex:0 0 110px;"><label>Urutan</label><input type="number" name="urutan" value="<?php echo $d['urutan']; ?>" min="1"></div>
  </div>
  <div class="form-group"><label class="label-inline"><input type="checkbox" name="aktif" <?php echo $d['aktif']?'checked':''; ?>> Aktif</label></div>
  <div class="form-actions"><button type="submit" class="btn-save">💾 Simpan</button><a href="faq.php" class="btn-cancel">Batalkan</a></div>
</form></div>
<?php endif; ?>
  </div></div></body></html>
