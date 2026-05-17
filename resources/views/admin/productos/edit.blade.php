@extends('layouts.admin')
@section('titulo','Editar Producto')
@section('subtitulo','Modificar datos del producto')
@section('contenido')
<div class="max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.productos.index') }}" class="hover:text-brand-600">Productos</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">{{ $producto->nombre }}</span>
    </div>
    <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/'.$producto->imagen) }}" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="package" class="w-6 h-6 text-slate-400"></i>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $producto->nombre }}</h3>
                    <p class="text-slate-400 text-sm">ID #{{ $producto->id }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Comercio</label>
                    <select name="comercio_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        @foreach($comercios as $c)
                        <option value="{{ $c->id }}" {{ old('comercio_id', $producto->comercio_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Categoría</label>
                    <select name="categoria_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ old('categoria_id', $producto->categoria_id) == $c->id ? 'selected' : '' }}>{{ $c->icono }} {{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Precio (Q)</label>
                    <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Imagen</label>
                    <div class="flex items-center gap-4">
                        <div id="img-preview" class="w-16 h-16 rounded-xl border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center bg-slate-100">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/'.$producto->imagen) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="imagen" id="img-input" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('img-input').click()"
                                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                                <i data-lucide="upload" class="w-4 h-4"></i> Cambiar imagen
                            </button>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="activo" value="1" class="sr-only peer" {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer-checked:bg-brand-600 transition"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Producto activo</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar cambios
            </button>
            <a href="{{ route('admin.productos.index') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="x" class="w-4 h-4"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('img-input').addEventListener('change', function() {
    const r = new FileReader();
    r.onload = e => { document.getElementById('img-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`; };
    r.readAsDataURL(this.files[0]);
});
</script>
@endsection
