<?php
header('Content-Type: application/json; charset=utf8');

// Cross Origin Request
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "pabw3");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data TO DO: Buat lebih spesifik (Untuk POSTMAN)
    $sql = "SELECT * FROM villa";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id = $_POST['id']; // All Required since it's a new data
    $nama_villa = $_POST['nama_villa'];
    $harga = $_POST['harga'];
    $fasilitas = $_POST['fasilitas'];
    $sql = "INSERT INTO villa (id, nama_villa, harga, fasilitas) VALUES ('$id', '$nama_villa', '$harga', '$fasilitas')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "ヾ(≧▽≦*)o YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "(っ °Д °;)っ NAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id = $_GET['id'];
    $sql = "DELETE FROM villa WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "ヾ(≧▽≦*)o YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "(っ °Д °;)っ NAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id_update'];
    $new_id = $_PUT['new_id'];

    // Check if a new ID was provided and use it if available
    if (isset($_PUT['new_id']) && !empty($_PUT['new_id'])) {
        // Update the ID in the database
        $sql_update_id = "UPDATE villa SET id='$new_id' WHERE id='$id'";
        $cek_update_id = mysqli_query($koneksi, $sql_update_id);

        // Update the ID variable if the update was successful
        if ($cek_update_id) {
            $id = $new_id;
        }
    }

    $nama_villa = $_PUT['nama_villa_update'];
    $harga = $_PUT['harga_update'];
    $fasilitas = $_PUT['fasilitas_update'];

    $sql = "UPDATE villa SET nama_villa='$nama_villa', harga='$harga', fasilitas='$fasilitas' WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "ヾ(≧▽≦*)o YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "(っ °Д °;)っ NAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>
