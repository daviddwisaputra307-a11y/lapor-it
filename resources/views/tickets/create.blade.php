@extends('layouts.app')

@section('title', 'Buat Laporan IT - Lapor IT')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-2xl p-6 shadow-lg text-white">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Buat Laporan IT</h1>
                    <p class="text-blue-50">Lapor IT - Laporkan Problem IT di Rumah Sakit</p>
                </div>
            </div>
        </div>

        {{-- Alert success --}}
        @if (session('success'))
            <div
                class="rounded-xl border-2 border-green-300 bg-green-50 px-4 py-3 text-green-800 flex items-center gap-2 shadow-sm">
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
        @endif

        {{-- Error summary --}}
        @if ($errors->any())
            <div
                class="rounded-xl border-2 border-red-300 bg-red-50 px-4 py-3 text-red-800 flex items-center gap-2 shadow-sm">
                <div><strong>Gagal:</strong> cek input kamu ya.</div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
            <form method="POST" action="{{ route('tickets.store') }}" class="space-y-5">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="judul" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Judul <span class="text-red-600">*</span>
                    </label>
                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}"
                        placeholder="Contoh: Printer error / WiFi lemot / PC bluescreen"
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                        required>
                    @error('judul')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        Deskripsi <span class="text-red-600">*</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="5"
                        placeholder="Jelasin singkat: masalahnya apa, kapan kejadian, ada pesan error apa..."
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none resize-y"
                        required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                            Lokasi / Unit Kerja <span class="text-red-600">*</span>
                        </label>
                        <select id="lokasi" name="lokasi"
                            class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                            required>
                            <option value="" disabled {{ old('lokasi') ? '' : 'selected' }}>
                                -- pilih lokasi --
                            </option>
                            @foreach ($bagians as $b)
                                <option value="{{ $b->KODEBAGIAN }}"
                                    {{ old('lokasi') == $b->KODEBAGIAN ? 'selected' : '' }}>
                                    {{ $b->NAMABAGIAN }}
                                </option>
                            @endforeach
                        </select>
                        @error('lokasi')
                            <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Prioritas --}}
                    <div>
                        <label for="prioritas" class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                            Prioritas <span class="text-red-600">*</span>
                        </label>
                        <select id="prioritas" name="prioritas"
                            class="w-full px-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none"
                            required>
                            <option value="Low" {{ old('prioritas', 'Low') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('prioritas') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('prioritas') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('prioritas')
                            <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- GAMBAR UPLOAD & EDIT --}}
                <div>
                    <label class="flex items-center gap-1 text-sm font-bold text-blue-900 mb-2">
                        📷 Lampiran Gambar <span class="text-xs text-gray-500 font-normal">(opsional)</span>
                    </label>

                    {{-- Upload Area --}}
                    <div id="uploadArea"
                        class="border-2 border-dashed border-blue-300 rounded-xl p-6 text-center bg-blue-50 hover:bg-blue-100 transition cursor-pointer">
                        <input type="file" id="fileInput" accept="image/png,image/jpeg,image/jpg" class="hidden">
                        <div class="space-y-2">
                            <div class="text-4xl">📸</div>
                            <div class="text-sm text-gray-600">
                                <span class="font-semibold text-blue-600">Klik untuk upload</span> atau
                                <span class="font-semibold text-blue-600">Paste (Ctrl+V)</span> screenshot
                            </div>
                            <div class="text-xs text-gray-500">PNG, JPG, JPEG • Max 2MB</div>
                        </div>
                    </div>

                    {{-- Canvas Editor (Hidden by default) --}}
                    <div id="editorContainer" class="hidden mt-4">
                        <div class="bg-white border-2 border-blue-200 rounded-xl p-4 space-y-3">
                            {{-- Toolbar --}}
                            <div class="flex flex-wrap items-center gap-2 pb-3 border-b border-blue-100">
                                <button type="button" id="btnDraw"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition-all shadow-sm">
                                    ✏️ Draw
                                </button>

                                <button type="button" id="btnArrow"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition-all shadow-sm">
                                    ➡️ Arrow
                                </button>

                                <button type="button" id="btnCrop"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-bold hover:bg-purple-700 transition-all shadow-sm">
                                    ✂️ Crop
                                </button>

                                <div class="h-8 w-px bg-gray-300 mx-1"></div>

                                <button type="button" id="btnRedo" onclick="redoCanvas()"
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-bold hover:bg-gray-700 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                    ↪️ Redo
                                </button>

                                <button type="button" id="btnUndo" onclick="undoCanvas()"
                                    class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-bold hover:bg-orange-700 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                    ↩️ Undo
                                </button>

                                <button type="button" id="btnClearDrawings"
                                    class="hidden px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm font-bold hover:bg-yellow-700 transition-all shadow-sm">
                                    🧹 Hapus Coretan
                                </button>

                                <div class="h-8 w-px bg-gray-300 mx-1"></div>

                                <div class="flex items-center gap-2">
                                    <label class="text-xs font-bold text-gray-700">Warna:</label>
                                    <input type="color" id="colorPicker" value="#ff0000"
                                        class="w-10 h-10 rounded cursor-pointer border-2 border-gray-300 hover:border-blue-400 transition">
                                </div>

                                <div class="flex items-center gap-2">
                                    <label class="text-xs font-bold text-gray-700">Ukuran:</label>
                                    <input type="range" id="brushSize" min="1" max="20" value="3"
                                        class="w-24 accent-blue-600">
                                    <span id="brushSizeValue"
                                        class="text-sm font-bold text-gray-700 w-6 text-center bg-gray-100 px-2 py-1 rounded">3</span>
                                </div>

                                <button type="button" id="btnClear"
                                    class="ml-auto px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition-all shadow-sm">
                                    🗑️ Hapus Gambar
                                </button>
                            </div>

                            {{-- Canvas --}}
                            <div class="flex justify-center bg-gray-100 rounded-lg p-4 overflow-auto">
                                <canvas id="canvas"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden input untuk base64 --}}
                    <input type="hidden" id="gambarBase64" name="gambar">

                    @error('gambar')
                        <div class="mt-2 flex items-center gap-1 text-xs text-red-600">
                            ⚠️ {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-100 font-semibold transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-1 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold hover:scale-105 transition-transform shadow-md">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let canvas;
        let canvasHistory = [];
        let historyStep = -1;
        let saveTimeout = null;
        let currentMode = 'draw'; // 'draw', 'arrow', atau 'crop'
        let isDrawingArrow = false;
        let arrowStartPoint = null;
        let tempArrow = null;
        let cropRect = null;
        let isCropping = false;
        let cropStartPoint = null;
        let baseImageSnapshot = null; // Snapshot gambar tanpa coretan

        document.addEventListener('DOMContentLoaded', function() {

            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const editorContainer = document.getElementById('editorContainer');
            const gambarBase64Input = document.getElementById('gambarBase64');
            const formElement = document.querySelector('form');

            /* =========================
                PASTE IMAGE (Ctrl + V)
            ========================= */
            document.addEventListener('paste', function(e) {
                const items = e.clipboardData?.items;
                if (!items) return;

                for (let item of items) {
                    if (item.type.indexOf('image') !== -1) {
                        e.preventDefault();

                        const file = item.getAsFile();
                        if (file) handleImageFile(file);

                        break;
                    }
                }
            });

            /* =========================
                IMAGE LOAD
            ========================== */

            uploadArea.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', e => {
                if (e.target.files[0]) handleImageFile(e.target.files[0]);
            });

            function handleImageFile(file) {
                // Validate size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('❌ Ukuran gambar maksimal 2MB!');
                    return;
                }

                // Validate type
                if (!file.type.match('image/(png|jpeg|jpg)')) {
                    alert('❌ Format gambar harus PNG, JPG, atau JPEG!');
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => initCanvas(e.target.result);
                reader.readAsDataURL(file);
            }

            /* =========================
                CANVAS INIT
            ========================== */

            function initCanvas(imageDataUrl) {

                uploadArea.classList.add('hidden');
                editorContainer.classList.remove('hidden');

                if (canvas) {
                    canvas.dispose();
                    canvasHistory = [];
                    historyStep = -1;
                }

                canvas = new fabric.Canvas('canvas', {
                    isDrawingMode: true,
                    renderOnAddRemove: false,
                    selection: false,
                    enableRetinaScaling: true // Kualitas tinggi untuk retina display
                });

                fabric.Image.fromURL(imageDataUrl, function(img) {

                    const maxW = 1920;
                    const maxH = 1080;

                    const scale = Math.min(
                        maxW / img.width,
                        maxH / img.height,
                        1
                    );

                    img.scale(scale);

                    canvas.setWidth(img.width * scale);
                    canvas.setHeight(img.height * scale);

                    canvas.backgroundColor = "#ffffff";

                    canvas.setBackgroundImage(
                        img,
                        canvas.renderAll.bind(canvas)
                    );

                    // Simpan snapshot gambar dasar (tanpa coretan)
                    setTimeout(() => {
                        baseImageSnapshot = canvas.toDataURL('image/png');
                        console.log('📸 Base image saved');
                    }, 100);

                    /* Smooth brush */
                    const brush = new fabric.PencilBrush(canvas);
                    brush.width = 3;
                    brush.color = "#ff0000";
                    brush.decimate = 2; // smoothing

                    canvas.freeDrawingBrush = brush;

                    // Set default mode
                    currentMode = 'draw';
                    updateButtonStates();

                    saveSnapshot();
                    updateBase64();
                });

                /* Drawing finished */
                canvas.on('path:created', function() {
                    // Delay merge untuk performa
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        mergeDrawing();
                        saveSnapshot();
                        updateBase64();
                    }, 100);
                });

                /* Mouse Events untuk Arrow & Crop */
                canvas.on('mouse:down', function(o) {
                    const pointer = canvas.getPointer(o.e);

                    if (currentMode === 'arrow') {
                        isDrawingArrow = true;
                        arrowStartPoint = {
                            x: pointer.x,
                            y: pointer.y
                        };
                    } else if (currentMode === 'crop') {
                        isCropping = true;
                        cropStartPoint = {
                            x: pointer.x,
                            y: pointer.y
                        };
                    }
                });

                canvas.on('mouse:move', function(o) {
                    const pointer = canvas.getPointer(o.e);

                    // Arrow preview
                    if (currentMode === 'arrow' && isDrawingArrow) {
                        // Remove previous temp arrow
                        if (tempArrow) {
                            tempArrow.line && canvas.remove(tempArrow.line);
                            tempArrow.headLeft && canvas.remove(tempArrow.headLeft);
                            tempArrow.headRight && canvas.remove(tempArrow.headRight);
                        }

                        // Draw preview arrow
                        tempArrow = createArrowObjects(arrowStartPoint, pointer, true);

                        if (tempArrow.line) canvas.add(tempArrow.line);
                        if (tempArrow.headLeft) canvas.add(tempArrow.headLeft);
                        if (tempArrow.headRight) canvas.add(tempArrow.headRight);

                        canvas.renderAll();
                    }

                    // Crop preview
                    if (currentMode === 'crop' && isCropping) {
                        // Remove previous crop rect
                        if (cropRect) {
                            canvas.remove(cropRect);
                        }

                        const left = Math.min(cropStartPoint.x, pointer.x);
                        const top = Math.min(cropStartPoint.y, pointer.y);
                        const width = Math.abs(pointer.x - cropStartPoint.x);
                        const height = Math.abs(pointer.y - cropStartPoint.y);

                        cropRect = new fabric.Rect({
                            left: left,
                            top: top,
                            width: width,
                            height: height,
                            fill: 'rgba(0, 123, 255, 0.15)',
                            stroke: '#007bff',
                            strokeWidth: 2,
                            strokeDashArray: [5, 5],
                            selectable: false,
                            evented: false
                        });

                        canvas.add(cropRect);
                        canvas.renderAll();
                    }
                });

                canvas.on('mouse:up', function(o) {
                    const pointer = canvas.getPointer(o.e);

                    // Arrow finalization
                    if (currentMode === 'arrow' && isDrawingArrow) {
                        const endPoint = {
                            x: pointer.x,
                            y: pointer.y
                        };

                        // Remove temp preview
                        if (tempArrow) {
                            tempArrow.line && canvas.remove(tempArrow.line);
                            tempArrow.headLeft && canvas.remove(tempArrow.headLeft);
                            tempArrow.headRight && canvas.remove(tempArrow.headRight);
                            tempArrow = null;
                        }

                        // Minimal distance untuk arrow
                        const distance = Math.sqrt(
                            Math.pow(endPoint.x - arrowStartPoint.x, 2) +
                            Math.pow(endPoint.y - arrowStartPoint.y, 2)
                        );

                        if (distance > 10) {
                            // Draw final arrow
                            const finalArrow = createArrowObjects(arrowStartPoint, endPoint, false);

                            if (finalArrow.line) canvas.add(finalArrow.line);
                            if (finalArrow.headLeft) canvas.add(finalArrow.headLeft);
                            if (finalArrow.headRight) canvas.add(finalArrow.headRight);

                            canvas.renderAll();

                            clearTimeout(saveTimeout);
                            saveTimeout = setTimeout(() => {
                                mergeDrawing();
                                saveSnapshot();
                                updateBase64();
                            }, 100);
                        }

                        isDrawingArrow = false;
                        arrowStartPoint = null;
                    }

                    // Crop finalization
                    if (currentMode === 'crop' && isCropping) {
                        if (cropRect && cropRect.width > 30 && cropRect.height > 30) {
                            // Remove crop rect dari canvas sebelum apply
                            canvas.remove(cropRect);
                            canvas.renderAll();

                            const cropData = {
                                left: cropRect.left,
                                top: cropRect.top,
                                width: cropRect.width,
                                height: cropRect.height
                            };

                            applyCrop(cropData);
                        } else {
                            // Remove invalid crop rect
                            if (cropRect) {
                                canvas.remove(cropRect);
                                canvas.renderAll();
                            }
                            alert('Area crop terlalu kecil. Minimal 30x30 pixel.');
                        }

                        cropRect = null;
                        isCropping = false;
                        cropStartPoint = null;

                        // Kembali ke draw mode setelah crop
                        currentMode = 'draw';
                        canvas.isDrawingMode = true;
                        updateButtonStates();
                    }
                });
            }

            /* =========================
                CREATE ARROW OBJECTS
            ========================== */

            function createArrowObjects(start, end, isPreview) {
                const color = document.getElementById('colorPicker').value;
                const strokeWidth = parseInt(document.getElementById('brushSize').value);

                const dx = end.x - start.x;
                const dy = end.y - start.y;
                const angle = Math.atan2(dy, dx);
                const distance = Math.sqrt(dx * dx + dy * dy);

                // Minimal distance untuk arrow head
                if (distance < 5) {
                    return {
                        line: null,
                        headLeft: null,
                        headRight: null
                    };
                }

                // Arrow head size
                const headLength = Math.min(20, strokeWidth * 5);
                const headAngle = Math.PI / 6; // 30 degrees

                const commonProps = {
                    stroke: color,
                    strokeWidth: strokeWidth,
                    selectable: false,
                    evented: false,
                    opacity: isPreview ? 0.6 : 1
                };

                // Arrow line
                const line = new fabric.Line([start.x, start.y, end.x, end.y], commonProps);

                // Arrow head - left
                const headLeft = new fabric.Line([
                    end.x,
                    end.y,
                    end.x - headLength * Math.cos(angle - headAngle),
                    end.y - headLength * Math.sin(angle - headAngle)
                ], commonProps);

                // Arrow head - right
                const headRight = new fabric.Line([
                    end.x,
                    end.y,
                    end.x - headLength * Math.cos(angle + headAngle),
                    end.y - headLength * Math.sin(angle + headAngle)
                ], commonProps);

                return {
                    line,
                    headLeft,
                    headRight
                };
            }

            /* =========================
                APPLY CROP
            ========================== */

            function applyCrop(cropData) {
                if (!canvas || !cropData) return;

                console.log('✂️ Memulai crop...');

                // Get current canvas sebagai high-quality image
                const currentDataURL = canvas.toDataURL('image/png');

                fabric.Image.fromURL(currentDataURL, function(img) {

                    // Set crop parameters
                    const scaleX = img.scaleX || 1;
                    const scaleY = img.scaleY || 1;

                    const cropX = cropData.left / scaleX;
                    const cropY = cropData.top / scaleY;
                    const cropWidth = cropData.width / scaleX;
                    const cropHeight = cropData.height / scaleY;

                    // Apply crop
                    img.set({
                        cropX: cropX,
                        cropY: cropY,
                        width: cropWidth,
                        height: cropHeight,
                        left: 0,
                        top: 0
                    });

                    // Resize canvas
                    canvas.setWidth(cropData.width);
                    canvas.setHeight(cropData.height);

                    // Clear canvas
                    canvas.clear();

                    // Set cropped image as background
                    canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                        scaleX: scaleX,
                        scaleY: scaleY
                    });

                    // Update base snapshot setelah crop
                    setTimeout(() => {
                        baseImageSnapshot = canvas.toDataURL('image/png');
                        saveSnapshot();
                        updateBase64();
                        console.log('✂️ Crop selesai, base image updated');
                    }, 100);

                });
            }

            /* =========================
                CLEAR DRAWINGS
            ========================== */

            function clearDrawings() {
                if (!canvas || !baseImageSnapshot) {
                    alert('Tidak ada gambar dasar untuk dikembalikan.');
                    return;
                }

                if (!confirm('Yakin ingin menghapus semua coretan?\n\nGambar dasar akan dikembalikan.')) {
                    return;
                }

                console.log('🧹 Menghapus coretan...');

                fabric.Image.fromURL(baseImageSnapshot, function(img) {

                    // Simpan ukuran canvas saat ini
                    const currentWidth = canvas.width;
                    const currentHeight = canvas.height;

                    // Clear canvas
                    canvas.clear();

                    // Restore canvas size jika berbeda
                    if (img.width !== currentWidth || img.height !== currentHeight) {
                        canvas.setWidth(img.width);
                        canvas.setHeight(img.height);
                    }

                    // Set base image as background
                    canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

                    // Save snapshot
                    saveSnapshot();
                    updateBase64();

                    console.log('🧹 Coretan berhasil dihapus');
                });
            }

            /* =========================
                MERGE DRAWINGS
            ========================== */

            function mergeDrawing() {
                if (!canvas) return;

                const dataURL = canvas.toDataURL('image/png');

                fabric.Image.fromURL(dataURL, function(img) {

                    canvas.clear();

                    canvas.setBackgroundImage(
                        img,
                        canvas.renderAll.bind(canvas)
                    );

                    canvas.isDrawingMode = (currentMode === 'draw');
                });
            }

            /* =========================
                HISTORY SNAPSHOT
            ========================== */

            function saveSnapshot() {
                if (!canvas) return;

                canvasHistory = canvasHistory.slice(0, historyStep + 1);

                // Save dengan kualitas tinggi
                canvasHistory.push(canvas.toDataURL('image/png'));
                historyStep = canvasHistory.length - 1;

                if (canvasHistory.length > 20) {
                    canvasHistory.shift();
                    historyStep--;
                }

                updateUndoRedoButtons();
            }

            /* =========================
                UNDO / REDO
            ========================== */

            window.undoCanvas = function() {
                if (historyStep <= 0) return;

                historyStep--;
                restoreSnapshot();
            };

            window.redoCanvas = function() {
                if (historyStep >= canvasHistory.length - 1) return;

                historyStep++;
                restoreSnapshot();
            };

            function restoreSnapshot() {
                if (!canvas) return;

                const snapshotData = canvasHistory[historyStep];

                fabric.Image.fromURL(snapshotData, function(img) {

                    const currentWidth = canvas.width;
                    const currentHeight = canvas.height;

                    canvas.clear();

                    // Restore canvas size jika berbeda (karena crop)
                    if (img.width !== currentWidth || img.height !== currentHeight) {
                        canvas.setWidth(img.width);
                        canvas.setHeight(img.height);
                    }

                    canvas.setBackgroundImage(
                        img,
                        canvas.renderAll.bind(canvas)
                    );

                    canvas.isDrawingMode = (currentMode === 'draw');

                    updateUndoRedoButtons();
                    updateBase64();
                });
            }

            function updateUndoRedoButtons() {
                const u = document.getElementById('btnUndo');
                const r = document.getElementById('btnRedo');

                if (u) u.disabled = historyStep <= 0;
                if (r) r.disabled = historyStep >= canvasHistory.length - 1;
            }

            /* =========================
                UPDATE BUTTON STATES
            ========================== */

            function updateButtonStates() {
                const btnDraw = document.getElementById('btnDraw');
                const btnArrow = document.getElementById('btnArrow');
                const btnCrop = document.getElementById('btnCrop');

                // Reset all buttons
                btnDraw.classList.remove('ring-2', 'ring-blue-300', 'bg-blue-700');
                btnDraw.classList.add('bg-blue-600');
                btnArrow.classList.remove('ring-2', 'ring-green-300', 'bg-green-700');
                btnArrow.classList.add('bg-green-600');
                btnCrop.classList.remove('ring-2', 'ring-purple-300', 'bg-purple-700');
                btnCrop.classList.add('bg-purple-600');

                // Highlight active button
                if (currentMode === 'draw') {
                    btnDraw.classList.add('ring-2', 'ring-blue-300', 'bg-blue-700');
                    btnDraw.classList.remove('bg-blue-600');
                } else if (currentMode === 'arrow') {
                    btnArrow.classList.add('ring-2', 'ring-green-300', 'bg-green-700');
                    btnArrow.classList.remove('bg-green-600');
                } else if (currentMode === 'crop') {
                    btnCrop.classList.add('ring-2', 'ring-purple-300', 'bg-purple-700');
                    btnCrop.classList.remove('bg-purple-600');
                }
            }

            /* =========================
                TOOLBAR CONTROLS
            ========================== */

            document.getElementById('btnDraw').onclick = () => {
                if (!canvas) return;

                currentMode = 'draw';
                canvas.isDrawingMode = true;
                canvas.selection = false;

                updateButtonStates();
                console.log('✏️ Draw mode aktif');
            };

            document.getElementById('btnArrow').onclick = () => {
                if (!canvas) return;

                currentMode = 'arrow';
                canvas.isDrawingMode = false;
                canvas.selection = false;

                updateButtonStates();
                console.log('➡️ Arrow mode aktif');
            };

            document.getElementById('btnCrop').onclick = () => {
                if (!canvas) return;

                currentMode = 'crop';
                canvas.isDrawingMode = false;
                canvas.selection = false;

                updateButtonStates();
                console.log('✂️ Crop mode aktif - drag area yang ingin di-crop');
            };

            document.getElementById('btnClearDrawings').onclick = () => {
                clearDrawings();
            };

            document.getElementById('colorPicker').onchange = e => {
                if (!canvas) return;
                canvas.freeDrawingBrush.color = e.target.value;
                console.log('🎨 Warna:', e.target.value);
            };

            document.getElementById('brushSize').oninput = e => {
                if (!canvas) return;

                const size = parseInt(e.target.value);
                canvas.freeDrawingBrush.width = size;
                document.getElementById('brushSizeValue').textContent = size;
                console.log('📏 Ukuran:', size);
            };

            document.getElementById('btnClear').onclick = () => {
                if (!confirm('Hapus gambar?')) return;

                canvas.dispose();
                canvas = null;
                canvasHistory = [];
                historyStep = -1;
                currentMode = 'draw';
                tempArrow = null;
                cropRect = null;
                baseImageSnapshot = null;

                editorContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
                fileInput.value = '';
                gambarBase64Input.value = '';
                console.log('🗑️ Canvas cleared');
            };

            /* =========================
                SUBMIT
            ========================== */

            function updateBase64() {
                if (!canvas) return;

                // Format PNG untuk kualitas tajam, kompresi ringan 0.95
                gambarBase64Input.value = canvas.toDataURL('image/png', 0.9);
            }

            formElement.addEventListener('submit', function() {
                if (canvas) {
                    updateBase64();
                    const sizeKB = (gambarBase64Input.value.length / 1024).toFixed(2);
                    console.log('📤 Form submitted, ukuran gambar:', sizeKB, 'KB');
                }
            });

        });
    </script>

@endsection
