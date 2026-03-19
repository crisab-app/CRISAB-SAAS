<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Activos AdministrarMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f3f4f6; }
        .canvas-container {
            background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), 
                              linear-gradient(-45deg, #ccc 25%, transparent 25%), 
                              linear-gradient(45deg, transparent 75%, #ccc 75%), 
                              linear-gradient(-45deg, transparent 75%, #ccc 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
    </style>
</head>
<body class="p-6 font-sans text-gray-800">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center mb-2 text-blue-900">Generador de Redes para AdministrarMe</h1>
        <p class="text-center text-gray-600 mb-8">Sube tu archivo <span class="font-semibold text-blue-700">LogoV1.jpg</span> y descarga las imágenes con las medidas exactas.</p>

        <!-- Controles -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8 flex flex-col md:flex-row items-center gap-6 justify-between border border-blue-100">
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-2">1. Sube tu Logo Original</label>
                <input type="file" id="imageUpload" accept="image/jpeg, image/png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer border border-gray-300 rounded-md p-1 bg-white"/>
            </div>
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-2">2. Color de Fondo (Azul Marino)</label>
                <div class="flex items-center gap-2">
                    <input type="color" id="bgColor" value="#051221" class="h-10 w-14 rounded cursor-pointer border-gray-300">
                    <span class="text-sm text-gray-600">Puedes ajustarlo si ves diferencias con el logo.</span>
                </div>
            </div>
        </div>

        <div id="results" class="hidden space-y-8">
            <!-- Perfil -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Foto de Perfil</h2>
                        <p class="text-sm text-gray-500">1080 x 1080 px (Ideal para el recorte circular)</p>
                    </div>
                    <button onclick="downloadCanvas('canvasProfile', 'AdministrarMe_Perfil.jpg')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Descargar</button>
                </div>
                <div class="canvas-container w-full max-w-[300px] mx-auto border shadow-sm aspect-square overflow-hidden relative rounded-full">
                    <canvas id="canvasProfile" class="w-full h-full object-contain"></canvas>
                </div>
            </div>

            <!-- Portada Facebook -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Portada de Facebook</h2>
                        <p class="text-sm text-gray-500">820 x 312 px</p>
                    </div>
                    <button onclick="downloadCanvas('canvasFb', 'AdministrarMe_PortadaFB.jpg')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Descargar</button>
                </div>
                <div class="canvas-container w-full border shadow-sm overflow-hidden">
                    <canvas id="canvasFb" class="w-full h-auto object-contain"></canvas>
                </div>
            </div>

            <!-- YouTube Banner -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Banner de YouTube</h2>
                        <p class="text-sm text-gray-500">2560 x 1440 px (Centrado en área segura)</p>
                    </div>
                    <button onclick="downloadCanvas('canvasYt', 'AdministrarMe_BannerYT.jpg')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Descargar</button>
                </div>
                <div class="canvas-container w-full border shadow-sm overflow-hidden relative">
                    <!-- Guía visual del área segura -->
                    <div class="absolute inset-0 pointer-events-none border-y border-red-400/50 flex items-center justify-center" style="height: 29.375%; top: 35.3125%;">
                        <span class="text-red-400/50 text-xs font-bold">Área Segura Móvil</span>
                    </div>
                    <canvas id="canvasYt" class="w-full h-auto object-contain"></canvas>
                </div>
            </div>

            <!-- Favicon -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Favicon (Pestaña Web)</h2>
                        <p class="text-sm text-gray-500">512 x 512 px (Recorte central automático)</p>
                    </div>
                    <button onclick="downloadCanvas('canvasFavicon', 'AdministrarMe_Favicon.jpg')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Descargar</button>
                </div>
                <div class="canvas-container w-full max-w-[150px] mx-auto border shadow-sm aspect-square overflow-hidden rounded-xl">
                    <canvas id="canvasFavicon" class="w-full h-full object-contain"></canvas>
                </div>
                <p class="text-xs text-center text-gray-400 mt-2">*El favicon hace un recorte centrado al símbolo para ser legible en pestañas pequeñas.</p>
            </div>
        </div>
    </div>

    <script>
        const imageUpload = document.getElementById('imageUpload');
        const bgColorInput = document.getElementById('bgColor');
        let currentImage = null;

        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    currentImage = img;
                    document.getElementById('results').classList.remove('hidden');
                    generateAll();
                }
                img.src = event.target.result;
            }
            reader.readAsDataURL(file);
        });

        bgColorInput.addEventListener('input', () => {
            if(currentImage) generateAll();
        });

        function generateAll() {
            if(!currentImage) return;
            const bgColor = bgColorInput.value;

            // 1. Foto de Perfil (1080x1080)
            drawCanvas('canvasProfile', 1080, 1080, bgColor, currentImage, 0.65); // 65% del tamaño para margen circular

            // 2. Portada FB (820x312)
            drawCanvas('canvasFb', 820, 312, bgColor, currentImage, 0.9); // 90% del alto

            // 3. Banner YT (2560x1440) - Área segura es 1546x423 en el centro
            drawCanvasYT('canvasYt', 2560, 1440, bgColor, currentImage);

            // 4. Favicon (512x512) - Recorte central (Zoom)
            drawFavicon('canvasFavicon', 512, 512, bgColor, currentImage);
        }

        function drawCanvas(canvasId, width, height, bgColor, img, scaleRatioHeight) {
            const canvas = document.getElementById(canvasId);
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            // Fondo
            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, width, height);

            // Calcular proporciones de la imagen
            const imgAspect = img.width / img.height;
            
            // Usamos la altura como base para escalar
            let drawHeight = height * scaleRatioHeight;
            let drawWidth = drawHeight * imgAspect;

            // Si el ancho se pasa, ajustamos por el ancho
            if (drawWidth > width * 0.9) {
                drawWidth = width * 0.9;
                drawHeight = drawWidth / imgAspect;
            }

            const x = (width - drawWidth) / 2;
            const y = (height - drawHeight) / 2;

            ctx.drawImage(img, x, y, drawWidth, drawHeight);
        }

        function drawCanvasYT(canvasId, width, height, bgColor, img) {
            const canvas = document.getElementById(canvasId);
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, width, height);

            const safeHeight = 423;
            const targetHeight = safeHeight * 0.85; // 85% del área segura
            const imgAspect = img.width / img.height;
            const drawWidth = targetHeight * imgAspect;

            const x = (width - drawWidth) / 2;
            const y = (height - targetHeight) / 2;

            ctx.drawImage(img, x, y, drawWidth, targetHeight);
        }

        function drawFavicon(canvasId, width, height, bgColor, img) {
            const canvas = document.getElementById(canvasId);
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, width, height);

            // Queremos recortar un área del centro de la imagen original
            // El pez con A|M suele estar en el medio. Tomaremos un cuadro del centro.
            // Asumimos que el ancho a recortar es el 60% del ancho original
            const cropWidth = img.width * 0.6;
            const cropHeight = cropWidth; // Hacerlo cuadrado
            
            const sourceX = (img.width - cropWidth) / 2;
            // Desplazamos un poco hacia abajo porque el calendario empuja el pez
            const sourceY = (img.height - cropHeight) / 2 + (img.height * 0.08); 

            // Dibujar el recorte ocupando casi todo el canvas de 512x512
            const targetSize = width * 0.9;
            const targetX = (width - targetSize) / 2;
            const targetY = (height - targetSize) / 2;

            ctx.drawImage(img, sourceX, sourceY, cropWidth, cropHeight, targetX, targetY, targetSize, targetSize);
        }

        function downloadCanvas(canvasId, filename) {
            const canvas = document.getElementById(canvasId);
            const link = document.createElement('a');
            link.download = filename;
            link.href = canvas.toDataURL('image/jpeg', 0.95);
            link.click();
        }
    </script>
</body>
</html>