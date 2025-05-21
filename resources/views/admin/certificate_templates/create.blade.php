@extends('layouts.admin')

@section('title', '記録証テンプレート作成')

@push('scripts')
<script>
    // DOMContentLoadedイベントをAlpine.jsの初期化後に移動
    document.addEventListener('alpine:init', () => {
        console.log('Alpine.js initialized');
        
        Alpine.data('templateEditor', () => ({
            previewImage: '',
            paperSize: 'A4',
            elements: {
                bib_number: { x: 100, y: 150, font_size: 24, color: '#000000' },
                category_name: { x: 200, y: 200, font_size: 20, color: '#000000' },
                participant_name: { x: 300, y: 250, font_size: 28, color: '#000000' },
                finish_time: { x: 400, y: 300, font_size: 24, color: '#000000' },
                overall_rank: { x: 500, y: 350, font_size: 20, color: '#000000' },
                category_rank: { x: 600, y: 400, font_size: 20, color: '#000000' }
            },
            draggedElement: null,
            startX: 0,
            startY: 0,

            init() {
                console.log('Component initialized');
                this.setupImageHandlers();
            },

            setupImageHandlers() {
                console.log('Setting up image handlers');
                const input = document.getElementById('template_image');
                const dropZone = document.querySelector('.border-dashed');

                if (!input || !dropZone) {
                    console.error('Required elements not found:', { input, dropZone });
                    return;
                }

                const handleFileSelect = (file) => {
                    console.log('File selected:', file);
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            console.log('File loaded');
                            this.previewImage = e.target.result;
                        };
                        reader.onerror = (e) => {
                            console.error('File read error:', e);
                        };
                        reader.readAsDataURL(file);
                    }
                };

                input.addEventListener('change', (e) => {
                    console.log('File input change event');
                    const file = e.target.files[0];
                    handleFileSelect(file);
                });

                dropZone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-blue-500');
                });

                dropZone.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-blue-500');
                });

                dropZone.addEventListener('drop', (e) => {
                    console.log('File dropped');
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-blue-500');
                    const file = e.dataTransfer.files[0];
                    input.files = e.dataTransfer.files;
                    handleFileSelect(file);
                });
            },

            getElementLabel(key) {
                const labels = {
                    bib_number: 'ゼッケン番号',
                    category_name: '部門名',
                    participant_name: '氏名',
                    finish_time: 'タイム',
                    overall_rank: '総合順位',
                    category_rank: '部門順位'
                };
                return labels[key] || key;
            },

            getPreviewText(key) {
                const previews = {
                    bib_number: '1234',
                    category_name: '男子40代',
                    participant_name: '山田 太郎',
                    finish_time: '1:23:45',
                    overall_rank: '10位',
                    category_rank: '3位'
                };
                return previews[key] || key;
            },

            getElementStyle(element) {
                return {
                    left: `${element.x}px`,
                    top: `${element.y}px`,
                    fontSize: `${element.font_size}px`,
                    color: element.color,
                    userSelect: 'none'
                };
            },

            startDrag(event, key) {
                console.log('Starting drag:', key);
                event.preventDefault();
                this.draggedElement = key;
                this.startX = event.clientX - this.elements[key].x;
                this.startY = event.clientY - this.elements[key].y;

                const moveHandler = (e) => {
                    if (this.draggedElement) {
                        e.preventDefault();
                        this.elements[this.draggedElement].x = e.clientX - this.startX;
                        this.elements[this.draggedElement].y = e.clientY - this.startY;
                    }
                };

                const upHandler = () => {
                    console.log('Ending drag:', key);
                    this.draggedElement = null;
                    document.removeEventListener('mousemove', moveHandler);
                    document.removeEventListener('mouseup', upHandler);
                };

                document.addEventListener('mousemove', moveHandler);
                document.addEventListener('mouseup', upHandler);
            },

            handleSubmit() {
                const layoutConfig = JSON.stringify({ elements: this.elements });
                console.log('Submitting layout config:', layoutConfig);
                document.getElementById('layout_config').value = layoutConfig;
            }
        }));
    });
</script>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6" x-data="templateEditor">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">新規テンプレート作成</h2>
        </div>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.certificate-templates.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-6"
              autocomplete="off"
              @submit.prevent="handleSubmit(); $el.submit();">
            @csrf

            <!-- テンプレート名 -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">テンプレート名</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       required
                       autocomplete="off"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- テンプレート画像 -->
            <div>
                <label for="template_image" class="block text-sm font-medium text-gray-700">テンプレート画像</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="template_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>画像をアップロード</span>
                                <input type="file" 
                                       name="template_image" 
                                       id="template_image"
                                       accept="image/jpeg,image/png,image/jpg"
                                       required
                                       class="sr-only">
                            </label>
                            <p class="pl-1">またはドラッグ＆ドロップ</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, JPEG (最大 10MB)
                        </p>
                    </div>
                </div>
                @error('template_image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 用紙サイズ -->
            <div>
                <label for="paper_size" class="block text-sm font-medium text-gray-700">用紙サイズ</label>
                <select name="paper_size" 
                        id="paper_size"
                        x-model="paperSize"
                        required
                        autocomplete="off"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="B5">B5</option>
                    <option value="A4">A4</option>
                </select>
                @error('paper_size')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 用紙の向き -->
            <div>
                <label for="orientation" class="block text-sm font-medium text-gray-700">用紙の向き</label>
                <select name="orientation" 
                        id="orientation"
                        required
                        autocomplete="off"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="portrait">縦</option>
                    <option value="landscape">横</option>
                </select>
                @error('orientation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- レイアウト設定 -->
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">レイアウト設定</h3>
                
                <div class="space-y-8">
                    <!-- プレビュー領域 -->
                    <div class="overflow-auto p-4 bg-gray-50 rounded-lg" style="max-height: 800px;">
                        <div class="relative border rounded-lg overflow-hidden bg-gray-100 mx-auto" 
                             :style="{ 
                                 width: paperSize === 'A4' ? '210mm' : '182mm', 
                                 height: paperSize === 'A4' ? '297mm' : '257mm', 
                                 transform: 'scale(0.8)',
                                 transformOrigin: 'top center',
                                 margin: '0 auto'
                             }">
                            <div id="preview-container" class="relative w-full h-full">
                                <template x-if="previewImage">
                                    <img :src="previewImage" 
                                         alt="テンプレートプレビュー" 
                                         class="w-full h-full object-contain"
                                         @load="console.log('Image loaded:', $event.target.src)">
                                </template>
                                <template x-if="!previewImage">
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                        <span>画像をアップロードしてください</span>
                                    </div>
                                </template>
                                
                                <!-- 各要素のプレビュー -->
                                <template x-for="(element, key) in elements" :key="key">
                                    <div :style="getElementStyle(element)"
                                         class="absolute cursor-move bg-white/50 px-2 py-1 rounded shadow-sm hover:bg-white/70"
                                         @mousedown="startDrag($event, key)">
                                        <span x-text="getPreviewText(key)" class="select-none"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- 要素設定 -->
                    <div class="space-y-4 bg-gray-50 p-4 rounded-lg">
                        <template x-for="(element, key) in elements" :key="key">
                            <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow transition">
                                <h4 x-text="getElementLabel(key)" class="font-medium mb-3 text-gray-700"></h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">X座標</label>
                                        <input type="number" x-model="element.x" class="w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Y座標</label>
                                        <input type="number" x-model="element.y" class="w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">フォントサイズ</label>
                                        <input type="number" x-model="element.font_size" class="w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">文字色</label>
                                        <input type="color" x-model="element.color" class="w-full h-9 border rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <input type="hidden" 
                       id="layout_config"
                       name="layout_config" 
                       :value="JSON.stringify({ elements: elements })"
                       autocomplete="off">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.certificate-templates.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    キャンセル
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    作成
                </button>
            </div>
        </form>
    </div>
@endsection 