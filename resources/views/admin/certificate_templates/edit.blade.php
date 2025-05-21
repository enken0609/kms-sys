@extends('layouts.admin')

@section('title', '記録証テンプレート編集')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">テンプレート編集</h2>
        </div>

        <form action="{{ route('admin.certificate-templates.update', $certificateTemplate) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <!-- テンプレート名 -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">テンプレート名</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $certificateTemplate->name) }}"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 現在のテンプレート画像 -->
            <div>
                <label class="block text-sm font-medium text-gray-700">現在の画像</label>
                <img src="{{ Storage::url($certificateTemplate->image_path) }}" 
                     alt="{{ $certificateTemplate->name }}" 
                     class="mt-2 h-40 w-auto object-contain">
            </div>

            <!-- テンプレート画像 -->
            <div>
                <label for="template_image" class="block text-sm font-medium text-gray-700">新しい画像（変更する場合のみ）</label>
                <input type="file" 
                       name="template_image" 
                       id="template_image"
                       accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('template_image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- 用紙サイズ -->
            <div>
                <label for="paper_size" class="block text-sm font-medium text-gray-700">用紙サイズ</label>
                <select name="paper_size" 
                        id="paper_size"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="B5" {{ old('paper_size', $certificateTemplate->paper_size) === 'B5' ? 'selected' : '' }}>B5</option>
                    <option value="A4" {{ old('paper_size', $certificateTemplate->paper_size) === 'A4' ? 'selected' : '' }}>A4</option>
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
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="portrait" {{ old('orientation', $certificateTemplate->orientation) === 'portrait' ? 'selected' : '' }}>縦</option>
                    <option value="landscape" {{ old('orientation', $certificateTemplate->orientation) === 'landscape' ? 'selected' : '' }}>横</option>
                </select>
                @error('orientation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- レイアウト設定 -->
            <div x-data="templateEditor({{ json_encode($certificateTemplate->layout_config) }})" class="border rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">レイアウト設定</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                            <img :src="previewImage || '{{ Storage::url($certificateTemplate->image_path) }}'" 
                                 alt="テンプレートプレビュー" 
                                 class="w-full h-full object-contain">
                            
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
                       name="layout_config" 
                       x-model="JSON.stringify({ elements: elements })">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.certificate-templates.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    キャンセル
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    更新
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function templateEditor(initialConfig = null) {
            return {
                previewImage: '',
                paperSize: '{{ $certificateTemplate->paper_size }}',
                elements: initialConfig?.elements || {
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
                    // 画像プレビューの設定
                    const input = document.getElementById('template_image');
                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        if (file) {
                            this.previewImage = URL.createObjectURL(file);
                        }
                    });

                    // 用紙サイズの監視
                    const sizeSelect = document.getElementById('paper_size');
                    sizeSelect.addEventListener('change', (e) => {
                        this.paperSize = e.target.value;
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
                        color: element.color
                    };
                },

                startDrag(event, key) {
                    this.draggedElement = key;
                    this.startX = event.clientX - this.elements[key].x;
                    this.startY = event.clientY - this.elements[key].y;

                    const moveHandler = (e) => {
                        if (this.draggedElement) {
                            this.elements[this.draggedElement].x = e.clientX - this.startX;
                            this.elements[this.draggedElement].y = e.clientY - this.startY;
                        }
                    };

                    const upHandler = () => {
                        this.draggedElement = null;
                        document.removeEventListener('mousemove', moveHandler);
                        document.removeEventListener('mouseup', upHandler);
                    };

                    document.addEventListener('mousemove', moveHandler);
                    document.addEventListener('mouseup', upHandler);
                }
            }
        }
    </script>
    @endpush
@endsection 