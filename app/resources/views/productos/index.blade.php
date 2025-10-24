<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
</head>
<body>
    <h1>Productos</h1>
    <form method="GET" action="/productos">
        <input type="text" name="buscar" placeholder="Buscar..." value="{{ $busqueda ?? '' }}">
        <button type="submit">Buscar</button>
    </form>

    <a href="/productos/crear">Agregar producto</a>

    <ul>
        @foreach($productos as $p)
            <!-- ❌ XSS intencional: render sin escapar -->
            <li><strong>{!! $p->nombre !!}</strong> — {!! $p->descripcion !!} — ₡{{ $p->precio }}</li>
        @endforeach
    </ul>
</body>
</html>
