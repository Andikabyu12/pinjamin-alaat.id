<h2>tambah data</h2>
<form action="/tasks" method="POST">
    @csrf
    <div>
        <label for="title">Nama Tugas:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Deskripsi:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <button type="submit">Simpan</button>
</form>
