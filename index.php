<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi (KHS)</title>
    <style>
        /* Styling biar tampilannya makin elegan */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #2c3e50; padding: 2rem 1rem; margin: 0; }
        .wrapper { max-width: 900px; margin: 0 auto; background: #ffffff; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
        
        h2 { text-align: center; color: #1abc9c; border-bottom: 3px solid #eee; padding-bottom: 1rem; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 1rem; text-align: center; border-bottom: 1px solid #eee; }
        th { background-color: #1abc9c; color: white; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; }
        td:first-child { text-align: left; font-weight: 500; }
        
        /* Baris khusus buat yang nasibnya ngulang */
        .ngulang { background-color: #fdf2f2; color: #e74c3c; font-weight: 600; }
        
        .summary-box { background: #f8f9fa; border-left: 5px solid #1abc9c; padding: 1.5rem; border-radius: 8px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 1.1rem; }
        .summary-item:last-child { margin-bottom: 0; font-weight: bold; border-top: 1px dashed #ccc; padding-top: 0.8rem; }
        
        @media (max-width: 768px) {
            .wrapper { padding: 1rem; }
            table { font-size: 0.85rem; }
            th, td { padding: 0.75rem; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <h2>Ringkasan Hasil Studi</h2>

    <?php
    // Setup data 5 matkul sesuai request
    $matkul = [
        ["nama" => "Pemrograman Web", "sks" => 3, "nilai" => 88],
        ["nama" => "Sistem Basis Data", "sks" => 3, "nilai" => 92],
        ["nama" => "Jaringan Komputer", "sks" => 3, "nilai" => 85],
        ["nama" => "Iot", "sks" => 2, "nilai" => 45], // Ini sengaja dibikin anjlok biar masuk kondisi ngulang
        ["nama" => "Desain Analisis dan Algoritma", "sks" => 3, "nilai" => 95]
    ];

    // Fungsi sakti buat nentuin huruf dan bobot
    function hitungBobot($nilai) {
        if ($nilai >= 80) return ["huruf" => "A", "bobot" => 4.0];
        if ($nilai >= 70) return ["huruf" => "B", "bobot" => 3.0];
        if ($nilai >= 60) return ["huruf" => "C", "bobot" => 2.0];
        if ($nilai >= 50) return ["huruf" => "D", "bobot" => 1.0];
        return ["huruf" => "E", "bobot" => 0.0];
    }

    $totalSKS = 0;
    $totalBobot = 0;
    ?>

    <table>
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai (Angka)</th>
                <th>Nilai (Huruf)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matkul as $mk) : 
                $hasil = hitungBobot($mk['nilai']);
                $huruf = $hasil['huruf'];
                $bobot = $hasil['bobot'];
                
                $status = ($bobot >= 2.0) ? "LULUS" : "MENGULANG";
                $rowClass = ($status === "MENGULANG") ? "ngulang" : "";

                $totalSKS += $mk['sks'];
                $totalBobot += ($mk['sks'] * $bobot);
            ?>
            <tr class="<?= $rowClass ?>">
                <td><?= $mk['nama'] ?></td>
                <td><?= $mk['sks'] ?></td>
                <td><?= $mk['nilai'] ?></td>
                <td><?= $huruf ?></td>
                <td><?= $status ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php 
    $ips = ($totalSKS > 0) ? ($totalBobot / $totalSKS) : 0;
    $sksMaksimal = ($ips >= 3.00) ? 24 : 20;
    ?>

    <div class="summary-box">
        <div class="summary-item">
            <span>Total SKS Diambil:</span>
            <span><?= $totalSKS ?> SKS</span>
        </div>
        <div class="summary-item">
            <span>Indeks Prestasi Semester (IPS):</span>
            <span><?= number_format($ips, 2) ?></span>
        </div>
        <div class="summary-item" style="color: <?= ($ips >= 3.00) ? '#1abc9c' : '#f39c12' ?>">
            <span>Kuota SKS Semester Depan:</span>
            <span><?= $sksMaksimal ?> SKS</span>
        </div>
    </div>
</div>

</body>
</html>