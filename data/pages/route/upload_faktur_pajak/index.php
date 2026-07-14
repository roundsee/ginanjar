<?php
if (!isset($koneksi)) {
  include dirname(__FILE__) . '/../../../../config/koneksi.php';
}

// Try loading Composer autoload for Smalot/PdfParser from common locations.
$fpAutoloadCandidates = array(
  dirname(__FILE__) . '/vendor/autoload.php',
  dirname(__FILE__) . '/../../../../../vendor/autoload.php',
  dirname(__FILE__) . '/../../../../../../vendor/autoload.php'
);
foreach ($fpAutoloadCandidates as $autoloadFile) {
  if (is_file($autoloadFile)) {
    require_once $autoloadFile;
    break;
  }
}

$judulform = "Upload Faktur Pajak";

if (!function_exists('fp_ensure_tables')) {
  function fp_ensure_tables($koneksi)
  {
    $sqlHeader = "CREATE TABLE IF NOT EXISTS faktur_pembelian (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      no_faktur_pajak VARCHAR(50) DEFAULT NULL,
      nama_pkp VARCHAR(255) DEFAULT NULL,
      alamat_pkp TEXT,
      npwp_pkp VARCHAR(50) DEFAULT NULL,
      nama_pembeli VARCHAR(255) DEFAULT NULL,
      alamat_pembeli TEXT,
      npwp_pembeli VARCHAR(50) DEFAULT NULL,
      nik VARCHAR(50) DEFAULT NULL,
      nomor_paspor VARCHAR(50) DEFAULT NULL,
      identitas_lain VARCHAR(100) DEFAULT NULL,
      email VARCHAR(150) DEFAULT NULL,
      tanggal_faktur DATE DEFAULT NULL,
      harga_jual_total DECIMAL(18,2) DEFAULT 0,
      potongan_harga DECIMAL(18,2) DEFAULT 0,
      uang_muka DECIMAL(18,2) DEFAULT 0,
      dasar_pengenaan_pajak DECIMAL(18,2) DEFAULT 0,
      jumlah_ppn DECIMAL(18,2) DEFAULT 0,
      jumlah_ppnbm DECIMAL(18,2) DEFAULT 0,
      ocr_text LONGTEXT,
      file_faktur VARCHAR(255) DEFAULT NULL,
      created_by VARCHAR(50) DEFAULT NULL,
      created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id),
      KEY idx_no_faktur (no_faktur_pajak)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $sqlDetail = "CREATE TABLE IF NOT EXISTS faktur_pembelian_detail (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      faktur_pembelian_id INT UNSIGNED NOT NULL,
      no_urut INT DEFAULT NULL,
      kode_barang_jasa VARCHAR(50) DEFAULT NULL,
      nama_barang TEXT,
      harga_satuan DECIMAL(18,2) DEFAULT 0,
      qty DECIMAL(18,2) DEFAULT 0,
      satuan VARCHAR(50) DEFAULT NULL,
      potongan_harga DECIMAL(18,2) DEFAULT 0,
      ppnbm DECIMAL(18,2) DEFAULT 0,
      subtotal DECIMAL(18,2) DEFAULT 0,
      raw_text TEXT,
      created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id),
      KEY idx_faktur_pembelian_id (faktur_pembelian_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    mysqli_query($koneksi, $sqlHeader);
    mysqli_query($koneksi, $sqlDetail);

    // Backward compatibility: add new columns for old tables created before this update.
    $checkTanggal = mysqli_query($koneksi, "SHOW COLUMNS FROM faktur_pembelian LIKE 'tanggal_faktur'");
    if ($checkTanggal && mysqli_num_rows($checkTanggal) === 0) {
      mysqli_query($koneksi, "ALTER TABLE faktur_pembelian ADD COLUMN tanggal_faktur DATE DEFAULT NULL AFTER email");
    }
  }

  function fp_clean_text($value)
  {
    return trim(preg_replace('/\s+/u', ' ', $value));
  }

  function fp_is_noise_item_name($name)
  {
    $name = fp_clean_text((string) $name);
    if ($name === '') {
      return true;
    }

    $lc = strtolower($name);
    $badPhrases = array(
      'kode dan nomor seri faktur pajak',
      'pengusaha kena pajak',
      'pembeli barang kena pajak',
      'nama barang kena pajak / jasa kena pajak',
      'harga jual / penggantian',
      'faktur pajak',
      'npwp :',
      'email:'
    );

    foreach ($badPhrases as $bad) {
      if (strpos($lc, $bad) !== false) {
        return true;
      }
    }

    if (strlen($name) > 260 && (strpos($lc, 'npwp') !== false || strpos($lc, 'alamat') !== false)) {
      return true;
    }

    return false;
  }

  function fp_normalize_item_name($name)
  {
    $name = fp_clean_text((string) $name);
    $name = preg_replace('/^\d{1,3}\s+[0-9]{6,}\s+/u', '', $name);
    return fp_clean_text($name);
  }

  function fp_pick_npwp($value)
  {
    $value = (string) $value;
    if (preg_match_all('/\d{15,16}/', $value, $m) && !empty($m[0])) {
      return end($m[0]);
    }

    $digits = preg_replace('/\D+/', '', $value);
    if ($digits !== '') {
      return $digits;
    }

    return fp_clean_text($value);
  }

  function fp_parse_number($value)
  {
    $value = str_replace('Rp', '', $value);
    $value = preg_replace('/[^0-9,\.\-]/', '', $value);

    if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
      $value = str_replace('.', '', $value);
      $value = str_replace(',', '.', $value);
    } elseif (strpos($value, ',') !== false) {
      $value = str_replace(',', '.', $value);
    }

    if ($value === '' || $value === '-') {
      return 0;
    }

    return (float) $value;
  }

  function fp_pdf_decode_literal($text)
  {
    $text = preg_replace_callback('/\\\\([0-7]{1,3})/', function ($m) {
      return chr(octdec($m[1]));
    }, $text);

    $replace = array(
      '\\\\n' => "\n",
      '\\\\r' => "\r",
      '\\\\t' => "\t",
      '\\\\b' => "\b",
      '\\\\f' => "\f",
      '\\\\(' => '(',
      '\\\\)' => ')',
      '\\\\\\\\' => '\\\\'
    );

    return strtr($text, $replace);
  }

  function fp_extract_text_from_pdf($pdfPath, &$errorMessage)
  {
    $errorMessage = '';

    if (!is_file($pdfPath)) {
      $errorMessage = 'File PDF tidak ditemukan.';
      return '';
    }

    // Priority: use Smalot/PdfParser when available for more reliable extraction.
    if (class_exists('Smalot\\PdfParser\\Parser')) {
      try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = trim((string) $pdf->getText());
        if ($text !== '') {
          return $text;
        }
      } catch (\Throwable $e) {
        // Continue to fallback parser below when library fails on a specific PDF.
      }
    }

    $raw = file_get_contents($pdfPath);
    if ($raw === false || trim($raw) === '') {
      $errorMessage = 'Gagal membaca file PDF.';
      return '';
    }

    $chunks = array();
    if (preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $raw, $matches)) {
      foreach ($matches[1] as $stream) {
        $decoded = @zlib_decode($stream);
        if ($decoded === false || $decoded === null || $decoded === '') {
          $decoded = @gzuncompress($stream);
        }
        if ($decoded === false || $decoded === null || $decoded === '') {
          $decoded = @gzdecode($stream);
        }
        if ($decoded === false || $decoded === null || $decoded === '') {
          $decoded = $stream;
        }
        $chunks[] = $decoded;
      }
    } else {
      $chunks[] = $raw;
    }

    $texts = array();
    foreach ($chunks as $chunk) {
      if (preg_match_all('/\((?:\\\\.|[^\\\\)])*\)/s', $chunk, $lit)) {
        foreach ($lit[0] as $token) {
          $token = substr($token, 1, -1);
          $token = fp_pdf_decode_literal($token);
          $token = trim($token);
          if ($token !== '') {
            $texts[] = $token;
          }
        }
      }
    }

    $text = trim(implode("\n", $texts));
    if ($text === '') {
      $errorMessage = 'PDF tidak mengandung text yang bisa diekstrak langsung (kemungkinan PDF hasil scan gambar). Gunakan upload foto OCR atau isi teks OCR manual.';
      return '';
    }

    return $text;
  }

  function fp_extract_section($text, $startLabel, $endLabel)
  {
    $startPos = stripos($text, $startLabel);
    if ($startPos === false) {
      return '';
    }

    $section = substr($text, $startPos + strlen($startLabel));

    if ($endLabel !== '') {
      $endPos = stripos($section, $endLabel);
      if ($endPos !== false) {
        $section = substr($section, 0, $endPos);
      }
    }

    return trim($section);
  }

  function fp_extract_section_regex($text, $startRegex, $endRegex)
  {
    $pattern = '/' . $startRegex . '(.*?)' . $endRegex . '/is';
    if (preg_match($pattern, $text, $m)) {
      return trim($m[1]);
    }
    return '';
  }

  function fp_parse_identity_section($section)
  {
    $result = array(
      'nama' => '',
      'alamat' => '',
      'npwp' => '',
      'nik' => '',
      'nomor_paspor' => '',
      'identitas_lain' => '',
      'email' => ''
    );

    $lines = preg_split('/\R/u', $section);
    $activeField = '';

    foreach ($lines as $lineRaw) {
      $line = trim($lineRaw);
      if ($line === '') {
        continue;
      }

      if (preg_match('/^Nama\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['nama'] === '') {
          $result['nama'] = fp_clean_text($m[1]);
        }
        $activeField = '';
      } elseif (preg_match('/^Alamat\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['alamat'] === '') {
          $result['alamat'] = fp_clean_text($m[1]);
        }
        $activeField = 'alamat';
      } elseif (preg_match('/^NPWP\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['npwp'] === '') {
          $result['npwp'] = fp_pick_npwp($m[1]);
        }
        $activeField = '';
      } elseif (preg_match('/^NIK\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['nik'] === '') {
          $result['nik'] = fp_clean_text($m[1]);
        }
        $activeField = '';
      } elseif (preg_match('/^Nomor\s+Paspor\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['nomor_paspor'] === '') {
          $result['nomor_paspor'] = fp_clean_text($m[1]);
        }
        $activeField = '';
      } elseif (preg_match('/^Identitas\s+Lain\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['identitas_lain'] === '') {
          $result['identitas_lain'] = fp_clean_text($m[1]);
        }
        $activeField = '';
      } elseif (preg_match('/^Email\s*:\s*(.*)$/i', $line, $m)) {
        if ($result['email'] === '') {
          $result['email'] = fp_clean_text($m[1]);
        }
        $activeField = '';
      } elseif ($activeField === 'alamat' && !preg_match('/^(NPWP|NIK|Nomor\s+Paspor|Identitas\s+Lain|Email|NITKU|Kode\s+dan\s+Nomor)/i', $line)) {
        $result['alamat'] = trim($result['alamat'] . ' ' . fp_clean_text($line));
      }
    }

    return $result;
  }

  function fp_extract_identity_blocks($text)
  {
    $lines = preg_split('/\R/u', (string) $text);
    $blocks = array();
    $current = null;
    $activeField = '';

    foreach ($lines as $lineRaw) {
      $line = trim($lineRaw);
      if ($line === '') {
        continue;
      }

      if (preg_match('/^Nama\s*:\s*(.*)$/i', $line, $m)) {
        if ($current !== null && $current['nama'] !== '') {
          $blocks[] = $current;
        }

        $current = array(
          'nama' => fp_clean_text($m[1]),
          'alamat' => '',
          'npwp' => '',
          'nik' => '',
          'nomor_paspor' => '',
          'identitas_lain' => '',
          'email' => ''
        );
        $activeField = '';
        continue;
      }

      if ($current === null) {
        continue;
      }

      if (preg_match('/^Alamat\s*:\s*(.*)$/i', $line, $m)) {
        $current['alamat'] = fp_clean_text($m[1]);
        $activeField = 'alamat';
      } elseif (preg_match('/^NPWP\s*:\s*(.*)$/i', $line, $m)) {
        $current['npwp'] = fp_pick_npwp($m[1]);
        $activeField = '';
      } elseif (preg_match('/^NIK\s*:\s*(.*)$/i', $line, $m)) {
        $current['nik'] = fp_clean_text($m[1]);
        $activeField = '';
      } elseif (preg_match('/^Nomor\s+Paspor\s*:\s*(.*)$/i', $line, $m)) {
        $current['nomor_paspor'] = fp_clean_text($m[1]);
        $activeField = '';
      } elseif (preg_match('/^Identitas\s+Lain\s*:\s*(.*)$/i', $line, $m)) {
        $current['identitas_lain'] = fp_clean_text($m[1]);
        $activeField = '';
      } elseif (preg_match('/^Email\s*:\s*(.*)$/i', $line, $m)) {
        $current['email'] = fp_clean_text($m[1]);
        $activeField = '';
      } elseif ($activeField === 'alamat' && !preg_match('/^(NPWP|NIK|Nomor\s+Paspor|Identitas\s+Lain|Email|NITKU|Kode\s+dan\s+Nomor|No\.?)/i', $line)) {
        $current['alamat'] = trim($current['alamat'] . ' ' . fp_clean_text($line));
      }
    }

    if ($current !== null && $current['nama'] !== '') {
      $blocks[] = $current;
    }

    return $blocks;
  }

  function fp_find_money_by_label($text, $labelRegex)
  {
    if (preg_match('/' . $labelRegex . '\s*[:=]?\s*([0-9\.,]+)/is', $text, $m1)) {
      return fp_parse_number($m1[1]);
    }

    if (preg_match('/([0-9\.,]+)\s*' . $labelRegex . '/is', $text, $m2)) {
      return fp_parse_number($m2[1]);
    }

    return 0;
  }

  function fp_find_money($text, $pattern)
  {
    if (preg_match($pattern, $text, $m)) {
      return fp_parse_number($m[1]);
    }

    return 0;
  }

  function fp_parse_indonesian_date_to_ymd($day, $monthName, $year)
  {
    $months = array(
      'januari' => 1,
      'februari' => 2,
      'maret' => 3,
      'april' => 4,
      'mei' => 5,
      'juni' => 6,
      'juli' => 7,
      'agustus' => 8,
      'september' => 9,
      'oktober' => 10,
      'november' => 11,
      'desember' => 12
    );

    $monthName = strtolower(trim($monthName));
    if (!isset($months[$monthName])) {
      return '';
    }

    $d = (int) $day;
    $m = (int) $months[$monthName];
    $y = (int) $year;

    if ($d <= 0 || $d > 31 || $y < 1900 || $y > 3000) {
      return '';
    }

    return sprintf('%04d-%02d-%02d', $y, $m, $d);
  }

  function fp_extract_tanggal_faktur($text)
  {
    // Example: KOTA ADM. JAKARTA BARAT, 11 Desember 2025 (sometimes year is on next line)
    if (preg_match('/,\s*(\d{1,2})\s+([A-Za-z]+)\s*(\d{4})/is', $text, $m)) {
      return fp_parse_indonesian_date_to_ymd($m[1], $m[2], $m[3]);
    }

    if (preg_match('/,\s*(\d{1,2})\s+([A-Za-z]+)\s*\R\s*(\d{4})/is', $text, $m2)) {
      return fp_parse_indonesian_date_to_ymd($m2[1], $m2[2], $m2[3]);
    }

    return '';
  }

  function fp_extract_items($text)
  {
    $normalizedText = str_replace("\r", "\n", (string) $text);
    $normalizedText = preg_replace('/[\t ]+/u', ' ', $normalizedText);

    // High-confidence parser for Indonesian faktur table format.
    $detailSection = $normalizedText;
    $startOffset = null;

    // Start from table header line (No./Kode/Barang) if present.
    if (preg_match('/(?:^|\R)\s*No\.?\s*(?:\R\s*Kode|\s+Kode|\R\s*Barang|\s+Barang)/i', $normalizedText, $mStart, PREG_OFFSET_CAPTURE)) {
      $startOffset = $mStart[0][1];
    }

    // Fallback: start from first valid item pattern like "1 000000".
    if ($startOffset === null && preg_match('/(?:^|\R|\s)(\d{1,3})\s+([0-9]{6,})\s+/i', $normalizedText, $mFirst, PREG_OFFSET_CAPTURE)) {
      $startOffset = $mFirst[0][1];
    }

    if ($startOffset !== null) {
      $detailSection = substr($normalizedText, (int) $startOffset);
    }

    // Stop before summary totals block.
    if (preg_match('/^(.*?)(?=Harga\s+Jual\s*\/\s*Penggantian(?:\s*\/\s*Uang\s+Muka\s*\/\s*Termin)?\s+[0-9\.,])/is', $detailSection, $mSection)) {
      $detailSection = trim($mSection[1]);
    }

    $inlineSection = preg_replace('/\s+/u', ' ', $detailSection);
    $directItems = array();
    if (preg_match_all('/(\d{1,3})\s*([0-9]{6,})\s*(.*?)\s*Rp\s*([0-9\.,]+)\s*x\s*([0-9\.,]+)\s*([A-Za-z]+)\s*Potongan\s+Harga\s*=\s*Rp\s*([0-9\.,]+)\s*PPnBM\s*\([^\)]*\)\s*=\s*Rp\s*([0-9\.,]+)\s*([0-9]{1,3}(?:\.[0-9]{3})*,[0-9]{2})(?=\s+\d{1,3}\s+[0-9]{6,}\s+|\s*$)/is', $inlineSection, $mDirect, PREG_SET_ORDER)) {
      foreach ($mDirect as $d) {
        $namaBarangDirect = fp_normalize_item_name($d[3]);
        if (fp_is_noise_item_name($namaBarangDirect)) {
          continue;
        }

        $directItems[] = array(
          'no_urut' => (int) $d[1],
          'kode_barang_jasa' => fp_clean_text($d[2]),
          'nama_barang' => $namaBarangDirect,
          'harga_satuan' => fp_parse_number($d[4]),
          'qty' => fp_parse_number($d[5]),
          'satuan' => fp_clean_text($d[6]),
          'potongan_harga' => fp_parse_number($d[7]),
          'ppnbm' => fp_parse_number($d[8]),
          'subtotal' => fp_parse_number($d[9]),
          'raw_text' => fp_clean_text($d[0])
        );
      }
    }

    if (!empty($directItems)) {
      return $directItems;
    }

    // Alternative OCR pattern without explicit item code/PPnBM per line.
    $simpleItems = array();
    if (preg_match_all('/([A-Z0-9][A-Z0-9\s\(\)\/\-]{4,}?)\s+Rp\s*([0-9\.,]+)\s*x\s*([0-9\.,]+)\s*(?:[A-Za-z]+)?\s+Potongan\s+Harga\s*[:=]\s*Rp\s*([0-9\.,]+)/is', $inlineSection, $mSimple, PREG_SET_ORDER)) {
      $urut = 1;
      foreach ($mSimple as $s) {
        $namaBarangSimple = fp_normalize_item_name($s[1]);
        if (fp_is_noise_item_name($namaBarangSimple)) {
          continue;
        }

        $harga = fp_parse_number($s[2]);
        $qty = fp_parse_number($s[3]);
        $simpleItems[] = array(
          'no_urut' => $urut,
          'kode_barang_jasa' => '000000',
          'nama_barang' => $namaBarangSimple,
          'harga_satuan' => $harga,
          'qty' => $qty,
          'satuan' => '',
          'potongan_harga' => fp_parse_number($s[4]),
          'ppnbm' => 0,
          'subtotal' => $harga * $qty,
          'raw_text' => fp_clean_text($s[0])
        );
        $urut++;
      }
    }

    if (!empty($simpleItems)) {
      return $simpleItems;
    }

    $lines = preg_split('/\R/u', $normalizedText);
    $itemsRaw = array();
    $current = null;

    foreach ($lines as $lineRaw) {
      $line = trim($lineRaw);
      if ($line === '') {
        continue;
      }

      // Common format: "1 000000" or noisy OCR like "1 | 000000"
      if (preg_match('/^(\d{1,3})\s*[\|:\.;-]?\s*([0-9]{6,})\s*$/', $line, $m)) {
        if ($current !== null) {
          $itemsRaw[] = $current;
        }

        $current = array(
          'no_urut' => (int) $m[1],
          'kode' => $m[2],
          'lines' => array()
        );
        continue;
      }

      if (preg_match('/^(\d{1,3})\s*[\|:\.;-]?\s*([0-9]{6,})\s+(.+)$/', $line, $m)) {
        if ($current !== null) {
          $itemsRaw[] = $current;
        }

        $current = array(
          'no_urut' => (int) $m[1],
          'kode' => $m[2],
          'lines' => array($m[3])
        );
        continue;
      }

      if (preg_match('/^Harga\s+Jual\s*\/\s*Penggantian/i', $line)) {
        if ($current !== null) {
          $itemsRaw[] = $current;
        }
        break;
      }

      if ($current !== null) {
        $current['lines'][] = $line;
      }
    }

    if ($current !== null) {
      $itemsRaw[] = $current;
    }

    // Fallback for single-line/inline PDF text where line-based detection misses item boundaries.
    if (empty($itemsRaw)) {
      if (preg_match_all('/(?:^|\s)(\d{1,3})\s+([0-9]{6,})\s+(.*?)(?=(?:\s\d{1,3}\s+[0-9]{6,}\s+)|(?:Harga\s+Jual\s*\/\s*Penggantian)|$)/is', $normalizedText, $inlineMatches, PREG_SET_ORDER)) {
        foreach ($inlineMatches as $im) {
          $blockText = trim($im[3]);
          if ($blockText === '') {
            continue;
          }

          $itemsRaw[] = array(
            'no_urut' => (int) $im[1],
            'kode' => $im[2],
            'lines' => preg_split('/\R/u', $blockText)
          );
        }
      }
    }

    $items = array();

    foreach ($itemsRaw as $row) {
      $block = implode("\n", $row['lines']);
      $namaBarang = '';
      $hargaSatuan = 0;
      $qty = 0;
      $satuan = '';
      $potongan = 0;
      $ppnbm = 0;
      $subtotal = 0;

      if (preg_match('/^(.*?)\s*Rp\s*[0-9\.,]+\s*x\s*[0-9\.,]+/is', $block, $mNamaFromBlock)) {
        $namaBarang = fp_normalize_item_name($mNamaFromBlock[1]);
      }

      if ($namaBarang === '') {
        foreach ($row['lines'] as $l) {
          if (!preg_match('/^Rp\s*[0-9\.,]+\s*x\s*[0-9\.,]+/i', $l) && stripos($l, 'Potongan Harga') === false && stripos($l, 'PPnBM') === false) {
            if ($namaBarang === '') {
              $namaBarang = fp_normalize_item_name($l);
            }
          }
        }
      }

      if (preg_match('/Rp\s*([0-9\.,]+)\s*x\s*([0-9\.,]+)\s*([A-Za-z]+)/i', $block, $mHarga)) {
        $hargaSatuan = fp_parse_number($mHarga[1]);
        $qty = fp_parse_number($mHarga[2]);
        $satuan = fp_clean_text($mHarga[3]);
      }

      if (preg_match('/Potongan\s+Harga\s*=\s*Rp\s*([0-9\.,]+)/i', $block, $mPot)) {
        $potongan = fp_parse_number($mPot[1]);
      }

      if (preg_match('/PPnBM\s*\([^\)]*\)\s*=\s*Rp\s*([0-9\.,]+)/i', $block, $mPPnBM)) {
        $ppnbm = fp_parse_number($mPPnBM[1]);
      }

      if (preg_match_all('/([0-9]{1,3}(?:\.[0-9]{3})*,[0-9]{2})/', $block, $allMoney) && !empty($allMoney[1])) {
        $lastMoney = end($allMoney[1]);
        $subtotal = fp_parse_number($lastMoney);
      }

      if (fp_is_noise_item_name($namaBarang)) {
        continue;
      }

      $items[] = array(
        'no_urut' => $row['no_urut'],
        'kode_barang_jasa' => $row['kode'],
        'nama_barang' => $namaBarang,
        'harga_satuan' => $hargaSatuan,
        'qty' => $qty,
        'satuan' => $satuan,
        'potongan_harga' => $potongan,
        'ppnbm' => $ppnbm,
        'subtotal' => $subtotal,
        'raw_text' => $block
      );
    }

    return $items;
  }

  function fp_parse_faktur_text($text)
  {
    $result = array(
      'no_faktur_pajak' => '',
      'nama_pkp' => '',
      'alamat_pkp' => '',
      'npwp_pkp' => '',
      'nama_pembeli' => '',
      'alamat_pembeli' => '',
      'npwp_pembeli' => '',
      'nik' => '',
      'nomor_paspor' => '',
      'identitas_lain' => '',
      'email' => '',
      'tanggal_faktur' => '',
      'harga_jual_total' => 0,
      'potongan_harga' => 0,
      'uang_muka' => 0,
      'dasar_pengenaan_pajak' => 0,
      'jumlah_ppn' => 0,
      'jumlah_ppnbm' => 0,
      'items' => array()
    );

    if (preg_match('/Kode\s+dan\s+Nomor\s+Seri\s+Faktur\s+Pajak\s*:\s*([0-9\.\-]+)/i', $text, $mNo)) {
      $result['no_faktur_pajak'] = fp_clean_text($mNo[1]);
    }

    $pkpSection = fp_extract_section_regex(
      $text,
      'Pengusaha\s+Kena\s+Pajak\s*:\s*',
      'Pembeli\s+Barang\s+Kena\s+Pajak\s*\/\s*Penerima\s+Jasa\s+Kena\s+Pajak\s*:'
    );

    if ($pkpSection === '') {
      $pkpSection = fp_extract_section(
        $text,
        'Pengusaha Kena Pajak:',
        'Pembeli Barang Kena Pajak/Penerima Jasa Kena Pajak:'
      );
    }

    $pembeliSection = fp_extract_section_regex(
      $text,
      'Pembeli\s+Barang\s+Kena\s+Pajak\s*\/\s*Penerima\s+Jasa\s+Kena\s+Pajak\s*:\s*',
      '(?:\n\s*No\.?\s*\n|\n\s*No\.?\s*$|\n\s*Kode\s*\n)'
    );

    if ($pembeliSection === '') {
      $pembeliSection = fp_extract_section(
        $text,
        'Pembeli Barang Kena Pajak/Penerima Jasa Kena Pajak:',
        'No.'
      );
    }

    $pkp = fp_parse_identity_section($pkpSection);
    $pembeli = fp_parse_identity_section($pembeliSection);

    $result['nama_pkp'] = $pkp['nama'];
    $result['alamat_pkp'] = $pkp['alamat'];
    $result['npwp_pkp'] = $pkp['npwp'];

    $result['nama_pembeli'] = $pembeli['nama'];
    $result['alamat_pembeli'] = $pembeli['alamat'];
    $result['npwp_pembeli'] = $pembeli['npwp'];
    $result['nik'] = $pembeli['nik'];
    $result['nomor_paspor'] = $pembeli['nomor_paspor'];
    $result['identitas_lain'] = $pembeli['identitas_lain'];
    $result['email'] = $pembeli['email'];

    // Fallback for OCR that interleaves seller and buyer columns.
    $allIdentityBlocks = fp_extract_identity_blocks($text);
    if (count($allIdentityBlocks) >= 2) {
      $isInterleavedLayout = (
        stripos($text, 'Pengusaha Kena Pajak:') === false &&
        stripos($text, 'Pengusaha Kena Pajak') !== false &&
        stripos($text, 'Pembeli Barang Kena Pajak') !== false
      );

      $fallbackPkp = $isInterleavedLayout ? $allIdentityBlocks[1] : $allIdentityBlocks[0];
      $fallbackPembeli = $isInterleavedLayout ? $allIdentityBlocks[0] : $allIdentityBlocks[1];

      if ($result['nama_pkp'] === '' && !empty($fallbackPkp['nama'])) {
        $result['nama_pkp'] = $fallbackPkp['nama'];
      }
      if ($result['alamat_pkp'] === '' && !empty($fallbackPkp['alamat'])) {
        $result['alamat_pkp'] = $fallbackPkp['alamat'];
      }
      if ($result['npwp_pkp'] === '' && !empty($fallbackPkp['npwp'])) {
        $result['npwp_pkp'] = $fallbackPkp['npwp'];
      }

      if ($result['nama_pembeli'] === '' && !empty($fallbackPembeli['nama'])) {
        $result['nama_pembeli'] = $fallbackPembeli['nama'];
      }
      if ($result['alamat_pembeli'] === '' && !empty($fallbackPembeli['alamat'])) {
        $result['alamat_pembeli'] = $fallbackPembeli['alamat'];
      }
      if ($result['npwp_pembeli'] === '' && !empty($fallbackPembeli['npwp'])) {
        $result['npwp_pembeli'] = $fallbackPembeli['npwp'];
      }
      if ($result['nik'] === '' && !empty($fallbackPembeli['nik'])) {
        $result['nik'] = $fallbackPembeli['nik'];
      }
      if ($result['nomor_paspor'] === '' && !empty($fallbackPembeli['nomor_paspor'])) {
        $result['nomor_paspor'] = $fallbackPembeli['nomor_paspor'];
      }
      if ($result['identitas_lain'] === '' && !empty($fallbackPembeli['identitas_lain'])) {
        $result['identitas_lain'] = $fallbackPembeli['identitas_lain'];
      }
      if ($result['email'] === '' && !empty($fallbackPembeli['email'])) {
        $result['email'] = $fallbackPembeli['email'];
      }
    }

    // Extra fallbacks when OCR labels are noisy.
    if ($result['nama_pkp'] === '' && preg_match('/Pengusaha\s+Kena\s+Pajak\s*:\s*.*?Nama\s*:\s*(.+)/is', $text, $mPkpNama)) {
      $result['nama_pkp'] = fp_clean_text($mPkpNama[1]);
    }
    if ($result['npwp_pkp'] === '' && preg_match('/Pengusaha\s+Kena\s+Pajak\s*:.*?NPWP\s*:\s*([0-9]+)/is', $text, $mPkpNpwp)) {
      $result['npwp_pkp'] = fp_clean_text($mPkpNpwp[1]);
    }
    if ($result['nama_pembeli'] === '' && preg_match('/Pembeli\s+Barang\s+Kena\s+Pajak\s*\/\s*Penerima\s+Jasa\s+Kena\s+Pajak\s*:\s*.*?Nama\s*:\s*(.+)/is', $text, $mPbNama)) {
      $result['nama_pembeli'] = fp_clean_text($mPbNama[1]);
    }
    if ($result['npwp_pembeli'] === '' && preg_match('/Pembeli\s+Barang\s+Kena\s+Pajak\s*\/\s*Penerima\s+Jasa\s+Kena\s+Pajak\s*:.*?NPWP\s*:\s*([0-9]+)/is', $text, $mPbNpwp)) {
      $result['npwp_pembeli'] = fp_clean_text($mPbNpwp[1]);
    }

    $result['tanggal_faktur'] = fp_extract_tanggal_faktur($text);

    $result['harga_jual_total'] = fp_find_money_by_label($text, 'Harga\s+Jual\s*\/\s*Penggantian(?:\s*\/\s*Uang\s+Muka\s*\/\s*Termin)?');
    $result['potongan_harga'] = fp_find_money_by_label($text, 'Dikurangi\s+Potongan\s+Harga');
    $result['uang_muka'] = fp_find_money_by_label($text, 'Dikurangi\s+Uang\s+Muka(?:\s+yang\s+telah\s+diterima)?');
    $result['dasar_pengenaan_pajak'] = fp_find_money_by_label($text, 'Dasar\s+Pengenaan\s+Pajak');
    $result['jumlah_ppn'] = fp_find_money_by_label($text, '(?:Jumlah|Total)\s+PPN(?:\s*\(Pajak\s+Pertambahan\s+Nilai\))?');
    $result['jumlah_ppnbm'] = fp_find_money_by_label($text, '(?:Jumlah|Total)\s+PPnBM(?:\s*\(Pajak\s+Penjualan(?:\s+atas)?\s+Barang\s+Mewah\))?');

    $result['items'] = fp_extract_items($text);

    return $result;
  }

  function fp_tesseract_not_found($text)
  {
    if ($text === null) {
      return true;
    }

    $lc = strtolower((string) $text);
    return (
      strpos($lc, 'not recognized as an internal or external command') !== false ||
      strpos($lc, 'is not recognized as an internal or external command') !== false ||
      strpos($lc, 'command not found') !== false ||
      strpos($lc, 'not found') !== false
    );
  }

  function fp_get_tesseract_binary()
  {
    $candidates = array();

    $envBin = getenv('TESSERACT_BIN');
    $envPath = getenv('TESSERACT_PATH');

    if ($envBin !== false && trim($envBin) !== '') {
      $candidates[] = trim($envBin);
    }

    if ($envPath !== false && trim($envPath) !== '') {
      $candidates[] = trim($envPath);
    }

    $candidates[] = 'tesseract';
    $candidates[] = 'C:\\Program Files\\Tesseract-OCR\\tesseract.exe';
    $candidates[] = 'C:\\Program Files (x86)\\Tesseract-OCR\\tesseract.exe';
    $candidates[] = '/usr/bin/tesseract';
    $candidates[] = '/usr/local/bin/tesseract';

    foreach ($candidates as $bin) {
      $bin = trim($bin);
      if ($bin === '') {
        continue;
      }

      if (
        strpos($bin, '\\') !== false ||
        strpos($bin, '/') !== false ||
        preg_match('/^[A-Za-z]:\\\\/', $bin)
      ) {
        if (!file_exists($bin)) {
          continue;
        }
      }

      $checkCmd = escapeshellarg($bin) . ' --version 2>&1';
      $checkOut = shell_exec($checkCmd);
      if ($checkOut !== null && trim($checkOut) !== '' && !fp_tesseract_not_found($checkOut)) {
        return $bin;
      }
    }

    return '';
  }

  function fp_run_ocr_tesseract($imagePath, &$errorMessage)
  {
    $errorMessage = '';
    $bin = fp_get_tesseract_binary();

    if ($bin === '') {
      $errorMessage = 'Perintah tesseract tidak ditemukan oleh web server. Set env TESSERACT_BIN ke path binary tesseract.';
      return '';
    }

    $cmdIndEng = escapeshellarg($bin) . ' ' . escapeshellarg($imagePath) . ' stdout -l ind+eng --psm 6 2>&1';
    $output = shell_exec($cmdIndEng);

    if ($output === null || trim($output) === '' || fp_tesseract_not_found($output)) {
      $cmdEng = escapeshellarg($bin) . ' ' . escapeshellarg($imagePath) . ' stdout -l eng --psm 6 2>&1';
      $output = shell_exec($cmdEng);
    }

    if ($output === null || trim($output) === '') {
      $errorMessage = 'OCR gagal dijalankan. Pastikan tesseract bisa diakses oleh user web server.';
      return '';
    }

    if (fp_tesseract_not_found($output)) {
      $errorMessage = 'Perintah tesseract tidak ditemukan oleh web server. Set env TESSERACT_BIN ke path binary tesseract.';
      return '';
    }

    if (stripos($output, 'error opening data file') !== false) {
      $errorMessage = 'Data bahasa tesseract tidak ditemukan. Coba install bahasa ind dan eng.';
      return '';
    }

    return trim($output);
  }

  function fp_is_tesseract_available()
  {
    return fp_get_tesseract_binary() !== '';
  }

  function fp_save_parsed_to_db($koneksi, $hasilParse, $hasilOcr, $newFileName, &$pesanError, &$pesanSukses, $sourceLabel)
  {
    $createdBy = isset($_SESSION['employee_number']) ? $_SESSION['employee_number'] : '';

    $noFaktur = mysqli_real_escape_string($koneksi, $hasilParse['no_faktur_pajak']);
    $namaPkp = mysqli_real_escape_string($koneksi, $hasilParse['nama_pkp']);
    $alamatPkp = mysqli_real_escape_string($koneksi, $hasilParse['alamat_pkp']);
    $npwpPkp = mysqli_real_escape_string($koneksi, $hasilParse['npwp_pkp']);
    $namaPembeli = mysqli_real_escape_string($koneksi, $hasilParse['nama_pembeli']);
    $alamatPembeli = mysqli_real_escape_string($koneksi, $hasilParse['alamat_pembeli']);
    $npwpPembeli = mysqli_real_escape_string($koneksi, $hasilParse['npwp_pembeli']);
    $nik = mysqli_real_escape_string($koneksi, $hasilParse['nik']);
    $nomorPaspor = mysqli_real_escape_string($koneksi, $hasilParse['nomor_paspor']);
    $identitasLain = mysqli_real_escape_string($koneksi, $hasilParse['identitas_lain']);
    $email = mysqli_real_escape_string($koneksi, $hasilParse['email']);
    $tanggalFaktur = $hasilParse['tanggal_faktur'] !== '' ? "'" . mysqli_real_escape_string($koneksi, $hasilParse['tanggal_faktur']) . "'" : "NULL";
    $ocrTextDb = mysqli_real_escape_string($koneksi, $hasilOcr);
    $createdByDb = mysqli_real_escape_string($koneksi, $createdBy);
    $fileFakturDb = mysqli_real_escape_string($koneksi, $newFileName);

    mysqli_begin_transaction($koneksi);

    $sqlHeaderInsert = "INSERT INTO faktur_pembelian (
      no_faktur_pajak, nama_pkp, alamat_pkp, npwp_pkp,
      nama_pembeli, alamat_pembeli, npwp_pembeli, nik,
      nomor_paspor, identitas_lain, email, tanggal_faktur,
      harga_jual_total, potongan_harga, uang_muka,
      dasar_pengenaan_pajak, jumlah_ppn, jumlah_ppnbm,
      ocr_text, file_faktur, created_by
    ) VALUES (
      '$noFaktur', '$namaPkp', '$alamatPkp', '$npwpPkp',
      '$namaPembeli', '$alamatPembeli', '$npwpPembeli', '$nik',
      '$nomorPaspor', '$identitasLain', '$email', $tanggalFaktur,
      " . (float) $hasilParse['harga_jual_total'] . ",
      " . (float) $hasilParse['potongan_harga'] . ",
      " . (float) $hasilParse['uang_muka'] . ",
      " . (float) $hasilParse['dasar_pengenaan_pajak'] . ",
      " . (float) $hasilParse['jumlah_ppn'] . ",
      " . (float) $hasilParse['jumlah_ppnbm'] . ",
      '$ocrTextDb', '$fileFakturDb', '$createdByDb'
    )";

    $okHeader = mysqli_query($koneksi, $sqlHeaderInsert);
    if (!$okHeader) {
      mysqli_rollback($koneksi);
      $pesanError = 'Gagal menyimpan header faktur: ' . mysqli_error($koneksi);
      return false;
    }

    $headerId = (int) mysqli_insert_id($koneksi);
    if (!empty($hasilParse['items'])) {
      foreach ($hasilParse['items'] as $item) {
        $kodeBarang = mysqli_real_escape_string($koneksi, $item['kode_barang_jasa']);
        $namaBarang = mysqli_real_escape_string($koneksi, $item['nama_barang']);
        $satuan = mysqli_real_escape_string($koneksi, $item['satuan']);
        $rawText = mysqli_real_escape_string($koneksi, $item['raw_text']);
        $noUrut = (int) $item['no_urut'];

        $sqlDetailInsert = "INSERT INTO faktur_pembelian_detail (
          faktur_pembelian_id, no_urut, kode_barang_jasa, nama_barang,
          harga_satuan, qty, satuan, potongan_harga, ppnbm, subtotal, raw_text
        ) VALUES (
          $headerId, $noUrut, '$kodeBarang', '$namaBarang',
          " . (float) $item['harga_satuan'] . ",
          " . (float) $item['qty'] . ",
          '$satuan',
          " . (float) $item['potongan_harga'] . ",
          " . (float) $item['ppnbm'] . ",
          " . (float) $item['subtotal'] . ",
          '$rawText'
        )";

        if (!mysqli_query($koneksi, $sqlDetailInsert)) {
          mysqli_rollback($koneksi);
          $pesanError = 'Gagal menyimpan detail faktur: ' . mysqli_error($koneksi);
          return false;
        }
      }
    }

    mysqli_commit($koneksi);
    $pesanSukses = 'Faktur pajak berhasil diproses dari ' . $sourceLabel . ' dan disimpan ke tabel header/detail.';
    return true;
  }

  function fp_num($value)
  {
    return number_format((float) $value, 2, ',', '.');
  }
}

fp_ensure_tables($koneksi);

$pesanSukses = '';
$pesanError = '';
$hasilOcr = '';
$hasilParse = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_faktur_pajak'])) {
  $allowedExt = array('jpg', 'jpeg', 'png', 'webp', 'pdf');
  $manualOcrText = isset($_POST['ocr_text_manual']) ? trim($_POST['ocr_text_manual']) : '';
  $newFileName = '';

  if ($manualOcrText !== '') {
    $hasilOcr = $manualOcrText;
    $hasilParse = fp_parse_faktur_text($hasilOcr);
    fp_save_parsed_to_db($koneksi, $hasilParse, $hasilOcr, $newFileName, $pesanError, $pesanSukses, 'teks OCR manual');
  }
  elseif (!isset($_FILES['foto_faktur']) || $_FILES['foto_faktur']['error'] !== UPLOAD_ERR_OK) {
    $pesanError = 'File faktur wajib dipilih (foto atau PDF).';
  } else {
    $namaAsli = $_FILES['foto_faktur']['name'];
    $tmpPath = $_FILES['foto_faktur']['tmp_name'];
    $ext = strtolower(pathinfo($namaAsli, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt, true)) {
      $pesanError = 'Format file tidak didukung. Gunakan: jpg, jpeg, png, webp.';
    } else {
      $uploadDir = dirname(__FILE__) . '/uploads';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      $newFileName = 'faktur_pajak_' . date('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $ext;
      $targetPath = $uploadDir . '/' . $newFileName;

      if (!move_uploaded_file($tmpPath, $targetPath)) {
        $pesanError = 'Gagal menyimpan file upload ke server.';
      } else {
        if ($ext === 'pdf') {
          $pdfError = '';
          $hasilOcr = fp_extract_text_from_pdf($targetPath, $pdfError);
          if ($hasilOcr === '') {
            $pesanError = $pdfError;
          } else {
            $hasilParse = fp_parse_faktur_text($hasilOcr);
            fp_save_parsed_to_db($koneksi, $hasilParse, $hasilOcr, $newFileName, $pesanError, $pesanSukses, 'PDF text');
          }
        } else {
          $ocrError = '';
          $hasilOcr = fp_run_ocr_tesseract($targetPath, $ocrError);

          if ($hasilOcr === '') {
            $pesanError = $ocrError;
          } else {
            $hasilParse = fp_parse_faktur_text($hasilOcr);
            fp_save_parsed_to_db($koneksi, $hasilParse, $hasilOcr, $newFileName, $pesanError, $pesanSukses, 'foto OCR');
          }
        }
      }
    }
  }
}

$listFaktur = mysqli_query($koneksi, "
  SELECT fp.*, 
    (SELECT COUNT(*) FROM faktur_pembelian_detail d WHERE d.faktur_pembelian_id = fp.id) AS jumlah_detail
  FROM faktur_pembelian fp
  ORDER BY fp.id DESC
  LIMIT 20
");
?>

<div class="content-wrapper" style="background-color: ghostwhite;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="list-gds"><b><?php echo $judulform; ?></b> <small style="font-weight: 100;">OCR</small></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main.php?route=home">Beranda</a></li>
            <li class="breadcrumb-item active">Transaksi</li>
            <li class="breadcrumb-item active"><?php echo $judulform; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if ($pesanSukses !== '') { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($pesanSukses); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php } ?>

      <?php if ($pesanError !== '') { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($pesanError); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php } ?>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Upload Foto Faktur Pajak</h3>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>File Faktur Pajak (Foto / PDF)</label>
                  <input type="file" name="foto_faktur" class="form-control" accept=".jpg,.jpeg,.png,.webp,.pdf">
                  <small class="text-muted">Foto diproses OCR. PDF text-based langsung diekstrak tanpa OCR. Jika PDF scan, gunakan foto OCR atau isi teks manual.</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Output</label>
                  <input type="text" class="form-control" value="Simpan ke tabel faktur_pembelian & faktur_pembelian_detail" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Teks OCR Manual (opsional, prioritas utama)</label>
                  <textarea name="ocr_text_manual" rows="8" class="form-control" placeholder="Paste teks hasil OCR di sini jika server belum terpasang tesseract..."></textarea>
                </div>
              </div>
            </div>
            <?php if (!fp_is_tesseract_available()) { ?>
              <div class="alert alert-warning mb-0">
                Tesseract belum tersedia di server. Gunakan kolom Teks OCR Manual untuk tetap memproses faktur pajak.
              </div>
            <?php } ?>
          </div>
          <div class="card-footer">
            <button type="submit" name="upload_faktur_pajak" class="btn btn-success"><i class="fa fa-upload"></i> Upload & Proses OCR</button>
          </div>
        </form>
      </div>

      <?php if ($hasilParse !== null) { ?>
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Preview Hasil Parse OCR (Upload Terakhir)</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-bordered table-sm">
                  <tr><th>No Faktur Pajak</th><td><?php echo htmlspecialchars($hasilParse['no_faktur_pajak']); ?></td></tr>
                  <tr><th>Tanggal Faktur</th><td><?php echo htmlspecialchars($hasilParse['tanggal_faktur']); ?></td></tr>
                  <tr><th>Nama PKP</th><td><?php echo htmlspecialchars($hasilParse['nama_pkp']); ?></td></tr>
                  <tr><th>Alamat PKP</th><td><?php echo htmlspecialchars($hasilParse['alamat_pkp']); ?></td></tr>
                  <tr><th>NPWP PKP</th><td><?php echo htmlspecialchars($hasilParse['npwp_pkp']); ?></td></tr>
                  <tr><th>Nama Pembeli</th><td><?php echo htmlspecialchars($hasilParse['nama_pembeli']); ?></td></tr>
                  <tr><th>Alamat Pembeli</th><td><?php echo htmlspecialchars($hasilParse['alamat_pembeli']); ?></td></tr>
                  <tr><th>NPWP Pembeli</th><td><?php echo htmlspecialchars($hasilParse['npwp_pembeli']); ?></td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-bordered table-sm">
                  <tr><th>Harga Jual Total</th><td><?php echo fp_num($hasilParse['harga_jual_total']); ?></td></tr>
                  <tr><th>Potongan Harga</th><td><?php echo fp_num($hasilParse['potongan_harga']); ?></td></tr>
                  <tr><th>DPP</th><td><?php echo fp_num($hasilParse['dasar_pengenaan_pajak']); ?></td></tr>
                  <tr><th>Jumlah PPN</th><td><?php echo fp_num($hasilParse['jumlah_ppn']); ?></td></tr>
                  <tr><th>Jumlah PPnBM</th><td><?php echo fp_num($hasilParse['jumlah_ppnbm']); ?></td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Riwayat Upload Faktur Pajak (20 Terakhir)</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-hover table-sm">
            <thead>
              <tr>
                <th style="width: 60px;">ID</th>
                <th>No Faktur Pajak</th>
                <th style="width: 110px;">Tanggal</th>
                <th>Nama PKP</th>
                <th>Nama Pembeli</th>
                <th class="text-right">DPP</th>
                <th class="text-right">PPN</th>
                <th style="width: 90px;" class="text-center">Detail</th>
                <th style="width: 130px;" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($listFaktur && mysqli_num_rows($listFaktur) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($listFaktur)) { ?>
                  <tr>
                    <td><?php echo (int) $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['no_faktur_pajak']); ?></td>
                    <td><?php echo htmlspecialchars($row['tanggal_faktur']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pkp']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pembeli']); ?></td>
                    <td class="text-right"><?php echo fp_num($row['dasar_pengenaan_pajak']); ?></td>
                    <td class="text-right"><?php echo fp_num($row['jumlah_ppn']); ?></td>
                    <td class="text-center"><?php echo (int) $row['jumlah_detail']; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#ocrModal<?php echo (int) $row['id']; ?>">
                        Lihat OCR
                      </button>
                    </td>
                  </tr>

                  <div class="modal fade" id="ocrModal<?php echo (int) $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">OCR Text - Faktur ID <?php echo (int) $row['id']; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <pre style="white-space: pre-wrap; font-size: 12px;"><?php echo htmlspecialchars($row['ocr_text']); ?></pre>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="9" class="text-center">Belum ada data upload faktur pajak.</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
