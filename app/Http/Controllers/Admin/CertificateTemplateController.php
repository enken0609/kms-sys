<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = CertificateTemplate::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.certificate_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.certificate_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('テンプレート作成開始', ['request' => $request->all()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'template_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'paper_size' => 'required|string|in:A4,B5',
                'orientation' => 'required|string|in:portrait,landscape',
                'layout_config' => 'required|json',
            ]);

            \Log::info('バリデーション成功', ['validated' => $validated]);

            // 画像の保存
            $imagePath = $request->file('template_image')->store('certificate-templates', 'uploads');
            \Log::info('画像保存成功', ['imagePath' => $imagePath]);

            // テンプレートの作成
            $template = CertificateTemplate::create([
                'name' => $validated['name'],
                'image_path' => $imagePath,
                'paper_size' => $validated['paper_size'],
                'orientation' => $validated['orientation'],
                'layout_config' => json_decode($validated['layout_config'], true),
            ]);

            \Log::info('テンプレート作成成功', ['template' => $template]);

            return redirect()
                ->route('admin.certificate-templates.index')
                ->with('success', 'テンプレートを作成しました。');

        } catch (\Exception $e) {
            \Log::error('テンプレート作成エラー', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'テンプレートの作成に失敗しました。' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateTemplate $certificateTemplate)
    {
        return view('admin.certificate_templates.edit', compact('certificateTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateTemplate $certificateTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'paper_size' => 'required|string|in:A4,B5',
            'orientation' => 'required|string|in:portrait,landscape',
            'layout_config' => 'required|json',
        ]);

        // 新しい画像がアップロードされた場合
        if ($request->hasFile('template_image')) {
            // 古い画像を削除
            if (file_exists(public_path('uploads/' . $certificateTemplate->image_path))) {
                unlink(public_path('uploads/' . $certificateTemplate->image_path));
            }
            // 新しい画像を保存
            $imagePath = $request->file('template_image')->store('certificate-templates', 'uploads');
            $validated['image_path'] = $imagePath;
        }

        $certificateTemplate->update([
            'name' => $validated['name'],
            'image_path' => $validated['image_path'] ?? $certificateTemplate->image_path,
            'paper_size' => $validated['paper_size'],
            'orientation' => $validated['orientation'],
            'layout_config' => json_decode($validated['layout_config'], true),
        ]);

        return redirect()
            ->route('admin.certificate-templates.index')
            ->with('success', 'テンプレートを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateTemplate $certificateTemplate)
    {
        // 画像の削除
        if (file_exists(public_path('uploads/' . $certificateTemplate->image_path))) {
            unlink(public_path('uploads/' . $certificateTemplate->image_path));
        }
        
        // テンプレートの削除
        $certificateTemplate->delete();

        return redirect()
            ->route('admin.certificate-templates.index')
            ->with('success', 'テンプレートを削除しました。');
    }
}
