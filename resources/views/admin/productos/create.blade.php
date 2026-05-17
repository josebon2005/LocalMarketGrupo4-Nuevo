@extends('layouts.admin')
@section('titulo','Nuevo Producto')
@section('subtitulo','Agregar producto al catálogo')
@section('contenido')
<div class="max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.productos.index') }}" class="hover:text-brand-600">Productos</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">Nuevo producto</span>
    </div>
    <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i data-lucide="package-plus" class="w-6 h-6 text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Datos del producto</h3>
                    <p class="text-slate-400 text-sm">Completa la información del producto</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre del producto"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('nombre') border-red-400 @enderror">
                    @error('nombre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Comercio <span class="text-red-500">*</span></label>
                    <select name="comercio_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        <option value="">Seleccionar comercio</option>
                        @foreach($comercios as $c)
                        <option value="{{ $c->id }}" {{ old('comercio_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    @error('comercio_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Categoría <span class="text-red-500">*</span></label>
                    <select name="categoria_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        <option value="">Seleccionar categoría</option>
                        @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ old('categoria_id') == $c->id ? 'selected' : '' }}>{{ $c->icono }} {{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Precio (Q) <span class="text-red-500">*</span></label>
                    <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" min="0" placeholder="0.00"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    @error('precio')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stock inicial <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" placeholder="0"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    @error('stock')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3" placeholder="Descripción del producto..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none">{{ old('descripcion') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Imagen del producto</label>
                    <div class="flex items-center gap-4">
                        <div id="img-preview" class="w-16 h-16 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center">
                            <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                        </div>
                        <div>
                            <input type="file" name="imagen" id="img-input" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('img-input').click()"
                                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                                <i data-lucide="upload" class="w-4 h-4"></i> Subir imagen
                            </button>
                            <p class="text-xs text-slate-400 mt-1.5">JPG, PNG o WEBP · máx. 2MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar producto
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
    const file = this.files[0]; if(!file) return;
    const r = new FileReader();
    r.onload = e => { document.getElementById('img-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`; };
    r.readAsDataURL(file);
});
</script>
@endsection
