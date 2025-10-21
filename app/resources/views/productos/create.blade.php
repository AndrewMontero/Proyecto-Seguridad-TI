<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
</head>
<body>
    <h1>Agregar nuevo producto</h1>
    <form method="POST" action="/productos/guardar">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="nombre"><br>

        <label>Descripción:</label>
        <textarea name="descripcion"></textarea><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio"><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
