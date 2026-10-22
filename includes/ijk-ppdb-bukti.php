<?php
/**
 * Template bukti pendaftaran PPDB (dipakai halaman publik & admin).
 * Butuh variabel $row (data ppdb + jurusan_nama + jurusan2_nama).
 */
$bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$tgl = function ($s) use ($bulan) {
    if (!$s || $s === '0000-00-00') return '-';
    $t = strtotime($s);
    return $t ? date('j', $t) . ' ' . $bulan[(int)date('n', $t)] . ' ' . date('Y', $t) : '-';
};
$v = function ($k) use ($row) {
    $x = $row[$k] ?? '';
    return ($x !== '' && $x !== null) ? h($x) : '-';
};
$r = function ($label, $val) {
    echo '<tr><td class="l">' . $label . '</td><td class="c">:</td><td>' . $val . '</td></tr>';
};

$parts = [];
if (!empty($row['alamat']))    $parts[] = $row['alamat'];
if (!empty($row['kelurahan'])) $parts[] = 'Kel. ' . $row['kelurahan'];
if (!empty($row['kecamatan'])) $parts[] = 'Kec. ' . $row['kecamatan'];
if (!empty($row['kota']))      $parts[] = $row['kota'];
if (!empty($row['kode_pos']))  $parts[] = $row['kode_pos'];
$alamatFull = $parts ? h(implode(', ', $parts)) : '-';

$tglDaftar = $row['tanggal_daftar'] ?? '';
$noDaftar = !empty($row['no_pendaftaran'])
    ? $row['no_pendaftaran']
    : 'PPDB-' . date('Y', strtotime($tglDaftar ?: 'now')) . '-' . str_pad($row['id'], 4, '0', STR_PAD_LEFT);
$ttl = trim(($row['tempat_lahir'] ?? '') . ', ' . $tgl($row['tanggal_lahir'] ?? ''), ' ,');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bukti Pendaftaran <?= h($noDaftar) ?></title>
<style>
  * { box-sizing: border-box; }
  body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #111; margin: 0; background: #e5e7eb; }
  .toolbar { background: #0b1533; padding: 12px 20px; display: flex; gap: 10px; align-items: center; justify-content: center; flex-wrap: wrap; }
  .toolbar button, .toolbar a { background: #f5b400; color: #0b1533; border: 0; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; text-decoration: none; }
  .toolbar span { color: #cbd5e1; font-size: 12px; }
  .page { background: #fff; width: 210mm; min-height: 297mm; margin: 20px auto; padding: 16mm 18mm; box-shadow: 0 4px 20px rgba(0,0,0,.15); }
  .kop { text-align: center; border-bottom: 3px double #0b1533; padding-bottom: 10px; margin-bottom: 14px; }
  .kop h1 { margin: 0; font-size: 18px; color: #0b1533; letter-spacing: .5px; }
  .kop p { margin: 3px 0 0; font-size: 11px; color: #444; }
  .judul { text-align: center; margin: 14px 0 6px; }
  .judul h2 { margin: 0; font-size: 15px; text-decoration: underline; }
  .judul .no { margin-top: 6px; font-size: 14px; font-weight: 700; letter-spacing: 1px; }
  .status { display: inline-block; margin-top: 6px; padding: 3px 12px; border: 1px solid #0b1533; border-radius: 20px; font-size: 11px; font-weight: 700; }
  h3 { font-size: 12px; background: #0b1533; color: #fff; padding: 5px 10px; margin: 16px 0 6px; }
  table { width: 100%; border-collapse: collapse; }
  td { padding: 4px 6px; vertical-align: top; }
  td.l { width: 38%; color: #333; }
  td.c { width: 12px; }
  .ttd { display: flex; justify-content: space-between; margin-top: 36px; text-align: center; }
  .ttd div { width: 45%; }
  .ttd .gap { height: 70px; }
  .catatan { margin-top: 24px; font-size: 11px; color: #444; border: 1px dashed #999; padding: 10px 12px; }
  .catatan ol { margin: 6px 0 0 16px; padding: 0; }
  @page { size: A4; margin: 0; }
  @media print {
    body { background: #fff; }
    .toolbar { display: none; }
    .page { margin: 0; box-shadow: none; width: 100%; min-height: auto; padding: 14mm 16mm; }
    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  }
</style>
</head>
<body>

<div class="toolbar">
  <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
  <?php if (!empty($backUrl)): ?><a href="<?= h($backUrl) ?>">Kembali</a><?php endif; ?>
  <span>Pada jendela cetak, pilih Printer: "Save as PDF" / "Simpan sebagai PDF".</span>
</div>

<div class="page">
  <div class="kop">
    <h1>SMK INFOKOM KOTA BOGOR</h1>
    <p>Jl. Letjen Ibrahim Adjie No.178, Kota Bogor &bull; info@smkinfokom.ach.id</p>
  </div>

  <div class="judul">
    <h2>BUKTI PENDAFTARAN PESERTA DIDIK BARU</h2>
    <div class="no"><?= h($noDaftar) ?></div>
    <div class="status">Status: <?= h($row['status'] ?? 'Menunggu') ?></div>
    <div style="margin-top:6px;font-size:11px;color:#555;">Tanggal daftar: <?= $tgl($tglDaftar) ?></div>
  </div>

  <h3>A. DATA PRIBADI</h3>
  <table>
    <?php
    $r('Nama Lengkap', '<strong>' . $v('nama_lengkap') . '</strong>');
    $r('NISN', $v('nisn'));
    $r('NIK', $v('nik'));
    $r('Tempat, Tanggal Lahir', $ttl !== '' ? h($ttl) : '-');
    $r('Jenis Kelamin', $v('jenis_kelamin'));
    $r('Agama', $v('agama'));
    $r('No. HP / WhatsApp', $v('no_hp'));
    $r('Email', $v('email'));
    ?>
  </table>

  <h3>B. ALAMAT TEMPAT TINGGAL</h3>
  <table>
    <?php $r('Alamat Lengkap', $alamatFull); ?>
  </table>

  <h3>C. DATA SEKOLAH ASAL</h3>
  <table>
    <?php
    $r('Asal Sekolah', $v('asal_sekolah'));
    $r('Tahun Lulus', $v('tahun_lulus'));
    ?>
  </table>

  <h3>D. DATA ORANG TUA / WALI</h3>
  <table>
    <?php
    $r('Nama Ayah', $v('nama_ayah'));
    $r('Pekerjaan Ayah', $v('pekerjaan_ayah'));
    $r('Nama Ibu', $v('nama_ibu'));
    $r('Pekerjaan Ibu', $v('pekerjaan_ibu'));
    $r('No. HP Orang Tua / Wali', $v('no_hp_ortu'));
    ?>
  </table>

  <h3>E. PILIHAN PROGRAM KEAHLIAN</h3>
  <table>
    <?php
    $r('Pilihan 1', !empty($row['jurusan_nama']) ? h($row['jurusan_nama']) : '-');
    $r('Pilihan 2', !empty($row['jurusan2_nama']) ? h($row['jurusan2_nama']) : '-');
    ?>
  </table>

  <div class="ttd">
    <div>
      Calon Peserta Didik,<div class="gap"></div>
      ( <?= h($row['nama_lengkap'] ?? '') ?> )
    </div>
    <div>
      Panitia PPDB,<div class="gap"></div>
      ( ............................................ )
    </div>
  </div>

  <div class="catatan">
    <strong>Catatan:</strong>
    <ol>
      <li>Bukti pendaftaran ini wajib dibawa saat verifikasi berkas di sekolah.</li>
      <li>Panitia akan menghubungi calon peserta didik melalui nomor HP yang terdaftar.</li>
      <li>Bukti ini bukan jaminan diterima. Status penerimaan ditetapkan oleh panitia PPDB.</li>
    </ol>
  </div>
</div>

</body>
</html>