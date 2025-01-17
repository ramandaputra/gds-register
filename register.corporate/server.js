const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

const PORT = 3000;
const DATA_FILE = 'dataperusahaan.json';

app.use(bodyParser.json());

// Endpoint untuk menyimpan data
app.post('/save-data', (req, res) => {
    const newData = req.body;

    // Baca file JSON yang ada
    fs.readFile(DATA_FILE, 'utf8', (err, data) => {
        if (err && err.code !== 'ENOENT') {
            return res.status(500).json({ message: 'Gagal membaca file' });
        }

        const jsonData = data ? JSON.parse(data) : [];

        // Tambahkan data baru
        jsonData.push(newData);

        // Tulis kembali ke file JSON
        fs.writeFile(DATA_FILE, JSON.stringify(jsonData, null, 2), (writeErr) => {
            if (writeErr) {
                return res.status(500).json({ message: 'Gagal menyimpan data' });
            }
            res.status(200).json({ message: 'Data berhasil disimpan' });
        });
    });
});

// Menjalankan server Express
app.listen(PORT, () => {
    console.log(`Server Express berjalan di http://localhost:${PORT}`);
});

// Server HTTP tambahan (opsional)
if (require.main === module) {
    const { createServer } = require('http');

    const server = createServer((req, res) => {
        res.writeHead(200, { 'Content-Type': 'text/plain' });
        res.end('Hello World!\n');
    });

    // Jalankan server HTTP pada port 3001 untuk menghindari konflik
    const HTTP_PORT = 3001;
    server.listen(HTTP_PORT, '127.0.0.1', () => {
        console.log(`Server HTTP berjalan di http://127.0.0.1:${HTTP_PORT}`);
    });
}
