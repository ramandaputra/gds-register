<?php
// Konfigurasi koneksi ke database
$servername = "127.0.0.1"; // ganti dengan server database Anda
$username = "root"; // ganti dengan username Anda
$password = ""; // ganti dengan password Anda
$dbname = "pelanggan_internet_perusahaan"; // ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel dataperusahaan
$sql = "SELECT * FROM dataperusahaan"; // pastikan nama tabel sesuai
$result = $conn->query($sql);

$data = [];

// Mengecek apakah query mengembalikan data
if ($result->num_rows > 0) {
    // Mengambil data baris per baris
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = []; // jika tidak ada hasil, kembalikan array kosong
}

// Menutup koneksi
$conn->close();

// Mengatur header untuk JSON response
header('Content-Type: application/json'); // pastikan content type JSON
echo json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Internet Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F4F4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-title {
            text-align: center;
            color: #25079D;
        }

        .search-bar {
            margin-bottom: 20px;
            text-align: right;
        }

        #searchInput {
            padding: 10px;
            width: 200px;
            border: 1px solid #25079D;
            border-radius: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #25079D;
            color: white;
        }

        .table tr:nth-child(odd) {
            background-color: #F4F4F4;
        }

        .table tr:nth-child(even) {
            background-color: #FFFFFF;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination i {
            font-size: 24px;
            margin: 0 10px;
            cursor: pointer;
        }

        .btn {
            background-color: #25079D;
            color: white;
            border: none;
            margin: 1px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btntab {
            background-color: #25079D;
            color: white;
            margin-left: 10%;
            font-weight: bold;
            text-align: center;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btntab:hover {
            background-color: #5c41ff;
        }

        .btn:hover {
            background-color: #5c41ff;
        }

        .banner {
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 10px auto;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>

<body>
    <div class="banner">
        <img src="http://gdshost.net/billing/assets/images/xlogo1.png.pagespeed.ic.8S05JGyY2g.webp" alt="Banner Image">
    </div>

    <div class="container">
        <h2 class="table-title">Tabel Pelanggan Internet Perusahaan</h2>

        <div class="search-bar">
            <input type="text" placeholder="Search..." id="searchInput">
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Perusahaan</th>
                    <th>Nama Pemesan</th>
                    <th>Email</th>
                    <th>Nomor Telepon Pemesan</th>
                    <th>Nomor Telepon Perusahaan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Rows will be dynamically inserted here -->
            </tbody>
        </table>

        <div class="pagination">
            <i class="bi bi-arrow-left-circle-fill" id="prevBtn"></i>
            <span id="pageNumber">1</span>
            <i class="bi bi-arrow-right-circle-fill" id="nextBtn"></i>
        </div>
    </div>

    <button class="btntab" onclick="window.location.href='tabelrumahan.html';">
        Daftar Pelanggan Rumahan
     </button>

     <script>
      let data = [];
let currentPage = 1;
const rowsPerPage = 10;

// Fungsi untuk mengambil data dari fetch_data.php
async function fetchData() {
    const response = await fetch('dataperusahaan.sql');
    const jsonData = await response.json();
    data = jsonData; // Menyimpan data dari server
    loadTableData(currentPage);
}

// Fungsi untuk memuat data ke dalam tabel
function loadTableData(page) {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filteredData = data.filter(item => Object.values(item).some(val => val.toString().toLowerCase().includes(searchTerm)));

    const startIndex = (page - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const currentPageData = filteredData.slice(startIndex, endIndex);

    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = ''; // Clear existing rows

    if (currentPageData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7">No data found</td></tr>';
        return;
    }

    currentPageData.forEach(row => {
        const tr = document.createElement('tr');
        for (let key in row) {
            const td = document.createElement('td');
            td.textContent = row[key];
            tr.appendChild(td);
        }

        // Add action buttons
        const actionTd = document.createElement('td');
        const editBtn = document.createElement('button');
        editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
        editBtn.classList.add('btn');
        editBtn.onclick = () => editRow(row.id);

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
        deleteBtn.classList.add('btn');
        deleteBtn.onclick = () => deleteRow(row.id);

        actionTd.appendChild(editBtn);
        actionTd.appendChild(deleteBtn);
        tr.appendChild(actionTd);
        tableBody.appendChild(tr);
    });

    document.getElementById('prevBtn').style.visibility = page === 1 ? 'hidden' : 'visible';
    document.getElementById('nextBtn').style.visibility = (page * rowsPerPage >= filteredData.length) ? 'hidden' : 'visible';
}

// Fungsi edit row
function editRow(id) {
    const row = data.find(item => item.id === id);
    if (row) {
        const newName = prompt("Edit Nama Perusahaan:", row.nama_perusahaan);
        if (newName && newName.trim()) {
            row.nama_perusahaan = newName.trim();
            loadTableData(currentPage);
        }
    }
}

// Fungsi delete row
function deleteRow(id) {
    const index = data.findIndex(item => item.id === id);
    if (index !== -1 && confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        data.splice(index, 1);
        loadTableData(currentPage);
    }
}

// Previous button
document.getElementById('prevBtn').addEventListener('click', function () {
    if (currentPage > 1) {
        currentPage--;
        loadTableData(currentPage);
        document.getElementById('pageNumber').textContent = currentPage;
    }
});

// Next button
document.getElementById('nextBtn').addEventListener('click', function () {
    if (currentPage * rowsPerPage < data.length) {
        currentPage++;
        loadTableData(currentPage);
        document.getElementById('pageNumber').textContent = currentPage;
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function () {
    currentPage = 1; // Reset to first page on search
    loadTableData(currentPage);
});

// Load data awal
fetchData();

    </script>

</body>

</html>