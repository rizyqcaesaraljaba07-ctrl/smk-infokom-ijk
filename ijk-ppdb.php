<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();
$programs = $db->query("SELECT * FROM program_keahlian ORDER BY urutan ASC")->fetchAll();
$errors = [];
$selesai = null;

function ppdbOld($k) { return h($_POST[$k] ?? ''); }
function ppdbSel($k, $v) { return ((string)($_POST[$k] ?? '') === (string)$v) ? 'selected' : ''; }

// Halaman sukses setelah submit
if (!empty($_GET['selesai'])) {
    $stmt = $db->prepare("SELECT nama_lengkap, no_pendaftaran, token FROM ppdb WHERE token = ?");
    $stmt->execute([$_GET['selesai']]);
    $selesai = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'nama_lengkap','nisn','nik','tempat_lahir','tanggal_lahir','jenis_kelamin','agama',
        'no_hp','email','alamat','kelurahan','kecamatan','kota','kode_pos',
        'asal_sekolah','tahun_lulus','nama_ayah','pekerjaan_ayah','nama_ibu','pekerjaan_ibu',
        'no_hp_ortu','jurusan_pilihan','jurusan_pilihan_2'
    ];
    $d = [];
    foreach ($fields as $k) { $d[$k] = trim($_POST[$k] ?? ''); }

    $wajib = [
        'nama_lengkap' => 'Nama lengkap', 'nisn' => 'NISN', 'nik' => 'NIK',
        'tempat_lahir' => 'Tempat lahir', 'tanggal_lahir' => 'Tanggal lahir',
        'jenis_kelamin' => 'Jenis kelamin', 'agama' => 'Agama', 'no_hp' => 'No. HP / WhatsApp',
        'alamat' => 'Alamat', 'kecamatan' => 'Kecamatan', 'kota' => 'Kota/Kabupaten',
        'asal_sekolah' => 'Asal sekolah', 'tahun_lulus' => 'Tahun lulus',
        'nama_ayah' => 'Nama ayah', 'nama_ibu' => 'Nama ibu', 'no_hp_ortu' => 'No. HP orang tua/wali',
        'jurusan_pilihan' => 'Pilihan jurusan 1',
    ];
    foreach ($wajib as $k => $label) {
        if ($d[$k] === '') $errors[] = "$label wajib diisi.";
    }

    if ($d['nisn'] !== '' && !preg_match('/^\d{10}$/', $d['nisn'])) $errors[] = 'NISN harus 10 digit angka.';
    if ($d['nik'] !== '' && !preg_match('/^\d{16}$/', $d['nik'])) $errors[] = 'NIK harus 16 digit angka.';
    if ($d['email'] !== '' && !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';
    foreach (['no_hp' => 'No. HP', 'no_hp_ortu' => 'No. HP orang tua'] as $k => $label) {
        if ($d[$k] !== '' && !preg_match('/^[0-9+\-\s]{8,15}$/', $d[$k])) $errors[] = "$label tidak valid.";
    }
    if ($d['tanggal_lahir'] !== '') {
        $dt = DateTime::createFromFormat('Y-m-d', $d['tanggal_lahir']);
        if (!$dt || $dt->format('Y-m-d') !== $d['tanggal_lahir'] || $dt > new DateTime()) $errors[] = 'Tanggal lahir tidak valid.';
    }
    if ($d['jenis_kelamin'] !== '' && !in_array($d['jenis_kelamin'], ['Laki-laki', 'Perempuan'], true)) $errors[] = 'Jenis kelamin tidak valid.';
    if ($d['tahun_lulus'] !== '' && (!preg_match('/^\d{4}$/', $d['tahun_lulus']) || $d['tahun_lulus'] < 2000 || $d['tahun_lulus'] > date('Y') + 1)) $errors[] = 'Tahun lulus tidak valid.';

    $idProg = array_map('strval', array_column($programs, 'id'));
    if ($d['jurusan_pilihan'] !== '' && !in_array($d['jurusan_pilihan'], $idProg, true)) $errors[] = 'Pilihan jurusan 1 tidak valid.';
    if ($d['jurusan_pilihan_2'] !== '') {
        if (!in_array($d['jurusan_pilihan_2'], $idProg, true)) $errors[] = 'Pilihan jurusan 2 tidak valid.';
        elseif ($d['jurusan_pilihan_2'] === $d['jurusan_pilihan']) $errors[] = 'Pilihan jurusan 2 tidak boleh sama dengan pilihan 1.';
    }
    if (empty($_POST['persetujuan'])) $errors[] = 'Anda harus menyetujui pernyataan kebenaran data.';

    // Cegah pendaftaran ganda dengan NISN yang sama
    if (!$errors) {
        $cek = $db->prepare("SELECT COUNT(*) FROM ppdb WHERE nisn = ?");
        $cek->execute([$d['nisn']]);
        if ($cek->fetchColumn() > 0) $errors[] = 'NISN ini sudah terdaftar. Hubungi panitia jika ada kesalahan data.';
    }

    if (!$errors) {
        if ($d['jurusan_pilihan_2'] === '') $d['jurusan_pilihan_2'] = null;
        $token = bin2hex(random_bytes(16));
        $d['token'] = $token;

        $cols = array_keys($d);
        $sql = "INSERT INTO ppdb (" . implode(',', $cols) . ") VALUES (" . implode(',', array_fill(0, count($cols), '?')) . ")";
        try {
            $ok = $db->prepare($sql)->execute(array_values($d));
            if ($ok) {
                $newId = $db->lastInsertId();
                $no = 'PPDB-' . date('Y') . '-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
                $db->prepare("UPDATE ppdb SET no_pendaftaran = ? WHERE id = ?")->execute([$no, $newId]);
                header('Location: ijk-ppdb.php?selesai=' . $token);
                exit;
            }
            $errors[] = 'Data gagal disimpan. Silakan coba lagi.';
        } catch (PDOException $e) {
            $errors[] = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';
        }
    }
}

$agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
.ppdb-form { max-width: 820px; margin-top: 24px; }
.ppdb-box { background:#fff; border:1px solid var(--border); border-radius:12px; padding:22px; margin-bottom:20px; }
.ppdb-box h3 { color:var(--navy); font-size:16px; margin:0 0 16px; padding-bottom:10px; border-bottom:2px solid var(--gold); display:inline-block; }
.ppdb-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.ppdb-grid .full { grid-column:1/-1; }
.ppdb-field label { display:block; font-size:13px; font-weight:600; color:var(--navy); margin-bottom:6px; }
.ppdb-field label span { color:#dc2626; }
.ppdb-field input, .ppdb-field select, .ppdb-field textarea {
    width:100%; padding:12px; border:1px solid var(--border); border-radius:8px; font:inherit; background:#fff; box-sizing:border-box;
}
.ppdb-field textarea { min-height:80px; resize:vertical; }
.ppdb-field input:focus, .ppdb-field select:focus, .ppdb-field textarea:focus { outline:2px solid var(--gold); border-color:var(--gold); }
.ppdb-hint { font-size:11px; color:var(--gray); margin-top:4px; }
.ppdb-alert-err { background:#fee2e2; color:#991b1b; padding:16px 20px; border-radius:10px; margin:20px 0; max-width:820px; }
.ppdb-alert-err ul { margin:8px 0 0 18px; padding:0; }
.ppdb-sukses { background:#dcfce7; color:#166534; padding:28px; border-radius:12px; margin:24px 0; max-width:820px; }
.ppdb-sukses .no { font-size:26px; font-weight:800; letter-spacing:1px; margin:8px 0 18px; color:#14532d; }
.ppdb-sukses .aksi { display:flex; gap:12px; flex-wrap:wrap; }
.ppdb-check { display:flex; gap:10px; align-items:flex-start; font-size:14px; }
.ppdb-check input { width:auto; margin-top:3px; }
@media (max-width:640px) { .ppdb-grid { grid-template-columns:1fr; } }
</style>

<section class="about" style="padding-top:50px;">
  <div class="container">
    <div class="section-label">PPDB</div>
    <div class="section-title">Formulir Pendaftaran Peserta Didik Baru</div>

    <?php if ($selesai): ?>
      <div class="ppdb-sukses">
        <strong>Pendaftaran berhasil dikirim, <?= h($selesai['nama_lengkap']) ?>!</strong>
        <div style="margin-top:12px;">Nomor Pendaftaran Anda:</div>
        <div class="no"><?= h($selesai['no_pendaftaran']) ?></div>
        <p style="margin:0 0 18px;">Simpan bukti pendaftaran dan nomor di atas. Tim kami akan menghubungi Anda melalui nomor HP yang didaftarkan.</p>
        <div class="aksi">
          <a href="ijk-ppdb-cetak.php?t=<?= h($selesai['token']) ?>" target="_blank" class="btn btn-gold" style="color:#0b1533;">
            <i class="fa-solid fa-file-pdf"></i> Unduh Bukti Pendaftaran (PDF)
          </a>
          <a href="ijk-ppdb.php" class="btn" style="background:#fff;color:#166534;border:1px solid #166534;">Daftarkan Calon Siswa Lain</a>
        </div>
      </div>
    <?php else: ?>

      <?php if ($errors): ?>
        <div class="ppdb-alert-err">
          <strong>Mohon periksa kembali isian Anda:</strong>
          <ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form method="POST" class="ppdb-form" autocomplete="off">

        <div class="ppdb-box">
          <h3>A. Data Pribadi Calon Siswa</h3>
          <div class="ppdb-grid">
            <div class="ppdb-field full">
              <label>Nama Lengkap <span>*</span></label>
              <input required name="nama_lengkap" type="text" value="<?= ppdbOld('nama_lengkap') ?>" placeholder="Sesuai ijazah / akta kelahiran">
            </div>
            <div class="ppdb-field">
              <label>NISN <span>*</span></label>
              <input required name="nisn" type="text" inputmode="numeric" maxlength="10" value="<?= ppdbOld('nisn') ?>" placeholder="10 digit">
            </div>
            <div class="ppdb-field">
              <label>NIK <span>*</span></label>
              <input required name="nik" type="text" inputmode="numeric" maxlength="16" value="<?= ppdbOld('nik') ?>" placeholder="16 digit, sesuai KK">
            </div>
            <div class="ppdb-field">
              <label>Tempat Lahir <span>*</span></label>
              <input required name="tempat_lahir" type="text" value="<?= ppdbOld('tempat_lahir') ?>">
            </div>
            <div class="ppdb-field">
              <label>Tanggal Lahir <span>*</span></label>
              <input required name="tanggal_lahir" type="date" max="<?= date('Y-m-d') ?>" value="<?= ppdbOld('tanggal_lahir') ?>">
            </div>
            <div class="ppdb-field">
              <label>Jenis Kelamin <span>*</span></label>
              <select required name="jenis_kelamin">
                <option value="">Pilih</option>
                <option value="Laki-laki" <?= ppdbSel('jenis_kelamin', 'Laki-laki') ?>>Laki-laki</option>
                <option value="Perempuan" <?= ppdbSel('jenis_kelamin', 'Perempuan') ?>>Perempuan</option>
              </select>
            </div>
            <div class="ppdb-field">
              <label>Agama <span>*</span></label>
              <select required name="agama">
                <option value="">Pilih</option>
                <?php foreach ($agamaList as $ag): ?>
                  <option value="<?= $ag ?>" <?= ppdbSel('agama', $ag) ?>><?= $ag ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="ppdb-field">
              <label>No. HP / WhatsApp <span>*</span></label>
              <input required name="no_hp" type="text" inputmode="tel" value="<?= ppdbOld('no_hp') ?>" placeholder="08xxxxxxxxxx">
            </div>
            <div class="ppdb-field">
              <label>Email</label>
              <input name="email" type="email" value="<?= ppdbOld('email') ?>" placeholder="nama@email.com">
            </div>
          </div>
        </div>

        <div class="ppdb-box">
          <h3>B. Alamat Tempat Tinggal</h3>
          <div class="ppdb-grid">
            <div class="ppdb-field full">
              <label>Alamat Lengkap <span>*</span></label>
              <textarea required name="alamat" placeholder="Nama jalan, RT/RW, nomor rumah"><?= ppdbOld('alamat') ?></textarea>
            </div>
            <div class="ppdb-field">
              <label>Kelurahan / Desa</label>
              <input name="kelurahan" type="text" value="<?= ppdbOld('kelurahan') ?>">
            </div>
            <div class="ppdb-field">
              <label>Kecamatan <span>*</span></label>
              <input required name="kecamatan" type="text" value="<?= ppdbOld('kecamatan') ?>">
            </div>
            <div class="ppdb-field">
              <label>Kota / Kabupaten <span>*</span></label>
              <input required name="kota" type="text" value="<?= ppdbOld('kota') ?>">
            </div>
            <div class="ppdb-field">
              <label>Kode Pos</label>
              <input name="kode_pos" type="text" inputmode="numeric" maxlength="5" value="<?= ppdbOld('kode_pos') ?>">
            </div>
          </div>
        </div>

        <div class="ppdb-box">
          <h3>C. Data Sekolah Asal</h3>
          <div class="ppdb-grid">
            <div class="ppdb-field">
              <label>Asal Sekolah (SMP/MTs) <span>*</span></label>
              <input required name="asal_sekolah" type="text" value="<?= ppdbOld('asal_sekolah') ?>">
            </div>
            <div class="ppdb-field">
              <label>Tahun Lulus <span>*</span></label>
              <input required name="tahun_lulus" type="text" inputmode="numeric" maxlength="4" value="<?= ppdbOld('tahun_lulus') ?>" placeholder="<?= date('Y') ?>">
            </div>
          </div>
        </div>

        <div class="ppdb-box">
          <h3>D. Data Orang Tua / Wali</h3>
          <div class="ppdb-grid">
            <div class="ppdb-field">
              <label>Nama Ayah <span>*</span></label>
              <input required name="nama_ayah" type="text" value="<?= ppdbOld('nama_ayah') ?>">
            </div>
            <div class="ppdb-field">
              <label>Pekerjaan Ayah</label>
              <input name="pekerjaan_ayah" type="text" value="<?= ppdbOld('pekerjaan_ayah') ?>">
            </div>
            <div class="ppdb-field">
              <label>Nama Ibu <span>*</span></label>
              <input required name="nama_ibu" type="text" value="<?= ppdbOld('nama_ibu') ?>">
            </div>
            <div class="ppdb-field">
              <label>Pekerjaan Ibu</label>
              <input name="pekerjaan_ibu" type="text" value="<?= ppdbOld('pekerjaan_ibu') ?>">
            </div>
            <div class="ppdb-field full">
              <label>No. HP Orang Tua / Wali <span>*</span></label>
              <input required name="no_hp_ortu" type="text" inputmode="tel" value="<?= ppdbOld('no_hp_ortu') ?>" placeholder="08xxxxxxxxxx">
            </div>
          </div>
        </div>

        <div class="ppdb-box">
          <h3>E. Pilihan Program Keahlian</h3>
          <div class="ppdb-grid">
            <div class="ppdb-field">
              <label>Pilihan 1 <span>*</span></label>
              <select required name="jurusan_pilihan">
                <option value="">Pilih Jurusan</option>
                <?php foreach ($programs as $prog): ?>
                  <option value="<?= $prog['id'] ?>" <?= ppdbSel('jurusan_pilihan', $prog['id']) ?>><?= h($prog['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="ppdb-field">
              <label>Pilihan 2 (opsional)</label>
              <select name="jurusan_pilihan_2">
                <option value="">Tidak ada</option>
                <?php foreach ($programs as $prog): ?>
                  <option value="<?= $prog['id'] ?>" <?= ppdbSel('jurusan_pilihan_2', $prog['id']) ?>><?= h($prog['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="ppdb-box">
          <label class="ppdb-check">
            <input type="checkbox" name="persetujuan" value="1" <?= !empty($_POST['persetujuan']) ? 'checked' : '' ?>>
            <span>Saya menyatakan bahwa seluruh data yang diisi adalah benar dan dapat dipertanggungjawabkan. Apabila di kemudian hari terbukti tidak benar, saya bersedia menerima sanksi sesuai ketentuan sekolah.</span>
          </label>
        </div>

        <button type="submit" class="btn btn-gold" style="width:100%;color:#0b1533;">Kirim Pendaftaran</button>
      </form>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>